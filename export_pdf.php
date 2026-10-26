<?php

require_once "vendor/autoload.php";
include "koneksi.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil ID yang dipilih
$ids = $_GET['ids'] ?? [];

if (!is_array($ids)) {
    $ids = [];
}

// Pastikan semua ID berupa angka
$ids = array_map('intval', $ids);
$ids = array_filter($ids);

if (count($ids) === 0) {
    die("Tidak ada data bunga yang dipilih.");
}

// Buat placeholder untuk query
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$types = str_repeat('i', count($ids));

$sql = "
    SELECT
        id,
        nama_bunga,
        jenis_bunga,
        warna,
        tanggal_tanam,
        lokasi,
        kondisi,
        catatan,
        latitude,
        longitude
    FROM bunga
    WHERE id IN ($placeholders)
    ORDER BY id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$ids);
$stmt->execute();

$result = $stmt->get_result();

// Buat HTML untuk PDF
$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body {
    font-family: Arial, sans-serif;
    font-size: 10px;
}

h1 {
    text-align: center;
    margin-bottom: 5px;
}

h2 {
    text-align: center;
    font-size: 14px;
    margin-top: 0;
}

.info {
    text-align: center;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background-color: #dff5e1;
    border: 1px solid #333;
    padding: 6px;
    text-align: center;
}

td {
    border: 1px solid #333;
    padding: 5px;
}

.center {
    text-align: center;
}

</style>

</head>

<body>

<h1>BLOOMCARE</h1>

<h2>DATA BUNGA TERPILIH</h2>

<div class="info">
    Laporan data bunga berdasarkan pilihan admin
</div>

<table>

<tr>
    <th>No</th>
    <th>Nama Bunga</th>
    <th>Jenis</th>
    <th>Warna</th>
    <th>Tanggal Tanam</th>
    <th>Lokasi</th>
    <th>Kondisi</th>
    <th>Catatan</th>
    <th>Latitude</th>
    <th>Longitude</th>
</tr>
';

$no = 1;

while ($row = $result->fetch_assoc()) {

    $html .= '
    <tr>

        <td class="center">' . $no++ . '</td>

        <td>' . htmlspecialchars($row['nama_bunga'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['jenis_bunga'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['warna'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['tanggal_tanam'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['lokasi'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['kondisi'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['catatan'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['latitude'] ?? '') . '</td>

        <td>' . htmlspecialchars($row['longitude'] ?? '') . '</td>

    </tr>
    ';
}

$html .= '
</table>

</body>
</html>
';

// Konfigurasi Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

// Ukuran kertas landscape supaya tabel muat
$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

// Download PDF
$filename = "data_bunga_terpilih_" . date("Y-m-d") . ".pdf";

$dompdf->stream($filename, [
    "Attachment" => true
]);

$stmt->close();
$conn->close();