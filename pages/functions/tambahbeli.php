<?php
require "functions.php";
session_start();

// pemeriksaan session login
if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit;
}


// memanggil apabila tombol submit di klik
if (isset($_POST["submit"])) {
    $nofaktur = $_POST['nofaktur'];
    $tanggal = $_POST['tanggal'];
    $karyawan = $_SESSION['idkaryawan'];
    $supplier = $_POST['supplier'];
    $id_obat = $_POST['id_obat'];
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga_satuan'];



    $harga = array(); // Deklarasi array
    // menghitung harga
    for ($j = 0; $j < count($jumlah); $j++) {
        $harga[] = $jumlah[$j] * $harga_satuan[$j];
    }

    $jumlah_obat = count($id_obat);
    // input detail & update stok
    for ($i = 0; $i < $jumlah_obat; $i++) {


        $stok = "SELECT * FROM obat WHERE id_obat = '$id_obat[$i]'";
        $hasilstok = $conn->query($stok);
        while ($aptstok = $hasilstok->fetch_assoc()) {
            $stokobat = $aptstok['stok'];
            $stokobat = $stokobat + $jumlah[$i];
        }

        // hanya memasukkan jumlah yang lebih dari 0
        if ($jumlah[$i] > 0) {
            $query = "INSERT INTO detail_pembelian VALUES ('', '$nofaktur', '$id_obat[$i]', '$jumlah[$i]', $harga[$i])";
            $updatestok = "UPDATE obat SET stok = '$stokobat' WHERE id_obat = '$id_obat[$i]'";
            $conn->query($query);
            $conn->query($updatestok);
        }
    }

    $total_bayar = 0;
    foreach ($harga as $nilai) {
        $total_bayar += $nilai;
    }
    $pembelian = "INSERT INTO pembelian VALUES ('$nofaktur', '$tanggal', '$karyawan', '$supplier', '$total_bayar')";

    if ($conn->query($pembelian) === TRUE) {
        header("location: ../pembelian.php?tambah=true");
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
    <title>Tambah Transaksi Barang Masuk</title>
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
                <h4 class="font-weight-bolder text-5xl text-primary">Tambah Transaksi Barang Masuk</h4>
                <p class="mb-0">Masukkan transaksi barang masuk dengan benar.</p>
            </div>


            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nofaktur" class="text-lg">Nomor Faktur</label>
                        <input type="text" name="nofaktur" class="form-control form-control-lg" placeholder="ID Pembelian" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="text-lg">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control form-control-lg" placeholder="Tanggal Pembelian" required>
                    </div>

                    <div class="mb-3">
                        <label for="supplier" class="text-lg">Supplier</label>
                        <select name="supplier" id="supplier" class="form-control form-control-lg" required>
                            <option selected>--Pilih Supplier--</option>

                            <?php
                            $querysup = "SELECT * FROM supplier";
                            $hasilsup = $conn->query($querysup);
                            while ($sup = $hasilsup->fetch_assoc()) :
                            ?>
                                <option value="<?= $sup['id_supplier'] ?>"><?= $sup['nama_supplier'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>ID Obat</th>
                                    <th width="20%">Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody id="showdata">

                            </tbody>
                        </table>
                    </div>


                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Tambahkan Data</button>
                    </div>
                    <p class="text-sm mt-3 mb-0">Tidak ingin menambahkan data? <a href="../pembelian.php" class="text-dark font-weight-bolder">kembali</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#supplier").change(function() {
                var supplierId = $(this).val();

                if (supplierId != "") {
                    $.ajax({
                        type: "get",
                        url: "ambildetailpembelian.php",
                        data: {
                            supplierId: supplierId
                        },
                        cache: false,
                        success: function(response) {
                            $('#showdata').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>