<?php 
//session_start();

	include("connection.php");
	include("functions.php");

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] {
            display: none;
        }
    </style>
	<title>Signup</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <style>
        .error {color: #FF0000;}
    </style>
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

        $check = "unchecked";
        $recaptchaErr = "";
        $user_name = $email = $password = $cpassword = "";
        $nameErr = $emailErr = $passwordErr = $cpasswordErr = "";

        if (isset($_POST['submit']) && $_POST['g-recaptcha-response'] != "")
        {
            $secret = '6Le4HEIbAAAAAChLQWZ8q03g1uuFV8qFlpayDbBb';
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            $check = "checked";

            if ($responseData->success)
            {

                //first validate then insert in db
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

                    //Email check
                    if (empty($_POST["email"]))
                    {
                        $emailErr = "Email is required!";
                    }
                    else {
                        $email = test_input($_POST["email"]);
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $emailErr = "Invalid email format!";
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

                    //Confirm password check
                    if (empty($_POST['cpassword']))
                    {
                        $cpasswordErr = "Confirm password is required!";
                    }
                    else {
                        $cpassword = $_POST['cpassword'];
                        //check password = confirm password
                        if ($password != $cpassword) {
                            $cpasswordErr = "Confirm password is not match as the password!";
                        }
                    }

                    //Second level check
                    if(!empty($user_name) && !empty($email) && ($emailErr == "") && !empty($password) && !empty($cpassword))
                    {

                        $sql = "SELECT * FROM users WHERE user_name = '$user_name'";
                        $result = mysqli_query($con, $sql);

                        if(mysqli_num_rows($result) == 0) {

                            $query = "SELECT * FROM users WHERE email = '$email'";
                            $res = mysqli_query($con, $query);

                            if (mysqli_num_rows($res) == 0) {

                                if ($password == $cpassword) {

                                    //save to database
                                    $password = password_hash($cpassword,PASSWORD_DEFAULT);

                                    $user_id = random_num(20);
                                    $query = "insert into users (user_id,user_name,email,password) values ('$user_id','$user_name','$email','$password')";

                                    mysqli_query($con, $query);
                                    
                                    echo("<script>location.href = 'login.php';</script>");
                                    //header("Location: login.php");
                                    //die;
                                }
                                else {
                                    $cpasswordErr = "Confirm password is not the same as the password!";
                                }
                            }
                            else {
                                $emailErr = "This email address have already been register!";
                            }
                        }
                        else {
                            $nameErr = "This username have already been register!";
                        }
                    }
                }
            }
        }
        else {
            $recaptchaErr = "Please check the captcha!";
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

    <!--Signup Form-->
    <section style="background-color: #6ca9b6" class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Signup</h2><br>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="team-member">
                        <form style="background-color: #aaf4ed" class="form-control" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <br><div class="error">* Required field</div><br>

                            <input type="text" name="user_name" placeholder="Username" minlength="2" maxlength="30" value="<?php echo $user_name;?>">
                            <span class="error">* <?php if ($nameErr != "") {echo "<br>".$nameErr;}?></span><br><br>

                            <input type="email" name="email" placeholder="Email Address" minlength="7" maxlength="50" value="<?php echo $email;?>">
                            <span class="error">* <?php if ($emailErr != "") {echo "<br>".$emailErr;}?></span><br><br>

                            <input type="password" name="password" placeholder="Password" minlength="5" maxlength="30">
                            <span class="error">* <?php if ($passwordErr != "") {echo "<br>".$passwordErr;}?></span><br><br>

                            <input type="password" name="cpassword" placeholder="Confirm Password" minlength="5" maxlength="30">
                            <span class="error">* <?php if ($cpasswordErr != "") {echo "<br>".$cpasswordErr;}?></span><br><br>

                            <div style="display: inline-block" class="text-center g-recaptcha" data-sitekey="6Le4HEIbAAAAALHWZeXvf-FcdZATiVtZ6TkFRVx4"></div>
                            <span class="error">
                                <?php
                                if($_SERVER['REQUEST_METHOD'] == "POST" && $check == "unchecked") {
                                        echo "<br>* " .$recaptchaErr;
                                    }?>
                            </span><br><br>

                            <input type="submit" name="submit" value="Signup"><br><br>

                            <div class="font-monospace">Already have an account?
                                <a class="text-decoration-none font-monospace" style="color: #0f36e2" href="login.php">Login Now!</a><br><br>
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
