<?php

include "koneksi.php";

$cari = $_GET['cari'] ?? '';
$cari = trim($cari);

if ($cari !== '') {

    $keyword = "%" . $cari . "%";

    $stmt = $conn->prepare("
        SELECT *
        FROM bunga
        WHERE
            nama_bunga LIKE ?
            OR jenis_bunga LIKE ?
            OR warna LIKE ?
            OR lokasi LIKE ?
            OR kondisi LIKE ?
            OR catatan LIKE ?
        ORDER BY id DESC
    ");

    $stmt->bind_param(
        "ssssss",
        $keyword,
        $keyword,
        $keyword,
        $keyword,
        $keyword,
        $keyword
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT * FROM bunga ORDER BY id DESC";

    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Bunga - Bloomcare Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

        .checkbox-pilih {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .btn-export {
            background: #198754;
            color: white;
            border: none;
        }

        .btn-export:hover {
            background: #157347;
            color: white;
        }

    </style>

</head>

<body>


<!-- NAVBAR -->

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



<!-- CONTENT -->

<div class="container py-5">


    <!-- JUDUL -->

    <div class="mb-4">

        <h2 class="page-title">
            🌷 Data Bunga
        </h2>

        <p class="text-muted">
            Seluruh data bunga dari aplikasi Bloomcare
        </p>

    </div>



    <!-- PENCARIAN -->

    <div class="card p-3 mb-4">

        <form method="GET">

            <div class="input-group">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="🔎 Cari nama bunga, jenis, warna, lokasi, kondisi, atau catatan..."
                    value="<?= htmlspecialchars($cari) ?>"
                >

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    🔎 Cari
                </button>

                <a
                    href="bunga.php"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>



    <!-- EXPORT -->

    <div class="card p-3 mb-4">

        <form
            method="GET"
            action="export_excel.php"
            id="formExport"
        >

            <div class="d-flex align-items-center gap-3 flex-wrap">

                <button
                    type="button"
                    class="btn btn-outline-success"
                    onclick="pilihSemua()"
                >
                    ☑ Pilih Semua
                </button>

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="batalPilih()"
                >
                    ☐ Batal Pilih
                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    onclick="pilihFormatExport()">
                    📊 EXPORT DATA
               </button>
                <span
                    id="jumlahDipilih"
                    class="text-muted"
                >
                    0 data dipilih
                </span>

            </div>

        </form>

    </div>



    <!-- TABEL -->

    <div class="card p-4">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>
                            Pilih
                        </th>

                        <th>
                            No
                        </th>

                        <th>
                            Nama Bunga
                        </th>

                        <th>
                            Jenis
                        </th>

                        <th>
                            Warna
                        </th>

                        <th>
                            Tanggal Tanam
                        </th>

                        <th>
                            Lokasi
                        </th>

                        <th>
                            Kondisi
                        </th>

                        <th>
                            Catatan
                        </th>

                        <th>
                            Latitude
                        </th>

                        <th>
                            Longitude
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

                        <td>

                            <input
                                type="checkbox"
                                class="checkbox-pilih"
                                name="ids[]"
                                value="<?= $row['id'] ?>"
                                form="formExport"
                                onchange="hitungPilihan()"
                            >

                        </td>


                        <td>
                            <?= $no++ ?>
                        </td>


                        <td>

                            <strong>

                                <?= htmlspecialchars(
                                    $row['nama_bunga'] ?? ''
                                ) ?>

                            </strong>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['jenis_bunga'] ?? ''
                            ) ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['warna'] ?? ''
                            ) ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['tanggal_tanam'] ?? ''
                            ) ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['lokasi'] ?? ''
                            ) ?>

                        </td>


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


                        <td>

                            <?= htmlspecialchars(
                                $row['catatan'] ?? ''
                            ) ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['latitude'] ?? ''
                            ) ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['longitude'] ?? ''
                            ) ?>

                        </td>

                    </tr>

                    <?php

                        endwhile;

                    else:

                    ?>

                    <tr>

                        <td
                            colspan="11"
                            class="text-center text-muted py-4"
                        >

                            <?php if ($cari !== ''): ?>

                                Data dengan kata
                                <strong>
                                    "<?= htmlspecialchars($cari) ?>"
                                </strong>
                                tidak ditemukan.

                            <?php else: ?>

                                Belum ada data bunga.

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- MODAL PILIH FORMAT EXPORT -->
<div class="modal fade" id="modalExport" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    📊 Pilih Format Export
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body text-center">

                <p class="text-muted">
                    Pilih format file yang ingin digunakan.
                </p>

                <div class="d-grid gap-3">

                    <button
                        type="button"
                        class="btn btn-success btn-lg"
                        onclick="exportExcel()">

                        📗 Export Excel

                    </button>

                    <button
                        type="button"
                        class="btn btn-danger btn-lg"
                        onclick="exportPDF()">

                        📕 Export PDF

                    </button>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    ❌ Batal

                </button>

            </div>

        </div>

    </div>

</div>

<script>

function getCheckboxes() {

    return document.querySelectorAll(
        '.checkbox-pilih'
    );

}


function hitungPilihan() {

    const checkbox =
        getCheckboxes();

    let jumlah = 0;

    checkbox.forEach(function(item) {

        if (item.checked) {
            jumlah++;
        }

    });

    document.getElementById(
        'jumlahDipilih'
    ).innerText =
        jumlah + ' data dipilih';

}


function pilihSemua() {

    const checkbox =
        getCheckboxes();

    checkbox.forEach(function(item) {

        item.checked = true;

    });

    hitungPilihan();

}


function batalPilih() {

    const checkbox =
        getCheckboxes();

    checkbox.forEach(function(item) {

        item.checked = false;

    });

    hitungPilihan();

}


function cekPilihan() {

    const checkbox =
        getCheckboxes();

    let jumlah = 0;

    checkbox.forEach(function(item) {

        if (item.checked) {
            jumlah++;
        }

    });

    if (jumlah === 0) {

        alert(
            'Silakan pilih minimal satu data bunga untuk diexport.'
        );

        return false;

    }

    return true;

}

function pilihFormatExport() {

    const checkbox = getCheckboxes();

    let jumlah = 0;

    checkbox.forEach(function(item) {
        if (item.checked) {
            jumlah++;
        }
    });

    if (jumlah === 0) {
        alert('Silakan pilih minimal satu data bunga terlebih dahulu.');
        return;
    }

    const modalElement = document.getElementById('modalExport');

    const modal = new bootstrap.Modal(modalElement);

    modal.show();
}


function exportExcel() {

    const form = document.getElementById('formExport');

    form.action = 'export_excel.php';

    form.submit();
}


function exportPDF() {

    const form = document.getElementById('formExport');

    form.action = 'export_pdf.php';

    form.submit();
}

</script>


</body>

</html>