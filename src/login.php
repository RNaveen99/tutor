<?php

//  Initialize the session
session_start();

//  check if the user if already logged in, if yes then redirect him to welcome page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('location: welcome.php');
    exit;
}

//  Include config file
require_once 'config.php';

//  define variables and initialize with empty values
$username = $password = '';
$username_err = $password_err = '';

//  processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //  check is username is empty
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter username';
    } else {
        $username = trim($_POST['username']);
    }

    //  check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter password';
    } else {
        $password = trim($_POST['password']);
    }

    //  validate credentials
    if (empty($username_err) && empty($password_err)) {

        //  prepare a select statement
        $sql = "select id, username, password , privileges from users where username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            //  bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //  set parameters
            $param_username = $username;

            //  attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                //  store result
                mysqli_stmt_store_result($stmt);

                //  check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {

                    //  bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $privileg);

                    if (mysqli_stmt_fetch($stmt)) {

                        if (password_verify($password, $hashed_password)) {

                            //  password is correct, so start a new session
                            session_start();

                            //  store data in session variables
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION['privileges'] = $privileg;

                            //  Redirect user to display page
                            header('location: welcome.php');
                        } else {
                            //  display an error mesage if password is not valid
                            $password_err = 'The password you entered was not valid';
                        }
                    }
                } else {
                    //  display an error message if username doesn't exist
                    $username_err = 'No account found with that username';
                }
            } else {
                echo "oops ! Something went wrong . Please try again later";
            }
        }

        //  close statement
        mysqli_stmt_close($stmt);
    }

    //  close connection
    mysqli_close($conn);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once 'headermain2.php'; ?>
    <title>Login</title>
</head>
<body>
    <?php require_once 'headermain.php'; ?>
<div class="container">
    <div class="row">
        <h2 class="col s12" style="color:#ee6e73;">Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" name="username" id="username" class="validate">
                    <label class="active" for="username">User Name</label>
                    <span class="helper-text"> <?php echo $username_err; ?> </span>
                </div>
                
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="password" name="password" id="password" class="validate">
                    <label class="active" for="password">Passsword</label>
                    <span class="helper-text"> <?php echo $password_err; ?> </span>
                </div>
                
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Login
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a></p>
            </div>
        </form>
    </div>
</div>
    
<?php require_once 'footermain.php'; ?>
</body>
</html>