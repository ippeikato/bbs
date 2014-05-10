<?php
session_start();

if(!isset($_SESSION["user_name"])) {
	header("location: logout.php");
	exit;
}

echo "ようこそ" . $_SESSION["user_name"] . "さん";

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
	echo $e->getmessage();
		exit;
}

$posts = array_reverse($posts);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>掲示板</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<style>
	.deletePost {
		cursor: pointer;
		color: blue;
	}
	</style>
</head>
<body>
	<h1>掲示板</h1>
	<form action="" method="post">
　　　　	<input type="text" name="name"><br>
		<textarea name="content" rows="8" cols="40"></textarea><br>
		<input type="submit" value="投稿">
	</form
	<h2> 投稿一覧 <?php echo count($posts); ?>件</h2>
	<ul id="posts">
		<?php if (count($posts)) : ?>
		<?php foreach ($posts as $post) : ?> <br>
    	<li　id="post_<?php echo h($post['id']); ?>" data-id="<?php echo h($post['id']); ?>" >
    		<?php echo h($post['content']), h($post['name']), h($post['id']); ?>
    		<span class="deletePost">[削除]</span>
    	</li>
		<?php endforeach; ?>
		<?php else : ?>
			<li>まだ投稿はありません。</li>
		<?php endif; ?>
	</ul>
	<div><a href="logout.php">ログアウト</a></div>
	<script>
	$(function() {

		$(document).on('click', '.deletePost', function() {
			if (confirm('本当に削除しますか？')) {
				var id = $(this).parent().data('id');
				$.post('_ajax_delete_post.php', {
					id: id
				}, function(rs) {
					$('#post_'+id).fadeOut(800);
				});
			}
		});
	});
	</script>
</body>
</html>
