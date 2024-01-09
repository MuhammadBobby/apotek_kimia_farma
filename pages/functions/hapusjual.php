<?php
require "functions.php";

$id = $_GET["id"];
$id_penjualan = $_GET["jual"];
$id_obat = $_GET["id_obat"];

// me refresh stok
$tambahstok = "SELECT * FROM detail_penjualan, obat WHERE id_detail_penjualan = '$id' and detail_penjualan.id_obat = obat.id_obat";
$hasilstok = $conn->query($tambahstok);
while ($aptstok = $hasilstok->fetch_assoc()) {
    $stokobat = $aptstok['stok'];
    $jumlahobat = $aptstok['jumlah'];
    $stokobat = $stokobat + $jumlahobat;
}
$updatestok = "UPDATE obat SET stok = '$stokobat' WHERE id_obat = '$id_obat'";
$conn->query($updatestok);

// mengurangi di penjualan
$queryharga = "SELECT * FROM penjualan WHERE id_penjualan = '$id_penjualan'";
$querydetail = "SELECT * FROM detail_penjualan WHERE id_detail_penjualan = '$id'";
$hasilharga = $conn->query($queryharga);
$aptdetail = query($querydetail)[0];

while ($aptharga = $hasilharga->fetch_assoc()) {
    $hargasekarang = $aptharga['total_bayar'];
    $hargahapus = $aptdetail['harga'];

    $harga = $hargasekarang - $hargahapus;
}
$updateharga = "UPDATE penjualan SET total_bayar = $harga WHERE id_penjualan = '$id_penjualan'";
$conn->query($updateharga);
//


$query = "DELETE FROM detail_penjualan WHERE id_detail_penjualan = '$id'";

if (mysqli_query($conn, $query) === TRUE) {
    header("location: ../penjualan.php?hapus=true");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
