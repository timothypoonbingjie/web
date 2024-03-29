<?php
include 'check.php'
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet" />

    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

</head>

<body>
    <?php
    include 'topnav.php'
    ?><div class="container-fluid image" style="background-image:url('image/brightbg.jpg')">
    <!-- container -->
    <div class="container">
        <div class="page-header text-center">
            <h1>Create Product</h1>
        </div>


        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php

        $name = $description = $price = $promotion_price = $manufacture_date = $expired_date = "";
        if ($_POST) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $promotion_price = $_POST['promotion_price'];
            $manufacture_date = $_POST['manufacture_date'];
            $expired_date = $_POST['expired_date'];
            $image = !empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";
            $error_message = "";

            if ($name == "" || $description == "" || $price == "" || $manufacture_date == "") {
                $error_message .= "<div class='alert alert-danger'>Please make sure all fields are not empty</div>";
            }
            if ($price == "") {
                $error_message .= "<div class='alert alert-danger'>Please make sure price are not empty</div>";
            } elseif (!is_numeric($price)) {
                $error_message .= "<div class='alert alert-danger'>Please make sure price only numbers</div>";
            } elseif ($price > 1000) {
                $error_message .= "<div class='alert alert-danger'>Please make sure price are not more than RM1000</div>";
            }

            if ($promotion_price == "") {
                $promotion_price = NULL;
            }

            if ($promotion_price > $price) {
                $error_message .= "<div class='alert alert-danger'>Please make sure promotion price is not more than normal price</div>";
            }

            if ($expired_date == "") {
                $expired_date = NULL;
            } else {
                $date1 = date_create($manufacture_date);
                $date2 = date_create($expired_date);
                $diff = date_diff($date1, $date2);
                if ($diff->format("%R%a") <= "0") {
                    $error_message .= "<div class='alert alert-danger'>Expired date must be after the manufacture date</div>";
                }
            }

            if ($promotion_price >= $price) {
                $error_message .= "<div class='alert alert-danger'>Please enter a cheaper price</div>";
            }
            if ($image) {

                // upload to file to folder
                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                // make sure that file is a real image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check === false) {
                    $error_message .= "<div>Submitted file is not an image.</div>";
                }
                // make sure certain file types are allowed
                $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                if (!in_array($file_type, $allowed_file_types)) {
                    $error_message .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
                // make sure file does not exist
                if (file_exists($target_file)) {
                    $error_message .= "<div>Image already exists. Try to change file name.</div>";
                }
                // make sure submitted file is not too large, can't be larger than 1 MB
                if ($_FILES['image']['size'] > (1024000)) {
                    $error_message .= "<div>Image must be less than 1 MB in size.</div>";
                }
                // make sure the 'uploads' folder exists
                // if not, create it
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
                // if $file_upload_error_messages is still empty
                if (empty($error_message)) {
                    // it means there are no errors, so try to upload the file
                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        echo "<div>Unable to upload photo.</div>";
                        echo "<div>Update the record to upload photo.</div>";
                    }
                }
            }
            if ($image == null) {
                $image = "emptybox.png";
            }
            if (!empty($error_message)) {
                echo "<div class='alert alert-danger'>{$error_message}</div>";
            } else {

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
                    $image = htmlspecialchars(strip_tags($image));
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($stmt->execute()) {
                        header("Location: product_read.php?action=update");
                        echo "<div class='alert alert-success bg-success text-white'>Record was saved.</div>";
                        // now, if image is not empty, try to upload the image

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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value='<?php echo $name ?>' class='form-control' placeholder="Please enter your Product's name"/></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea type='text' name='description' value='<?php echo $description ?>' class='form-control'placeholder="Please enter your Product's desciption"></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value='<?php echo $price ?>' class='form-control' placeholder="Please enter your Product's Price"/></td>
                </tr>
                <tr>
                    <td>Promotion_Price</td>
                    <td><input type='text' name='promotion_price' value='<?php echo $promotion_price ?>' class='form-control' placeholder="Please enter your Product's Promotion Price"/></td>
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
    </div>
</body>

</html>