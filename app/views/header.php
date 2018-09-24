<header>

<div id="header-div">

    <div id="logo-div">
        <a href="/">
            <img id="devops-logo-img" src="/data/images/devops_camagru.png">
        </a>
    </div>

    <div id="buttons-div">
            <?php if (isset($_SESSION['username'])) {
                    echo "Hello, " . $_SESSION['username'];
                    echo "<a href=\"/account/settings\" class=\"btn blue\">Settings</a>";
                    echo "<a href=\"/account/logout\" class=\"btn red\">Logout</a>";
                    echo "<a href=\"/photo\" class=\"btn green\">Add photo</a>";
            } else {
                echo "<a href=\"/account/login\" class=\"btn blue\">Login</a>";
                echo "<a href=\"/account/register\" class=\"btn blue\">Create an account</a>";
            }?>
    </div>

</div>
</header>
<!-- <br> -->