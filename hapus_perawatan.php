<?php

header("Content-Type: application/json");

include "koneksi.php";

$id = $_POST['id'] ?? '';

if ($id == '') {
    echo json_encode([
        "status" => false,
        "message" => "ID perawatan wajib diisi"
    ]);
    exit;
}

$sql = "DELETE FROM perawatan WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "Data perawatan berhasil dihapus"
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Data perawatan gagal dihapus"
    ]);
}

$stmt->close();
$conn->close();

?>