<?php
    require_once 'config.php';
    session_start();
    //  Check if the user is logged in, if not then redirect him to login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }
    
    
    if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['numofquestions']) && isset($_POST['takequiz'])) {
        $_SESSION['numofquestions'] = $_POST['numofquestions'];
        $_SESSION['currentquestion'] = 0;
        $_SESSION['points'] = 0;
    }
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['next']) && isset($_POST['question'.$_SESSION['currentquestion']])) {
        if ($_SESSION['correctanswer'] == $_POST['question'.$_SESSION['currentquestion']]) {
            $_SESSION['points']++;
        }
    }
    if (isset($_SESSION['currentquestion'])) {
        $_SESSION['currentquestion']++;
    } 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php' ?>
    <style>select {display:block;}</style>
    <title>Quiz</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
<?php
    if(($_SERVER['REQUEST_METHOD'] == 'POST') && !isset($_POST['numofquestions']) && isset($_POST['takequiz'])) {
        echo "<div class='red-msg center'> Select number of questions </div>";
    }
?>

<div class="container">
    <div class="row">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="col s12">
        <?php 
        if (!isset($_SESSION['numofquestions'])) {
            $sql = 'select count(*) from quiz';
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            ?>
            <div class="row">
                <h1 class="center col s12">Select num of questions</h1>
                <select name="numofquestions" id="numofquestions">
                <option value="" disabled selected>Choose number of questions</option>
                <?php 
                for ($i = 1; $i <= $row[0]; $i++) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                </select>
                <br><br><br>
                <div class="row"> 
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="takequiz">Take Quiz
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        <?php }
        else if ($_SESSION['currentquestion'] <= $_SESSION['numofquestions']) { 
            ?>
            <div class="row">
                <?php
                $id = $_SESSION['currentquestion'];
                $sql = "select id, question, option1, option2, option3, option4, answer from quiz where id = $id";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) == 0) {
                    $_SESSION['numofquestions']++;
                    header('location:quiz3.php');
                }
                $row = mysqli_fetch_array($result);
                $_SESSION['correctanswer'] = $row[6];
                echo "<h2 class='center col s12'>".$row[1]."</h1>";
                ?>
                <div class="row">
                <p class="col s6">
                    <label for="<?php echo $row[2]; ?>">
                    <input class="with-gap" type="radio" id="<?php echo $row[2]; ?>" name="<?php echo "question".$row[0]; ?>" value="<?php echo $row[2]; ?>">
                    <span><?php echo $row[2]; ?></span>
                    </label>
                </p>
                <p class="col s6">
                    <label for="<?php echo $row[3]; ?>">
                    <input class="with-gap" type="radio" id="<?php echo $row[3]; ?>" name="<?php echo "question".$row[0]; ?>" value="<?php echo $row[3]; ?>">
                    <span><?php echo $row[3]; ?></span>
                    </label>
                </p>
                <p class="col s6">
                    <label for="<?php echo $row[4]; ?>">
                    <input class="with-gap" type="radio" id="<?php echo $row[4]; ?>" name="<?php echo "question".$row[0]; ?>" value="<?php echo $row[4]; ?>">
                    <span><?php echo $row[4]; ?></span>
                    </label>
                </p>
                <p class="col s6">
                    <label for="<?php echo $row[5]; ?>">
                    <input class="with-gap" type="radio" id="<?php echo $row[5]; ?>" name="<?php echo "question".$row[0]; ?>" value="<?php echo $row[5]; ?>">
                    <span><?php echo $row[5]; ?></span>
                    </label>
                </p>
                <?php if ($_SESSION['currentquestion'] < $_SESSION['numofquestions']) { ?>
                <button class="btn waves-effect waves-light col s2 offset-s3" type="submit" name="next">Next
                    <i class="material-icons right">send</i>
                </button>
                <?php } else if ($_SESSION['currentquestion'] == $_SESSION['numofquestions']) { ?>
                    <button class="btn waves-effect waves-light col s2 offset-s3" type="submit" name="next">Submit
                        <i class="material-icons right">send</i>
                    </button>
                <?php } ?>
        </div>
        <?php } else { ?> <div class="row"> <?php
            echo "<h2 class='center col s12'>You scored ".$_SESSION['points']."</h2>";
            unset($_SESSION['currentquestion']);
            unset($_SESSION['numofquestions']);
            unset($_SESSION['points']);
            unset($_SESSION['correctanswer']);
            ?>
            <a href="display.php"><h6 class='right'>Continue</h6></a></div>
        <?php }
        ?>
    </form>
    </div>
</div>
<?php require_once 'footermain.php'; ?>
</body>
</html>