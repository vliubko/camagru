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
    <h1 class="text-center login-title">Register Camagru</h1>

    <br>
    Registration page.
    <br>

    <?php if(!empty($pageData['error'])) :?>
                <p><font color=red><?php echo $pageData['error']; ?></font></p>
    <?php endif; ?>
    
    <?php if(empty($pageData['error']) || strpos($pageData['error'], "Succesful") === FALSE) : ?>
    
    <form id="register" method="post">
            <input type="text" name="user" id="user" placeholder="Username" autofocus><br>
            <input type="email" name="email" id="email" placeholder="Email" required><br>
            <input type="text" name="name" id="name" placeholder="Full Name" required><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
        <button class="btn blue" type="submit">
            Register
        </button>
    </form>

    <?php endif; ?>

    </center>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>

</body>
</html>
