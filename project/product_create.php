<?php
include 'check.php'
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

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
        <!-- container -->
        <div class="container">
            <div class="page-header text-center">
                <h1>Create Product</h1>
            </div>


            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php

            if ($_POST) {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];
                $date1 = date_create($manufacture_date);
                $date2 = date_create($expired_date);
                $diff = date_diff($date1, $date2);

                if ($name == "" || $description == "" || $price == "" || $manufacture_date == "") {
                    echo "Please make sure all fields are not empty";
                }
                $flag = 0;
                if ($price == "") {
                    echo "Please make sure price are not empty";
                    $flag = 1;
                } elseif (preg_match('/[A-Z]/', $price)) {
                    echo "Please make sure price are not contain capital A-Z";
                    $flag = 1;
                } elseif (preg_match('/[a-z]/', $price)) {
                    echo "Please make sure price are not contain capital a-z";
                    $flag = 1;
                } elseif ($price < 0) {
                    echo "Please make sure price are not negative";
                    $flag = 1;
                } elseif ($price > 1000) {
                    echo "Please make sure price are not more than RM1000";
                    $flag = 1;
                }

                if ($promotion_price == "") {
                    $promotion_price = NULL;
                } elseif (preg_match('/[A-Z]/', $promotion_price)) {
                    echo "Please make sure promotion price are not contain capital A-Z";
                    $flag = 1;
                } elseif (preg_match('/[a-z]/', $promotion_price)) {
                    echo "Please make sure promotion price are not contain capital a-z";
                    $flag = 1;
                } elseif ($promotion_price < 0) {
                    echo "Please make sure promotion price are not negative";
                    $flag = 1;
                } elseif ($promotion_price > 999) {
                    echo "Please make sure promotion price are not more than RM999";
                    $flag = 1;
                }

                if ($promotion_price > $price) {
                    echo "Please make sure promotion price is not more than normal price";
                    $flag = 1;
                }

                if ($expired_date == "") {
                    $expired_date = NULL;
                }

                if ($promotion_price >= $price) {
                    echo "Please enter a cheaper price";
                } elseif ($diff->format("%R%a") <= "0") {
                    echo "Expired date must be after the manufacture date";
                } else {

                    if ($flag == 0) {

                        include 'config/database.php';
                        try {
                            // insert query
                            $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price,  manufacture_date=:manufacture_date, expired_date=:expired_date, created=:created, image=:image";
                            // prepare query for execution
                            $stmt = $con->prepare($query);
                            // bind the parameters
                            $stmt->bindParam(':name', $name);
                            $stmt->bindParam(':description', $description);
                            $stmt->bindParam(':price', $price);
                            $stmt->bindParam(':promotion_price', $promotion_price);
                            $image = !empty($_FILES["image"]["name"])
                                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                                : "";
                            $image = htmlspecialchars(strip_tags($image));
                            $stmt->bindParam(':image', $image);
                            $stmt->bindParam(':manufacture_date', $manufacture_date);
                            $stmt->bindParam(':expired_date', $expired_date);
                            $created = date('Y-m-d H:i:s'); // get the current date and time
                            $stmt->bindParam(':created', $created);
                            // Execute the query
                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Record was saved.</div>";
                                // now, if image is not empty, try to upload the image
                                if ($image) {

                                    // upload to file to folder
                                    $target_directory = "uploads/";
                                    $target_file = $target_directory . $image;
                                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                                    // error message is empty
                                    $file_upload_error_messages = "";
                                    // make sure that file is a real image
                                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                                    if ($check !== false) {
                                        // submitted file is an image
                                    } else {
                                        $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
                                    }
                                    // make sure certain file types are allowed
                                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                                    if (!in_array($file_type, $allowed_file_types)) {
                                        $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                                    }
                                    // make sure file does not exist
                                    if (file_exists($target_file)) {
                                        $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
                                    }
                                    // make sure submitted file is not too large, can't be larger than 1 MB
                                    if ($_FILES['image']['size'] > (1024000)) {
                                        $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
                                    }
                                    // make sure the 'uploads' folder exists
                                    // if not, create it
                                    if (!is_dir($target_directory)) {
                                        mkdir($target_directory, 0777, true);
                                    }
                                    // if $file_upload_error_messages is still empty
                                    if (empty($file_upload_error_messages)) {
                                        // it means there are no errors, so try to upload the file
                                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                            // it means photo was uploaded
                                        } else {
                                            echo "<div class='alert alert-danger'>";
                                            echo "<div>Unable to upload photo.</div>";
                                            echo "<div>Update the record to upload photo.</div>";
                                            echo "</div>";
                                        }
                                    }

                                    // if $file_upload_error_messages is NOT empty
                                    else {
                                        // it means there are some errors, so show them to user
                                        echo "<div class='alert alert-danger'>";
                                        echo "<div>{$file_upload_error_messages}</div>";
                                        echo "<div>Update the record to upload photo.</div>";
                                        echo "</div>";
                                    }
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
            }

            ?>

            <!-- html form here where the product information will be entered -->

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea type='text' name='description' class='form-control'></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Promotion_Price</td>
                        <td><input type='text' name='promotion_price' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><input type='date' name='manufacture_date' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><input type='date' name='expired_date' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td><input type="file" name="image" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </form>


        </div>
        <!-- end .container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>