<?php
require_once("includes/config_session.inc.php");
require_once("includes/signup_view.inc.php");
require_once("includes/login_view.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <title><?= $pageTitle ?></title>
</head>
<body class="position-relative <?= $bodyClasses ?>">
  <header class="bg-darkbrown" id="header">
    <nav class="navbar navbar-expand-md" data-bs-theme="dark">
      <div class="container-fluid">
        <div>
          <a class="navbar-brand" href="index.php">
            <img src="images/Logo.png" alt="Logo" class="navbar-logo mw-100">
          </a>
        </div>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-start">

            <?php 
            // Store the filename of the current page
            $currentPage = basename($_SERVER['PHP_SELF']);
            ?>

            <!-- Show navlinks  -->
            <!-- Home -->
            <li class="nav-item">
              <a class="nav-link px-4 <?= ($currentPage == 'index.php') ? 'active' : ''; ?>" aria-current="page" href="index.php">Home</a>
            </li>

            <!-- Resources -->
            <li class="nav-item">
              <a class="nav-link px-4 <?= ($currentPage == 'resources.php') ? 'active' : ''; ?>" aria-current="page" href="resources.php">Resources</a>
            </li>

            <!-- Zoo -->
            <li class="nav-item">
              <a class="nav-link px-4 <?= ($currentPage == 'zoo_bookings.php') ? 'active' : ''; ?> <?= !isset($_SESSION["user_id"]) ? 'disabled' : ''; ?>" aria-current="page" href="zoo_bookings.php">Zoo</a>
            </li>

            <!-- Hotel -->
            <li class="nav-item">
              <a class="nav-link px-4 <?= ($currentPage == 'hotel_bookings.php') ? 'active' : ''; ?> <?= !isset($_SESSION["user_id"]) ? 'disabled' : ''; ?>" aria-current="page" href="hotel_bookings.php">Hotel</a>
            </li>

            <!-- Account -->
            <li class="nav-item ms-auto">
            <!-- ms-auto used to place this item at the end of the navbar -->
            <?php if (!isset($_SESSION["user_id"])) { ?>
            
              <a class="nav-link px-4 <?= ($currentPage == 'account.php') ? 'active' : ''; ?>" href="account.php">Login/Signup</a>

            <?php } else { ?>

              <a class="nav-link px-4 <?= ($currentPage == 'account.php') ? 'active' : ''; ?>" href="account.php">Account: <?= $_SESSION["user_email"]?> </a>

            <?php } ?>

            </li>
            
          </ul>

        </div>
        
      </div>
    </nav>
  </header>

    <main class="pb-5 <?= $mainClasses ?>">