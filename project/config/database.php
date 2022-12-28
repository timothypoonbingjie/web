
<?php
// used to connect to the database
$host = "localhost";
$db_name = "eshop";
$user_name = "eshop";
$pass_word = "123Asdw123";
$mysqli = new mysqli($host, $user_name, $pass_word, $db_name);

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $user_name, $pass_word);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}
// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>
