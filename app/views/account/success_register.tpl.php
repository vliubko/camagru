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
    <h1 class="text-center login-title">Registration Camagru</h1>

    <p>
        <?php echo $pageData['message']; ?>
    </p>

    <script language="javascript">   
        setTimeout("window.location='/account/login'", 5000);  
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>

</body>
</html>
