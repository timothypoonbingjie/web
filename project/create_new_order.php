<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order Form</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div>
        <!-- container -->
        <nav class="navbar navbar-expand-lg bg-info">
            <div class="container-fluid ">
                <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                    <ul class="navbar-nav nav">
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" aria-current="page" href="home.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="http://localhost/web/project/product_create.php">Create Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="http://localhost/web/project/create_customers.php">Create Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="contact_us.html">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="product_read.php">Read Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="customers_read.php">Read Customers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="create_new_order.php">Create new order</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">

            <div class="page-header d-flex justify-content-center my-3">
                <h1>Create New Order</h1>
            </div>

            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php

            if ($_POST) {
                $user = $_POST['user'];
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $flag = 0;

                if ($flag == 0) {
                    include 'config/database.php';

                    try {
                        // insert query
                        $query = "INSERT INTO order_summary SET username=:username, date=:date";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':username', $username);
                        $date = date('Y-m-d H:i:s'); // get the current date and time
                        $stmt->bindParam(':date', $date);

                        // Execute the query
                        if ($stmt->execute()) {
                            $query = "SELECT MAX(id) as order_id FROM order_summary";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $order_id = $row['order_id'];
                            echo "<div class='alert alert-info'>ID: $order_id</div>";
                            echo "<div class='alert alert-success'>Your order is save</div>";
                            for ($two = 0; $two < count($product_id); $two++) {
                                try {
                                    // insert query
                                    $query = "INSERT INTO order_detials SET order_id=:order_id,product_id=:product_id,quantity=:quantity";
                                    // prepare query for execution
                                    $stmt = $con->prepare($query);
                                    // bind the parameters
                                    $stmt->bindParam(':order_id', $order_id);
                                    $stmt->bindParam(':product_id', $product_id[$two]);
                                    $stmt->bindParam(':quantity', $quantity[$two]);


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
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Customer username</td>
                        <td colspan="3">
                            <select class="form-select form-select-lg mb-3" name="user" aria-label=".form-select-lg example">
                                <option>Select Customer Username</option>
                                <?php

                                // include database connection
                                include 'config/database.php';
                                $query = "SELECT id, user FROM customers ORDER BY id DESC";
                                $stmt = $con->prepare($query);
                                $stmt->execute();

                                $num = $stmt->rowCount();
                                if ($num > 0) {

                                    // table body will be here
                                    // retrieve our table contents
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // extract row
                                        // this will make $row['firstname'] to just $firstname only
                                        extract($row);
                                        // creating new table row per record

                                        echo "<option value=\"$username\">$username</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php

                    echo "
                        <tr class=\"pRow\">
                        <td>Product</td>
                        <td class=\"d-flex\">
                            <select class=\"form-select form-select-lg mb-3 col\" name=\"product_id[]\" aria-label=\".form-select-lg example\">
                                <option>Select product</option>";
                    // include database connecphp';
                    $query = "SELECT id, name, price FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    $num = $stmt->rowCount();

                    if ($num > 0) {

                        // table body will be here
                        // retrieve our table contents
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // extract row
                            extract($row);
                            // creating new table row per record
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }

                    echo "
                            </select>

                        </td>
                        <td>Quantity</td>
                        <td><input type='number' name='quantity[]' class='form-control' /></td>
                    </tr>";


                    ?>

                    <tr>
                        <td colspan="2">
                            <input type="button" value="Add More Product" class="add_one" />
                            <input type="button" value="Delete" class="delete_one" />
                        </td>
                        <td colspan="2" class="text-end">
                            <input type='submit' value='Save' class='btn btn-primary' />
                        </td>
                    </tr>
                </table>
            </form>


        </div>
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var element = document.querySelector('.pRow');
                    var clone = element.cloneNode(true);
                    element.after(clone);
                }
                if (event.target.matches('.delete_one')) {
                    var total = document.querySelectorAll('.pRow').length;
                    if (total > 1) {
                        var element = document.querySelector('.pRow');
                        element.remove(element);
                    }
                }
            }, false);
        </script>
        <!-- end .container -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">

        </script>
</body>

</html>