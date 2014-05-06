<?php
require_once ('config.php');

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$posts = array();

try {
    $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content']) && isset($_POST['name'])) {
        $stmt = $dbh -> prepare("insert into posts (`name`, `content`) values (?, ?)");
        $stmt -> execute(array($_POST['name'], $_POST['content']));
    }
    $stmt = $dbh -> query('select * from posts');
    foreach ($stmt as $row) {
        array_push($posts, $row);
    }
} catch (PDOException $e) {
    echo $e -> getmessage();
    exit ;
}

$posts = array_reverse($posts);
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
	<h2> 投稿一覧 <?php echo count($posts); ?>件</h2>
	<ul>
		<?php if (count($posts)) : ?>
		<?php foreach ($posts as $post) : ?>
    		<li><?php echo h($post['name']),   h($post['content']); ?></li>
		<?php endforeach; ?>
		<?php else : ?>
			<li>まだ投稿はありません。</li>
		<?php endif; ?>
	</ul>
</body>
</html>
