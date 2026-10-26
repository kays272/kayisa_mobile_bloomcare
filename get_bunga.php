<?php

header("Content-Type: application/json");

include "koneksi.php";

$sql = "SELECT * FROM bunga ORDER BY id DESC";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "data" => $data
]);

$conn->close();

?>