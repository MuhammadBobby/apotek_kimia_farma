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
$sql = "SELECT * FROM supplier WHERE id_supplier = '$id'";
$hasil = $conn->query($sql);


// memanggil apabila tombol submit di klik
if (isset($_POST["ubah"])) {
    $id = htmlspecialchars($_POST["id"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $nomor = htmlspecialchars($_POST["nomor"]);

    $query = "UPDATE supplier SET
        nama_supplier = '$nama',
        alamat = '$alamat',
        no_telepon = '$nomor'
    WHERE id_supplier = '$id'";

    if (mysqli_query($conn, $query) === TRUE) {
        header("location: ../supplier.php?ubah=true");
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
    <title>Update Data Supplier</title>
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
                <h4 class="font-weight-bolder text-5xl text-primary">Edit Data Supplier</h4>
                <p class="mb-0">Ubah data supplier dengan benar.</p>
            </div>

            <!-- alert -->
            <?php
            if (isset($_GET['gagal'])) : ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "ID Supplier Sudah Terdaftar!",
                        footer: "Silahkan Gunakan ID Supplier Lain!"
                    });
                </script>
            <?php endif; ?>



            <div class="card-body">
                <?php while ($apotek = $hasil->fetch_assoc()) : ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="id" class="text-lg">ID Supplier</label>
                            <input type="text" name="id" class="form-control form-control-lg" value="<?= $apotek['id_supplier'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="text-lg">Nama</label>
                            <input type="text" name="nama" class="form-control form-control-lg" value="<?= $apotek['nama_supplier'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="text-lg">Alamat</label>
                            <input type="text" name="alamat" class="form-control form-control-lg" value="<?= $apotek['alamat'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor" class="text-lg">Nomor Telepon</label>
                            <input type="text" name="nomor" class="form-control form-control-lg" value="<?= $apotek['no_telepon'] ?>" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="ubah" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Update Data</button>
                        </div>
                        <p class="text-sm mt-3 mb-0">Tidak ingin menambahkan data? <a href="../supplier.php" class="text-dark font-weight-bolder">kembali</a></p>
                    </form>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>