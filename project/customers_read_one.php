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


</head>


<body>
    
    <div class="container">

        <nav class="navbar navbar-expand-lg bg-info">

            <a class="navbar-brand " href="index.php">Home</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href="log_out.php">Log Out</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- container -->
        <div class="container">
            <div class="page-header text-center">
                <h1>Customers Read One</h1>
            </div>

            <!-- PHP read one record will be here -->

            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            } else {
                die('ERROR: Record ID not found.');
            }

            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');


            //include database connection
            include 'config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM customers ORDER BY id DESC";
                $stmt = $con->prepare($query);

                // Bind the parameter
                $stmt->bindParam(":id", $id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $user = $row['user'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $gender = $row['gender'];
                $date_of_birth = $row['date_of_birth'];
                $register_date = $row['register_date'];
                $account_status = $row['account_status'];
                $image = $row['image'];

                // shorter way to do that is extract($row)
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
                    <td>User</td>
                    <td><?php echo htmlspecialchars($user, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>first_name</td>
                    <td><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>last_name</td>
                    <td><?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>gender</td>
                    <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Images</td>
                    <td><img src="uploads/<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>" /></td>
                </tr>
                <tr>
                    <td>date_of_birth</td>
                    <td><?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>register_date</td>
                    <td><?php echo htmlspecialchars($register_date, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>account_status</td>
                    <td><?php echo htmlspecialchars($account_status, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='customers_read.php' class='btn btn-danger'>Back to read Customers</a>
                        <?php echo "<a href='customers_delete.php?id={$id}' onclick=delete_customers([$id});' class='btn btn-danger'>Delete Customer</a>"; ?>
                    </td>
                </tr>
            </table>


        </div> <!-- end .container -->
        <script type='text/javascript'>
            // confirm record deletion
            function delete_customers(id) {

                if (confirm('Are you sure?')) {
                    // if user clicked ok,
                    // pass the id to delete.php and execute the delete query
                    window.location = 'customers_delete.php?id=' + id;
                }
            }
        </script>
    </div>
</body>

</html>