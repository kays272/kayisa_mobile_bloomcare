<?php

header("Content-Type: application/json");

include "koneksi.php";

$sql = "SELECT COUNT(*) AS total FROM bunga";

$result = $conn->query($sql);

if ($result) {

    $row = $result->fetch_assoc();

    echo json_encode([
        "status" => true,
        "total" => (int)$row['total']
    ]);

} else {

    echo json_encode([
        "status" => false,
        "total" => 0,
        "message" => "Gagal mengambil jumlah data bunga"
    ]);

}

$conn->close();

?>