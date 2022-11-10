<?php
include 'check.php'
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>
    <div>
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
                $query = "SELECT id, user, first_name, last_name, gender, date_of_birth, register_date, account_status FROM customers ORDER BY id DESC";
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
                    </td>
                </tr>
            </table>


        </div> <!-- end .container -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
    </div>
</body>

</html>