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

    <h1 class="text-center login-title">Settings Page</h1>
    <img class="profile-img" src="/data/images/user.png">

    <?php echo "Hello, " . $_SESSION['name']; ?>

    <br>

    <form id="settings" method="post">
            <?php if(!empty($pageData['error'])) :?>
                <p><?php echo $pageData['error']; ?></p>
            <?php endif; ?>
            
            <p> Username</p>
            <input type="text" name="user" id="user" value="<?php echo $_SESSION['username'] ?>" autofocus><br>

            <p> Email </p>
            <input type="email" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" required><br>
            
            <div class="box">
                <a class="button-password" href="#popup1">Change Password</a>
            </div>
        <p>
            <input type="checkbox" class="checkbox" id="checkbox" name="notification" value="1" 
                <?php
                    if ($_SESSION['notification']) {
                        echo "checked='checked'";
                    } ?> />
            <label for="checkbox">Email notification</label>
        </p>
        <button type="submit">
            Change
        </button>
    </form>

    <div id="popup1" class="overlay">
        <div class="popup">
            <h2>Change Password</h2>
            <a class="close" href="#">&times;</a>
            <div class="password-div">
                <form id='change-password-form' method="post">
                    <input type="password" name="old_pwd" id="old_pwd" placeholder="Old Password" required><br>
                    <input type="password" name="password" id="password" placeholder="New Password" required><br>
                    <button id="change-password-button" type="submit">
                        Change
                    </button>
                </form>
            </div>
        </div>
    </div>

    <a href="/account/logout">Logout</a> <br>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/login_script.js"></script>
    <script src="/js/password_change.js"></script>
</body>
</html>