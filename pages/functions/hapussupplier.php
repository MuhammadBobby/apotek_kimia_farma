<?php
require "functions.php";

$id = $_GET["id"];
$query = "DELETE FROM supplier WHERE id_supplier = '$id'";

if (mysqli_query($conn, $query) === TRUE) {
    header("location: ../supplier.php?hapus=true");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
