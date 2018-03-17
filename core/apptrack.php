<?php
session_start();
$curr = $_SESSION['firstname'];
?>
<html>
<head>
    <title>Applicant Tracking</title>
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
                <a class="nav-item" href="managepostings.php">Manage Job Postings</a>
                <a class="nav-item" href="hire.php">Hire an Applicant</a>
                <a class="nav-item" href="shortlist.php">Accepted Applicants Shortlist</a>
                <a class="nav-item active" href="apptrack.php">Track Applicant</a>
                <a class="nav-item" href="usermgt.php">Manage Users</a>
            </nav>
        </div>
        <div id="content">
            <h3>Track Applicant</h3>
            <hr>
            <table class="bg-23">
                <tr>
                    <td style="padding-right: 1em">Job Description</td>
                    <td class="padding-bottom"><input class="inputform" type="text"></td>
                </tr>
                <tr>
                    <td style="padding-right: 1em">Salary</td>
                    <td class="padding-bottom"><input class="inputform" type="text"></td>
                </tr>
                <tr>
                    <td style="padding-right: 1em">Skill Requirements</td>
                    <td class="padding-bottom"><textarea name="skills" class="multiline-textarea" cols="40" rows="10"></textarea></td>
                </tr>
                <tr>
                    <td style="padding-right: 1em">Hiring time</td>
                    <td class="padding-bottom"><input class="inputform" type="text"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn-signin" type="submit"></td>
                </tr>
            </table>
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

