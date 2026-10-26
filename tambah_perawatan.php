<?php

header("Content-Type: application/json");

include "koneksi.php";

$bunga_id = $_POST['bunga_id'] ?? '';
$jenis_perawatan = $_POST['jenis_perawatan'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$kondisi = $_POST['kondisi'] ?? '';
$catatan = $_POST['catatan'] ?? '';

if (
    $bunga_id == '' ||
    $jenis_perawatan == '' ||
    $tanggal == '' ||
    $kondisi == ''
) {
    echo json_encode([
        "status" => false,
        "message" => "Data perawatan wajib diisi"
    ]);
    exit;
}

$sql = "INSERT INTO perawatan
        (bunga_id, jenis_perawatan, tanggal, kondisi, catatan)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => false,
        "message" => "Prepare gagal: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "issss",
    $bunga_id,
    $jenis_perawatan,
    $tanggal,
    $kondisi,
    $catatan
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "Data perawatan berhasil ditambahkan",
        "id" => $stmt->insert_id
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Data perawatan gagal ditambahkan",
        "error" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();

?>