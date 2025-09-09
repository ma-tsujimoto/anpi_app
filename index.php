!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>安否情報入力フォーム</title>
    <style>
        body {
            font-family: "Yu Gothic", sans-serif;
            background: #f9f9ff;
            margin: 0;
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        form {
            background: #fff;
            padding: 20px;
            max-width: 400px;
            margin: 20px auto;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #4e73df;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #3759c1;
        }
    </style>
</head>
<body>
    <h1>安否情報入力フォーム</h1>
    <form action="submit.php" method="post">
        <label for="name">氏名</label>
        <input type="text" id="name" name="name" required>

        <label for="status">状態</label>
        <select id="status" name="status">
            <option value="無事">無事</option>
            <option value="怪我">怪我</option>
            <option value="行方不明">行方不明</option>
        </select>

        <label for="comment">コメント</label>
        <textarea id="comment" name="comment"></textarea>

        <button type="submit">送信</button>
    </form>
</body>
</html>
