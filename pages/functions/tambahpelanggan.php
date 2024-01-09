<?php
require "functions.php";
session_start();

// pemeriksaan session login
if (!isset($_SESSION["login"])) {
    header("Location: ../../index.php");
    exit;
}

// memanggil apabila tombol submit di klik
if (isset($_POST["submit"])) {
    $id = htmlspecialchars($_POST["id"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $jenkel = htmlspecialchars($_POST["jenkel"]);
    $pekerjaan = htmlspecialchars($_POST["pekerjaan"]);
    $usia = htmlspecialchars($_POST["usia"]);

    // pengecekan username apakah ada di database
    $result = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE id_pelanggan='$id'");

    if (mysqli_fetch_assoc($result)) {
        header("location: ?gagal=true");
        exit;
    }

    $query = "INSERT INTO pelanggan VALUES ('$id', '$nama', '$alamat', '$jenkel', '$pekerjaan', $usia)";

    if ($conn->query($query) === TRUE) {
        header("location: ../pelanggan.php?tambah=true");
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
    <title>Tambah Data Pelanggan</title>
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
                <h4 class="font-weight-bolder text-5xl text-primary">Tambah Data Pelanggan</h4>
                <p class="mb-0">Masukkan data pelanggan dengan benar.</p>
            </div>

            <!-- alert -->
            <?php
            if (isset($_GET['gagal'])) : ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "ID Pelanggan Sudah Terdaftar!",
                        footer: "Silahkan Gunakan ID Pelanggan Lain!"
                    });
                </script>
            <?php endif; ?>


            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="id" class="text-lg">ID Pelanggan</label>
                        <input type="text" name="id" class="form-control form-control-lg" placeholder="ID Pelanggan" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="text-lg">Nama</label>
                        <input type="text" name="nama" class="form-control form-control-lg" placeholder="Nama Pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="text-lg">Alamat</label>
                        <input type="text" name="alamat" class="form-control form-control-lg" placeholder="Alamat Pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenkel" class="text-lg">Jenis Kelamin</label>
                        <select name="jenkel" id="jenkel" class="form-control form-control-lg" required>
                            <option selected>--Jenis Kelamin--</option>
                            <option value="lk">Laki-Laki</option>
                            <option value="pr">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan" class="text-lg">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control form-control-lg" placeholder="Pekerjaan Pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="usia" class="text-lg">Usia</label>
                        <input type="number" min="0" name="usia" class="form-control form-control-lg" placeholder="Usia Pelanggan" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Tambahkan Data</button>
                    </div>
                    <p class="text-sm mt-3 mb-0">Tidak ingin menambahkan data? <a href="../pelanggan.php" class="text-dark font-weight-bolder">kembali</a></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>