<?php
session_start();
require "pages/functions/functions.php";

// pemeriksaan cookie
if (isset($_COOKIE["xx"]) || isset($_COOKIE["yy"])) {
  $id = $_COOKIE["xx"];
  $username = $_COOKIE["yy"];

  $result = mysqli_query($conn, "SELECT kode_unik FROM karyawan WHERE id_karyawan = '$id'");
  $row = mysqli_fetch_assoc($result);

  if ($username === hash("sha256", $row["kode_unik"])) {
    // $_SESSION["login"] = true;
  }
}

// pemeriksaan session login
if (isset($_SESSION["login"])) {
  header("Location: pages/dashboard.php");
  exit;
}


// ketika di klik login
if (isset($_POST["login"])) {
  $id = $_POST["username"];
  $password = $_POST["password"];
  // query data toko berdasarka id
  $apotek = query("SELECT * FROM karyawan WHERE id_karyawan = '$id'")[0];

  // pengecekan apakah admin atau owner
  if ($apotek['status'] === "karyawan") {
    header("location: ?gagal=true");
    exit;
  }


  // pengecekan username dan password
  if ($apotek['id_karyawan'] == $id) {
    // cek password
    if (password_verify($password, $apotek["kode_unik"])) {

      // session
      $_SESSION["login"] = true;
      $_SESSION["idkaryawan"] = $id;

      // cek cookie
      if (isset($_POST["rememberMe"])) {
        // id
        setcookie("xx", $apotek["id_karyawan"], time() + 60 * 60);
        // // username
        setcookie("yy", hash("sha256", $apotek["kode_unik"]), time() + 60 * 60);
      }

      header("Location: pages/dashboard.php");
      exit;
    }
  }
  header("Location: ?salah=true");
  exit;
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" />
  <title>Sign In</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="">
  <!-- alert -->
  <?php
  if (isset($_GET['gagal'])) : ?>
    <script>
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Anda Bukan owner / Admin!",
        footer: "Anda tidak diizinkan untuk masuk!"
      });
    </script>
  <?php endif; ?>

  <?php
  if (isset($_GET['salah'])) : ?>
    <script>
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Username atau Password Anda Salah!",
        footer: "Masukkan username dan password yang benar!"
      });
    </script>
  <?php endif; ?>

  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <p class="navbar-brand font-weight-bolder ms-lg-0 ms-3 d-flex m-auto">Dashboard Apotek Kimia Farma</p>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link me-2" href="https://www.kimiafarma.co.id/" target="_blank">
                    <i class="fa fa-user opacity-6 text-dark me-1"></i>
                    Apotek
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="https://www.instagram.com/muhammad_bobby_o/" target="_blank">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Instagram
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="https://github.com/MuhammadBobby/MuhammadBobby.github.io" target="_blank">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Github
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Masukkan username dan password admin anda.</p>
                </div>
                <div class="card-body">
                  <form action="" method="post">
                    <div class="mb-3">
                      <label for="username" class="text-lg">Username</label>
                      <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" required autocomplete="off" />
                      <p class="text-sm font-weight-light">*Username berdasarkan ID Karyawan</p>
                    </div>
                    <div class="mb-3">
                      <label for="password" class="text-lg">Password</label>
                      <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password" required autocomplete="off" />
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe" checked />
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="login" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="text-sm text-danger text-start font-weight-light">username dan password admin hanya dipegang oleh Owner dan admin.</p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('assets/img/apotek-1.jpg'); background-size: cover">
                <span class="mask bg-gradient-primary bg-opacity-50"></span>
                <h4 class="mt-5 text-warning font-weight-bolder position-relative">Apotek Kimia Farma</h4>
                <p class="text-white position-relative">"Semua usaha berawal dari usaha yang kita lakukan dengan skala kecil namun bermimpi besar." <br /><span class="text-bold">~ Muhammad Bobby</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <!-- <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script> -->
  <!-- Github buttons -->
  <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <!-- <script src="assets/js/argon-dashboard.min.js?v=2.0.4"></script> -->
</body>

</html>