<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <h1 class="text-center login-title">Login page Camagru</h1>
    <img class="profile-img" src="/data/images/user.png" alt="">
        <form class="form-signin" id="form-signin" method="post">
            <?php if(!empty($pageData['error'])) :?>
                <p><?php echo $pageData['error']; ?></p>
            <?php endif; ?>
            <input type="text" name="login" id="login" placeholder="Email" autofocus>
            <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit">
            Sign in</button>
        </form>
    <br>
    <a href="/account/recovery">Reset password? </a> <br>
    <a href="/account/register">Create an account </a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>

</body>
</html>
