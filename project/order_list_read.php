<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>

    <!-- container -->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="home.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_customer.php">create customer</a></li>
                            <li><a class="dropdown-item" href="customer_read.php">read customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Order
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="create_new_order.php">create order</a></li>
                            <li><a class="dropdown-item" href="order_list.php">order list</a></li>
                            <li><a class="dropdown-item" href="order_details.php">order details</a></li>
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
                        <a class="nav-link" href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </div>

        </nav>
        <div class="page-header">
            <h1>Read order</h1>
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
            $query = "SELECT id, username, date FROM order_summary WHERE id = :id ";
            $stmt = $con->prepare($query);

            // Bind the parameter
            $stmt->bindParam(":id", $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $id = $row['id'];
            $username = $row['username'];
            $date = $row['date'];
            // shorter way to do that is extract($row)
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>



        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($id, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?php echo htmlspecialchars($date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='order_summary.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>