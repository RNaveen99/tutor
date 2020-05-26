<?php

//  Initialise the session
session_start();

//  Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
if ($_SESSION['privileges'] == 0) {
    header('location:welcome.php');
    exit;
}
require_once ('config.php');
$topicname = $mdfilename = $mdfileurl = $textfilename = $textfileurl = '';
$topicname_err = $mdfilename_err = $mdfileurl_err = $textfilename_err = $textfileurl_err ='';

//-----------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //  ------------------ validate topic name ---------------------------
    if (empty(trim($_POST['topicname']))) {
        $topicname_err = 'Please enter a topic name';
    }
    else {
        // Prepare a select statement
        $sql = "select topic_id from topics where topic_name = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_topicname);
            
            // Set parameters
            $param_topicname = trim($_POST['topicname']);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                // store result
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) >= 1) {
                    $topicname_err = 'This topic is already used';
                } else {
                    $topicname = trim($_POST['topicname']);
                    $mdfilename = $topicname;
                    $textfilename = $topicname;
                    $mdfileurl = "md/$mdfilename.md";
                    $textfileurl = "text/$textfilename.txt";
                }
            } else {
                echo 'Something went wrong. Please try again later';
            }
        }

        //  close statement
        mysqli_stmt_close($stmt);
    }
    //  -----------check input errors before inserting into database----------------
    if (empty($topicname_err)) {
        
        //  Prepare an insert statement
        $sql = "insert into topics (topic_name, md_file_name, md_file_url, text_file_name, text_file_url) values (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_topicname, $param_mdfilename, $param_mdfileurl, $param_textfilename, $param_textfileurl);

            //  set parameters
            $param_topicname = $topicname;
            $param_mdfilename = $mdfilename;
            $param_mdfileurl = $mdfileurl;
            $param_textfilename = $textfilename;
            $param_textfileurl = $textfileurl;

            //  attempt to execute the prepared statements
            if (mysqli_stmt_execute($stmt)) {
                
                $myfile = fopen($param_mdfileurl, 'w');
                $content = "# $topicname";
                fwrite($myfile, $content);
                fclose($myfile);
                
                $content = "<h1> $topicname </h1>";
                $myfile = fopen($param_textfileurl, 'w');
                fwrite($myfile, $content);
                fclose($myfile);
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        //  close statement
        mysqli_stmt_close($stmt);
    }
    //--------------------------------------------------------------------------------------

    // close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php' ?>
    <title>Add Topics</title>
</head>
<body>
    <?php require_once 'headermain.php'; ?>

    <?php 
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (empty($topicname_err))) {
            echo "<div class='green-msg center'> Topic Added </div>";
        }
    
    ?>

    <div class="container">
        <div class="row">
            <h1 class="col s12" style="color:#ee6e73;">Add Topics</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" name="topicname" id="topicname" class="validate">
                        <label for="topicname" class="active">Enter Topic name</label>
                        <span class="helper-text"><?php echo $topicname_err; ?></span>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>

    <?php require_once 'footermain.php'; ?>
</body>
</html>