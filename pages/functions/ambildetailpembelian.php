<?php
require "functions.php";

$kode = $_GET['supplierId'];

$sql = "SELECT * FROM obat WHERE id_supplier='$kode'";
$hasil = $conn->query($sql);
$nom = 1;
echo '<tr><td colspan = "5" class="text-center text-warning text-bold bg-dark">Pilih Barang yang dibeli.</td>
    </tr>';
while ($row = $hasil->fetch_assoc()) {
  $apt .= '<tr><td width="5%">' . $nom++ . '</td>
  <td><input type="text" name="id_obat[]" value=' . $row['id_obat'] . ' class="form-control" readonly></td>
        <td>' . $row['nama_obat'] . '</td>
        <td><input type="number" min="0" name="jumlah[]" class="form-control" value="0" required></td>
        <td><input type="number" name="harga_satuan[]" class="form-control" value=' . $row['harga'] . ' readonly></td>
      </tr>';
}
echo $apt;
$conn->close();
