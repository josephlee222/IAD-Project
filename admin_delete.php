<html>
    <?php
    include_once "connect.php";
    include_once "auth.php";

    $deleted = false;
    $show_confirm = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["delete-btn"])) {
            $delete_id = $_POST["delete-id"];
            $sql = "DELETE FROM registrations WHERE id=" . $delete_id;
            if (!mysqli_query($db_connect, $sql)) {
                $error = "mySQL query failed: " . mysqli_error($db_connect) . "<br><br>SQL Query: " . $sql;
            } else {
                if (mysqli_affected_rows($db_connect) > 0) {
                    $success = "Delete successful: " . mysqli_affected_rows($db_connect) . " entry affected.";
                    $deleted = true;
                }
            }
            

        }
    }
    if (!$deleted) {
        if (isset($_GET["id"])) {
            $search_id = $_GET["id"];
            $sql = "SELECT * FROM registrations WHERE id=" . $search_id;
            $result = mysqli_query($db_connect, $sql);

            if (!$result) {
                $error = "mySQL query failed: " . mysqli_error($db_connect) . "<br><br>SQL Query: " . $sql;
            } else {
                if (mysqli_num_rows($result) > 0) {
                    $show_confirm = true;
                } else {
                    $error = "Record does not exist. Please try again";
                }
                
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
        <title>Innovate Training - Admin (Delete Registant)</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="container bg-light">
                <a class="navbar-brand" href="#">Innovate Training</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarNav">
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
                    <div class=" mt-3 mt-md-0 d-flex">
                        <p class="my-auto mr-3 admin-username"><?php echo $cookie_username?></p>
                        <a class="custom-btn nav-btn btn logout material-icons">power_settings_new</a>
                    </div>
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
            }

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
                        <a href="./admin_edit.php" class="list-group-item list-group-item-action">Edit Registration</a>
                        <a href="#" class="list-group-item list-group-item-action active">Delete Registration</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Enter ID to delete</h5>
                                        <form class="container-fluid p-0 mb-0">
                                            <div class="row">
                                                <div class="col-md-9 mb-3 mb-md-0">
                                                    <input class="custom-input w-100" type="number" name="id" id="delete-id" placeholder="ID to delete">
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="custom-btn w-100" type="submit" name="delete-search-btn" id="delete-search-btn" value="Find by ID">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SHould only appear with php (Placeholder HTML) -->
                        <?php
                        if ($show_confirm) {
                            $row = mysqli_fetch_assoc($result);
                            echo '
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Confirm delete</h5>
                                                <form method="post">
                                                    <div class="mb-4">
                                                        <label for="delete-id">Deleting ID</label>
                                                        <input type="number" id="delete-id" name="delete-id" class="custom-input w-100" readonly value="' . $row["id"] . '">
                                                    </div>
                                                    <h6>Registeration Details</h6>
                                                    <div class="card white mb-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title">' . $row["name"] . '</h5>
                                                            <p>Course Applied: ' . $row["course"] . '<br>Start Date: ' . $row["register_date"] . '<br>Email: ' . $row["email"] . '<br>Phone: ' . $row["contact"] . '</p>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="custom-btn danger delete-btn w-100" name="delete-btn" value="Delete">
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