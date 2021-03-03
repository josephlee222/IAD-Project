<html>
    <?php
    //Import connection and account checker
    include_once "connect.php";
    include_once "auth.php";

    //Initialise variables
    $show_edit = false;

    //If a form via POST method is received
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["edit-btn"])) {
            //Collect form details
            $edit_id = $_POST["edit-id"];
            $edit_name = $_POST["edit-name"];
            $edit_phone = $_POST["edit-phone"];
            $edit_email = $_POST["edit-email"];
            $edit_course = $_POST["edit-course"];
            $edit_date = $_POST["edit-date"];

            //Update registration details
            $sql = "UPDATE registrations SET name='" . $edit_name . "', course='" . $edit_course . "', email='" . $edit_email . "', contact=" . $edit_phone . ", register_date='" . $edit_date . "' WHERE id=" . $edit_id;
            if (!mysqli_query($db_connect, $sql)) {
                //In case of SQL error
                $error = "mySQL query failed: " . mysqli_error($db_connect);
            } else {
                //Update successful
                $success = "
                    Updated registration successfully.
                ";
            }
        }
    }

    if (isset($_GET["id"])) {
        $sql = "SELECT course_name from courses";
        $courses_result = mysqli_query($db_connect, $sql);

        if (!$courses_result) {
            $error = "mySQL query failed: " . mysqli_error($db_connect) . "<br><br>SQL Query: " . $sql;
        }

        $search_id = $_GET["id"];
        $sql = "SELECT * FROM registrations WHERE id=" . $search_id;
        $result = mysqli_query($db_connect, $sql);

        if (!$result) {
            $error = "mySQL query failed: " . mysqli_error($db_connect) . "<br><br>SQL Query: " . $sql;
        } else {
            if (mysqli_num_rows($result) > 0) {
                $show_edit = true;
            } else {
                $error = "Record does not exist. Please try again";
            }
            
        }
    }

    ?>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="./css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
        <script src="./js/animations.js"></script>
        <script src="./js/admin.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Innovate Training - Admin (Edit Registant)</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="container bg-light">
                <a class="navbar-brand" href="./index.php">Innovate Training</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarNav">
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <div class=" mt-3 mt-md-0 d-flex">
                        <p class="my-auto mr-3 admin-username"><?php echo $cookie_username?></p>
                        <a class="custom-btn nav-btn btn logout material-icons">power_settings_new</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container main">
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

            //If a success occurs, this part triggers showing the alert with the success message in it
            if (isset($success)) {
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
                <div class="col-lg-3">
                    <!-- Sidebar navigation -->
                    <div class="list-group">
                        <a href="./admin_view_all.php" class="list-group-item list-group-item-action">View Registrations</a>
                        <a href="./admin_add.php" class="list-group-item list-group-item-action">Add Registration</a>
                        <a href="#" class="list-group-item list-group-item-action active">Edit Registration</a>
                        <a href="./admin_delete.php" class="list-group-item list-group-item-action">Delete Registration</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Enter ID to edit</h5>
                                        <form class="container-fluid p-0 mb-0">
                                            <div class="row">
                                                <div class="col-md-9 mb-3 mb-md-0">
                                                    <input class="custom-input w-100" type="number" name="id" id="delete-id" placeholder="ID to edit" value="<?php if (isset($_GET['id'])) {echo $_GET['id'];}?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="custom-btn w-100" type="submit" name="edit-search-btn" id="edit-search-btn" value="Find by ID">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        //Checks whether a record is successfully retrived
                        if ($show_edit) {
                            //Print out the html form that the user is going to edit
                            $row = mysqli_fetch_assoc($result);
                            echo '
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Edit Registration</h5>
                                            <form method="POST" class="container-fluid p-0">
                                                <div class="row mb-3">
                                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                                        <label for="edit-name">Name</label>
                                                        <input required type="text" class="custom-input full-field" id="edit-name" name="edit-name" placeholder="Your name" value="' . $row['name'] . '">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="edit-phone">Phone</label>
                                                        <input required type="tel" class="custom-input full-field" id="edit-phone" name="edit-phone" placeholder="Phone number" value="' . $row['contact'] . '">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="edit-email">E-mail</label>
                                                        <input required type="email" class="custom-input full-field" id="edit-email" name="edit-email" placeholder="Email address" value="' . $row['email'] . '">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                                        <label for="edit-course">Course</label>
                                                        <select required class="custom-input full-field" name="edit-course" id="edit-course">
                                                            '; 
                                                            if (mysqli_num_rows($courses_result) > 0) {
                                                                for ($i = 0; mysqli_num_rows($courses_result) > $i; $i++) {
                                                                    $row_courses = mysqli_fetch_assoc($courses_result);
                                                                    if ($row_courses["course_name"] == $row["course"]) {
                                                                        echo "<option value='" . $row_courses['course_name'] . "' selected>" . $row_courses['course_name'] . "</option>";
                                                                    } else {
                                                                        echo "<option value='" . $row_courses['course_name'] . "'>" . $row_courses['course_name'] . "</option>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<option disabled>No courses avaliable</option>";
                                                            }
                                                            echo '
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="edit-date">Date</label>
                                                        <input required type="date" class="custom-input full-field" id="edit-date" name="edit-date" placeholder="Attending date" value="' . $row['register_date'] . '">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="edit-id">Editing for ID</label>
                                                        <input required readonly type="number" class="custom-input full-field" id="edit-id" name="edit-id" placeholder="ID" value="' . $row['id'] . '">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="submit" class="custom-btn full-btn mb-0" id="edit-btn" name="edit-btn" value="Edit Registration">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <footer class="my-5">
            <p>Innovate Training - 2021</p>
        </footer>
    </body>
</html>