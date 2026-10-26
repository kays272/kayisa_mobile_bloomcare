<?php

include "koneksi.php";

$cari = $_GET['cari'] ?? '';

$cari = trim($cari);

if ($cari !== '') {

    $keyword = "%" . $cari . "%";

    $stmt = $conn->prepare("
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
        WHERE
            bunga.nama_bunga LIKE ?
            OR perawatan.jenis_perawatan LIKE ?
            OR perawatan.kondisi LIKE ?
            OR perawatan.catatan LIKE ?
        ORDER BY perawatan.id DESC
    ");

    $stmt->bind_param(
        "ssss",
        $keyword,
        $keyword,
        $keyword,
        $keyword
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

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
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Perawatan - Bloomcare Admin</title>


    <!-- BOOTSTRAP CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- BOOTSTRAP JAVASCRIPT -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


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

        .page-title {
            color: #2e7d32;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .table {
            vertical-align: middle;
        }

        .table thead {
            background: #2e7d32;
            color: white;
        }

        .badge-baik {
            background: #198754;
        }

        .badge-perlu {
            background: #dc3545;
        }

    </style>

</head>


<body>


<!-- ========================= -->
<!-- NAVBAR -->
<!-- ========================= -->

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a
            class="navbar-brand"
            href="index.php"
        >
            🌷 Bloomcare Admin
        </a>


        <a
            href="index.php"
            class="btn btn-light btn-sm"
        >
            ← Dashboard
        </a>

    </div>

</nav>



<!-- ========================= -->
<!-- CONTENT -->
<!-- ========================= -->

<div class="container py-5">


    <!-- ========================= -->
    <!-- JUDUL -->
    <!-- ========================= -->

    <div class="mb-4">

        <h2 class="page-title">
            🌱 Data Perawatan
        </h2>

        <p class="text-muted">
            Riwayat perawatan bunga dari aplikasi Bloomcare
        </p>

    </div>



    <!-- ========================= -->
    <!-- PENCARIAN -->
    <!-- ========================= -->

    <div class="card p-3 mb-4">

        <form method="GET">

            <div class="input-group">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="🔎 Cari nama bunga, jenis perawatan, kondisi, atau catatan..."
                    value="<?= htmlspecialchars($cari) ?>"
                >


                <button
                    type="submit"
                    class="btn btn-success"
                >
                    🔎 Cari
                </button>


                <a
                    href="perawatan.php"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>



    <!-- ========================= -->
    <!-- EXPORT -->
    <!-- ========================= -->

    <div class="card p-3 mb-4">

        <div class="d-flex align-items-center gap-3 flex-wrap">

            <button
                type="button"
                class="btn btn-success"
                onclick="pilihFormatExportPerawatan()"
            >

                📊 EXPORT DATA

            </button>

        </div>

    </div>



    <!-- ========================= -->
    <!-- TABEL -->
    <!-- ========================= -->

    <div class="card p-4">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            ID Bunga
                        </th>

                        <th>
                            Nama Bunga
                        </th>

                        <th>
                            Jenis Perawatan
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Kondisi
                        </th>

                        <th>
                            Catatan
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    $no = 1;

                    if ($result && $result->num_rows > 0):

                        while ($row = $result->fetch_assoc()):

                    ?>

                    <tr>


                        <!-- NO -->

                        <td>

                            <?= $no++ ?>

                        </td>



                        <!-- ID BUNGA -->

                        <td>

                            <?= htmlspecialchars(
                                $row['bunga_id'] ?? ''
                            ) ?>

                        </td>



                        <!-- NAMA BUNGA -->

                        <td>

                            <strong>

                                <?= htmlspecialchars(
                                    $row['nama_bunga'] ?? 'Tidak ditemukan'
                                ) ?>

                            </strong>

                        </td>



                        <!-- JENIS PERAWATAN -->

                        <td>

                            🌱

                            <?= htmlspecialchars(
                                $row['jenis_perawatan'] ?? ''
                            ) ?>

                        </td>



                        <!-- TANGGAL -->

                        <td>

                            <?= htmlspecialchars(
                                $row['tanggal'] ?? ''
                            ) ?>

                        </td>



                        <!-- KONDISI -->

                        <td>

                            <?php if (($row['kondisi'] ?? '') === 'Baik'): ?>

                                <span class="badge badge-baik">

                                    Baik

                                </span>


                            <?php elseif (!empty($row['kondisi'])): ?>

                                <span class="badge badge-perlu">

                                    <?= htmlspecialchars(
                                        $row['kondisi']
                                    ) ?>

                                </span>


                            <?php else: ?>

                                <span class="text-muted">

                                    -

                                </span>

                            <?php endif; ?>

                        </td>



                        <!-- CATATAN -->

                        <td>

                            <?= htmlspecialchars(
                                $row['catatan'] ?? ''
                            ) ?>

                        </td>


                    </tr>


                    <?php

                        endwhile;

                    else:

                    ?>


                    <!-- DATA KOSONG -->

                    <tr>

                        <td
                            colspan="7"
                            class="text-center text-muted py-4"
                        >

                            <?php if ($cari !== ''): ?>

                                Data dengan kata

                                <strong>

                                    "<?= htmlspecialchars($cari) ?>"

                                </strong>

                                tidak ditemukan.


                            <?php else: ?>

                                Belum ada data perawatan.

                            <?php endif; ?>

                        </td>

                    </tr>


                    <?php endif; ?>


                </tbody>

            </table>

        </div>

    </div>

</div>



<!-- ================================================= -->
<!-- MODAL PILIH FORMAT EXPORT -->
<!-- ================================================= -->

<div
    class="modal fade"
    id="modalExportPerawatan"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <!-- HEADER -->

            <div class="modal-header">

                <h5 class="modal-title">

                    📊 Pilih Format Export

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            <!-- BODY -->

            <div class="modal-body text-center">

                <p class="text-muted">

                    Pilih format file yang ingin diexport.

                </p>


                <div class="d-grid gap-3">


                    <!-- EXCEL -->

                    <button
                        type="button"
                        class="btn btn-success btn-lg"
                        onclick="exportPerawatanExcel()"
                    >

                        📗 Export Excel

                    </button>



                    <!-- PDF -->

                    <button
                        type="button"
                        class="btn btn-danger btn-lg"
                        onclick="exportPerawatanPDF()"
                    >

                        📕 Export PDF

                    </button>


                </div>

            </div>



            <!-- FOOTER -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >

                    ❌ Batal

                </button>

            </div>


        </div>

    </div>

</div>



<!-- ================================================= -->
<!-- JAVASCRIPT -->
<!-- ================================================= -->

<script>


function pilihFormatExportPerawatan() {

    const modalElement =
        document.getElementById(
            'modalExportPerawatan'
        );


    const modal =
        new bootstrap.Modal(
            modalElement
        );


    modal.show();

}



function exportPerawatanExcel() {

    window.location.href =
        'export_perawatan_excel.php';

}



function exportPerawatanPDF() {

    window.location.href =
        'export_perawatan_pdf.php';

}


</script>


</body>

</html>