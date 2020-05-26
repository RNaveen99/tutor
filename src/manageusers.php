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
    if (isset($_POST['makeadmin'])) {
        $id = $_POST['id'];
        $sql = "update users set privileges = 1 where id = $id";
        mysqli_query($conn, $sql);
    } else if (isset($_POST['removeadmin'])) {
        $id = $_POST['id'];
        $sql = "update users set privileges = 0 where id = $id";
        mysqli_query($conn, $sql);
    } else if (isset($_POST['removeaccount'])) {
        $id = $_POST['id'];
        $sql = "delete from users where id = $id";
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
    <title>Manage Users</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
    <div class="users">
    <table class="centered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Options</th>
            </tr>
        </thead>
    </table>
        <?php
            $sql = 'select id, username, privileges from users';
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
        ?> 
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <table class="highlight centered">
                        <?php
                            echo "<tr>";
                            echo " <td> <input type='hidden' name='id' value='$row[0]' readonly='readonly'> </td>";
                            echo "<td> <input type='text' name='username' value='$row[1]' readonly='readonly'> </td>";
                            if ($row[2] == 0) {
                                ?>
                                <td><button class="btn waves-effect waves-light" type="submit" name="makeadmin">Make admin
                                    <i class="material-icons right">send</i>
                                </button></td>
                            <?php
                            } else if ($row[2] == 1) {
                                ?>
                                <td><button class="btn waves-effect waves-light" type="submit" name="removeadmin">Remove as Admin
                                    <i class="material-icons right">send</i>
                                </button></td>
                            <?php
                            }
                            ?>
                            <td><button class="btn waves-effect waves-light" type="submit" name="removeaccount">Remove Account
                                <i class="material-icons right">send</i>
                            </button></td>
                            </tr>
                            <?php
                            ?>
                    </table>
                </form>
        <?php
            }
        ?>
    </div>
    <?php require_once 'footermain.php'; ?>
</body>
</html>