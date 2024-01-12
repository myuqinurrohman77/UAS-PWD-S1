<?php require_once "bagian/header.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$sql = "SELECT * FROM tbl_produk";
$ambilDataProduk = $koneksi->prepare($sql);
$ambilDataProduk->execute();
$dataProduk = $ambilDataProduk->fetchAll(PDO::FETCH_ASSOC);

// var_dump($dataProduk).PHP_EOL;

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
                        Produk
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/kategori.php" class="btn btn-info d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 4h6v6h-6z" />
                                <path d="M14 4h6v6h-6z" />
                                <path d="M4 14h6v6h-6z" />
                                <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            </svg>
                            Kategori
                        </a>
                        <a href="../pages/kategori.php" class="btn btn-info d-sm-none btn-icon"
                            aria-label="Tambah Koleksi">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 4h6v6h-6z" />
                                <path d="M14 4h6v6h-6z" />
                                <path d="M4 14h6v6h-6z" />
                                <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            </svg>
                        </a>
                    </div>
                </div>
                <?php if($_SESSION['role'] === "2"): ?>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/tambah-produk.php" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Produk
                        </a>
                        <a href="../pages/tambah-produk.php" class="btn btn-primary d-sm-none btn-icon"
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
            <div class="row row-cards">
                <?php foreach($dataProduk as $dtproduk): ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card card-sm">
                        <a href="detail-produk.php?id_produk=<?= $dtproduk['id_produk'] ?>" class="d-block"><img
                                height="350px" src="../assets/foto-produk/<?= $dtproduk['gambar_produk'] ?>"
                                class="card-img-top"></a>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <!-- <span class="avatar me-3 rounded"
                                    style="background-image: url(./static/avatars/000m.jpg)"></span> -->
                                <div>
                                    <div>
                                        <h3><b><?= $dtproduk['nama_produk'] ?></b></h3>
                                    </div>
                                    <div class="text-secondary">Rp. <?= $dtproduk['harga'] ?></div>
                                    <?php if($dtproduk['stok'] != 0): ?>
                                    <div class="text-secondary">
                                        Tersedia : <?= $dtproduk['stok'] ?>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-danger">
                                        Habis
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>