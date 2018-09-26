<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/camera.css">
    <link rel="stylesheet" href="/css/header.css">
</head>



<body>
    
    <?php include_once ROOT. "/views/header.php" ; ?>

    

    <div id="parent-div">

        <div id="choice-div">
        <center>
            <h1 class="text-center login-title">Photo part Camagru</h1>
            
            <a class="btn blue" id="open-camera-button" onClick="attach_cam()">Open Camera</a>
            <a class="btn green" href="#popup1" id="camera-button-take-snap">Upload photo</a>
        </center>
        </div>

        <!-- style="visibility: hidden;" -->

        <div id="results" style="display: none;">
        </div>

        <?php include 'loading_spinner.php' ?>

        <div id="my_camera">
        </div>

        <div id="stickers-div">
            <div id="stickers-salt" class="div_with_sticker_img">
                <img src="/data/stickers/salt.png">
            </div>
            <div id="stickers-cool" class="div_with_sticker_img">
                <img src="/data/stickers/cool.png">
            </div>
            <div id="stickers-baby" class="div_with_sticker_img">
                <img src="/data/stickers/baby.png">
            </div>
            <div id="stickers-cat" class="div_with_sticker_img">
                <img src="/data/stickers/cat.png">
            </div>
        </div>

        <div id="popup1" class="overlay">
        <div class="popup">
            <a class="close" href="#">&times;</a>
            <div class="upload-div">
                <form id="upload form" method="POST" enctype="multipart/form-data">
                    <input style="width: 300px;" class="btn red" name="upload" type="file">
                    <br>
                    <input class="btn green" type="submit" value="Send">
                </form>
            </div>
        </div>
        </div>

    </div>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/webcam.min.js"></script>
    <script src="/js/camera.js"></script>

</body>
</html>
