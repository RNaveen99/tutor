<nav role="navigation">
    <div class="nav-wrapper"><a id="logo-container" href="welcome.php" class="brand-logo">&nbsp&nbspTutor</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="display.php">Learn</a></li>
            <li><a href="quiz3.php"> Play Quiz </a></li>
            <li><a href="run/demo/try.html"> Run Code </a></li>
            <?php if (! isset($_SESSION['privileges']) || $_SESSION['privileges'] == 0) {
                echo <<< a
            <li><a href="requesttopic.php">Request Topic </a></li>
a;
            } ?>
            <?php if (isset($_SESSION['privileges']) && $_SESSION['privileges'] == 1) {
            echo <<< a
            <li><a href="add.php">Add Topics</a></li>
            <li><a href="update.php">Update Topics</a></li>
            <li><a href="delete.php">Delete Topics</a></li>
            <li><a href="addquiz.php">Add Quiz</a></li>
            <li><a href="managequiz.php">Update Quiz</a></li>
            <li><a href="manageusers.php">Manage Users</a></li>
            <li><a href="managerequests.php">Manage Requests</a></li>
a;
            } ?>
            <li><a href="notes.php">Notes </a></li>
            
            <?php if (isset($_SESSION['privileges'])) {
            echo <<< a
            <li><a class="waves-effect waves-light btn" href="logout.php">Logout </a></li>
a;
            } else if (! isset($_SESSION['loggedin'])) {
                echo <<< a
                <li><a class="waves-effect waves-light btn" href="login.php">Log in</a></li>
a;
            } 
            ?>
      </ul>

      <ul id="nav-mobile" class="sidenav">
      <li><li><a href="display.php">Learn</a></li>
            <li><a href="quiz3.php"> Play Quiz </a></li>
            <?php if (! isset($_SESSION['privileges']) || $_SESSION['privileges'] == 0) {
                echo <<< a
            <li><a href="requesttopic.php">Request Topic </a></li>
a;
            } ?>

            <?php if (isset($_SESSION['privileges']) && $_SESSION['privileges'] == 1) {
            echo <<< a
            <li><a href="add.php">Add Topics</a></li>
            <li><a href="update.php">Update Topics</a></li>
            <li><a href="delete.php">Delete Topics</a></li>
            <li><a href="addquiz.php">Add Quiz</a></li>
            <li><a href="managequiz.php">Update Quiz</a></li>
            <li><a href="manageusers.php">Manage Users</a></li>
            <li><a href="managerequests.php">Manage Requests</a></li>
a;
            } ?>
            <li><a href="notes.php">Notes </a></li>
            
            <?php if (isset($_SESSION['privileges'])) {
            echo <<< a
            <li><a class="waves-effect waves-light btn" href="logout.php">Logout </a></li>
a;
            } else if (! isset($_SESSION['loggedin'])) {
                echo <<< a
                <li><a class="waves-effect waves-light btn" href="login.php">Log in</a></li>
a;
            } 
            ?>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>