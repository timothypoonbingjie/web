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
    <link href="css/style.css" rel="stylesheet" />



</head>

<body>
    <?php
    include 'topnav.php'
    ?>
    <div class="container-fluid image" style="background-image:url('image/bright2.png')">
        <div class="container">

            <div class="page-header d-flex justify-content-center my-3">
                <h1>Create New Order</h1>
            </div>

            <!-- html form to create product will be here -->
            <!-- PHP insert code will be here -->
            <?php

            if ($_POST) {
                $username = $_POST['username'];
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
                $flag = 0;
                if ($username == 'Select Customer Username') {
                    echo "<div class='alert alert-danger'>Please choose your order.</div>";
                    $flag = 1;
                }
                if ($product_id == ['Select product']) {
                    echo "<div class='alert alert-danger'>Please choose your product.</div>";
                    $flag = 1;
                }
                if ($quantity <= ["0"]) {
                    echo "<div class='alert alert-danger'>The quantity cannot below 1</div>";
                    $flag = 1;
                }

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
                            echo "<div class='alert alert-success bg-success text-white'>Your order is save</div>";
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
                                        header("Location: order_summary.php?action=update");
                                        echo "<div class='alert alert-success bg-success text-white'>Record was saved.</div>";
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
                <table id="delete_row" class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Customer username</td>
                        <td colspan="3">
                            <select class="form-select form-select-lg mb-3" name="username" aria-label=".form-select-lg example">
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

                                        echo "<option value=\"$user\">$user</option>";
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

                    ?>
                    </select>

                    </td>
                    <td>Quantity</td>
                    <td><input type='number' name='quantity[]' class='form-control' placeholder="Quantity need at least 1"/></td>
                    <td><input type="button" value="Delete" class='btn btn-danger' onclick="deleteRow(this)"></td>
                    </tr>




                    <tr>
                        <td colspan="2">
                            <input type="button" value="Add More Product" class="add_one" />

                        </td>
                        <td colspan="2" class="text-end">
                            <a href='order_summary.php' class='btn btn-primary'>Go to order list</a>
                            <input type='submit' value='Save Changes' class='btn btn-success' onclick="checkDuplicate(event)" />
                        </td>
                    </tr>
                </table>
            </form>


        </div>

        <script>
            function checkDuplicate(event) {
                var newarray = [];
                var selects = document.getElementsByTagName('select');
                for (var i = 0; i < selects.length; i++) {
                    newarray.push(selects[i].value);
                }
                if (newarray.length !== new Set(newarray).size) {
                    alert("Product cannot be same");
                    event.preventDefault();
                }
            }

            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var rows = document.getElementsByClassName('pRow');
                    // Get the last row in the table
                    var lastRow = rows[rows.length - 1];
                    // Clone the last row
                    var clone = lastRow.cloneNode(true);
                    // Insert the clone after the last row
                    lastRow.insertAdjacentElement('afterend', clone);

                    // Loop through the rows
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                }
            }, false);

            function deleteRow(r) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var i = r.parentNode.parentNode.rowIndex;
                    document.getElementById("delete_row").deleteRow(i);
                } else {
                    alert("Need at least one row in table!")
                }
            }
        </script>
        <!-- end .container -->
    </div>
</body>

</html>