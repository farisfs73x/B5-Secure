<?php
    session_start();
	include("connection.php");
	include("connection_notes.php");
?>
<!DOCTYPE html>
<html>
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
    <style>
        .error {color: #FF0000;}
    </style>
    <title>Login</title>
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

<?php
	include("functions.php");
    $user_name = $password = "";
    $nameErr = $passwordErr = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //Username check
        if (empty($_POST["user_name"]))
        {
            $nameErr = "Name is required!";
        }
        else {
            $user_name = test_input($_POST["user_name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $user_name))
            {
                $nameErr = "Only letters and white space allowed!";
            }
        }

        //Password check
        if (empty($_POST['password']))
        {
            $passwordErr = "Password is required!";
        }
        else {
            $password = $_POST['password'];
        }

        if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
        {

            //read from database
            $query = "select * from users where user_name = '$user_name' limit 1";
            $result = mysqli_query($con, $query);

            if($result)
            {
                if($result && mysqli_num_rows($result) > 0)
                {

                    $user_data = mysqli_fetch_assoc($result);

                    if (password_verify($password, $user_data['password'])) {

                        $_SESSION['user_id'] = $user_data['user_id'];
                        echo("<script>location.href = 'notes.php';</script>");
                        //header("Location: notes.php");
                        //exit;
                    }
                    else {
                        $passwordErr = "Incorrect password!";
                    }
                }
                else {
                    $nameErr = "Incorrect username!";
                }
            }
        }
    }
?>

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

    <!--Login Form-->
    <section style="background-color: #6ca9b6" class="page-section">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Login</h2><br>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="team-member">
                        <form style="background-color: #aaf4ed" class="error form-control" method="post">
                            <br><div class="error">* Required field</div><br>

                            <input type="text" name="user_name" placeholder="Username" minlength="2" maxlength="30" value="<?php echo $user_name;?>">
                            <span class="error">* <?php if ($nameErr != "") {echo "<br>".$nameErr;}?></span><br><br>

                            <input type="password" name="password" placeholder="Password" minlength="5" maxlength="30">
                            <span class="error">* <?php if ($passwordErr != "") {echo "<br>".$passwordErr;}?></span><br><br>

                            <input type="submit" name="submit" value="Login"><br><br>

                            <div class="font-monospace">Didn't have account?
                                <a class="text-decoration-none font-monospace" style="color: #0f36e2" href="signup.php">Signup Now!</a><br><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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