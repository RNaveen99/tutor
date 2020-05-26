<?php
//  Initialise the session
session_start();

//  Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
if (!isset($_SESSION['privileges']) || $_SESSION['privileges'] == 0) {
    header('location:display.php');
}
if (!isset($_POST['topic']) || !isset($_POST['filetype'])) {
    header('location:update.php');
}

    $_SESSION['flag'] = true;
    $_SESSION['mdfilename'] = 'md/'.trim($_POST['topic']).'.md';
    $_SESSION['textfilename'] = 'text/'.trim($_POST['topic']).'.txt';
    $_SESSION['filetype'] = $_POST['filetype'] == 'mdfile' ? 'md' : 'text';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <title>Update</title>
</head>
<body>
    <main>
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars('update3.php'); ?>" method="post" class="col s12">
        
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $filefolder = $_POST['filetype'] == 'mdfile' ? 'md/' : 'text/';

                    $filetype = $_POST['filetype'] == 'mdfile' ? '.md' : '.txt';
                    
                    $filename = $filefolder.trim($_POST['topic']).$filetype;
                    //echo $filename;
                    $myfile = fopen("$filename", 'r');
                    $filecontent = fread($myfile, filesize("$filename"));
                    ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="content" id="content" class="materialize-textarea" cols="30" rows="10"><?php echo $filecontent; ?></textarea>
                            <label for="content">Content</label>
                        </div>
                    </div>
                    <?php
                    fclose($myfile);
                }
                ?>
                <?php if ($_POST['filetype'] == 'mdfile') { ?> 
                    <button class="btn waves-effect waves-light" type="submit" name="savemdfile">Save
                        <i class="material-icons right">send</i>
                    </button>
                    <button class="btn waves-effect waves-light" type="submit" name="saveandgenerate">Save and Generate HTML
                        <i class="material-icons right">send</i>
                    </button>
                <?php } else {?>
                    <button class="btn waves-effect waves-light" type="submit" name="savetextfile">Save HTML
                        <i class="material-icons right">send</i>
                    </button>
                <?php } ?>
            </form>
        </div>
    </div>
    <?php require_once 'footermain.php'; ?>
</body>
</html>