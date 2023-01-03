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
    <?php
    include 'topnav.php'
    ?>
    <div class="container-fluid image" style="background-image:url('image/brightbg.jpg')">
    <div class="page-header">
        <h1>Edit Order List</h1>
    </div>
    <!-- PHP read record by ID will be here -->


    <?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not


    //include database connection
    include 'config/database.php';

    $error_message = "";
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    try {
        $query = "SELECT id as summaryid, username, date FROM order_summary GROUP BY id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }


    // check if form was submitted
    if ($_POST) {

        $username = $_POST['username'];
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        if ($username == 'Select Customer Username') {
            $error_message .= "<div class='alert alert-danger'>Please choose your order.</div>";
        }
        if ($product_id == ['Select product']) {
            $error_message .= "<div class='alert alert-danger'>Please choose your product.</div>";
        }
        if ($quantity <= ["0"]) {
            $error_message .= "<div class='alert alert-danger'>The quantity cannot below 1</div>";
        }

        if ($username == "") {
            $error_message .= "<div class='alert alert-danger'>Please select your username!</div>";
        }

        if ($product_id == [""]) {
            $error_message .= "<div class='alert alert-danger'>Please select your product!</div>";
        }

        if ($quantity == [""]) {
            $error_message .= "<div class='alert alert-danger'>Please enter how many product you want!</div>";
        }

        if (!empty($error_message)) {
            echo "<div class='alert alert-danger'>{$error_message}</div>";
        } else {

            try {
                // insert query
                $query = "UPDATE order_summary SET username=:username, date=:date WHERE id=:id";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // bind the parameters
                $stmt->bindParam(':username', $username);
                $date = date('Y-m-d H:i:s'); // get the current date and time
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':id', $id);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success bg-success text-white'>Your order is updated.</div>";
                    $query_delete = "DELETE FROM order_detials WHERE order_id=:order_id";
                    $stmt_delete = $con->prepare($query_delete);
                    $stmt_delete->bindParam(':order_id', $id);
                    if ($stmt_delete->execute()) {

                        for ($count = 0; $count < count($product_id); $count++) {
                            try {
                                // insert query
                                $query_insert = "INSERT INTO order_detials SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                                // prepare query for execution
                                $stmt_insert = $con->prepare($query_insert);
                                // bind the parameters
                                $stmt_insert->bindParam(':order_id', $id);
                                $stmt_insert->bindParam(':product_id', $product_id[$count]);
                                $stmt_insert->bindParam(':quantity', $quantity[$count]);
                                //echo $product_id[$count];
                                // Execute the query
                                $record_number = $count + 1;
                                if ($stmt_insert->execute()) {
                                    header("Location: order_summary.php?action=update");
                                    echo "<div class='alert alert-success bg-success text-white'>Record was saved.</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                                }
                            }
                            // show errorproduct_id
                            catch (PDOException $exception) {
                                die('ERROR: ' . $exception->getMessage());
                            }
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
    try {
        // prepare select query
        $query = "SELECT * FROM order_summary WHERE id =:id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }


    ?>



    <!--we have our html form here where new record information can be updated-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
        <table id="delete_row" class='table table-hover table-responsive table-bordered'>

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
                    echo "<tr class='pRow'>  
                            <td class='col-3'>Product Name</td>
                            <td class='col-3'><select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"product_id[]\">
                            <option value=\"$id\">$name</option>";
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
                            <td class='col-3'><input type='number' name='quantity[]' value='$quantity' class='form-control' /></td>
                            <td><input type=\"button\" value=\"Delete\" class='btn btn-danger' onclick=\"deleteRow(this)\"></td>
                            </tr>";
                }
            }
            ?>
            <tr>
                <td colspan="2">
                    <input type="button" value="Add More Product" class="add_one" />

                </td>
                <td><a href='order_summary.php' class='btn btn-primary'>Back to Order Summary</a></td>
                <td>
                    <a href='product_read.php' class='btn btn-primary'>Back to read products</a>
                </td>
                <td>
                    <input type='submit' value='Save Changes' class='btn btn-success' onclick="checkDuplicate(event)" />
                </td>
            </tr>

        </table>
    </form>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
        function checkDuplicate(event) {
            var newarray = [];
            var selects = document.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                newarray.push(selects[i].value);
            }
            if (newarray.length !== new Set(newarray).size) {
                alert("There are duplicate item in the array");
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
            }
        }
    </script>
</div>
    <!-- end .container -->
</body>

</html>