<html>
    <?php
        include_once "connect.php";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["register-btn"])) {
                $register_name = $_POST["register-name"];
                $register_phone = $_POST["register-phone"];
                $register_email = $_POST["register-email"];
                $register_course = $_POST["register-course"];
                $register_date = $_POST["register-date"];

                $sql = "INSERT INTO registrations (name, course, email, contact, register_date) VALUES ('" . $register_name . "', '" . $register_course . "', '" . $register_email . "', " . $register_phone . ", '" . $register_date . "' )";
                if (!mysqli_query($db_connect, $sql)) {
                    $error = "mySQL query failed: " . mysqli_error($db_connect);
                } else {
                    $success = "
                        <h4 class='alert-heading'>Registration successful</h4>
                        <p>Thank you for registering! We will get back to you as soon as we can.</p>
                    ";
                }
            }
        }

        if (isset($_GET["register-id"])) {
            $select_id = $_GET["register-id"];
        }

        $sql = "SELECT course_name FROM courses";
        $result = mysqli_query($db_connect, $sql);
        
        if (!$result) {
            $error = "mySQL query failed: " . mysqli_error($db_connect);
        }
    ?>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="./css/styles.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
        <script src="./js/animations.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Innovate Training - Register</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="container bg-light">
                <a class="navbar-brand" href="index.php">Innovate Training</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="course_info.php">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_login.php">Admin</a>
                        </li>
                    </ul>
                    <a class="custom-btn nav-btn btn" href="course_registration.php">Register now</a>
                </div>
            </div>
        </nav>

        
        <div class="container main">
            <?php
            if (isset($error)) {
                echo "
                <div class='alert alert-danger alert-dismissible fade show mt-3 mb-0 slidein-right' role='alert'>
                    ". $error . "
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                ";
            } else if (isset($success)) {
                echo "
                <div class='alert alert-success alert-dismissible fade show mt-3 mb-0 slidein-right' role='alert'>
                    ". $success . "
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                ";
            }
            ?>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1>Register</h1>
                            <p>Register and book for our courses today.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <form class="col-lg-7 slidein-right" method="POST">
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid p-0">
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                        <label for="register-name">Name</label>
                                        <input required type="text" class="custom-input full-field" id="register-name" name="register-name" placeholder="Your name">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="register-phone">Phone</label>
                                        <input required type="tel" class="custom-input full-field" id="register-phone" name="register-phone" placeholder="Phone number">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="register-email">E-mail</label>
                                        <input required type="email" class="custom-input full-field" id="register-email" name="register-email" placeholder="Email address">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                        <label for="register-course">Course</label>
                                        <select required class="custom-input full-field" name="register-course" id="register-course">
                                            <?php
                                                if (mysqli_num_rows($result) > 0) {
                                                    for ($i = 1; mysqli_num_rows($result) >= $i; $i++) {
                                                        $row = mysqli_fetch_assoc($result);
                                                        if ($i == $select_id) {
                                                            //If the user come to this page with a register id from course_info.php
                                                            echo "<option value='" . $row['course_name'] . "' selected>" . $row['course_name'] . "</option>";
                                                        } else {
                                                            echo "<option value='" . $row['course_name'] . "'>" . $row['course_name'] . "</option>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<option disabled>No courses avaliable</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="register-date">Date</label>
                                        <input required type="date" class="custom-input full-field" id="register-date" name="register-date" placeholder="Attending date">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="submit" class="custom-btn full-btn mb-0" id="register-btn" name="register-btn" value="Register">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-lg-5 slidein-left">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Placeholder Title</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="my-5">
            <p>Innovate Training - 2021 - <a href="./admin_login.php">Admin</a></p>
        </footer>
    </body>
</html>