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

    <h1 class="text-center login-title">Photos Camagru</h1>
    
    Add photo here.
    Canvas and buttons?

    <form>
        <input type=button id="camera-button" value="Open Camera" onClick="attach_cam()">
        <input type=button style="visibility: hidden;" id="camera-button-take-snap" value="Take Snapshot" onClick="take_snapshot()">
    </form>
    <div id="results" style="display: none;">
    </div>
    
	<div id="my_camera">
    </div>

    
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/webcam.min.js"></script>
    <script src="/js/camera.js"></script>

</body>
</html>
