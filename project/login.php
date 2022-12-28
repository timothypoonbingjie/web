<?php
session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="css/login.css" rel="stylesheet">


</head>

<body>

    <!-- container -->
    <div class="container-fluid image">

        <div class="page-header d-flex justify-content-center my-3">
            <h1>Login Page</h1>
        </div>

        <?php
        include 'config/database.php';

        if (isset($_POST['user']) && isset($_POST['passwords'])) {

            $user = ($_POST['user']);
            $passwords = md5($_POST['passwords']);
            $select = "SELECT user, passwords, account_status FROM customers WHERE user = '$user'";
            $result = mysqli_query($mysqli, $select);
            $row = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result) == 1) {
                if ($row['passwords'] != $passwords) {
                    echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Your password is incorrect.</div>";
                } elseif ($row['account_status'] != "opened") {
                    echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Your account is closed.</div>";
                } else {
                    header("Location: index.php");
                    $_SESSION["Pass"] = "Pass";
                }
            } else {
                echo "<div class='alert alert-danger w-25 d-flex justify-content-center align-self-center ms-auto me-auto'>Please enter your username and password.</div>";
            }
        };

        if ($_GET) {
            echo "Please make sure you have access";
        }


        ?>

        <div class="container d-flex justify-content-center mt-5">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered '>
                    <div class="form-floating  ">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="user">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating ">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="passwords" name="passwords">
                        <label for="floatingPassword">Passwords</label>
                    </div>

                    <div class="checkbox mb-3">

                    </div>
                    <div><button class="w-50 btn btn-lg btn-primary d-flex justify-content-center align-self-center ms-auto me-auto" type="submit">Login</button>
                        <a href='create_customers.php' class='mt-3 btn btn-primary d-flex justify-content-center align-self-center ms-auto me-auto'>Register now</a>
                    </div>
                </table>

            </form>
        </div>
    </div>
</body>
    
</html>