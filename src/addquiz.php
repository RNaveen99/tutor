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

$question = $option1 = $option2 = $option3 = $option4 = $answer = '';
$question_err = $option1_err = $option2_err = $option3_err = $option4_err = $answer_err = $option_err = $optionanswer_err = '';
$correct = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $question = trim($_POST['question']);
    $option1 = trim($_POST['option1']);
    $option2 = trim($_POST['option2']);
    $option3 = trim($_POST['option3']);
    $option4 = trim($_POST['option4']);
    $answer = trim($_POST['answer']);

    //---------------validating input fields--------------------------
    if (empty($question)) {
        $question_err = 'Please enter a question';
    }
    if (empty($option1)) {
        $option1_err = 'Please enter option 1';
    }
    if (empty($option2)) {
        $option2_err = 'Please enter option 2';
    }
    if (empty($option3)) {
        $option3_err = 'Please enter option 3';
    }
    if (empty($option4)) {
        $option4_err = 'Please enter option 4';
    }
    if (empty($answer)) {
        $answer_err = 'Please enter answer';
    }
    if (empty($question_err) && empty($option1_err) && empty($option2_err) && empty($option3_err) && empty($option4_err)&&empty($answer_err)) {
        if (($option1 == $option2) || ($option1 == $option3) || ($option1 == $option4) || ($option2 == $option3) || ($option2 == $option4) || ($option3 == $option4)) {
            $option_err = 'Options can not be same';
        }
        if ($option1 == $answer);
        else if ($option2 == $answer);
        else if ($option3 == $answer);
        else if ($option4 == $answer);
        else {
            $optionanswer_err = 'Answer should be out of the given options';
        }
    }
    
    //--------------check input errors before inserting into database-------------------
    if (empty($optionanswer_err) && empty($option_err) && empty($question_err) && empty($option1_err) && empty($option2_err) && empty($option3_err) && empty($option4_err)&&empty($answer_err)) {
        $sql = "insert into quiz (question,option1,option2,option3,option4,answer) values('$question', '$option1', '$option2', '$option3', '$option4', '$answer')";
        mysqli_query($conn, $sql);
        $correct = true;
        //header('location:addquiz.php');
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
    <title>Add Quiz Question</title>
</head>
<body>
    <?php require_once 'headermain.php'; ?>
    <?php 
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($correct == true)) {
            echo "<div class='green-msg center'> Question Added </div>";
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST') && ((!empty($option_err)) || (!empty($optionanswer_err)))) {         
            $msg = '';
            if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($option_err)) {
                $msg = $option_err.'<br>';
            }
            if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($optionanswer_err)) {
                $msg = $msg . $optionanswer_err;
            }
            echo "<div class='red-msg center'> $msg  </div>";
        } 
        
    
    ?>

    <div class="container">
        <div class="row">
            <h1 class="cols12" style="color:#ee6e73;">Quiz Questions</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="question" id="question" value="<?php if (!$correct) echo $question;?>" class="validate">
                        <label for="question" class="active">Question*</label>
                        <span class="helper-text"><?php echo $question_err?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">                        
                        <input type="text" name="option1" id="option1" value="<?php if (!$correct) echo $option1;?>" class="validate">
                        <label for="option1" class="active">Option 1*</label>
                        <span class="helper-text"><?php echo $option1_err?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="option2" id="option2" value="<?php if (!$correct) echo $option2;?>" class="validate">    
                        <label for="option2" class="active">Option 2*</label>
                        <span class="helper-text"><?php echo $option2_err?></span>    
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="option3" id="option3" value="<?php if (!$correct) echo $option3;?>" class="validate">
                        <label for="option3" class="active">Option 3*</label>
                        <span class="helper-text"><?php echo $option3_err?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="option4" id="option4" value="<?php if (!$correct) echo $option4;?>" class="validate">    
                        <label for="option4" class="active">Option 4*</label>
                        <span class="helper-text"><?php echo $option4_err?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="answer" id="answer" value="<?php if (!$correct) echo $answer;?>" class="validate">    
                        <label for="answer" class="active">Answer*</label>
                        <span class="helper-text"><?php echo $answer_err?></span>                       
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="submit">Add Question to Quiz
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