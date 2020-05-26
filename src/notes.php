<?php

    session_start();

    //  Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }
    
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['save'])) {
        $myfile = fopen('notes/'.$_SESSION['username'].'txt', 'w');
        fwrite($myfile, $_POST['notes']);
        fclose($myfile);
        header('location:welcome.php');
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <title>Notes</title>
</head>
<body>
    <?php require_once 'headermain.php'; ?>
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <?php $filename = 'notes/'.$_SESSION['username'].'txt';
                                $myfile = fopen($filename, 'r');
                                $filecontent = fread($myfile, filesize($filename));
                        ?>        
                        <i class="material-icons prefix">mode_edit</i>
                        <textarea name="notes" id="notes" class="materialize-textarea"><?php echo $filecontent; ?></textarea>
                        <label for="notes">Notes</label>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="save">Save
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    <?php require_once 'footermain.php'; ?>
</body>
</html>