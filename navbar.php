<?php
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: darkslategray;">


  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
        <a class="nav-link active" href="product-list.php">Albums <span class="sr-only">(current)</span></a>
    </div>
    <div class="navbar-nav ml-auto">
        <?php if (!empty($loggedInUser)) : ?>
        Hello, <?= $loggedInUser->name ?>
        <a href="logout.php">Logout</a>
        <?php else: ?>
            <a class="nav-link" href="register.php">Register</a>
            <a class="nav-link" href="login.php">Login</a>
            <a class="nav-link" href="product_create.php">Create</a>
        <?php endif; ?>
    </div>
  </div>
</nav>
