<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-expand-lg bg-info">

            <a class="navbar-brand " href="home.php">Home</a>
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
                            <li><a class="dropdown-item" href="order_detials.php">order details</a></li>
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
                </ul>

            </div>

        </nav>
        <div class="page-header">
            <h1>Update Customers</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM customers WHERE id = :id";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(":id", $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $user = $row['user'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $account_status = $row['account_status'];
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML form to update record will be here -->


        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                $user = $_POST['user'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $date_of_birth = $_POST['date_of_birth'];
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : htmlspecialchars($image, ENT_QUOTES);
                $image = htmlspecialchars(strip_tags($image));
                $error_message = "";
                $today = date("Y-m-d");
                $date1 = date_create($date_of_birth);
                $date2 = date_create($today);
                $diff = date_diff($date1, $date2);
                $result = $diff->format("%a");
                $pass = true;
                $passw = $_POST['passw'];
                $new_pass = $_POST['new_pass'];
                $comfirm_password = $_POST['comfirm_password'];
                $select = "SELECT passwords FROM customers WHERE id = :id ";
                $stmt = $con->prepare($select);


                // Bind the parameter
                $stmt->bindParam(":id", $id);
                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                }
                // values to fill up our form
                $space = " ";
                if (strlen($user) < 6) {
                    echo "<div class='alert alert-danger'>Username should have at least 6 character.</div>";
                    $pass = false;
                }

                if (strpos($user, $space) !== false) {
                    echo "<div class='alert alert-danger'>Username cannot space.</div>";
                    $pass = false;
                }
                $keeppass = false;
                if ($passw == "" && $new_pass == "" && $comfirm_password == "") {
                    $keeppass = true;
                } else {
                    if ($row['passwords'] == $passw) {
                        $uppercase = preg_match('@[A-Z]@', $new_pass);
                        $lowercase = preg_match('@[a-z]@', $new_pass);
                        $number    = preg_match('@[0-9]@', $new_pass);
                        if (!$uppercase || !$lowercase || !$number || strlen($new_pass) < 8) {
                            echo "<div class='alert alert-danger'>Password should be at least 8 characters in length and should include at least one upper case letter, one number.</div>";
                            $pass = false;
                        }
                        if ($passw == $new_pass) {
                            echo "<div class='alert alert-danger'>Old Password cannot same with New Password.</div>";
                            $pass = false;
                        }
                        if ($new_pass != $comfirm_password) {
                            echo "<div class='alert alert-danger'>New Password and Comfirm Password not same.</div>";
                            $pass = false;
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Wrong Old Password</div>";
                        $pass = false;
                    }
                }


                if ($result < 6570) {
                    echo "<div class='alert alert-danger'>Only above 18 years old can save.</div>";
                    $pass = false;
                }
                if ($date_of_birth > $today) {
                    echo "<div class='alert alert-danger'>You cannot input the future date</div>";
                    $pass = false;
                }
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                if ($_FILES["image"]["name"]) {

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
                if (isset($_POST['delete'])) {
                    $image = htmlspecialchars(strip_tags($image));

                    $image = !empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    unlink("uploads/" . $row['image']);
                    $_POST['image'] = null;
                    $query = "UPDATE products
                                SET image=:image WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':id', $id);
                    // Execute the query
                    $stmt->execute();
                }
                if ($pass == true) {
                    $query = "UPDATE customers
                  SET user=:user, passwords=:new_pass, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth, account_status=:account_status, image=:imageS WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $user = htmlspecialchars(strip_tags($_POST['user']));
                    if ($keeppass == true) {
                        $new_pass = $row['passwords'];
                    } else {
                        $new_pass = htmlspecialchars(strip_tags($_POST['new_pass']));
                    }
                    $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                    $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                    $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                    $account_status = htmlspecialchars(strip_tags($_POST['account_status']));
                    // bind the parameters
                    $stmt->bindParam(':user', $user);
                    $stmt->bindParam(':new_pass', $new_pass);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':account_status', $account_status);
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':id', $id);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>

        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='user' value="<?php echo htmlspecialchars($user, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type='text' name='passw' class='form-control' /></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type='text' name='new_pass' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Comfirm Password</td>
                    <td><input type='text' name='comfirm_password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Images</td>
                    <td><img src="uploads/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" />
                        <input type="file" name="image" value="<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" />
                        <input type='submit' name='delete' value='Delete Image' class='btn btn-danger' />
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <div><input disabled type='text' name="gender" value="<?php echo htmlspecialchars($gender, ENT_QUOTES);  ?>" /></div>
                        <div class="ms-4 col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" checked>
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td><input placeholder="Select birthday" type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control ' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <div><input disabled type='text' name="account_status" value="<?php echo htmlspecialchars($account_status, ENT_QUOTES);  ?>" /></div>
                        <div class="ms-4 col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="account_status" id="inlineRadio3" value="opened" checked>
                            <label class="form-check-label" for="inlineRadio3">Opened</label>
                        </div>
                        <div class="col-2 form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="account_status" id="inlineRadio4" value="closed">
                            <label class="form-check-label" for="inlineRadio4">Closed</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customers_read.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
</body>

</html>