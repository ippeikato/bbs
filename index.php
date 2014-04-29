<?php
require_once('config.php');

function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

try {
	$dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
	if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
	isset($_POST['content']) &&
	isset($_POST['name'])) 
	// ここから下が謎です。
	/*
	$sql = "select * from posts";
	$stmt = $dbh->query($sql);
	*/
} catch (PDOException $e) {
	echo $e->getmessage();
		exit;
}
?>
<!DOCTYPE html>
<hrml lang="ja">
<head>
	<meta charset="UTF-8">
	<title>掲示板</title>
</head>
<body>
	<h1>掲示板</h1>
	<form action="" method="post">
　　　　	<input type="text" name="name"><br>
		<textarea name="content" rows="8" cols="40"></textarea><br>
		<input type="submit" value="投稿">
	</form
	<h2> 投稿一覧 0件</h2>
	<ul>
			<li>まだ投稿はありません。</li>
	</ul>
</body>
</html>
