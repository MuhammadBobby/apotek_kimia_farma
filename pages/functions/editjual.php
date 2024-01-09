<?php
require "functions.php";
session_start();

// pemeriksaan session login
if (!isset($_SESSION["login"])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_GET["id"];
// query data toko berdasarka id
$sql = "SELECT *, detail_penjualan.harga as hrg FROM penjualan, detail_penjualan, karyawan, obat, pelanggan WHERE detail_penjualan.id_detail_penjualan = '$id' AND detail_penjualan.id_penjualan = penjualan.id_penjualan AND detail_penjualan.id_obat = obat.id_obat AND
penjualan.id_karyawan = karyawan.id_karyawan AND
penjualan.id_pelanggan = pelanggan.id_pelanggan";
$hasil = $conn->query($sql);


// memanggil apabila tombol submit di klik
if (isset($_POST["ubah"])) {
    $idjual = $_POST['idjual'];
    $karyawan = $_POST['karyawan'];
    $pelanggan = $_POST['pelanggan'];
    $id_obat = $_POST['obat'];
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga'];

    $harga = $jumlah * $harga_satuan;
    $jumlahsebelum = $_POST['jumlahsebelum'];
    $hargasebelum = $_POST['hargasebelum'];

    $query = "UPDATE detail_penjualan SET
        id_obat = '$id_obat',
        jumlah = $jumlah,
        harga = $harga
    WHERE id_detail_penjualan = $id";

    // update stok obat
    $querystok = "SELECT * FROM obat WHERE id_obat = '$id_obat'";
    $hasilstok = $conn->query($querystok);
    while ($aptstok = $hasilstok->fetch_assoc()) {
        $stokobat = $aptstok['stok'];
        if ($jumlah < $jumlahsebelum) {
            $selisih = $jumlahsebelum - $jumlah;
            $stokobat = $stokobat + $selisih;
        } else if ($jumlah > $jumlahsebelum) {
            $selisih = $jumlah - $jumlahsebelum;
            if ($stokobat < $selisih) {
                header("location: ../penjualan.php?gagal=true");
                exit;
            }
            $stokobat = $stokobat - $selisih;
        }
    }
    $updatestok = "UPDATE obat SET stok = '$stokobat' WHERE id_obat = '$id_obat' ";
    $conn->query($updatestok);
    // 

    // update jumlah bayar penjualan
    $queryharga = "SELECT * FROM penjualan WHERE id_penjualan = '$idjual'";
    $hasilharga = $conn->query($queryharga);
    while ($aptharga = $hasilharga->fetch_assoc()) {
        $hargasekarang = $aptharga['total_bayar'];
        if ($harga > $hargasebelum) {
            $selisih = $harga - $hargasebelum;
            $hargasekarang = $hargasekarang + $selisih;
        } else if ($harga < $hargasebelum) {
            $selisih = $hargasebelum - $harga;
            $hargasekarang = $hargasekarang - $selisih;
        }
    }
    $updateharga = "UPDATE penjualan SET total_bayar = $hargasekarang WHERE id_penjualan = '$idjual'";
    $conn->query($updateharga);
    //

    if (mysqli_query($conn, $query) === TRUE) {
        header("location: ../penjualan.php?ubah=true");
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaksi Barang Keluar</title>
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png" />

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-primary">
    <div class="container  bg-white  rounded-3 my-7 m-auto w-60">
        <div class="card card-plain">
            <div class="card-header pb-0 text-start">
                <h4 class="font-weight-bolder text-5xl text-primary">Edit Transaksi Barang Keluar</h4>
                <p class="mb-0">Ubah transaksi barang keluar dengan benar.</p>
            </div>


            <div class="card-body">
                <?php while ($apotek = $hasil->fetch_assoc()) : ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="idjual" class="text-lg">ID Transaksi</label>
                            <input type="text" name="idjual" class="form-control form-control-lg" value="<?= $apotek['id_penjualan'] ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="karyawan" class="text-lg">Karyawan</label>
                            <select name="karyawan" id="karyawan" class="form-control form-control-lg" readonly>
                                <option selected value="<?= $apotek['id_karyawan'] ?>"><?= $apotek['nama_karyawan'] ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pelanggan" class="text-lg">Pelanggan</label>
                            <select name="pelanggan" id="pelanggan" class="form-control form-control-lg" readonly>
                                <option selected value="<?= $apotek['id_pelanggan'] ?>"><?= $apotek['nama_pelanggan'] ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="obat" class="text-lg">Obat</label>
                            <select name="obat" id="obat" class="form-control form-control-lg" required>
                                <option selected value="<?= $apotek['id_obat'] ?>"><?= $apotek['nama_obat'] ?></option>

                                <?php
                                $queryobt = "SELECT * FROM obat";
                                $hasilobt = $conn->query($queryobt);
                                while ($obt = $hasilobt->fetch_assoc()) :
                                ?>
                                    <option value="<?= $obt['id_obat'] ?>"><?= $obt['nama_obat'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <input type="hidden" name="jumlahsebelum" class="form-control form-control-lg" value="<?= $apotek['jumlah'] ?>">

                        <div class="mb-3">
                            <label for="jumlah" class="text-lg">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control form-control-lg" value="<?= $apotek['jumlah'] ?>" required>
                        </div>

                        <input type="hidden" name="hargasebelum" class="form-control form-control-lg" value="<?= $apotek['hrg'] ?>">

                        <div class="mb-3">
                            <label for="harga" class="text-lg">Harga Satuan</label>
                            <input type="number" name="harga" class="form-control form-control-lg" value="<?= $apotek['harga'] ?>" readonly>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="ubah" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update Data</button>
                        </div>

                        <p class="text-sm mt-3 mb-0">Tidak ingin menambahkan data? <a href="../penjualan.php" class="text-dark font-weight-bolder">kembali</a></p>
                    </form>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>