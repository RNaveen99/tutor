<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <title>Welcome</title>
    <style>
        div.column {
            height: 180px
        }
    </style>
</head>
<body>
<?php require_once 'headermain.php'; ?>
    <div class="container">
        <br>
        <div class="row">
            <div class="col s12 z-depth-5">
                <h1 class="center" style="color:#ee6e73;"> PHP</h1>   
            </div><br>
            <div class="col s12 m5 card-panel z-depth-2 column"><p class="flow-text">PHP stands for Hypertext Preprocessor</p></div>
            <div class="col s12 m6 push-m1 card-panel z-depth-2 column"><p class="flow-text">PHP is an interpreted language, i.e., there is no need for compilation</p></div>
            <div class="col s12 m5 card-panel z-depth-2 column"><p class="flow-text">PHP is a server scripting language and a powerful tool for making dynamic and interactive Web pages.</p></div>
            <div class="col s12 m6 push-m1 card-panel z-depth-2 column"><p class="flow-text ">PHP is a widely-used, free, and efficient alternative to competitors such as Microsoft's ASP</p></div>
            
        </div>
    </div>
    <?php require_once 'footermain.php'; ?>
</body>
</html>