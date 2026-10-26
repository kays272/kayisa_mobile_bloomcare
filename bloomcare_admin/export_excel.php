<?php

include "koneksi.php";


// Ambil ID bunga yang dipilih
$ids = $_GET['ids'] ?? [];


// Pastikan berupa array
if (!is_array($ids)) {
    $ids = [];
}


// Bersihkan ID agar hanya angka
$ids = array_map('intval', $ids);


// Hapus ID kosong / tidak valid
$ids = array_filter($ids);


// Kalau tidak ada data yang dipilih
if (count($ids) === 0) {

    die("Tidak ada data bunga yang dipilih untuk diexport.");

}


// Buat tanda ? sesuai jumlah ID
$placeholders = implode(',', array_fill(0, count($ids), '?'));


// Buat tipe parameter
$types = str_repeat('i', count($ids));


// Query
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


// Masukkan parameter ID secara dinamis
$stmt->bind_param($types, ...$ids);

$stmt->execute();

$result = $stmt->get_result();


// Nama file
$filename = "data_bunga_terpilih_" . date("Y-m-d") . ".xls";


// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="1">

    <tr>

        <th colspan="10">
            DATA BUNGA TERPILIH - BLOOMCARE
        </th>

    </tr>


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


    <?php

    $no = 1;

    while ($row = $result->fetch_assoc()):

    ?>

    <tr>

        <td>
            <?= $no++ ?>
        </td>

        <td>
            <?= htmlspecialchars($row['nama_bunga'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['jenis_bunga'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['warna'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['tanggal_tanam'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['lokasi'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['kondisi'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['catatan'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['latitude'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['longitude'] ?? '') ?>
        </td>

    </tr>

    <?php endwhile; ?>

</table>