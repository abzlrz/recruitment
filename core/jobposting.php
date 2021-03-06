<?php
include "../misc/objs.php";
include "../misc/config.php";

session_start();
$curr = $_SESSION['firstname'];

$msg = "";

$jobdescription = "";
$salary = "";
$skills = "";
$hiringtime = "";

$errorJobdescription = "";
$errorSalary = "";
$errorSkills = "";
$errorhiringtime = "";

if (!empty($_POST['jobdescription'])){
    $jobdescription = $_POST['jobdescription'];
} else {
    $errorJobdescription = "please enter Job Description";
}

if (!empty($_POST['salary'])){
    $salary = $_POST['salary'];
} else {
    $errorSalary = "please enter Salary";
}

if (!empty($_POST['skillsreq'])){
    $skills = $_POST['skillsreq'];
} else {
    $errorSkills= "please enter Skills Requirement";
}

if (!empty($_POST['hiringtime'])){
    $hiringtime = $_POST['hiringtime'];
} else {
    $errorHiringtime = "please enter Hiring Time";
}



if (!empty($_POST)){

    $obj = new JobPost();
    $obj->setConnection($connection);

    if ($obj->insert($jobdescription, $salary, $skills, $hiringtime)){
        $_SESSION['jobdescription'] = $obj->getJobDescription();
        $_SESSION['salary'] = $obj->getSalary();
        $_SESSION['skills'] = $obj->getSkillRequirements();
        $_SESSION['hiringtime'] = $obj->getHiringTime();
    }
    $msg = $obj->msg;
}

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
                <a class="nav-item active" href="jobposting.php">Add Job Posting</a>
                <a class="nav-item" href="managepostings.php">Manage Job Postings</a>
                <a class="nav-item" href="hire.php">Hire an Applicant</a>
                <a class="nav-item" href="shortlist.php">Accepted Applicants Shortlist</a>
                <a class="nav-item" href="apptrack.php">Track Applicant</a>
                <a class="nav-item" href="usermgt.php">Manage Users</a>
            </nav>
        </div>
        <div id="content">
            <h3>Post a Job</h3>
            <hr>
            <form action="" method="post">
                <table class="bg-23">
                    <tr>
                        <td style="padding-right: 1em">Job Description</td>
                        <td class="padding-bottom"><input class="inputform" type="text" name="jobdescription"></td>
                    </tr>
                    <tr>
                        <td style="padding-right: 1em">Salary</td>
                        <td class="padding-bottom"><input class="inputform" type="text" name="salary"></td>
                    </tr>
                    <tr>
                        <td style="padding-right: 1em">Skill Requirements</td>
                        <td class="padding-bottom"><textarea class="multiline-textarea" cols="40" rows="10" name="skillsreq"></textarea></td>
                    </tr>
                    <tr>
                        <td style="padding-right: 1em">Hiring time</td>
                        <td class="padding-bottom"><input class="inputform" type="text" name="hiringtime"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input class="search-btn" type="submit" name="submit"></td>
                    </tr>
                    <tr>
                        <td><div><?php echo $msg ?></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div>
        <ul class="navbar">
            <li><a href="../index.php">Return to Index</a></li>
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

