<?php

session_start();

include("connection.php");
include("functions.php");
include("connection_notes.php");

$user_data = "";
$user_name = "";
$id = "";
$email = "";
$date = "";

$user_data = check_login($con);
$user_name = $user_data['user_name'];
$id = $user_data['id'];
$email = $user_data['email'];
$date = $user_data['date'];


$sql = "SELECT * FROM notes WHERE username = '$user_name'";
$result = mysqli_query($con, $sql);
$count_note = mysqli_num_rows($result);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <style>
        img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] {
            display: none;
        }
    </style>
    <title>My Account</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">CST235 x GB5</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="team.html">Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="account.php">Account</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Account-->
    <section style="background-color: #72cfdf" class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Account</h2><br>
            </div>

            <!--Biodata-->
            <div class="row">
                <div class="col-lg-5">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/user.png" alt="..." />
                        <h4 class="text-uppercase"><?php echo $user_name ?></h4><br>
                        <p class="text-muted">User number: <?php echo $id ?></p>
                        <p class="text-muted">Email Address: <?php echo $email ?></p>
                        <p class="text-muted">Date Registered: <?php echo $date ?></p>
                        <p class="text-muted">Total Notes: <?php echo $count_note ?></p><br><br>
                        <a class="btn btn-custom btn-social mx-2" href="logout.php"><i class="fas fa-sign-out-alt"></i></a><br>Logout<br><br>
                        <a class="btn btn-custom btn-social mx-2" href="delete_account.php"><i class="fas fa-trash-alt"></i></a><br>Delete Account<br>
                    </div>
                </div>
            </div>
            <!--a href="mailto:cstb5secure?body=Cool%20email%20tutorial">Click here to email us about our tutorials</a> </a>-->
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Copyright &copy; B5 Secure 2021</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>

