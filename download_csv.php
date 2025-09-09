<?php
$mysqli = new mysqli("db_host", "db_user", "db_pass", "anpi_db");
$mysqli->set_charset("utf8");

$result = $mysqli->query("SELECT * FROM anpi_info ORDER BY 登録日時 DESC");

$filename = "anpi_" . date("Ymd_His") . ".csv";

// 出力準備
header('Content-Type: text/csv; charset=Shift-JIS');
header("Content-Disposition: attachment; filename={$filename}");

$output = fopen('php://output', 'w');

// ヘッダー行
fputcsv($output, ['氏名', '状態', 'コメント', '登録日時']);

// データ行
while ($row = $result->fetch_assoc()) {
    $line = [
        $row['氏名'],
        $row['状態'],
        $row['コメント'],
        $row['登録日時']
    ];
    mb_convert_variables('SJIS-win', 'UTF-8', $line);
    fputcsv($output, $line);
}

fclose($output);
$mysqli->close();
exit;
?>
