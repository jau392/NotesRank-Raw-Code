<?php require_once "db.php"; $errorMessages = []; $successMessages = []; $processCards = ""; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./style.css">
    <title>NotesRank | <?php echo $title; ?></title>
  </head>
  <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="./">
                    <img src="./images/logo.png" alt="Notes Rank Logo" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if(isGuest()) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "Home") echo 'active'; ?>" href="./index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "Contact Us") echo 'active'; ?>" href="./contact.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "Login") echo 'active'; ?>" href="./auth.php">Login or Register Now</a>
                        </li>
                        <?php } ?>
                        <?php if(isLoggedIn()) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "Dashboard") echo 'active'; ?>" href="./dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "Upload Current Notes") echo 'active'; ?>" href="./upload_notes.php">Upload Current Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "Vote on Current Notes") echo 'active'; ?>" href="./vote_notes.php">Vote on Current Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($title == "View Past Rankings") echo 'active'; ?>" href="./past_rankings.php">View Past Rankings</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome, <?php echo loggedInUsername(); ?>!
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                                <li><a class="dropdown-item" href="./logout.php">Log Out</a></li>
                                <li><a class="dropdown-item" href="./contact.php">Contact Us</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main style="min-height: 80vh;" class="mt-5">
        <div class="container">
            <div class="row align-items-start"><div id="alertSection"></div></div>
