<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</head>

<body>
    <div class="container">

        <nav class="navbar navbar-expand-lg bg-info">

            <a class="navbar-brand " href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_customers.php">create customer</a></li>
                            <li><a class="dropdown-item" href="customers_read.php">read customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Order
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_new_order.php">create order</a></li>
                            <li><a class="dropdown-item" href="order_summary.php">order list</a></li>
                            
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="product_create.php">create product</a></li>
                            <li><a class="dropdown-item" href="product_read.php">read product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="log_out.php">Log Out</a>
                    </li>
                </ul>

            </div>

        </nav>

        <!-- container -->
        <div class="container">
            <div class="page-header text-center">
                <h1>Create Customers</h1>
            </div>


            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php
            $user = $first_name = $last_name = $date_of_birth = "";
            if ($_POST) {
                $user = $_POST['user'];
                $passwords = $_POST['passwords'];
                $confirm_passwords = $_POST['confirm_passwords'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $account_status = $_POST['account_status'];
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";     
                $error_message = "";

                // include database connection

                $flag = 0;
                if ($user == "") {
                    echo "Please enter your username";
                    $flag = 1;
                }
                $space = " ";
                $world = $_POST['user'];
                if (strpos($world, $space) !== false) {
                    echo "Username should not space";
                    $flag = 1;
                } elseif (strlen($user) < 6) {
                    echo "Username need at least 6 charecter";
                    $flag = 1;
                }
                if ($passwords == "") {
                    echo "Please enter your password";
                    $flag = 1;
                } elseif (!preg_match('/[A-Z]/', $passwords)) {
                    echo "Password need include uppercase";
                    $flag = 1;
                } elseif (!preg_match('/[a-z]/', $passwords)) {
                    echo "Password need include lowercase";
                    $flag = 1;
                } elseif (!preg_match('/[0-9]/', $passwords)) {
                    echo "Password need include number";
                    $flag = 1;
                } elseif (strlen($passwords) < 8) {
                    echo "Password need at least 8 charecter";
                    $flag = 1;
                }


                if ($confirm_passwords == "") {
                    echo "Please enter your confirm password";
                    $flag = 1;
                } elseif ($passwords != $confirm_passwords) {
                    echo "Password need same with confirm password";
                    $flag = 1;
                }

                if ($first_name == "") {
                    echo "Please enter your first name";
                    $flag = 1;
                }

                if ($last_name == "") {
                    echo "Please enter your last name";
                    $flag = 1;
                }

                if ($gender == "") {
                    echo "Please do not empty gender";
                    $flag = 1;
                }

                if ($date_of_birth == "") {
                    echo "Please enter your date of birth";
                    $flag = 1;
                }
                $day = $_POST['date_of_birth'];
                $today = date("Ymd");
                $date1 = date_create($day);
                $date2 = date_create($today);
                $diff = date_diff($date1, $date2);
                if ($diff->format("%y") <= "18") {
                    echo "User need atleast 18 years old";
                    $flag = 1;
                }

                if ($account_status == "") {
                    echo "Please do not empty account status";
                    $flag = 1;
                }
                if ($image) {

                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);


                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check === false) {
                        $error_message .= "<div class='alert alert-danger'>Submitted file is not an image.</div>";
                    }

                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $error_message .= "<div class='alert alert-danger'>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }

                    if (file_exists($target_file)) {
                        $error_message .= "<div class='alert alert-danger'>Image already exists. Try to change file name.</div>";
                    }

                    if ($_FILES['image']['size'] > (1024000)) {
                        $error_message .= "<div class='alert alert-danger'>Image must be less than 1 MB in size.</div>";
                    }

                    if (!is_dir($target_directory)) {
                        mkdir($target_directory, 0777, true);
                    }

                    if (empty($error_message)) {
                        // it means there are no errors, so try to upload the file
                        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            echo "<div class='alert alert-danger>Unable to upload photo.</div>";
                            echo "<div class='alert alert-danger>Update the record to upload photo.</div>";
                        }
                    }
                }
                if($image == null){
                    $image = "nonprofile.jpg";
                }
                
                if ($flag == 0) {


                    include 'config/database.php';

                    try {
                        // insert query
                        $query = "INSERT INTO customers SET user=:user, passwords=:passwords, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth, register_date=:register_date,account_status=:account_status, image=:image";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':user', $user);
                        $stmt->bindParam(':passwords', $passwords);
                        $stmt->bindParam(':first_name', $first_name);
                        $stmt->bindParam(':last_name', $last_name);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':date_of_birth', $date_of_birth);
                        $stmt->bindParam(':account_status', $account_status);
                        $register_date = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':register_date', $register_date);
                        $stmt->bindParam(':image', $image);
                        // Execute the query
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was saved.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }
                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }

            ?>

            <!-- html form here where the product information will be entered -->

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Username</td>
                        <td><input type='text' name='user' value='<?php echo $user ?>'class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type='password' name='passwords' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input type='password' name='confirm_passwords' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>First name</td>
                        <td><input type='text' name='first_name' value='<?php echo $first_name ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td><input type='text' name='last_name' value='<?php echo $last_name ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Images</td>
                        <td>
                            <input type="file" name="image" />
                            <input type='submit' name='delete' value='Delete Image' class='btn btn-danger' />
                        </td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="female" name="gender" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="male" name="gender">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Female
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of birth</td>
                        <td><input type='date' name='date_of_birth' value='<?php echo $date_of_birth ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Account status</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="opened" name="account_status" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Opened
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="closed" name="account_status">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Closed
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='customers_read.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </form>


        </div>
        <!-- end .container -->
    </div>


</body>

</html>