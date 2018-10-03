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

    <?php if(empty($pageData['photos'])) {
        echo "<br>No photos in database!" ;
    } else {
            echo "<div class=\"photos\">";
        foreach ($pageData['photos'] as $key => $photo) { ?>
                <div class="photo" id="photo-<?php echo $photo['id'] ?>">
                    <div style="display: inline-flex; width: 100%; justify-content: space-between;">
                        <img height=20px src="/data/images/user-shape.png">
                        <div> <?php echo $photo['username'] ?> </div>
                        <div>
                            <?php if(!empty($photo['canDelete'])) {
                                if ($photo['canDelete']) {
                                    echo "<a class=\"close\" href=\"" . "/photo/delete/" . $photo['id'] . "\">&times;</a>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div>
                        <img class="img-photo" height=300px src="<?php echo $photo['url']; ?>"><br>
                    </div>
                    <div class="number-likes">
                        <?php echo $photo['likes']; ?>
                    </div>
                    
                    <div class="like">
                        <img class="like-img" height=20px src="/data/images/<?php if (!empty($photo['like_status'])) {
                                    echo "like_full.png";
                                } else {
                                    echo "like.png";
                                }
                        ?>">
                    </div>
                    
                    <div class="comment-img-div">
                        <a href="/photo/<?php echo $photo['id']; ?>">
                            <img class="comment-img" height=20px src="/data/images/comment.png">
                        </a>
                    </div>

                    <div class="comments" id="comments_div_ <?php echo $photo['id'];?>">
                        <?php foreach ($photo['comments'] as $key => $comment) {
                            echo "<div class=\"comment-" . $comment['id'] .  "\">";
                                echo $comment['username'] . " ";
                                echo $comment['message'];
                                if ($comment['showDelete']) {
                                    echo "<a href=\"/comment/delete/" . $comment['id'] . "\" class=\"close-thik\"></a>";
                                }
                            echo "</div>";
                            if ($key > 1) {
                                echo "<div class=\"viewAllComments-div-" . $photo['id'] .  "\">";
                                    echo "<a href=/photo/" . $photo['id'] . ">View all comments</a>";
                                echo "</div>";
                                break ;
                            }
                        } ?>
                    </div>

                    <div class="text_date">
                        <?php echo $photo['timeAgo']; ?>
                    </div>

                    <hr>
                    <div class="new_comment_div">
                        <form id="comment_form_ <?php echo $photo['id'];?>">
                            <input id="comment_text_ <?php echo $photo['id'];?>" placeholder="Enter a comment..." class="comment_text"></input>
                            <input id="comment_button_ <?php echo $photo['id'];?>" type="submit" value="Add"></input>
                        </form>
                    </div>

                </div> <br>
        <?php
        } ?>
        </div>
    <?php
} ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/like.js"></script>
    <script src="/js/comment.js"></script>
</body>
</html>
