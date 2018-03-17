<?php
session_start();
$result = "<li><a href=\"index.php?find\">Find Job</a></li>";
$logout = false;

if(!empty($curr = $_SESSION['firstname'])){
    $result.= "<li style=\"float:right\"><div class='dropdown'><a href='#hello'>Hello $curr! </a>";
    $result.="    <div class='dropdown-content'>";

    if($_SESSION['accesstype'] == false){
        $result.= "<a href='core/jobposting.php' style='color: orange; font-weight: bold'>Recruitment</a>";
    }

    $result.= "           <a href='settings.php' name='settings'>Edit Info</a>
                         <a href='misc/logout.php' name='logout' style='color: red'>Logout</a>";
    $result.="</div></div></li>";
}
else {
    $result =  "<li style=\"float:right\"><a href=\"login.php\">Sign In</a></li>";
    $result.=  "<li style=\"float:right\"><a href=\"signup.php\">Sign Up</a></li>";
}

if (!empty($_POST['submit'])){
    $_SESSION['search'] = $_POST['search'];
    $cursession = $_SESSION['search'];
    $destination = "location: core/searchresult.php?search=$cursession";
    header($destination);
}

?>
<html>
<head>
    <title>Search Job</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins|Roboto+Mono" rel="stylesheet">
</head>
<body>

<div class="content">
    <div class="main">
        <div class="logo-header" align="center" style="padding-top: 5em">
            <img src="img/logo.svg" width="500" height="200" alt="ABC Careers" align="center">
        </div>
        <div class="search-area">
            <form action="" method="post" class="search-form">
                <center>
                    <div class="search_bar">
                        <input type="search" class="search-text" size="40" name="search">
                    </div>
                    <div class="search-area">
                        <input class="search-btn" type="submit" name="submit" value="Search" style="font-size: 16px; font-weight: bold" autofocus>
                    </div>
                </center>
            </form>
        </div>
    </div>
    <div>
        <ul class="navbar">
            <?php echo $result ?>
        </ul>
    </div>
</div>

</body>
</html>

