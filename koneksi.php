<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "bloomcare";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

<<<<<<< HEAD
$conn->set_charset("utf8mb4");
=======
$conn->set_charset("utf8");
>>>>>>> 4706cf2fab44859e69484ed7cde24a5f6e9f3d4a

?>