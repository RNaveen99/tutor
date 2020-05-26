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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        $id = $_POST['id'];
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
        
        //--------------check input errors before updating database-------------------
        if (empty($optionanswer_err) && empty($option_err) && empty($question_err) && empty($option1_err) && empty($option2_err) && empty($option3_err) && empty($option4_err)&&empty($answer_err)) {
            $sql = "update quiz set question = '$question', option1 = '$option1', option2 = '$option2', option3 = '$option3', option4 = '$option4', answer = '$answer' where id = $id";
            mysqli_query($conn, $sql);
            $correct = true;
            //header('location:addquiz.php');
        }

    } else if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "delete from quiz where id = $id";
        mysqli_query($conn, $sql);
        $correct = true;
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
    <title>Update Quiz</title>
</head>
<body>
<?php require_once 'headermain.php'; ?>
<?php
    
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['save']) && ($correct == true)) {
        echo "<div class='green-msg center'> Question Updated </div>";
    } else if (($_SERVER['REQUEST_METHOD'] == 'POST') && ((!empty($question_err)) || (!empty($option1_err)) || (!empty($option2_err)) || (!empty($option3_err)) || (!empty($option4_err)) || (!empty($answer_err)) || (!empty($option_err)) || (!empty($optionanswer_err)))) {         
        $msg = '';
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($question_err)) {
            $msg = $question_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($option1_err)) {
            $msg .= $option1_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($option2_err)) {
            $msg .= $option2_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($option3_err)) {
            $msg .= $option3_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($option4_err)) {
            $msg .= $option4_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($answer_err)) {
            $msg .= $answer_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($option_err)) {
            $msg .= $option_err.'<br>';
        }
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($optionanswer_err)) {
            $msg = $msg . $optionanswer_err;
        }
        echo "<div class='red-msg center'> $msg  </div>";
    } else if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['delete'])) {
        echo "<div class='green-msg center'> Question Deleted </div>";
    }

?>
    <div class="quiz">
    <table>
        <thead>
            <tr>
                <th>Question</th>
                <th>Option1</th>
                <th>Option2</th>
                <th>Option3</th>
                <th>Option4</th>
                <th>Answer</th>
                <th>Options</th>
            </tr>
        </thead>
    </table>
        <?php
            $sql = 'select id, question, option1, option2, option3, option4, answer from quiz';
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0 ) {
                echo "<h2 class='center' style='color:#ee6e73;'> No Questions are there in quiz </h2>";
            } else
            while ($row = mysqli_fetch_array($result)) {
        ?> 
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <table class="highlight">
                        <?php
                            echo "<tr>";
                            
                            echo "<td> <input type='hidden' name='id' value='$row[0]'> </td>";
                            echo "<td> <input type='text' name='question' value='$row[1]'> </td>";
                            echo "<td> <input type='text' name='option1' value='$row[2]' > </td>";
                            echo "<td> <input type='text' name='option2' value='$row[3]' > </td>";
                            echo "<td> <input type='text' name='option3' value='$row[4]' > </td>";
                            echo "<td> <input type='text' name='option4' value='$row[5]' > </td>";
                            echo "<td> <input type='text' name='answer' value='$row[6]' > </td>";
                        ?>
                            <td><button class="btn waves-effect waves-light" type="submit" name="save">Save
                                <i class="material-icons right">send</i>
                            </button></td>
                            <td><button class="btn waves-effect waves-light" type="submit" name="delete">Delete Question
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