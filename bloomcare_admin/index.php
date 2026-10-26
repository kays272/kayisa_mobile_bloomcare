<?php

include "koneksi.php";

// Hitung jumlah bunga
$queryBunga = $conn->query("SELECT COUNT(*) AS total FROM bunga");
$totalBunga = $queryBunga->fetch_assoc()['total'];

// Hitung jumlah perawatan
$queryPerawatan = $conn->query("SELECT COUNT(*) AS total FROM perawatan");
$totalPerawatan = $queryPerawatan->fetch_assoc()['total'];

// Hitung jumlah kondisi baik
$queryBaik = $conn->query("SELECT COUNT(*) AS total FROM bunga WHERE kondisi = 'Baik'");
$totalBaik = $queryBaik->fetch_assoc()['total'];

// Hitung jumlah bunga yang perlu perawatan
$queryPerlu = $conn->query("SELECT COUNT(*) AS total FROM bunga WHERE kondisi != 'Baik'");
$totalPerlu = $queryPerlu->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bloomcare Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f8f3;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #2e7d32;
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .dashboard-title {
            color: #2e7d32;
            font-weight: bold;
        }

        .card-stat {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .icon {
            font-size: 40px;
        }

        .number {
            font-size: 32px;
            font-weight: bold;
        }

        .menu-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .menu-card a {
            text-decoration: none;
            color: inherit;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand" href="index.php">
                🌷 Bloomcare Admin
            </a>

        </div>
    </nav>


    <!-- CONTENT -->
    <div class="container py-5">

        <div class="mb-4">

            <h2 class="dashboard-title">
                Dashboard Admin
            </h2>

            <p class="text-muted">
                Perawatan & Pendataan Bunga
            </p>

        </div>


        <!-- STATISTIK -->

        <div class="row g-4">

            <!-- TOTAL BUNGA -->

            <div class="col-md-6 col-lg-3">

                <div class="card card-stat p-4">

                    <div class="icon">
                        🌷
                    </div>

                    <div class="text-muted mt-2">
                        Total Bunga
                    </div>

                    <div class="number">
                        <?= $totalBunga ?>
                    </div>

                </div>

            </div>


            <!-- TOTAL PERAWATAN -->

            <div class="col-md-6 col-lg-3">

                <div class="card card-stat p-4">

                    <div class="icon">
                        🌱
                    </div>

                    <div class="text-muted mt-2">
                        Total Perawatan
                    </div>

                    <div class="number">
                        <?= $totalPerawatan ?>
                    </div>

                </div>

            </div>


            <!-- KONDISI BAIK -->

            <div class="col-md-6 col-lg-3">

                <div class="card card-stat p-4">

                    <div class="icon">
                        💚
                    </div>

                    <div class="text-muted mt-2">
                        Kondisi Baik
                    </div>

                    <div class="number">
                        <?= $totalBaik ?>
                    </div>

                </div>

            </div>


            <!-- PERLU PERAWATAN -->

            <div class="col-md-6 col-lg-3">

                <div class="card card-stat p-4">

                    <div class="icon">
                        ⚠️
                    </div>

                    <div class="text-muted mt-2">
                        Perlu Perawatan
                    </div>

                    <div class="number">
                        <?= $totalPerlu ?>
                    </div>

                </div>

            </div>

        </div>


        <!-- MENU -->

        <div class="row g-4 mt-4">

            <div class="col-md-6">

                <div class="card menu-card p-4">

                    <a href="bunga.php">

                        <h4>🌷 Data Bunga</h4>

                        <p class="text-muted mb-0">
                            Lihat seluruh data bunga yang tersimpan.
                        </p>

                    </a>

                </div>

            </div>


            <div class="col-md-6">

                <div class="card menu-card p-4">

                    <a href="perawatan.php">

                        <h4>🌱 Data Perawatan</h4>

                        <p class="text-muted mb-0">
                            Lihat riwayat perawatan bunga.
                        </p>

                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>