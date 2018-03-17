<?php
session_start();
include '../misc/config.php';
include '../misc/objs.php';
global $connection;


$curr = $_SESSION['firstname'];
$obj = new JobPost();
$obj->setConnection($connection);

if (isset($_GET['delete'])){
    $obj->delete($_GET['delete']);
    echo '<meta http-equiv=Refresh content="0;url=managepostings.php?reload=1">';
}
?>
<html>
<head>
    <title>Manage Postings</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/recruitment.css">
    <link rel="stylesheet" href="../css/misc.css">
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
            <h3>Manage Postings</h3>
            <hr>
            <?php foreach ($obj->showAll() as $row){ ?>
            <div class="jobpost-content">
                <a href="postingresult.php?id=<?php echo $row['id'];?>" class="jobdescription"><?php echo $row['jobdescription']; ?></a>
                <div class="salary"><?php echo $row['salary'];?></div>
                <div class="qualification"><?php echo $row['skillrequirements'];?></div>
                <div class="controls">
                    <span>
                        <a id="d1" href="editjobpost.php?edit=<?php echo $row['id']?>">Edit</a>
                        <a id="d2" href="managepostings.php?delete=<?php echo $row['id']?>">Delete</a>
                    </span>
                </div>
            </div>
            <?php } ?>
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

