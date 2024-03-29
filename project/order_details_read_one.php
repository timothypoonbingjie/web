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
    <!-- container -->
    <?php
    include 'topnav.php'
    ?><div class="container-fluid image" style="background-image:url('image/brightbg.jpg')">
    <div class="page-header">
        <h1>Read Order Details</h1>
    </div>

    <!-- PHP read one record will be here -->

    <?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    if (isset($_GET['id'])) {
        $details_id = $_GET['id'];
    } else {
        die('ERROR: Record ID not found.');
    }
    //include database connection
    include 'config/database.php';

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT * FROM order_detials INNER JOIN products ON order_detials.product_id = products.id WHERE details_id = :details_id";
        $stmt = $con->prepare($query);

        // Bind the parameter
        $stmt->bindParam(":details_id", $details_id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // values to fill up our form
        extract($row);
    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
    ?>



    <!-- HTML read one record table will be here -->
    <!--we have our html table here where the record will be displayed-->
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Order ID</td>
            <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Product Name</td>
            <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Per/ Price</td>
            <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Total Price</td>
            <td><?php echo $price * $quantity;  ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href='order_detials.php' class='btn btn-danger'>Back to read Order Details</a>
            </td>
        </tr>
    </table>


    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    </div>
</body>

</html>