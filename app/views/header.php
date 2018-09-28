<header>

<div id="header-div">

    <div id="logo-div">
        <a href="/">
            <img id="devops-logo-img" src="/data/images/devops_camagru.png">
        </a>
    </div>

    <div id="other_div">
        <ul id="buttons-div">
            <?php if (isset($_SESSION['username'])): ?>
            <li>Hello, <?= $_SESSION['username'];?></li>
                <li><a href="/account/settings" class="btn blue">Settings</a></li>
                <li><a href="/account/logout" class="btn red">Logout</a></li>
                <li><a href="/photo" class="btn green">Add photo</a></li>
            <?php else: ?>
                <li><a href="/account/login" class="btn blue">Login</a></li>
                <li><a href="/account/register" class="btn blue">Create an account</a></li>
            <?php endif;?>
        </ul>
    </div>

</div>
</header>
<!-- <br> -->