<?php
require "functions.php";

$id = $_GET["id"];
$query = "DELETE FROM karyawan WHERE id_karyawan = '$id'";

if (mysqli_query($conn, $query) === TRUE) {
    header("location: ../karyawan.php?hapus=true");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
