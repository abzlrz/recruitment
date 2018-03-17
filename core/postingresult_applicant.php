<?php
include "../misc/objs.php";
include "../misc/config.php";
session_start();

$result = "<li><a href=\"index.php?find\">Find Job</a></li>";
$logout = false;

if(!empty($curr = $_SESSION['firstname'])){
    $result.= "<li style=\"float:right\"><div class='dropdown'><a href='#hello'>Hello $curr! </a>";
    $result.="    <div class='dropdown-content'>";

    if($_SESSION['accesstype'] == false){
        $result.= "<a href='../core/jobposting.php' style='color: orange; font-weight: bold'>Recruitment</a>";
    }

    $result.= "           <a href='../settings.php' name='settings'>Edit Info</a>
                         <a href='../misc/logout.php' name='logout' style='color: red'>Logout</a>";
    $result.="</div></div></li>";
}
else {
    $result =  "<li style=\"float:right\"><a href=\"../login.php\">Sign In</a></li>";
    $result.=  "<li style=\"float:right\"><a href=\"../signup.php\">Sign Up</a></li>";
}



$curr = $_SESSION['firstname'];

$obj = new JobPost();
$obj->setConnection($connection);

if(isset($_GET['id'])){
    $_SESSION['jobpost_id'] = $_GET['id'];
}

if (isset($_GET['delete'])){
    $obj->delete($_GET['delete']);
    echo '<meta http-equiv=Refresh content="0;url=managepostings.php?reload=1">';
}


$obj->getInfoByID($_SESSION['jobpost_id']);

?>
<html>
<head>
    <title>Post a Job</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/recruitment.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins|Roboto+Mono" rel="stylesheet">
</head>
<body>

<div class="content">
    <div class="main">
        <div id="content">
            <h3><a href="postingresult_applicant.php" style="text-decoration: none">Job Postings</a>/Info</h3>
            <hr>
            <h2><?php echo $obj->getJobDescription()?></h2>
            <h4>Salary: <i><?php echo $obj->getSalary()?></i></h4>
            <p style="font-size: 13px"><?php echo $obj->getSkillRequirements()?>
                <br><br>
                <?php echo $obj->getHiringTime()?></p>
            <br>
            <span>
                <a id="d1" href="editjobpost.php?edit=<?php echo $_SESSION['jobpost_id']?>">Edit</a>
                <a id="d2" href="managepostings.php?delete=<?php echo $_SESSION['jobpost_id']?>">Delete</a>
            </span><br><br>
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

