<?php
//  Initialise the session
session_start();
//  Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
if ($_SESSION['privileges'] == 0) {
    header('location:display.php');
    exit;
}
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
    <style>select {display:block;}</style>
    <title>Update Topics</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
<?php if ((isset($_SESSION['updated'])) && $_SESSION['updated'] === true) {
    echo "<div class='green-msg center'> File Updated </div>";
    unset($_SESSION['updated']);
}
?>
    <div class="container">
        <div class="row">
            <h1 class="col s12 center" style="color:#ee6e73;">Select topic:</h1>
            <form action="<?php echo htmlspecialchars('update2.php'); ?>" method="post" class="col s12">
                <div class="input-field col s12">
                    <select name="topic" id="topic">
                        <option value="" disabled selected>Choose Topic</option>
                        <?php $sql = 'select topic_name from topics';
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_array($result)) {
                                    echo "<option value=\"$row[0]\">$row[0]</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="input-field col s12">
                    <select name="filetype" id="filetype">
                    <option value="" disabled selected>Choose File Type</option>
                    <option value="mdfile">MarkDown file</option>
                    <option value="textfile">Text file</option>
                    </select>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Load
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>    

    <?php require_once 'footermain.php'; ?>
</body>
</html>

