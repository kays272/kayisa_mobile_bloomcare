<?php

header("Content-Type: application/json");

include "koneksi.php";

$sql = "SELECT
            id,
            bunga_id,
            jenis_perawatan,
            tanggal,
            kondisi,
            catatan,
            created_at
        FROM perawatan
        ORDER BY id DESC";

$result = $conn->query($sql);

$data = [];

if ($result) {

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode([
        "status" => true,
        "data" => $data
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Gagal mengambil data perawatan",
        "error" => $conn->error
    ]);
}

$conn->close();

?>