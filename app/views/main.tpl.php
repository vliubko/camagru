<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <h1 class="text-center login-title">DevOps Camagru</h1>
    <img class="profile-img" src="/data/images/user.png" alt="">
    <br>
    <a href="/account/login">Login</a> <br>
    <a href="/account/register">Create an account </a>

    <!-- <h4> Debug info: </h4>
    <?php var_dump ($_SESSION); ?> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
</body>
</html>
