<?php

include "koneksi.php";

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

$filename = "data_perawatan_bloomcare_" . date("Y-m-d") . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="1">

    <tr>
        <th colspan="7">
            DATA RIWAYAT PERAWATAN - BLOOMCARE
        </th>
    </tr>

    <tr>
        <th>No</th>
        <th>ID Bunga</th>
        <th>Nama Bunga</th>
        <th>Jenis Perawatan</th>
        <th>Tanggal</th>
        <th>Kondisi</th>
        <th>Catatan</th>
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
            <?= htmlspecialchars($row['bunga_id'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['nama_bunga'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['jenis_perawatan'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['tanggal'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['kondisi'] ?? '') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['catatan'] ?? '') ?>
        </td>

    </tr>

    <?php endwhile; ?>

</table>