<?php

header("Content-Type: application/json");

include "koneksi.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username == '' || $password == '') {
    echo json_encode([
        "status" => false,
        "message" => "Username dan password wajib diisi"
    ]);
    exit;
}

$sql = "SELECT id, username, nama
        FROM users
        WHERE username = ?
        AND password = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ss",
    $username,
    $password
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    echo json_encode([
        "status" => true,
        "message" => "Login berhasil",
        "data" => $user
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Username atau password salah"
    ]);
}

$stmt->close();
$conn->close();

?>