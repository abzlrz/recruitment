<?php
include "misc/objs.php";
include "misc/config.php";

$msg = "";

if (isset($_POST['submit'])){
    global $user;

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $obj = new User();
    $obj->setConnection($connection);

    if ($obj->login($email, $pass)){
        $_SESSION['userid'] = $obj->getID();
        $_SESSION['firstname'] = $obj->getFirstname();
        $_SESSION['lastname'] = $obj->getLastname();
        $_SESSION['email'] = $obj->getEmail();
        $_SESSION['password'] = $obj->getPassword();
        $_SESSION['accesstype'] = $obj->isApplicant();

        $obj->proceed();
    }

    $msg = $obj->msg;
}
?>
<html>
<head>
    <title>Login | ABC Global Careers</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="page-content">
    <header class="page-header"><img src="img/logo.svg" alt=""></header>
    <section class="form-content">
        <h1 id="pageHeaderText">Sign In</h1>
        <form id="loginform" name="loginform" method="post">
            <div class="form-inputs">

                <div class="form-group">
                    <label class="control-label"><span>Email Address</span></label>
                    <input class="inputform" type="email" name="email">
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Password</span></label>
                    <input class="inputform" type="password" name="password">
                </div>

            </div>
            <div class="control-error"><?php echo $msg ?></div>
            <button class="btn-signin" type="submit" name="submit">Sign In</button>
        </form>
    </section>
    <div class="navlinks">
        <a href="signup.php">
            <div class="linkItem-title">Not a member? Create an account free</div>
        </a>
        <a href="help.php">
            <div class="linkItem-title">Help Center</div>
        </a>
    </div>
</div>
</body>
</html>