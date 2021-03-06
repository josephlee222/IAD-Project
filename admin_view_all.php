<html>
    <?php
        //Import connection and account checker
        include_once "connect.php";
        include_once "auth.php";

        //for course filtering options
        $sql = "SELECT course_name FROM courses";
        $result_courses = mysqli_query($db_connect, $sql);
        
        //If the filter button is pressed
        if (isset($_GET["filter-btn"])) {
            $sql = "SELECT * FROM registrations";
            $start = true;

            //If the course filter is set
            if (isset($_GET["filter-course"]) && $_GET["filter-course"] != "") {
                $fliter_course = $_GET["filter-course"];
                $sql = $sql . " WHERE course LIKE '%" . $fliter_course . "%'";
                $start = false;
            }

            //If the date filter is set
            if (isset($_GET["filter-date"]) && $_GET["filter-date"] != "") {
                $fliter_date = $_GET["filter-date"];
                if (!$start) {
                    //If it is the first condition
                    $sql = $sql . " AND register_date LIKE '%" . $fliter_date . "%'";
                } else {
                    //If there is another condition already in use
                    $sql = $sql . " WHERE register_date LIKE '%" . $fliter_date . "%'";
                    $start = false;
                }
            }

            //If the name filter is set
            if (isset($_GET["filter-name"]) && $_GET["filter-name"] != "") {
                $fliter_name = $_GET["filter-name"];
                if (!$start) {
                    $sql = $sql . " AND name LIKE '%" . $fliter_name . "%'";
                } else {
                    $sql = $sql . " WHERE name LIKE '%" . $fliter_name . "%'";
                }
            }

            $sql = $sql . " ORDER BY id DESC";
            
        } else {
            //Default display
            $sql = "SELECT * FROM registrations ORDER BY id DESC";
        }

        $result = mysqli_query($db_connect, $sql);
        if (!$result) {
            //In case of SQL error
            $error = "mySQL query failed: " . mysqli_error($db_connect) . "<br><br>SQL Query: " . $sql;
            //echo $error;
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
        <title>Innovate Training - Admin (View Registants)</title>
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
        ?>
        <div class="row">
            <div class="col-lg-3">
                <!-- Sidebar navigation -->
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">View Registrations</a>
                    <a href="./admin_add.php" class="list-group-item list-group-item-action">Add Registration</a>
                    <a href="./admin_edit.php" class="list-group-item list-group-item-action">Edit Registration</a>
                    <a href="./admin_delete.php" class="list-group-item list-group-item-action">Delete Registrations</a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col">
                            <div class="card fliter-card">
                                <div class="card-body">
                                    <div class="d-flex card-expendable">
                                        <h5 class="card-title flex-grow-1 mb-0">Filters</h5>
                                        <span class="material-icons card-expendable-icon">arrow_drop_up</span>
                                    </div>
                                    
                                    <form class="container-fluid p-0" id="expendable">
                                        <div class="row mt-3">
                                            <div class="col-lg-4">
                                                <label for="filter-course">Filter By Course</label>
                                                <select id="filter-course" name="filter-course" class="custom-input w-100 mb-3 mb-lg-0">
                                                    <!-- PHP code will be here -->
                                                    <option value="" disabled selected>Filter courses</option>
                                                    <?php
                                                    if (mysqli_num_rows($result_courses) > 0) {
                                                        for ($i = 0; mysqli_num_rows($result_courses) > $i; $i++) {
                                                            $row = mysqli_fetch_assoc($result_courses);
                                                            if ($row['course_name'] == $_GET["filter-course"]) {
                                                                echo "<option value='" . $row['course_name'] . "' selected>" . $row['course_name'] . "</option>";
                                                            } else {
                                                                echo "<option value='" . $row['course_name'] . "'>" . $row['course_name'] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 mb-3 mb-lg-0">
                                                <label for="fliter-date">Filter By Date</label>
                                                <input id="filter-date" name="filter-date" class="custom-input w-100" type="date" placeholder="Fliter By Date" value="<?php if (isset($_GET['filter-date'])) {echo $_GET['filter-date'];}?>">
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="d-flex align-content-center label-div">
                                                    <label for="filter-name" style="flex-grow: 1;">Filter By Name</label>
                                                    <span id="vaildation" class="material-icons white"></span>
                                                </div>
                                                <input id="filter-name" name="filter-name" class="custom-input w-100" type="text" placeholder="Fliter By Name" value="<?php if (isset($_GET['filter-name'])) {echo $_GET['filter-name'];}?>">
                                            </div>
                                        </div>
                                        <div class="row mb-0 mt-3">
                                            <div class="col">
                                                <input type="submit" name="filter-btn" class="custom-btn w-100" value="Fliter by selection">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Content -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <!-- PHP will be here -->
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    for ($i = 0; mysqli_num_rows($result) > $i; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        echo '
                                        <div class="card white mb-3 stagger">
                                            <div class="card-body">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-lg-8 mb-3 mb-lg-0">
                                                            <h5>' . $row["name"] . '</h5>
                                                            <p>Course Applied: ' . $row["course"] . '<br>Start Date: ' . $row["register_date"] . '<br>Email: ' . $row["email"] . '<br>Phone: ' . $row["contact"] . '</p>
                                                        </div>
                                                        <div class="col-lg-4 list-controls d-flex">
                                                            <a class="custom-btn mail-btn mr-2 flex-grow-1 option-btn d-inline-flex" href="mailto:' . $row["email"] . '"><span class="material-icons mr-3 mail-icon">email</span>E-mail</a>
                                                            <a class="custom-btn mr-2 material-icons option-btn" href="./admin_edit.php?id=' . $row["id"] . '">edit</a>
                                                            <a class="custom-btn danger material-icons option-btn" href="./admin_delete.php?id=' . $row["id"] . '">delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        ';
                                    }
                                } else {
                                    echo "<p>No results matching criteria</p>";
                                }
                                ?>
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