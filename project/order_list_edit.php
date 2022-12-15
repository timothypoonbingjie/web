<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>




    <!-- custom css -->
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
    <!-- container -->
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
            <h1>Edit Order List</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM order_summary INNER JOIN order_detials ON order_detials.order_id = order_summary.id INNER JOIN products ON products.id = order_detials.product_id WHERE order_summary.id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $order_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form

        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM order_summary INNER JOIN order_detials ON order_detials.order_id = order_summary.id WHERE order_summary.id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $id = $row['id'];
            $date = $row['date'];
            $username = $row['username'];
            $quantity = $row['quantity'];
            $product_id = $row['product_id'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        // check if form was submitted
        if ($_POST) {

            $order_id = $_POST['order_id'];
            $order_date = $_POST['order_date'];
            $username = $_POST['username'];
            $quantity = $_POST['quantity'];
            $product_id = $_POST['product_id'];
            $error_message = "";

            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE order_summary SET id=:id, date=:date, username=:username WHERE id = :id
                    INNER JOIN order_detials ON order_detials.order_id = order_summary.id SET id=:id, product_id=:product_id, quantity=:quantity WHERE id = :id WHERE id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $id = htmlspecialchars(strip_tags($_POST['id']));
                $date = htmlspecialchars(strip_tags($_POST['date']));
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $quantity = htmlspecialchars(strip_tags($_POST['quantity']));
                $product_id = htmlspecialchars(strip_tags($_POST['product_id']));
                // bind the parameters
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':product_id', $product_id);
                // Execute the query
                if ($stmt->execute()) {
                    header("Location: order_summary.php?update={$order_id}");
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>



        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>

                <tr>
                    <td>Username</td>
                    <td colspan="3">
                        <select class="form-select form-select-lg" name="username" aria-label=".form-select-lg example">
                            <option><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></option>
                            <?php
                            $query = "SELECT user FROM customers ORDER BY user DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $row = $stmt->rowCount();
                            if ($row > 0) {
                                // table body will be here
                                // retrieve our table contents
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    // extract row
                                    extract($row);
                                    // creating new table row per record
                                    echo "<option value=\"$user\">$user</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <?php
                $query = "SELECT * FROM order_detials INNER JOIN products ON products.id = order_detials.product_id WHERE order_detials.order_id=:order_id";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":order_id", $id);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                            <td class='col-3'>Product Name</td>
                            <td class='col-3'><select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"product_id[]\">
                            <option value=\"$name\">$name</option>";
                        $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                        $stmt2 = $con->prepare($query);
                        $stmt2->execute();
                        $num = $stmt2->rowCount();
                        if ($num > 0) {
                            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                echo "<option value=\"$id\">$name</option>";
                            }
                        }
                        echo "
                            
                            <td class='col-3'>Quantity</td>
                            <td class='col-3'><input type='number' name='quantity' value='$quantity' class='form-control' />
                            </td>
                            </tr>";
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>

            </table>
        </form>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


    <!-- end .container -->
</body>

</html>