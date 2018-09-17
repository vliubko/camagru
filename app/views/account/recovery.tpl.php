<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <h1 class="text-center login-title">Reset Password Camagru</h1>

    
    <p>
    If you forget your password, you can restore it. <br>
    Enter your email to get new password, please.
    </p>

    <form id="recover" method="post">
            <?php if(!empty($pageData['error'])) :?>
                <p><?php echo $pageData['error']; ?></p>
            <?php endif; ?>
            <input type="email" name="email" id="email" placeholder="Email" required><br>
        <button type="submit">
            Restore password
        </button>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>

</body>
</html>
