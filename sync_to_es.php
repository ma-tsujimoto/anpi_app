<?php
require 'vendor/autoload.php';
use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();

$pdo = new PDO('mysql:host=192.168.1.125;dbname=safety_check;charset=utf8', 'anpi_app', '!Tophonsha2023');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM reports";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $params = [
        'index' => 'reports',
        'id' => $row['id'],
        'body' => [
            'name' => $row['name'],
            'status' => $row['status'],
            'comment' => $row['comment'],
            'created_at' => $row['created_at'] // 形式が Elasticsearch で認識される日付ならOK
        ]
    ];
    try {
        $client->index($params);
    } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
        echo "Error syncing ID {$row['id']}: " . $e->getMessage() . "\n";
    }
}

echo "同期完了\n";
?>
