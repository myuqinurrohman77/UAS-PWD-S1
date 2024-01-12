<?php require_once "bagian/header-kategori.php"; ?>
<?php 

require_once "../koneksi/koneksi.php";

$sql = "SELECT * FROM tbl_kategori ";
$ambil = $koneksi->prepare($sql);
$ambil->execute();
$dataKategori = $ambil->fetchAll(PDO::FETCH_ASSOC);

$sqlProduk = "SELECT tbl_kategori.id_kategori, COALESCE(COUNT(tbl_produk.id_kategori), 0) AS jumlah_kategori FROM tbl_kategori LEFT JOIN tbl_produk ON tbl_produk.id_kategori = tbl_kategori.id_kategori GROUP BY tbl_kategori.nama_kategori";
$jumlahKategori = $koneksi->prepare($sqlProduk);
$jumlahKategori->execute();
$jumlahProdukKategori = $jumlahKategori->fetchAll(PDO::FETCH_ASSOC);

// var_dump($jumlahProdukKategori).PHP_EOL;

// foreach($jumlahProdukKategori as $key => $value){
// 	echo "id kategori : {$value['id_kategori']} jumlah kategori : {$value['jumlah_kategori']} | " ;
// }

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
                        Kategori
                    </h2>
                </div>
                <?php if($_SESSION['role'] === "2"): ?>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/tambah-kategori.php" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah Kategori
                        </a>
                        <a href="../pages/tambah-kategori.php" class="btn btn-primary d-sm-none btn-icon"
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
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="row row-cards">
                        <?php foreach($dataKategori as $kategori): ?>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <a
                                                href="../pages/produk-kategori.php?id_kategori=<?= $kategori['id_kategori'] ?>">
                                                <span class="bg-primary text-white avatar">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-category-filled" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M10 3h-6a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1 -1v-6a1 1 0 0 0 -1 -1z"
                                                            stroke-width="0" fill="currentColor" />
                                                        <path
                                                            d="M20 3h-6a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1 -1v-6a1 1 0 0 0 -1 -1z"
                                                            stroke-width="0" fill="currentColor" />
                                                        <path
                                                            d="M10 13h-6a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1 -1v-6a1 1 0 0 0 -1 -1z"
                                                            stroke-width="0" fill="currentColor" />
                                                        <path
                                                            d="M17 13a4 4 0 1 1 -3.995 4.2l-.005 -.2l.005 -.2a4 4 0 0 1 3.995 -3.8z"
                                                            stroke-width="0" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                <?= $kategori['nama_kategori'] ?>
                                            </div>
                                            <div class="text-secondary">
                                                <?php foreach($jumlahProdukKategori as $key => $value): ?>
                                                <?php if($value['id_kategori'] == $kategori['id_kategori']): ?>
                                                <?= $value['jumlah_kategori'] ?> Produk
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php if($_SESSION['role'] === "2" && $kategori['id_kategori'] !== 11): ?>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        style="margin-right: -0.3rem;"
                                                        class="icon icon-tabler icon-tabler-dots-vertical" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item"
                                                            href="../pages/hapus-kategori.php?id_kategori=<?= $kategori['id_kategori'] ?>">Hapus</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>