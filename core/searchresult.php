<?php
session_start();
include '../misc/config.php';
include '../misc/objs.php';

$jobpost = new JobPost();

$result = "<li><a href=\"..\index.php?find\">Find Job</a></li>";
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

$jobpost->setConnection($connection);

if (isset($_GET['apply'])){
    $jobpost->applyJob($_SESSION['userid'], $_SESSION['jobpost_id']);
    echo '<meta http-equiv=Refresh content="0;url=searchresult.php?reload=1">';
}

if(isset($_GET['id'])){
    $_SESSION['jobpost_id'] = $_GET['id'];
}

$queryresult = $jobpost->searchJob($_SESSION['search']);

?>
<html>
<head>
    <title>Search Job</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/recruitment.css">
    <link rel="stylesheet" href="../css/misc.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins|Roboto+Mono" rel="stylesheet">
</head>
<body>

<div class="content">
    <div class="main">
        <div id="content-search" style="width: 67%">
            <h3>Search results for '<?php echo $_SESSION['search']?>'</h3>
            <hr>
            <?php foreach ($queryresult as $row){ ?>
                <div class="jobpost-content">
                    <a href="postingresult_applicant.php?id=<?php echo $row['id'];?>" class="jobdescription"><?php echo $row['jobdescription']; ?></a>
                    <div class="salary"><?php echo $row['salary'];?></div>
                    <div class="qualification"><?php echo $row['skillrequirements'];?></div>
                    <div class="controls">
                        <span>
                        <a id="d1" href="searchresult.php?apply=<?php echo $row['id']?>">Apply</a>
                    </span>
                    </div>
                </div>
            <?php } ?>
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

