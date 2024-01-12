<?php require_once "bagian/header.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$idKategori = $_GET['id_kategori'];
$sql = "SELECT tbl_produk.id_produk, tbl_produk.nama_produk, tbl_produk.gambar_produk, tbl_produk.harga, tbl_produk.deskripsi, tbl_produk.stok, tbl_kategori.id_kategori, tbl_kategori.nama_kategori FROM tbl_produk JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id_kategori WHERE tbl_produk.id_kategori=$idKategori";

$ambilDataProduk = $koneksi->prepare($sql);
$ambilDataProduk->execute();
$dataProduk = $ambilDataProduk->fetchAll(PDO::FETCH_ASSOC);

// $sqlRelasi = "SELECT tbl_produk.id_produk, tbl_produk.nama_produk, tbl_produk.gambar_produk, tbl_produk.harga, tbl_produk.deskripsi, tbl_produk.stok, tbl_kategori.id_kategori, tbl_kategori.nama_kategori FROM tbl_kategori JOIN tbl_produk ON tbl_kategori.id_kategori = tbl_produk.id_kategori WHERE id_kategori=$idKategori";
// $ambilKategori = $koneksi->prepare($sqlRelasi);
// $ambilKategori->execute();

// var_dump($dataProduk).PHP_EOL;
// var_dump($dataProduk).PHP_EOL;



$jumlahData = "SELECT COUNT(*) FROM tbl_produk WHERE id_kategori=$idKategori";

$jumlahDataProduk = $koneksi->prepare($jumlahData);
$jumlahDataProduk->execute();
$jumlahProduk = $jumlahDataProduk->fetch(PDO::FETCH_ASSOC);




$dataHalaman = "SELECT * FROM tbl_kategori WHERE id_kategori=$idKategori";
$halaman = $koneksi->prepare($dataHalaman);
$halaman->execute();
$dataHalamanKategori = $halaman->fetch(PDO::FETCH_ASSOC);

// var_dump($dataHalamanKategori).PHP_EOL;


// var_dump($jumlahProduk['COUNT(*)']).PHP_EOL;

$dataKosong = false;
if($jumlahProduk['COUNT(*)'] === 0){
	$dataKosong = true;
}

?>
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Kategori
                    </div>
                    <h2 class="page-title">
                        <?= $dataHalamanKategori['nama_kategori'] ?>
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/produk.php" class="btn btn-info d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-grid-dots"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M19 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M5 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M19 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            </svg>
                            Produk
                        </a>
                        <a href="../pages/produk.php" class="btn btn-info d-sm-none btn-icon"
                            aria-label="Tambah Koleksi">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-grid-dots"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M19 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M5 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M19 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            </svg>
                        </a>
                    </div>
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
        <?php if($dataKosong): ?>
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
                <div class="empty-img"><img src="static/illustrations/no_data.svg" height="128" alt="">
                </div>
                <p class="empty-title">Data kategori kosong</p>
                <p class="empty-subtitle text-secondary">
                    Admin belum menambahkan produk pada kategori tersebut
                </p>
            </div>
        </div>
        <?php endif; ?>
        <div class="container-xl">
            <div class="row row-cards">
                <?php foreach($dataProduk as $dtproduk): ?>
                <div class="col-sm-6 col-lg-6">
                    <div class="card card-sm">
                        <a href="detail-produk.php?id_produk=<?= $dtproduk['id_produk'] ?>" class="d-block"><img
                                height="350px" src="../assets/foto-produk/<?= $dtproduk['gambar_produk'] ?>"
                                class="card-img-top"></a>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <!-- <span class="avatar me-3 rounded"
                                    style="background-image: url(./static/avatars/000m.jpg)"></span> -->
                                <div>
                                    <div><?= $dtproduk['nama_produk'] ?></div>
                                    <div class="text-secondary"><?= $dtproduk['harga'] ?></div>
                                    <div class="text-secondary">Tersedia : <?= $dtproduk['stok'] ?></div>
                                </div>
                                <div class="ms-auto">
                                    <a href="#" class="text-secondary">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        467 -->
                                        <button class="btn btn-primary">Beli</button>
                                    </a>
                                    <a href="#" class="ms-1 text-secondary">
                                        <button class="btn btn-dark"><svg style="margin-left: 0.6rem;"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-shopping-cart" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M17 17h-11v-14h-2" />
                                                <path d="M6 5l14 1l-1 7h-13" />
                                            </svg></button>
                                    </a>
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