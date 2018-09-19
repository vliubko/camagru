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
    <div id="buttons">
        <?php if (isset($_SESSION['username'])) {
                echo "Hello, " . $_SESSION['username'] . "<br>";
                echo "<a href=\"/account/settings\" class=\"btn blue\">Settings</a> <br>";
                echo "<a href=\"/account/logout\" class=\"btn red\">Logout</a> <br>";
                echo "<a href=\"/photo\" class=\"btn green\">Add photo</a>";
        } else {
            echo "<a href=\"/account/login\" class=\"btn blue\">Login</a> <br>";
            echo "<a href=\"/account/register\" class=\"btn blue\">Create an account</a> <br>";
        }?>
    </div>
    <br>

    <?php if(empty($pageData['photos'])) {
        echo "<br>No photos in database!" ;
    } else {
        foreach ($pageData['photos'] as $key => $photo) {
            echo "<img border=5 height=300px src=".$photo['url']."><br>";
            echo $photo['username']."<br>";
            echo $photo['likes']. " ";
            echo "<img class=\"likes\" id=\"like-but-". $photo['id']."\"height=20px src=\"/data/images/like.png\"><br>";
        }
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/like.js"></script>
</body>
</html>
