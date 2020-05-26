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
if (isset($_SESSION['flag']) && $_SESSION['flag'] == true) {
    if ($_SESSION['filetype'] == 'md' && isset($_POST['saveandgenerate'])) {
        $myfile = fopen($_SESSION['mdfilename'], 'w');
        fwrite($myfile, $_POST['content']);
        fclose($myfile);
        
        include_once'Parsedown.php';
        $Parsedown = new Parsedown();

        //$html = file_get_contents($_SESSION['mdfilename']);
        $html = $_POST['content'];
        $a =  $Parsedown->text($html);
        //echo $a;

        $myfile = fopen($_SESSION['textfilename'], 'w');
        fwrite($myfile, $a);
        fclose($myfile);

        $_SESSION['updated'] = true;

    } else if ($_SESSION['filetype'] == 'md' && isset($_POST['savemdfile'])) {
        $myfile = fopen($_SESSION['mdfilename'], 'w');
        fwrite($myfile, $_POST['content']);
        fclose($myfile);
        $_SESSION['updated'] = true;
        
    } else if (($_SESSION['filetype'] == 'text') && isset($_POST['savetextfile'])) {
        $myfile = fopen($_SESSION['textfilename'], 'w');
        fwrite($myfile, $_POST['content']);
        fclose($myfile);
        $_SESSION['updated'] = true;
    }

    header('location: update.php');
} else {
    header('location: update.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>update 3</title>
</head>
<body>
    
</body>
</html>