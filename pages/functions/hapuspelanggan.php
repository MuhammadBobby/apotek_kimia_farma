<?php
require "functions.php";

$id = $_GET["id"];
$query = "DELETE FROM pelanggan WHERE id_pelanggan = '$id'";

if (mysqli_query($conn, $query) === TRUE) {
    header("location: ../pelanggan.php?hapus=true");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
