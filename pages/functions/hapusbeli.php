<?php
require "functions.php";

$id = $_GET["id"];
$no_faktur = $_GET["beli"];
$id_obat = $_GET["id_obat"];

$tambahstok = "SELECT * FROM detail_pembelian, obat WHERE id_detail_pembelian = '$id' and detail_pembelian.id_obat = obat.id_obat";
$hasilstok = $conn->query($tambahstok);
while ($aptstok = $hasilstok->fetch_assoc()) {
    $stokobat = $aptstok['stok'];
    $jumlahobat = $aptstok['jumlah'];
    $stokobat = $stokobat - $jumlahobat;
}
$updatestok = "UPDATE obat SET stok = '$stokobat' WHERE id_obat = '$id_obat'";
$conn->query($updatestok);

// mengurangi di pembelian
$queryharga = "SELECT * FROM pembelian WHERE no_faktur = '$no_faktur'";
$querydetail = "SELECT * FROM detail_pembelian WHERE id_detail_pembelian = '$id'";
$hasilharga = $conn->query($queryharga);
$aptdetail = query($querydetail)[0];

while ($aptharga = $hasilharga->fetch_assoc()) {
    $hargasekarang = $aptharga['total_bayar'];
    $hargahapus = $aptdetail['harga'];

    $harga = $hargasekarang - $hargahapus;
}
$updateharga = "UPDATE pembelian SET total_bayar = $harga WHERE no_faktur = '$no_faktur'";
$conn->query($updateharga);
//



$query = "DELETE FROM detail_pembelian WHERE id_detail_pembelian = '$id'";

if (mysqli_query($conn, $query) === TRUE) {
    header("location: ../pembelian.php?hapus=true");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
