<?php

require_once "vendor/autoload.php";
include "koneksi.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$sql = "
    SELECT
        perawatan.id,
        perawatan.bunga_id,
        bunga.nama_bunga,
        perawatan.jenis_perawatan,
        perawatan.tanggal,
        perawatan.kondisi,
        perawatan.catatan
    FROM perawatan
    LEFT JOIN bunga
        ON perawatan.bunga_id = bunga.id
    ORDER BY perawatan.id DESC
";

$result = $conn->query($sql);

$html = '
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<style>

body {
    font-family: Arial, sans-serif;
    font-size: 11px;
}

h1 {
    text-align: center;
    margin-bottom: 5px;
}

h2 {
    text-align: center;
    font-size: 15px;
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
    padding: 7px;
    text-align: center;
}

td {
    border: 1px solid #333;
    padding: 6px;
}

.center {
    text-align: center;
}

</style>

</head>

<body>

<h1>BLOOMCARE</h1>

<h2>RIWAYAT PERAWATAN BUNGA</h2>

<div class="info">
    Laporan seluruh riwayat perawatan bunga
</div>

<table>

<tr>
    <th>No</th>
    <th>ID Bunga</th>
    <th>Nama Bunga</th>
    <th>Jenis Perawatan</th>
    <th>Tanggal</th>
    <th>Kondisi</th>
    <th>Catatan</th>
</tr>
';

$no = 1;

while ($row = $result->fetch_assoc()) {

    $html .= '
    <tr>

        <td class="center">' . $no++ . '</td>

        <td class="center">' .
            htmlspecialchars($row['bunga_id'] ?? '') .
        '</td>

        <td>' .
            htmlspecialchars($row['nama_bunga'] ?? '') .
        '</td>

        <td>' .
            htmlspecialchars($row['jenis_perawatan'] ?? '') .
        '</td>

        <td class="center">' .
            htmlspecialchars($row['tanggal'] ?? '') .
        '</td>

        <td>' .
            htmlspecialchars($row['kondisi'] ?? '') .
        '</td>

        <td>' .
            htmlspecialchars($row['catatan'] ?? '') .
        '</td>

    </tr>
    ';
}

$html .= '
</table>

</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

$filename = "data_perawatan_bloomcare_" . date("Y-m-d") . ".pdf";

$dompdf->stream($filename, [
    "Attachment" => true
]);

$conn->close();