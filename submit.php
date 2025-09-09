<?php
// DB接続
$mysqli = new mysqli("db_host", "db_user", "db_pass", "anpi_db");
$mysqli->set_charset("utf8");

// POSTデータ取得
$name    = $_POST['name'] ?? '';
$status  = $_POST['status'] ?? '';
$comment = $_POST['comment'] ?? '';
$created = date("Y-m-d H:i:s");

// 登録処理
$stmt = $mysqli->prepare("INSERT INTO anpi_info (氏名, 状態, コメント, 登録日時) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $status, $comment, $created);
$success = $stmt->execute();

$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録結果</title>
    <style>
        body {
            font-family: "Yu Gothic", sans-serif;
            background: #f9f9ff;
            text-align: center;
            padding: 50px;
        }
        .card {
            display: inline-block;
            padding: 30px 50px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            text-decoration: none;
            background: #4e73df;
            color: #fff;
            border-radius: 8px;
        }
        a:hover {
            background: #3759c1;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($success): ?>
            <h1>登録が完了しました！</h1>
            <p>ご協力ありがとうございます。</p>
        <?php else: ?>
            <h1>登録に失敗しました…</h1>
            <p>再度お試しください。</p>
        <?php endif; ?>
        <a href="list.php">一覧画面へ戻る</a>
    </div>
</body>
</html>
