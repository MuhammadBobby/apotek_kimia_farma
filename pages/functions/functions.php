<?php

// connect database
// $conn = mysqli_connect("localhost", "id21565230_dbbobby", "Darkwolf/30", "id21565230_dbbobby");
$conn = mysqli_connect("localhost", "root", "", "apotek");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}


// query (banyak untuk read)
function query($query)
{
    global $conn;
    $rows = [];
    // memilih table / query
    $result = mysqli_query($conn, $query);

    // fetch
    while ($apt = mysqli_fetch_assoc($result)) {
        $rows[] = $apt;
    }

    return $rows;
}
