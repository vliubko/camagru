<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/main.css">
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

<?php
    $photo = $pageData['photo'];
    echo "<div class=\"photos\">";
    echo "<div class=\"photo\" id=\"photo-". $photo['id']. "\">\n";
    echo "<img height=20px src=\"/data/images/user-shape.png\">";
    echo " " . $photo['username']."<br>";
    echo "<img class=\"img-photo\" height=300px src=" . $photo['url'] . "><br>\n";
    echo "<div class=\"like\">";
    if (!empty($photo['like_status'])) {
        echo "<img class=\"like-img\" height=20px src=\"/data/images/like_full.png\">";
    } else {
        echo "<img class=\"like-img\" height=20px src=\"/data/images/like.png\">";
    }
    echo "</div>";
    echo "<div class=\"number-likes\">" . $photo['likes'] . "</div>";

    foreach ($photo['comments'] as $comment) {
        echo "<div class=\"comment\">";
        echo $comment['username'] . " ";
        echo $comment['message'];
        echo "</div>";
    }

    echo "<div class=\"text-date\">". $photo['timeAgo'] . "</div>";
    echo "<hr>";
    echo "<form id=\"comment_form\">";
    echo "<input
    onkeypress=\"insertComment(event, '', '1')\"
    id=\"comment_text_1\" placeholder=\"Enter a comment...\" class=\"comment_text\"></input>";
    echo "</form>";
    echo "<button type=\"submit\" form=\"comment_form\" value=\"Submit\">Add</button>";
    echo "\n</div>\n";
    echo "\n</div>\n";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/like.js"></script>
</body>
</html>