<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/header.css">
</head>

<body>

    <?php include_once ROOT. "/views/header.php" ; ?>

<?php
    $photo = $pageData['photo'];
    echo "<div class=\"photos\">";
        echo "<div class=\"photo\" id=\"photo-". $photo['id']. "\">\n";
            echo "<img height=20px src=\"/data/images/user-shape.png\">";
            echo " " . $photo['username']."<br>";
            echo "<img class=\"img-photo\" height=300px src=".$photo['url']."><br>\n";

            echo "<div class=\"number-likes\">";
                echo $photo['likes'];
            echo "</div>";
            
            echo "<div class=\"like\">";
            echo "<img class=\"like-img\" height=20px src=\"/data/images/";
            if (!empty($photo['like_status'])) {
                echo "like_full.png\">";
            } else {
                echo "like.png\">";
            }
            echo "</div>";

            echo "<div class=\"comment-img-div\">";
                echo "<a href=\"/photo/". $photo['id'] . "\">";
                    echo "<img class=\"comment-img\" height=20px src=\"/data/images/comment.png\">";
                echo "</a>";
            echo "</div>";

            echo "<div class=\"comments\" id=\"comments_div_" . $photo['id'] . "\">";
                foreach ($photo['comments'] as $comment) {
                    echo "<div class=\"comment\">";
                        echo $comment['username'] . " ";
                        echo $comment['message'];
                        if ($comment['showDelete']) {
                            echo "<a href=\"/comment/delete/" . $comment['id'] . "\" class=\"close-thik\"></a>";
                        }
                    echo "</div>";
                }
            echo "</div>";

            echo "<div class=\"text_date\">";
                echo $photo['timeAgo'];
            echo "</div>";

            echo "<hr>";
            echo "<div class=\"new_comment_div\">";
                echo "<form id=\"comment_form_" . $photo['id'] . "\">";
                echo "<input id=\"comment_text_" . $photo['id'] . "\" placeholder=\"Enter a comment...\" class=\"comment_text\"></input>";
                echo "<input id=\"comment_button_" . $photo['id'] . "\" type=\"submit\" value=\"Add\"></input>";
                echo "</form>";
            echo "\n</div>\n";
        echo "\n</div>\n";
    echo "\n</div>\n";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/like.js"></script>
    <script src="/js/comment.js"></script>
</body>
</html>