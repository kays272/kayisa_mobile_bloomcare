<?php

header("Content-Type: application/json");

include "koneksi.php";

$nama_bunga = $_POST['nama_bunga'] ?? '';
$jenis_bunga = $_POST['jenis_bunga'] ?? '';
$warna = $_POST['warna'] ?? '';
$lokasi = $_POST['lokasi'] ?? '';
$kondisi = $_POST['kondisi'] ?? '';
$catatan = $_POST['catatan'] ?? '';

$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';

$tanggal_tanam = date("Y-m-d");

if (
    $nama_bunga == '' ||
    $jenis_bunga == '' ||
    $warna == '' ||
    $kondisi == ''
) {
    echo json_encode([
        "status" => false,
        "message" => "Data wajib diisi"
    ]);
    exit;
}

$sql = "INSERT INTO bunga
        (nama_bunga, jenis_bunga, warna, tanggal_tanam, lokasi, kondisi, catatan, latitude, longitude)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => false,
        "message" => "Prepare gagal: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "sssssssss",
    $nama_bunga,
    $jenis_bunga,
    $warna,
    $tanggal_tanam,
    $lokasi,
    $kondisi,
    $catatan,
    $latitude,
    $longitude
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "Data bunga berhasil ditambahkan",
        "id" => $stmt->insert_id,
        "latitude" => $latitude,
        "longitude" => $longitude
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Data bunga gagal ditambahkan",
        "error" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();

?>