<?php
include "misc/objs.php";
include "misc/config.php";

$obj = new User();
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

    $obj->setConnection($connection);

    $target = $_SESSION['email'];
    $acctype = 0;
    if ($_SESSION['accesstype'] == false){
       $acctype = 1;
    }

    if ($obj->updateAccount($firstname, $lastname, $email, $password, $acctype, $target)){
        $_SESSION['firstname'] = $obj->getFirstname();
        $_SESSION['lastname'] = $obj->getLastname();
        $_SESSION['email'] = $obj->getEmail();
        $_SESSION['password'] = $obj->getPassword();
        $_SESSION['accesstype'] = $obj->isApplicant();
    }
    $msg = $obj->msg;
}
?>
<html>
<head>
    <title>Create an Account | ABC Global Careers</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/settings.css">
</head>
<body>
<div>
    <ul class="navbar">
        <li style="float: right"><a href="index.php">Return</a></li>
    </ul>
</div>
<div class="page-content">
    <header class="page-header"><img src="img/logo.svg" alt=""></header>
    <section class="form-content">
        <h1 id="pageHeaderText">Edit Info</h1>
        <form id="loginform" name="signupform" action="" method="post">
            <div class="form-inputs">

                <div class="form-group">
                    <label class="control-label"><span>Firstname</span></label>
                    <input class="form-control" type="text" name="firstname" value="<?php echo $_SESSION['firstname']; ?>">
                    <div class="control-error"><?php $errorFirstname ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Lastname</span></label>
                    <input class="form-control" type="text" name="lastname" value="<?php echo $_SESSION['lastname']; ?>">
                    <div class="control-error"><?php $errorLastname ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Email Address</span></label>
                    <input class="form-control" type="email" name="email" value="<?php echo $_SESSION['email']; ?>">
                    <div class="control-error"><?php $errorEmail ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><span>Password</span></label>
                    <input class="form-control" type="password" name="password" value="<?php echo $_SESSION['password']; ?>">
                    <div class="control-error"><?php $errorPassword ?></div>
                </div>
            </div>
            <div class="control-error"><?php echo $msg ?></div>
            <button class="btn-signin" type="submit" name="submit">Update</button>
        </form>
    </section>
    <div class="navlinks">
        </a>
        <a href="help.php">
            <div class="linkItem-title">Help Center</div>
        </a>
    </div>
</div>
</body>
</html>