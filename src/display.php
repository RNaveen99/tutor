<?php

//  Initialise the session
session_start();


require_once ('config.php');
$topicname = $mdfilename = $mdfileurl = $textfilename = $textfileurl = '';
$topicname_err = $mdfilename_err = $mdfileurl_err = $textfilename_err = $textfileurl_err ='';

//-----------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <link rel="stylesheet" href="disp.css">
    <title>Learn</title>
</head>
<body>
    
<?php require_once 'headermain.php'; ?>
    
    <div class="row">
        <div class="col s2 vnav" style="background-color:#e87d81;">
                <?php
                    $sql = "select topic_name from topics order by topic_id";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        echo "<ul>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<li class='left-align' ><a href = display.php?topic=$row[0]> $row[0]</a></li>";
                        }
                        echo "</ul>";
                    }
                ?>
            </div>
        <div class="col s9 offset-s1">
            <?php
                if (($_SERVER['REQUEST_METHOD'] == 'GET') && (!empty($_GET['topic']))) {
                    $topic = $_GET['topic'];
                    $sql = "select text_file_url from topics where topic_name = '$topic' ";
                    
                    $result = mysqli_query($conn, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);
                        $myfile = fopen($row[0], 'r');
                        $html = fread($myfile, filesize($row[0]));
                        echo $html;
                    }
                } else {
                    echo "<h1>This is a php learning website</h1>";
                }
            ?>
        </div>
    </div>

    <?php require_once 'footermain.php'; ?>
</body>
</html>