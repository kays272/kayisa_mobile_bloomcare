<?php

header("Content-Type: application/json");

include "koneksi.php";

$id = $_POST['id'] ?? '';

if ($id == '') {
    echo json_encode([
        "status" => false,
        "message" => "ID bunga wajib diisi"
    ]);
    exit;
}

$sql = "DELETE FROM bunga WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "Data bunga berhasil dihapus"
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Data bunga gagal dihapus"
    ]);
}

$stmt->close();
$conn->close();

?>