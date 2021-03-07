<html>
    <?php
    //Import SQL connection
    include_once "connect.php";

    //Get courses
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($db_connect, $sql);

    //Get the number of courses avaliable to register
    $courses_count = mysqli_num_rows($result);

    //Get registrations
    $sql = "SELECT * FROM registrations";
    $result = mysqli_query($db_connect, $sql);

    //Get the total registrations
    $register_count = mysqli_num_rows($result);
    ?>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="./css/styles.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Innovate Training - Home</title>
    </head>


    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container bg-light">
            <a class="navbar-brand" href="#">Innovate Training</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="course_info.php">Courses</a>
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
        <div class="row splash">
            <div class="col">
                <header class="jumbotron splash-jumbo mb-0 mt-3">
                    <h1 class="display-5">Learn with us.</h1>
                    <p class="lead">Upgrade your skills with the the courses that we provide to get an advantage over others when applying for a new job.</p>
                    <form action="course_info.php" class="splash-btns mb-0">
                        <input type="text" class="custom-input" name="search-text" placeholder="Search courses...">
                        <input type="submit" class="custom-btn" value="Search">
                    </form>
                </header>
            </div>
        </div>
        <div class="row features">
            <div class="col m-xs-0">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <div class="card white">
                                        <div class="card-body feature-card-body">
                                            <h1 class="material-icons feature-icon">school</h1>
                                            <h5 class="card-title">Experienced teachers</h5>
                                            <p>All of our teachers have at least 5 years of relevant updated programming experience</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <div class="card white">
                                        <div class="card-body feature-card-body">
                                            <h1 class="material-icons feature-icon">whatshot</h1>
                                            <h5 class="card-title">Updated technologies</h5>
                                            <p>We teach demanding techologies such as HTML5 and Swift programming</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card white">
                                        <div class="card-body feature-card-body">
                                            <h1 class="material-icons feature-icon">psychology</h1>
                                            <h5 class="card-title">Critical thinking</h5>
                                            <p>Activites are design to train and challange our student's critical thinking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row about">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">About Us</h5>
                        <article class="card-text">Innovate Training is a training center that has been operated since 2000, we specialise in courses such as photo editing, website design as well as app developement.<br><br>As a leading IT training company, we are always looking for new competitive techoloigies to make sure all our students can remain relevant in the fast-paced IT industry.</article>
                    </div>
                </div>
            </div>
            <aside class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">Summary</h5>
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-xl-6 mb-3 mb-xl-0">
                                    <div class="card white">
                                        <div class="counter card-body">
                                            <h1 class="counter-num"><?php echo $courses_count?></h1>
                                            <p>Courses offered</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card white">
                                        <div class="counter card-body">
                                            <h1 class="counter-num"><?php echo $register_count?></h1>
                                            <p>Registrations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <footer class="my-5">
        <p>Innovate Training - 2021 - <a href="./admin_login.php">Admin</a></p>
    </footer>
    </body>
</html>