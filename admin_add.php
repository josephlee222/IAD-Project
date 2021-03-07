<html>
    <?php
    //Import connection and account checker
    include_once "connect.php";
    include_once "auth.php";

    //If a form via POST method is received
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["register-btn"])) {
            //Get form details for registration
            $register_name = $_POST["register-name"];
            $register_phone = $_POST["register-phone"];
            $register_email = $_POST["register-email"];
            $register_course = $_POST["register-course"];
            $register_date = $_POST["register-date"];

            //Check the course which the user is registering
            $sql = "SELECT * FROM courses WHERE id=" . $register_course;
            $result = mysqli_query($db_connect, $sql);
            if (!$result) {
                $error = "mySQL query failed: " . mysqli_error($db_connect);
            } else {
                $row =mysqli_fetch_assoc($result);
            }

            $course_id = $row["id"];
            $course_seats = $row["seats"];
            $course_seats_after = $course_seats - 1;
            $register_course = $row["course_name"];

            //Checking whether the course still have avaliable seats
            if ($course_seats > 0) {
                //If there is seats avaliable
                //Insert new registration into database
                $sql = "INSERT INTO registrations (name, course, email, contact, register_date) VALUES ('" . $register_name . "', '" . $register_course . "', '" . $register_email . "', " . $register_phone . ", '" . $register_date . "' )";
                if (!mysqli_query($db_connect, $sql)) {
                    //In case of SQL error
                    $error = "mySQL query failed: " . mysqli_error($db_connect);
                } else {
                    $sql = "UPDATE courses SET seats=" . $course_seats_after . " WHERE id=" . $course_id;
                    if (!mysqli_query($db_connect, $sql)) {
                        //In case of SQL error
                        $error = "mySQL query failed: " . mysqli_error($db_connect) . "<br><br>SQL Query: " . $sql;
                    } else {
                        //Registration successful, show success message
                        $success = "
                            Registration successfully done.<br>An E-mail has been sent to the customer with the registration details
                        ";
                    }
                }
            } else {
                //If there is no more seats avaliable
                $error = "The course you have selected is not avaliable anymore as all the seats has been taken. Please try again later.";
            }   
        }
    }

    //Get the list of courses avaliable for registration
    $sql = "SELECT course_name, id, seats FROM courses";
    $result = mysqli_query($db_connect, $sql);
    
    if (!$result) {
        //In case of SQL error
        $error = "mySQL query failed: " . mysqli_error($db_connect);
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
        <script src="./js/vaildation.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Innovate Training - Admin (Add Registant)</title>
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
                        <a href="#" class="list-group-item list-group-item-action active">Add Registration</a>
                        <a href="./admin_edit.php" class="list-group-item list-group-item-action">Edit Registration</a>
                        <a href="./admin_delete.php" class="list-group-item list-group-item-action">Delete Registrations</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Add Registration</h5>
                                        <form method="POST" class="container-fluid p-0">
                                            <div class="row mb-3">
                                                <div class="col-lg-6 mb-3 mb-lg-0">
                                                    <div class="d-flex align-content-center label-div">
                                                        <label for="register-name" style="flex-grow: 1;">Name</label>
                                                        <span id="vaildation" class="material-icons white"></span>
                                                    </div>
                                                    <input required type="text" class="custom-input vaildate-text w-100" id="register-name" name="register-name" placeholder="Name" minlength="4">
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="d-flex align-content-center label-div">
                                                        <label for="register-phone" style="flex-grow: 1;">Phone</label>
                                                        <span id="vaildation" class="material-icons white"></span>
                                                    </div>
                                                    <input required type="tel" class="custom-input vaildate-phone w-100" id="register-phone" name="register-phone" placeholder="Phone number" minlength="8" maxlength="8">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="d-flex align-content-center label-div">
                                                        <label for="register-email" style="flex-grow: 1;">Email</label>
                                                        <span id="vaildation" class="material-icons white"></span>
                                                    </div>
                                                    <input required type="email" class="custom-input vaildate-email w-100" id="register-email" name="register-email" placeholder="Email address">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-6 mb-3 mb-lg-0">
                                                    <label for="register-course">Course</label>
                                                    <select required class="custom-input w-100" name="register-course" id="register-course">
                                                        <?php
                                                        //Checks whether there is courses to register for
                                                        if (mysqli_num_rows($result) > 0) {
                                                            //Print options for courses
                                                            for ($i = 0; mysqli_num_rows($result) > $i; $i++) {
                                                                $row = mysqli_fetch_assoc($result);
                                                                if ($row['seats'] == 0) {
                                                                    echo "<option value='" . $row['id'] . "' disabled>" . $row['course_name'] . " [Full]</option>";
                                                                } else {
                                                                    //Default selection
                                                                    echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
                                                                }
                                                                
                                                            }
                                                        } else {
                                                            //If there is no courses avaliable, print disabled option
                                                            echo "<option disabled>No courses avaliable</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="register-date">Date</label>
                                                    <input required type="date" class="custom-input w-100" id="register-date" name="register-date" placeholder="Attending date"  min="<?php echo date("Y-m-d");?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="submit" class="custom-btn w-100 mb-0" id="register-btn" name="register-btn" value="Register">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="my-5">
            <p>Innovate Training - 2021</p>
        </footer>
    </body>
</html>