<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <h1 class="text-center login-title">Settings Page</h1>
    <img class="profile-img" src="/data/images/user.png">

    <?php echo "Hello," . $_SESSION['name']; ?>

    <br>

    <a href="/account/sendmail"> Send mail </a>
    <a href="/account/logout">Logout</a> <br>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
</body>
</html>