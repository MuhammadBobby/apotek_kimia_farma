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
$sql = "SELECT * FROM obat, supplier WHERE obat.id_obat = '$id' AND obat.id_supplier = supplier.id_supplier";
$hasil = $conn->query($sql);


// memanggil apabila tombol submit di klik
if (isset($_POST["ubah"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $jenis = htmlspecialchars($_POST["jenis"]);
    $harga = htmlspecialchars($_POST["harga"]);
    $stok = htmlspecialchars($_POST["stok"]);
    $supplier = htmlspecialchars($_POST["supplier"]);

    $query = "UPDATE obat SET
        nama_obat = '$nama',
        jenis = '$jenis',
        harga = $harga,
        stok = $stok,
        id_supplier = '$supplier'
    WHERE id_obat = '$id'";

    if (mysqli_query($conn, $query) === TRUE) {
        header("location: ../obat.php?ubah=true");
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
    <title>Update Data Obat</title>
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
                <h4 class="font-weight-bolder text-5xl text-primary">Edit Data Obat</h4>
                <p class="mb-0">Ubah data obat dengan benar.</p>
            </div>


            <div class="card-body">
                <?php while ($apotek = $hasil->fetch_assoc()) : ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <input type="hidden" name="nama" class="form-control form-control-lg" value="<?= $apotek['id_obat'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="text-lg">Nama</label>
                            <input type="text" name="nama" class="form-control form-control-lg" value="<?= $apotek['nama_obat'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="text-lg">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control form-control-lg" required>
                                <option selected value="<?= $apotek['jenis'] ?>"><?= $apotek['jenis'] ?></option>
                                <option value="tablet">Tablet</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="cair">Cair</option>
                                <option value="oles">Oles</option>
                                <option value="tetes">Tetes</option>
                                <option value="alat">Peralatan Medis</option>
                                <option value="lain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="text-lg">Harga</label>
                            <input type="number" min="0" name="harga" class="form-control form-control-lg" value="<?= $apotek['harga'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="text-lg">Stok</label>
                            <input type="number" min="0" name="stok" class="form-control form-control-lg" value="<?= $apotek['stok'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier" class="text-lg">Supplier</label>
                            <select name="supplier" id="supplier" class="form-control form-control-lg">
                                <option selected value="<?= $apotek['id_supplier'] ?>"><?= $apotek['nama_supplier'] ?></option>

                                <?php

                                $querysup = "SELECT * FROM supplier";
                                $hasil = $conn->query($querysup);
                                while ($apt = $hasil->fetch_assoc()) :
                                ?>
                                    <option value="<?= $apt['id_supplier'] ?>"><?= $apt['nama_supplier'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="ubah" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Ubah Data</button>
                        </div>
                        <p class="text-sm mt-3 mb-0">Tidak ingin menambahkan data? <a href="../obat.php" class="text-dark font-weight-bolder">kembali</a></p>
                    </form>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>