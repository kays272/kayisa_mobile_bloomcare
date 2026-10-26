<?php

header("Content-Type: application/json");

include "koneksi.php";

$id = $_POST['id'] ?? '';
$nama_bunga = $_POST['nama_bunga'] ?? '';
$jenis_bunga = $_POST['jenis_bunga'] ?? '';
$warna = $_POST['warna'] ?? '';
$tanggal_tanam = $_POST['tanggal_tanam'] ?? '';
$lokasi = $_POST['lokasi'] ?? '';
$kondisi = $_POST['kondisi'] ?? '';
$catatan = $_POST['catatan'] ?? '';

if (
    $id == '' ||
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

$sql = "UPDATE bunga SET
        nama_bunga = ?,
        jenis_bunga = ?,
        warna = ?,
        tanggal_tanam = ?,
        lokasi = ?,
        kondisi = ?,
        catatan = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssssssi",
    $nama_bunga,
    $jenis_bunga,
    $warna,
    $tanggal_tanam,
    $lokasi,
    $kondisi,
    $catatan,
    $id
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => true,
        "message" => "Data bunga berhasil diubah"
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Data bunga gagal diubah"
    ]);
}

$stmt->close();
$conn->close();

?>