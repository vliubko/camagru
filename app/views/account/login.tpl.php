<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/header.css">
</head>

<body>

    <?php include_once ROOT. "/views/header.php" ; ?>
    <center>
    <h1 class="text-center login-title">Login page Camagru</h1>
    <img class="profile-img" src="/data/images/user.png" alt="">
        <form class="form-signin" id="form-signin" method="post">
            <?php if(!empty($pageData['error'])) :?>
                <p><font color=red><?php echo $pageData['error']; ?></font></p>
            <?php endif; ?>
            <input type="text" name="login" id="login" placeholder="Username" autofocus><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
        <button class="btn green" type="submit">
            Sign in</button>
        </form>
    <br>
    <a class="btn red" id="small_btn" href="/account/recovery">Reset password? </a> <br>
    <a class="btn blue" id="small_btn" href="/account/register">Create an account </a>
    </center>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>

</body>
</html>
