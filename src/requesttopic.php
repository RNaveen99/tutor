<?php
session_start();
require_once 'config.php';

//  Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
$requesttopic = $requesttopic_err = '';

if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['requesttopic'])) {
    $requesttopic = trim($_POST['requesttopic']);
    if ($requesttopic == '') {
        $requesttopic_err = 'Please enter a topic.';
    }
    if (empty($requesttopic_err)) {
        $sql = "select id, topic_name, status from requesttopic where topic_name = '$requesttopic'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if ($row[2] == 'pending') {
                $requesttopic_err = 'Topic already in queue.';
            } else if ($row[2] == 'approved') {
                $requesttopic_err = 'Topic already exists in the Learn Section.';
            }
        } else {
            $sql = "insert into requesttopic (topic_name, status) values ('$requesttopic', 'pending')";
            mysqli_query($conn, $sql);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <title>Request Topic</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
    <div class="container">
        <div class="row">
            <h1 class="col s12">Request Topic</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" name="requesttopic" id="requesttopic" class="validate">
                        <label for="requesttopic" class="active">Request Topic</label>
                        <span class="helper-text"> <?php echo $requesttopic_err ; ?></span>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Request Topic
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>        
    </div>
    <?php require_once 'footermain.php'; ?>
</body>
</html>