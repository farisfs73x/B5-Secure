<?php 
session_start();

	include("connection.php");
	include("functions.php");

    $user_data = "";
	$user_data = check_login($con);

/** @var Connection $connection */
$connection = require_once 'connection_notes.php';
// Read notes from database
$notes = $connection-> getNotes($user_data['user_name']);

$currentNote = [
    'id' => '',
    'username' => $user_data['user_name'],
    'title' => '',
    'description' => ''
];

if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}

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
    <style>
        .error {color: #FF0000;}
    </style>
    <title>My Notes</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="index_note.css" rel="stylesheet"/>
</head>
<body id="page-top">

    <?php

        $id = $title = $description = "";
        $titleErr = $descriptionErr = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $id = $_POST['id'];

        //title empty check
        if (empty($_POST['title'])) {
            $titleErr = "Title is required!";
        }else {
            $title = $_POST['title'];
        }

        //description empty check
        if (empty($_POST['description'])) {
            $descriptionErr = "Description is required!";
        }else {
            $description = $_POST['description'];
        }

        if (!empty($title && !empty($description))) {

            if ($id) {
                $connection->updateNote($id, $_POST);
            } else {
                $connection->addNote($_POST);
            }
            
            echo("<script>location.href = 'notes.php';</script>");
            //header("Location: notes.php");
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

    <!--Notes-->
    <section style="background-color: #a1cbd3">
        <!--Welcome user note-->
        <h1 class="padding-custom" style="text-align: center; color: #a89216; font-family:'Marck Script',cursive; font-size:50px;">Welcome to <?php echo $user_data['user_name']; ?>'s</h1>
        <br/>

        <h1 style="text-align: center; color: #8f81f3; font-family:'Marck Script',cursive; font-size:50px;">STICKY NOTES!</h1>
        <br/><br/>

        <!--Note form-->
        <form class="new-note" method="post">

            <input type="hidden" name="username" value="<?php echo $currentNote['username'] ?>">
            <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">

            <input type="text" name="title" minlength="3" maxlength="30" placeholder="Note title" autocomplete="off" value="<?php echo $currentNote['title'] ?>">
            <span class="error"> <?php if ($titleErr != "") {echo "* ".$titleErr. "<br><br>";}?></span>

            <textarea name="description" cols="30" rows="4" placeholder="Note Description" minlength="3"><?php echo $currentNote['description'] ?></textarea>
            <span class="error"> <?php if ($descriptionErr != "") {echo "* ".$descriptionErr. "<br><br>";}?></span>

            <button>
                <?php if ($currentNote['id']): ?>
                    Update
                <?php else: ?>
                    New note
                <?php endif ?>
            </button>
        </form>

        <!--Display Notes-->
        <div class="notes">
            <?php foreach ($notes as $note): ?>
                <div class="note">
                    <div class="title">
                        <a href="?id=<?php echo $note['id'] ?>">
                            <?php echo $note['title'] ?>
                        </a>
                    </div>
                    <div class="description">
                        <?php echo $note['description'] ?>
                    </div>
                    <small>
                        <?php echo $note['create_date'] ?>
                    </small>
                    <form action="delete_note.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                        <button class="close">X</button>
                    </form>
                </div>
            <?php endforeach; ?>
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