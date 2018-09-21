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

    <?php if(empty($pageData['photos'])) {
        echo "<br>No photos in database!" ;
    } else {
            echo "<div class=\"photos\">";
        foreach ($pageData['photos'] as $photo) {
                echo "<div class=\"photo\" id=\"photo-". $photo['id']. "\">\n";
                echo "<img height=20px src=\"/data/images/user-shape.png\">";
                echo " " . $photo['username']."<br>";
                echo "<img class=\"img-photo\" height=300px src=".$photo['url']."><br>\n";
                echo "<div class=\"number-likes\">" . $photo['likes'] . "</div>";
                echo "<div class=\"like\">";
                if (!empty($photo['like_status'])) {
                    echo "<img class=\"like-img\" height=20px src=\"/data/images/like_full.png\">";
                } else {
                    echo "<img class=\"like-img\" height=20px src=\"/data/images/like.png\">";
                }
                echo "</div>";
                echo "<div class=\"comment-img-div\">";
                    echo "<a href=\"/photo/". $photo['id'] . "\">";
                        echo "<img class=\"comment-img\" height=20px src=\"/data/images/comment.png\">";
                    echo "</a>";
                echo "</div>";

                foreach ($photo['comments'] as $comment) {
                    echo "<div class=\"comment\">";
                    echo $comment['username'] . " ";
                    echo $comment['message'];
                    echo "</div>";
                }

                echo "<div class=\"text-date\">". $photo['timeAgo'] . "</div>";
                echo "<hr>";
                echo "<div class=\"comment_div\">";
                    echo "<form id=\"comment_form_" . $photo['id'] . "\">";
                    echo "<input id=\"comment_text_" . $photo['id'] . "\" placeholder=\"Enter a comment...\" class=\"comment_text\"></input>";
                    echo "<input id=\"comment_button_" . $photo['id'] . "\" type=\"submit\" value=\"Add\"></input>";
                    echo "</form>";
                    
                echo "\n</div>\n";
                echo "\n</div>\n";
        }
            echo "\n</div>\n";
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/like.js"></script>
    <script src="/js/comment.js"></script>
</body>
</html>
