<?php require_once "bagian/header.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$sql = "SELECT * FROM tbl_galeri";
$data = $koneksi->prepare($sql);
$data->execute();
$dataGaleri = $data->fetchAll(PDO::FETCH_ASSOC);
// var_dump($dataGaleri).PHP_EOL;

?>
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Halaman
                    </div>
                    <h2 class="page-title">
                        Galeri
                    </h2>
                </div>
                <?php if($_SESSION['role'] === "2"): ?>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/kelola-galeri.php" class="btn btn-info d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-edit"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 8h.01" />
                                <path d="M11 20h-4a3 3 0 0 1 -3 -3v-10a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v4" />
                                <path d="M4 15l4 -4c.928 -.893 2.072 -.893 3 0l3 3" />
                                <path d="M14 14l1 -1c.31 -.298 .644 -.497 .987 -.596" />
                                <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                            </svg>
                            Kelola
                        </a>
                        <a href="../pages/kelola-galeri.php" class="btn btn-info d-sm-none btn-icon"
                            aria-label="Tambah Koleksi">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-edit"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 8h.01" />
                                <path d="M11 20h-4a3 3 0 0 1 -3 -3v-10a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v4" />
                                <path d="M4 15l4 -4c.928 -.893 2.072 -.893 3 0l3 3" />
                                <path d="M14 14l1 -1c.31 -.298 .644 -.497 .987 -.596" />
                                <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/tambah-foto-galeri.php" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Foto
                        </a>
                        <a href="../pages/tambah-foto-galeri.php" class="btn btn-primary d-sm-none btn-icon"
                            aria-label="Tambah Koleksi">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cols-6 g-3">
                <?php foreach($dataGaleri as $dtgambar): ?>
                <div class="col">
                    <a data-fslightbox="gallery" href="../assets/galeri/<?= $dtgambar['nama_gambar'] ?>">
                        <!-- Photo -->
                        <div class="img-responsive img-responsive-1x1 rounded border"
                            style="background-image: url(../assets/galeri/<?= $dtgambar['nama_gambar'] ?>)">
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>