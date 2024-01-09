<?php

session_start();
$_SESSION["login"] = [];
$_SESSION["idkaryawan"] = [];
session_unset();
session_destroy();

// menghapus cookie
setcookie("xx", "", time() - 300);
setcookie("yy", "", time() - 300);


header("Location: ../index.php");
exit;
