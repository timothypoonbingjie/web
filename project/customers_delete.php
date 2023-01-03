<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    $select = "SELECT user AS customername, image FROM customers where id=:id";
    $stmt = $con->prepare($select);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // delete query
    $check = "SELECT username FROM order_summary WHERE username=:username";
    $stmt = $con->prepare($check);
    $stmt->bindParam(":username", $customername);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
        echo "This customer has order so cannot be delete.";
    } else {
        $query = "DELETE FROM customers WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            if ($row['image'] != "nonprofile2.png") {
                unlink("uploads/" . $row['image']);
                
            }header('Location: customers_read.php?action=deleted');
    
            // redirect to read records page and
            // tell the user record was deleted
           
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
