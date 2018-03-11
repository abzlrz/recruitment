<?php
include "php/objs.php";
include "php/config.php";

$msg = "";
$firstname = "";
$lastname = "";
$email = "";
$password = "";
$errorFirstname = "";
$errorLastname = "";
$errorEmail = "";
$errorPassword = "";

if (!empty($_POST['firstname'])){
    $firstname = $_POST['firstname'];
} else {
    $errorFirstname = "please enter your firstname";
}

if (!empty($_POST['lastname'])){
    $lastname = $_POST['lastname'];
} else {
    $errorLastname = "please enter your lastname";
}

if (!empty($_POST['email'])){
    $email = $_POST['email'];
} else {
    $errorEmail = "please enter your email";
}

if (!empty($_POST['password'])){
    $password = $_POST['password'];
} else {
    $errorPassword = "please enter your password";
}

if (!empty($_POST)){
    global $user;

    $obj = new User();
    $obj->setConnection($connection);

    if ($obj->signup($firstname, $lastname, $email, $password)){
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
    <title>Create an Account | ABC Global Careers</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
<div class="page-content">
    <header class="page-header"><img src="img/logo.svg" alt=""></header>
    <section class="form-content">
        <h1 id="pageHeaderText">Create an Account</h1>
        <form id="loginform" name="signupform" action="" method="post">
            <div class="form-inputs">

                <div class="form-group">
                    <label class="control-label"><span>Firstname</span></label>
                    <input class="form-control" type="text" name="firstname">
                    <div class="control-error"><?php $errorFirstname ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Lastname</span></label>
                    <input class="form-control" type="text" name="lastname">
                    <div class="control-error"><?php $errorLastname ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Email Address</span></label>
                    <input class="form-control" type="email" name="email">
                    <div class="control-error"><?php $errorEmail ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Password</span></label>
                    <input class="form-control" type="password" name="password">
                    <div class="control-error"><?php $errorPassword ?></div>
                </div>
            </div>
            <div class="control-error"><?php $msg ?></div>
            <button class="btn-signin" type="submit" name = "submit">Sign Up</button>
        </form>
    </section>
    <div class="navlinks">
        <a href="login.php">
            <div class="linkItem-title">Have an account? Sign in</div>
        </a>
        <a href="help.php">
            <div class="linkItem-title">Help Center</div>
        </a>
    </div>
</div>
</body>
</html>