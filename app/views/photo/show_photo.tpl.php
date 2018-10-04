<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/header.css">
</head>

<body>

    <?php include_once ROOT. "/views/header.php" ; ?>

<?php
    $photo = $pageData['photo'];?>
    <div class="photos">

        <?php include ROOT . "/views/photo/single_photo.tpl.php"; ?>

    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/like.js"></script>
    <script src="/js/comment.js"></script>
</body>
</html>