<?php
$mysqli = new mysqli("db_host", "db_user", "db_pass", "anpi_db");
$mysqli->set_charset("utf8");

// 検索フォームからの入力取得
$name = $_GET['name'] ?? '';
$status = $_GET['status'] ?? '';
$comment = $_GET['comment'] ?? '';

// WHERE 条件作成
$where = [];
$params = [];
if ($name) {
    $where[] = "氏名 LIKE ?";
    $params[] = "%$name%";
}
if ($status) {
    $where[] = "状態 LIKE ?";
    $params[] = "%$status%";
}
if ($comment) {
    $where[] = "コメント LIKE ?";
    $params[] = "%$comment%";
}

$sql = "SELECT * FROM anpi_info";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY 登録日時 DESC";

$stmt = $mysqli->prepare($sql);
if ($params) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>安否情報一覧（検索付き）</title>
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
        form {
            width: 90%;
            margin: 0 auto 20px auto;
            text-align: center;
        }
        input[type="text"] {
            padding: 6px 10px;
            margin: 0 5px 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 6px 12px;
            border: none;
            background: #4e73df;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #2e59d9;
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
    <h1>安否情報一覧（検索付き）</h1>

    <!-- 検索フォーム -->
    <form method="GET" action="">
        <input type="text" name="name" placeholder="名前" value="<?= htmlspecialchars($name) ?>">
        <input type="text" name="status" placeholder="状態" value="<?= htmlspecialchars($status) ?>">
        <input type="text" name="comment" placeholder="コメント" value="<?= htmlspecialchars($comment) ?>">
        <button type="submit">検索</button>
    </form>

    <!-- 一覧表示 -->
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

<?php $mysqli->close(); ?>
</body>
</html>
