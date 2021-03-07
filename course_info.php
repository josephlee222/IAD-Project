<html>
    <?php
    //Import connection
    include_once "connect.php";

    //If a form is received through GET method
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        //If a search is performed
        if (isset($_GET["search-text"])) {
            //If search is set
            $search_text = mysqli_real_escape_string($db_connect,$_GET["search-text"]);
            $sql = "SELECT * FROM courses WHERE course_name LIKE '%" . $search_text . "%'";
        } else {
            //load default list
            $sql = "SELECT * FROM courses";
        }

        $result = mysqli_query($db_connect, $sql);
        if (!$result) {
            $error = "mySQL query failed: " . mysqli_error($db_connect);
        }
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
        <script src="./js/course_info.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Innovate Training - Course Info</title>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./admin_login.php">Admin</a>
                        </li>
                    </ul>
                    <a class="custom-btn nav-btn btn" href="course_registration.php">Register now</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <?php
            //If an error occurs, this part triggers showing the alert with the error code in it
            if (isset($error)) {
                echo "
                <div class='alert alert-danger alert-dismissible fade show mt-3 mb-0 slidein-right' role='alert'>
                    ". $error . "
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
                            <h1 class="card-title">Courses</h1>
                            <p>Browse though our avaliable offerings</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid p-0">
                                <form class="row mb-0">
                                    <div class="col-md-9 mb-3 mb-md-0">
                                        <input type="text" class="custom-input w-100" id="search-text" name="search-text" placeholder="Search courses" value="<?php if (isset($_GET["search-text"])) {echo $_GET["search-text"];}?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" class="custom-btn" id="search-btn" value="Search">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-columns courses-section">
                                <?php
                                //Check whether there are any courses in the result
                                if (mysqli_num_rows($result) > 0) {
                                    //Print all courses in the result
                                    for ($i = 1; mysqli_num_rows($result) >= $i; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        echo '
                                        <div class="card white animate-enlarge stagger course-card">
                                            <div class="card-body">
                                                <h6 class="card-title">' . $row["course_name"] . '</h6>
                                                <div class="d-flex mb-2">
                                                    <h5 class="m-0"><strong>$' . $row["price"] . '</strong></h5>
                                                    <small class="course-other ml-2">' . $row["course_duration"] . ' Days / ' . $row["seats"] . ' Seats</small>
                                                </div>
                                                <p class="mb-3">' . $row["description"] . '</p>
                                                <a class="course-register custom-btn '; 
                                                if ($row["seats"] < 1) {
                                                    echo "disabled";
                                                }
                                                echo '" ';
                                                if ($row["seats"] > 0) {
                                                    echo 'href="./course_registration.php?register-id=' . $row["id"] . '"';
                                                }
                                                echo '>';
                                                if ($row["seats"] > 0) {
                                                    echo 'Register this course';
                                                } else {
                                                    echo 'Course unavailable';
                                                }
                                                echo '</a>
                                            </div>
                                        </div>
                                        ';
                                    }
                                } else {
                                    //Print no results found
                                    echo "<p>No courses found matching criteria</p>";
                                }
                                ?>
                            </div>
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