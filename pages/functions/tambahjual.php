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
    $idjual = $_POST['idjual'];
    $karyawan = $_SESSION["idkaryawan"];
    $pelanggan = $_POST['pelanggan'];
    $id_obat = $_POST['id_obat'];
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga_satuan'];
    $create_at = date('Y-m-d');



    $harga = array(); // Deklarasi array
    // menghitung harga
    for ($j = 0; $j < count($jumlah); $j++) {
        $harga[] = $jumlah[$j] * $harga_satuan[$j];
    }

    // input detail & update stok
    for ($i = 0; $i < count($id_obat); $i++) {

        $stok = "SELECT * FROM obat WHERE id_obat = '$id_obat[$i]'";
        $hasilstok = $conn->query($stok);
        while ($aptstok = $hasilstok->fetch_assoc()) {
            $stokobatnow = $aptstok['stok'];
            $stokobat = $stokobatnow - $jumlah[$i];
        }

        // cek jumlah harus lebih dari stok dan tidak boleh 0
        if ($stokobatnow >= $jumlah[$i]) {
            if ($jumlah[$i] > 0) {
                $query = "INSERT INTO detail_penjualan VALUES ('', '$idjual', '$id_obat[$i]', '$jumlah[$i]', $harga[$i])";
                $updatestok = "UPDATE obat SET stok = '$stokobat' WHERE id_obat = '$id_obat[$i]'";
                $conn->query($query);
                $conn->query($updatestok);
            }
        }
    }

    $total_bayar = 0;
    foreach ($harga as $nilai) {
        $total_bayar += $nilai;
    }
    $penjualan = "INSERT INTO penjualan VALUES ('$idjual', '$pelanggan', '$karyawan', '$total_bayar', '$create_at')";

    if ($conn->query($penjualan) === TRUE) {
        header("location: ../penjualan.php?tambah=true");
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
    <title>Tambah Transaksi Barang Keluar</title>
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
                <h4 class="font-weight-bolder text-5xl text-primary">Tambah Transaksi Barang Keluar</h4>
                <p class="mb-0">Masukkan transaksi barang Keluar dengan benar.</p>
            </div>


            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="idjual" class="text-lg">ID Transaksi</label>
                        <input type="text" name="idjual" class="form-control form-control-lg" placeholder="ID Penjualan" required>
                    </div>

                    <div class="mb-3">
                        <label for="pelanggan" class="text-lg">Pelanggan</label>
                        <select name="pelanggan" id="pelanggan" class="form-control form-control-lg" required>
                            <option selected>--Pilih Pelanggan--</option>

                            <?php
                            $querypel = "SELECT * FROM pelanggan";
                            $hasilpel = $conn->query($querypel);
                            while ($pel = $hasilpel->fetch_assoc()) :
                            ?>
                                <option value="<?= $pel['id_pelanggan'] ?>"><?= $pel['nama_pelanggan'] ?></option>
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
                                <?php
                                $queryobat = "SELECT * FROM obat";
                                $hasilobat = $conn->query($queryobat);
                                $nom = 1;
                                $apt = '';
                                while ($obat = $hasilobat->fetch_assoc()) :
                                    $apt .= '<tr><td width="5%">' . $nom++ . '</td>
                                    <td><input type="text" name="id_obat[]" value=' . $obat['id_obat'] . ' class="form-control" readonly></td>
                                    <td>' . $obat['nama_obat'] . '</td>
                                    <td><input type="number" min="0" name="jumlah[]" class="form-control" value="0" required></td>
                                    <td><input type="number" name="harga_satuan[]" class="form-control" value=' . $obat['harga'] . ' readonly></td>
                                    </tr>';
                                endwhile;

                                echo $apt;
                                ?>
                            </tbody>
                        </table>
                    </div>


                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Tambahkan Data</button>
                    </div>
                    <p class="text-sm mt-3 mb-0">Tidak ingin menambahkan data? <a href="../penjualan.php" class="text-dark font-weight-bolder">kembali</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- <script>
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
    </script> -->
</body>

</html>