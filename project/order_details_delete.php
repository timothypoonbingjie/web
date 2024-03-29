<?php
// include database connection
include 'config/database.php';
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// get record ID
// isset() is a PHP function used to verify if a value is there or not
$select = "SELECT order_id AS orderid FROM order_detials WHERE details_id =:details_id";
$stmt = $con->prepare($select);
$stmt->bindParam(":details_id", $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
extract($row);

try {
    $check = "SELECT * FROM order_detials WHERE order_id=:order_id";
    $stmt = $con->prepare($check);
    $stmt->bindParam(":order_id", $orderid);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 1) {
        $query = "DELETE FROM order_detials WHERE details_id =:details_id;DELETE FROM order_summary WHERE id =:id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":details_id", $id);
        $stmt->bindParam(":id", $orderid);
        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: order_detials.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    } else {
        $query = "DELETE FROM order_detials WHERE details_id =:details_id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":details_id", $id);

        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: order_detials.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
    // delete query