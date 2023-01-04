<?php
include 'check.php'
?>
<!DOCTYPE html>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet" />


</head>

<body>
    <div class="container-fluid image" style="background-image:url('image/bg.jpg')">
        <?php
        include 'topnav.php'
        ?>

        <div class="container-fluid row m-0 y d-flex justify-content-between align-items-center">

            <div class="col-5">
                <?php
                include 'config/database.php';

                $query = "SELECT * FROM customers";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $customer = $stmt->rowCount();

                $query = "SELECT * FROM products";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $products = $stmt->rowCount();

                $query = "SELECT * FROM order_summary";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $order = $stmt->rowCount();

                echo "<h1 class=\"text-white bg-dark text-center\">Summary</h1>";
                echo "<table class='table table-dark table-hover table-bordered text-center'>";
                echo "<tr class='table-light'>";
                echo "<th>Total Number of Customer</th>";
                echo "<th>Total Number of Products</th>";
                echo "<th>Total Number of Order</th>";
                echo "</tr>";
                echo "<tr class='table-success'>";
                echo "<td>$customer</td>";
                echo "<td>$products</td>";
                echo "<td>$order</td>";
                echo "</tr>";
                echo "</table>";
                ?>
            </div>

            <div class="col-5">
                <?php
                include 'config/database.php';

                $query = "SELECT MAX(id) as id FROM order_summary";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $row['id'];

                isset($id);
                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT order_summary.id as summaryid, username, first_name, last_name, date FROM order_summary INNER JOIN customers ON customers.user = order_summary.username  WHERE order_summary.id = ?";
                    $stmt = $con->prepare($query);


                    // Bind the parameter
                    $stmt->bindParam(1, $id);


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
                <h1 class="text-center text-white bg-dark">Latest Order</h1>
                <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                    <tr class="table table-light">
                        <th>User ID</th>
                        <th>Order Date</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                    </tr>
                    <tr class='table-success'>
                        <td><a href="order_list_read.php?id=<?php echo urlencode($summaryid); ?>"><?php echo htmlspecialchars($summaryid, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($date, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?></td>
                        <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                    </tr>
                </table>
            </div>

            <div class="container my-3">
                <div class="my-3">
                    <?php
                    $query = "SELECT order_summary.id as newid, sum(price*quantity) AS HIGHEST FROM order_summary INNER JOIN order_detials ON order_detials.order_id = order_summary.id INNER JOIN products ON products.id = order_detials.product_id GROUP BY order_summary.id ORDER BY HIGHEST DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);

                    ?>
                    <h1 class="text-center text-white bg-dark">Highest Purchased Amount Order</h1>
                    <table class='table table-success table-hover table-responsive table-bordered text-center'>
                        <tr class='table-light'>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Username</th>
                            <th>Highest Amount</th>
                        </tr>
                        <tr class='table-success'>
                            <td><a href="order_list_read.php?id=<?php echo urlencode($newid); ?>"><?php echo htmlspecialchars($newid, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($date, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                            <td><?php $amount = htmlspecialchars(round($HIGHEST), ENT_QUOTES);
                                echo "RM $HIGHEST";
                                ?></td>
                        </tr>
                    </table>
                </div>

                <div class="my-3">
                    <?php
                    $query = "SELECT id, name, sum(quantity) AS popular FROM products INNER JOIN order_detials ON order_detials.product_id = products.id group by name order by sum(quantity) desc limit 5;";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h1 class=\"text-white bg-dark text-center\">Top 5 Selling Product</h1>";
                        echo "<table class='table table-success table-hover table-responsive table-bordered text-center'>";
                        echo "<tr class='table-light'>
                        <th>Id</th>
                        <th>Product Name</th>
                 <th>Quantity</th></tr>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr class='table-success'>";
                            echo "<td>";
                            echo "<a href='product_read_one.php?id=" . urlencode($id) . "'>{$id}</a>";
                            echo "</td>";
                            echo "<td>{$name}</td>";
                            echo "<td>{$popular}</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } ?>
                </div>

                <div class="my-3">
                    <?php
                    $nobuyitem = "SELECT * FROM products left JOIN order_detials ON order_detials.product_id = products.id WHERE product_id is NULL limit 3";
                    $stmt = $con->prepare($nobuyitem);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        echo "<h1 class=\"text-white bg-dark text-center\">TOP 3 Product that no perchase</h1>";
                        echo "<table class='table table-dark table-hover table-responsive table-bordered text-center'>";
                        echo "<tr class='table-light'>
                            <th>Product Name</th>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr class='table-success'>";
                            echo "<td>{$name}</td>";
                            echo "</tr>";
                        }
                        echo "
                    </table>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</body>

</html>