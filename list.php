<?php
$mysqli = new mysqli("db_host", "db_user", "db_pass", "anpi_db");
$mysqli->set_charset("utf8");

$result = $mysqli->query("SELECT * FROM anpi_info ORDER BY 登録日時 DESC");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>安否情報一覧</title>
    <style>
        body {
            font-family: "Yu Gothic", sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }
        th {
            background: #4e73df;
            color: #fff;
        }
        tr:hover {
            background: #f1f5ff;
        }
        .download-link {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 12px;
            text-align: center;
            background: #1cc88a;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        .download-link:hover {
            background: #17a673;
        }
    </style>
</head>
<body>
    <h1>安否情報一覧</h1>
    <table>
        <tr>
            <th>氏名</th>
            <th>状態</th>
            <th>コメント</th>
            <th>登録日時</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['氏名']) ?></td>
            <td><?= htmlspecialchars($row['状態']) ?></td>
            <td><?= htmlspecialchars($row['コメント']) ?></td>
            <td><?= htmlspecialchars($row['登録日時']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="download.php" class="download-link">CSVダウンロード</a>
</body>
</html>
<?php $mysqli->close(); ?>

