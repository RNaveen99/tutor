<?php 

session_start();
require_once'config.php';
//  Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
if ($_SESSION['privileges'] == 0) {
    header('location:display.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve'])) {
        $id = $_POST['id'];
        $requesttopic = trim($_POST['requesttopic']);

        $sql = "update requesttopic set status = 'approved' where id = $id";
        mysqli_query($conn, $sql);
    } 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php' ?>
    <title>Manage Requests</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
    <div class="quiz">
    <table class="centered">
        <thead>
            <tr>
                <th>Topic Requested</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
    </table>
    
        <?php
            $sql = "select id, topic_name, status from requesttopic where status = 'pending'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {
                echo "<h2 class='center' style='color:#ee6e73;'>No pending Requests.</h2>";
            }
            else while ($row = mysqli_fetch_array($result)) {
        ?> 
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <table class="centered highlight">
                        <?php
                            echo "<tr>";
                            
                            echo "<td> <input type='hidden' name='id' value='$row[0]'></td>";
                            echo "<td> <input type='text' name='requesttopic' value='$row[1]' readonly='readonly'> </td>";
                            echo "<td> <input type='text' name='status' value='$row[2]' readonly='readonly'></td>";
                        ?>
                        <td><button class="btn waves-effect waves-light" type="submit" name="approve">Approve
                            <i class="material-icons right">send</i>
                        </button></td>
                        </tr>
                    </table>
                </form>
        <?php
            }
        ?>
    </div>
    <?php require_once 'footermain.php'; ?>
</body>
</html>