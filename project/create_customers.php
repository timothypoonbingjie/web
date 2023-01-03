<?php session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet" />


</head>

<body>
   
        <?php

        if (isset($_SESSION["Pass"])) {
            include 'topnav.php';
        }
        ?>
        <div class="container-fluid image" style="background-image:url('image/brightbg.jpg')">
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
                $passwords = md5($_POST['passwords']);
                $confirm_passwords = md5($_POST['confirm_passwords']);
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

                
                if ($user == "") {
                    $error_message .= "<div>Please enter your username</div>";
                    
                }
                $space = " ";
                $world = $_POST['user'];
                if (strpos($world, $space) !== false) {
                    $error_message .= "<div>Username should not space</div>";
                    
                } elseif (strlen($user) < 6) {
                    $error_message .= "<div>Username need at least 6 charecter</div>";
                    
                }
                if ($passwords == "") {
                    $error_message .= "<div>Please enter your password</div>";
                    
                } elseif (!preg_match('/[a-z]/', $passwords)) {
                    $error_message .= "<div>Password need include lowercase</div>";
                   
                } elseif (!preg_match('/[0-9]/', $passwords)) {
                    $error_message .= "<div>Password need include number</div>";
                    
                } elseif (strlen($passwords) < 8) {
                    $error_message .= "<div>Password need at least 8 charecter</div>";
                    
                }


                if ($confirm_passwords == "") {
                    $error_message .= "<div>Please enter your confirm password</div>";
                    
                } elseif ($passwords != $confirm_passwords) {
                    $error_message .= "<div>Password need same with confirm password</div>";
                    
                }

                if ($first_name == "") {
                    $error_message .= "<div>Please enter your first name</div>";
                   
                }

                if ($last_name == "") {
                    $error_message .= "<div>Please enter your last name</div>";
                    
                }

                if ($gender == "") {
                    $error_message .= "<div>Please do not empty gender</div>";
                    
                }

                if ($date_of_birth == "") {
                    $error_message .= "<div>Please enter your date of birth</div>";
                    
                }
                $day = $_POST['date_of_birth'];
                $today = date("Ymd");
                $date1 = date_create($day);
                $date2 = date_create($today);
                $diff = date_diff($date1, $date2);
                if ($diff->format("%y") <= "18") {
                    $error_message .= "<div>User need atleast 18 years old</div>";
                   
                }

                if ($account_status == "") {
                    $error_message .= "<div>Please do not empty account status</div>";
                
                }
                if ($image) {

                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);


                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check === false) {
                        $error_message .= "<div>Submitted file is not an image.</div>";
                    }

                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $error_message .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }

                    if (file_exists($target_file)) {
                        $error_message .= "<div>Image already exists. Try to change file name.</div>";
                    }

                    if ($_FILES['image']['size'] > (1024000)) {
                        $error_message .= "<div>Image must be less than 1 MB in size.</div>";
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
                if ($image == null) {
                    $image = "nonprofile2.png";
                }

                if (!empty($error_message)){
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                else{


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
                            header("Location: customers_read.php?action=update");
                            echo "<div class='alert alert-success bg-success text-white'>Record was saved.</div>";
                        if (!isset($_SESSION["pass"])){
                            header('Location:login.php?action=create');
                        } else {
                            header('Location:customers_read.php?action=change');
                        }    
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
                        <td><input type='text' name='user' value='<?php echo $user ?>' class='form-control' placeholder="Please enter your username" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type='password' name='passwords' class='form-control' placeholder="Please enter your password" /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input type='password' name='confirm_passwords' class='form-control' placeholder="Confirm Password need same with Password"/></td>
                    </tr>
                    <tr>
                        <td>First name</td>
                        <td><input type='text' name='first_name' value='<?php echo $first_name ?>' class='form-control' placeholder="Please enter your First name" /></td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td><input type='text' name='last_name' value='<?php echo $last_name ?>' class='form-control' placeholder="Please enter your lastname" /></td>
                    </tr>
                    <tr>
                        <td>Images</td>
                        <td>
                            <input type="file" name="image"/>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="male" name="gender" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="female" name="gender">
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
                            <a href='customers_read.php' class='btn btn-danger'>Back to customers read</a>
                        </td>
                    </tr>
                </table>
            </form>



            <!-- end .container -->
        </div>

    </div>
</body>

</html>