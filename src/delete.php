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
//-----------------------------------------------------------------------------------
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['topic'])) {
    $deletetopic = $_POST['topic'];
    $sql = "select md_file_url, text_file_url from topics where topic_name ='$deletetopic' ";
    $result = mysqli_query($conn, $sql);
    $mdfile = $textfile = '';

    $row = mysqli_fetch_array($result);
    $mdfile = $row[0];
    $textfile = $row[1];

    unlink($mdfile) or die("Couldn't delete file");
    unlink($textfile) or die("Couldn't delete file");
    
    // $myfile = fopen($mdfile, 'w');
    // fclose($myfile);
    // $myfile = fopen($textfile, 'w');
    // fclose($myfile);

    $sql = "delete from topics where topic_name = '$deletetopic'";
    mysqli_query($conn, $sql);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <style>select {display:block;}</style>
    <title>Delete Topic</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
    <?php 
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['topic'])) {
            echo "<div class='green-msg center'> Topic Deleted </div>";
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !isset($_POST['topic'])) {
            echo "<div class='red-msg center'> First Select Topic  </div>";
        }
    
    ?>
    <div class="container">
        <div class="row">
            <h1 class="col s12" style="color:#ee6e73;">Select Topic</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="col s12">
                <div class="input-field col s12">  
                    <select name="topic" id="topic">
                        <option value="" disabled selected>Choose Topic</option>
                        <?php $sql = 'select topic_name from topics';
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_array($result)) {
                                 echo "<option value='$row[0]'>$row[0]</option>";
                                }
                            }
                        ?>
                    </select> 
                    <label class="active">Select topic</label>   
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Delete
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    
    <?php require_once 'footermain.php'; ?>
</body>
</html>
