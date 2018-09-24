<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/camera.css">
    <link rel="stylesheet" href="/css/header.css">

    <style>
        .none {
            -webkit-filter: none;
            filter: none;
        }
        .blur {
            -webkit-filter: blur(3px);
            filter: blur(3px);
        }
        .grayscale {
            -webkit-filter: grayscale(1);
            filter: grayscale(1);
        }
        .invert {
            -webkit-filter: invert(1);
            filter: invert(1);
        }
        .sepia {
            -webkit-filter: sepia(1);
            filter: sepia(1);
        }
        button#snapshot {
            margin: 0 10px 25px 0;
            width: 110px;
        }
        video {
            object-fit: cover;
        }
    </style>
</head>



<body>
    
    <?php include_once ROOT. "/views/header.php" ; ?>

    <h1 class="text-center login-title">Photos Camagru</h1>
    
    Add photo here.
    Canvas and buttons?

    <div id="container">

        <video id="gum-local" autoplay playsinline></video>
        <button id="showVideo">Open camera</button>
        

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/camera.js"></script>

</body>
</html>
