<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <h1 class="text-center login-title">Register Camagru</h1>

    <br>
    Registration page.
    <br>

    <form id="register" method="post">
            <?php if(!empty($pageData['error'])) :?>
                <p><?php echo $pageData['error']; ?></p>
            <?php endif; ?>
            <input type="text" name="login" id="login" placeholder="Email" autofocus><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
            
        <button type="submit">
            Sign in</button>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>

</body>
</html>
