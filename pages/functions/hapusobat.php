<?php
require "functions.php";

$id = $_GET["id"];
$query = "DELETE FROM obat WHERE id_obat = '$id'";

if (mysqli_query($conn, $query) === TRUE) {
    header("location: ../obat.php?hapus=true");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
