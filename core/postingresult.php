<?php
include "../misc/objs.php";
include "../misc/config.php";

session_start();
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
        <div id="sidebar" class="s34">
            <nav class="menu" id="nav">
                <h3 class="menu-heading">Dashboard</h3>
                <a class="nav-item" href="jobposting.php">Add Job Posting</a>
                <a class="nav-item active" href="managepostings.php">Manage Job Postings</a>
                <a class="nav-item" href="hire.php">Hire an Applicant</a>
                <a class="nav-item" href="shortlist.php">Accepted Applicants Shortlist</a>
                <a class="nav-item" href="apptrack.php">Track Applicant</a>
                <a class="nav-item" href="usermgt.php">Manage Users</a>
            </nav>
        </div>
        <div id="content">
            <h3><a href="managepostings.php" style="text-decoration: none">Manage Postings</a>/Info</h3>
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
            <li><a href="../index.php?find">Return to Index</a></li>
            <li style="float:right">
                <div class='dropdown'><a href='#hello'>Hello <?php echo $curr ?> </a>
                    <div class='dropdown-content'>
                        <a href='../settings.php' name='settings'>Edit My Info</a>
                        <a href='../misc/logout.php' name='logout' style='color: red'>Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

</body>
</html>

