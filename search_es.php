<?php
require 'vendor/autoload.php';
use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();

$name = $_GET['name'] ?? null;
$status = $_GET['status'] ?? null;
$comment = $_GET['comment'] ?? null;
$created_at = $_GET['created_at'] ?? null;

$must = [];
if ($name) $must[] = ['match' => ['name' => $name]];
if ($status) $must[] = ['match' => ['status' => $status]];
if ($comment) $must[] = ['match' => ['comment' => $comment]];
if ($created_at) $must[] = ['match' => ['created_at' => $created_at]];

$params = [
    'index' => 'reports',
    'body' => [
        'query' => [
            'bool' => ['must' => $must]
        ],
        'sort' => [['created_at' => ['order' => 'desc']]],
        'size' => 100
    ]
];

$response = $client->search($params);
$hits = $response['hits']['hits'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>安否情報検索</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f5f5f5; text-align: center; padding: 30px; }
        h1 { color: #2c3e50; }
        table { margin: 0 auto; width: 80%; border-collapse: collapse; background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); table-layout: fixed; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #3498db; color: white; }
        tr:hover { background-color: #f0f8ff; }
        .comment-box { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; cursor: pointer; }
        .comment-box.expanded { -webkit-line-clamp: unset; }
    </style>
</head>
<body>
    <h1>安否情報検索</h1>

    <form method="GET" action="search_es.php" style="margin-bottom: 20px;">
        <input type="text" name="name" placeholder="名前" value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">
        <input type="text" name="status" placeholder="状態" value="<?= htmlspecialchars($_GET['status'] ?? '') ?>">
        <input type="text" name="comment" placeholder="コメント" value="<?= htmlspecialchars($_GET['comment'] ?? '') ?>">
        <input type="date" name="created_at" value="<?= htmlspecialchars($_GET['created_at'] ?? '') ?>">
        <button type="submit">検索</button>
    </form>

    <table>
        <tr><th>ID</th><th>名前</th><th>状態</th><th>コメント</th><th>送信日時</th></tr>
        <?php foreach ($hits as $hit): ?>
            <tr>
                <td><?= htmlspecialchars($hit['_id']) ?></td>
                <td><?= htmlspecialchars($hit['_source']['name']) ?></td>
                <td><?= htmlspecialchars($hit['_source']['status']) ?></td>
                <td class="comment-box"><?= nl2br(htmlspecialchars($hit['_source']['comment'])) ?></td>
                <td><?= htmlspecialchars($hit['_source']['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php">戻る</a>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const commentBoxes = document.querySelectorAll('.comment-box');
            commentBoxes.forEach(box => {
                box.addEventListener('click', () => box.classList.toggle('expanded'));
            });
        });
    </script>
</body>
</html>
