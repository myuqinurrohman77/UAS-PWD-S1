<?php require_once "bagian/header.php"; ?>
<?php

require_once "../koneksi/koneksi.php";
$idUser = $_SESSION['id_user']; 

$jumlahUang = "SELECT tbl_user.id_e_wallet, tbl_e_wallet.jumlah_uang FROM tbl_user JOIN tbl_e_Wallet ON tbl_user.id_e_Wallet = tbl_e_Wallet.id_e_wallet WHERE tbl_user.id_user = $idUser";
$jumlah = $koneksi->prepare($jumlahUang);
$jumlah->execute();
$uangUser = $jumlah->fetch(PDO::FETCH_ASSOC);
// var_dump($uangUser).PHP_EOL;

$historiTransaksi = "SELECT COUNT(*) FROM tbl_transaksi WHERE id_user = $idUser";
$histori = $koneksi->prepare($historiTransaksi);
$histori->execute();
$dataHistoriTransaksi = $histori->fetchAll(PDO::FETCH_ASSOC);
// var_dump($dataHistoriTransaksi).PHP_EOL;

$sqlKategori = "SELECT COUNT(*) FROM tbl_kategori";
$kategori = $koneksi->prepare($sqlKategori);
$kategori->execute();
$dataKategori = $kategori->fetchAll(PDO::FETCH_ASSOC);



$sqlProduk = "SELECT COUNT(*) FROM tbl_produk";
$produk = $koneksi->prepare($sqlProduk);
$produk->execute();
$dataProduk = $produk->fetchAll(PDO::FETCH_ASSOC);

// var_dump($uangUser).PHP_EOL;\\

$sqlIdTerakhir = "SELECT id_produk FROM tbl_produk ORDER BY id_produk DESC LIMIT 1";
$idTerakhir = $koneksi->prepare($sqlIdTerakhir);
$idTerakhir->execute();
$idTerakhirProduk = $idTerakhir->fetch(PDO::FETCH_ASSOC);
$idProdukTerakhirDitambahkan = $idTerakhirProduk['id_produk'];
// var_dump($idTerakhirProduk).PHP_EOL;

$produkTerakhir = "SELECT * FROM tbl_produk WHERE id_produk = $idProdukTerakhirDitambahkan";
$produkDiInsert = $koneksi->prepare($produkTerakhir);
$produkDiInsert->execute();
$dataProdukTerakhir = $produkDiInsert->fetch(PDO::FETCH_ASSOC);

$sqlPenjualanTerbanyak = "SELECT id_produk FROM tbl_transaksi GROUP BY id_produk ORDER BY COUNT(id_produk) DESC LIMIT 1";
$penjualanTerbanyak = $koneksi->prepare($sqlPenjualanTerbanyak);
$penjualanTerbanyak->execute();
$idProdukTerlaris = $penjualanTerbanyak->fetch(PDO::FETCH_ASSOC);
$produkTerlaris = $idProdukTerlaris['id_produk'];

$sqlProdukTerlaris = "SELECT * FROM tbl_produk WHERE id_produk = $produkTerlaris";
$terlaris = $koneksi->prepare($sqlProdukTerlaris);
$terlaris->execute();
$dataProdukTerlaris = $terlaris->fetch(PDO::FETCH_ASSOC);
// var_dump($dataProdukTerlaris).PHP_EOL;



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
                        Beranda
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="row row-cards">
                        <div class="col-sm-6 col-lg-6">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar bg-yellow-lt">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                                    <path d="M12 3v3m0 12v3" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                E-Wallet Anda
                                            </div>
                                            <div class="text-secondary">
                                                <?php if(!(isset($uangUser['id_e_wallet']))): ?>
                                                <span class="text-danger">* Anda belum memiliki E-Wallet</span>
                                                <?php else: ?>
                                                Rp.
                                                <?= is_null($uangUser['jumlah_uang']) || $uangUser['jumlah_uang'] == "" ? "0" : $uangUser['jumlah_uang'] ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar bg-green-lt">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-history" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 8l0 4l2 2" />
                                                    <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                Histori Transaksi Anda
                                            </div>
                                            <div class="text-secondary">
                                                <?= $dataHistoriTransaksi[0]['COUNT(*)'] ?> Transaksi
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row row-cards">
                        <div class="col-sm-6 col-lg-6">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar bg-blue-lt">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-list-details" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M13 5h8" />
                                                    <path d="M13 9h5" />
                                                    <path d="M13 15h8" />
                                                    <path d="M13 19h5" />
                                                    <path
                                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path
                                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                Jumlah Produk
                                            </div>
                                            <div class="text-secondary">
                                                <?= $dataProduk[0]['COUNT(*)'] ?> Produk
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar bg-orange-lt">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-category-2" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 4h6v6h-6z" />
                                                    <path d="M4 14h6v6h-6z" />
                                                    <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M7 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                Kategori Produk
                                            </div>
                                            <div class="text-secondary">
                                                <?= $dataKategori[0]['COUNT(*)'] ?> Kategori
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="row row-0">
                            <div class="col-3">
                                <!-- Photo -->
                                <img src="../assets/assets-beranda/penghargaan.png"
                                    class="h-100 object-cover card-img-start" style="width: auto;"
                                    alt="Beautiful blonde woman relaxing with a can of coke on a tree stump by the beach" />
                            </div>
                            <div class="col">
                                <div class="card-body">
                                    <h3 class="card-title">Penghargaan batik terbaik</h3>
                                    <p class="text-secondary">Toko batik kami mendapatkan penghargaan sebagai produsen
                                        batik terbaik dan berkualitas. Dan kami juga mendapatkan penghargaan sebagai
                                        pelestari batik milenial.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="row row-0">
                            <div class="col-3">
                                <!-- Photo -->
                                <img src="../assets/assets-beranda/presiden-joko-widodo-membeli-batik.png"
                                    class="w-100 h-100 object-cover card-img-start"
                                    alt="Beautiful blonde woman relaxing with a can of coke on a tree stump by the beach" />
                            </div>
                            <div class="col">
                                <div class="card-body">
                                    <h3 class="card-title">Batik berkualitas untuk konsumen terbaik</h3>
                                    <p class="text-secondary">Kami memiliki konsumen tetap yang selalu berbelanja di
                                        toko kami dikarenakan produk dan kualitas batik kami yang terbaik. Presiden dan
                                        para pejabat menggunakan batik kami.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly">
                    <div class="col-lg-4 m-2">
                        <hr>
                        <p class="text-center">Produk Terbaru</p>
                        <div class="card card-sm">
                            <div class="ribbon bg-red">NEW</div>
                            <a href="detail-produk.php?id_produk=<?= $dataProdukTerakhir['id_produk'] ?>"
                                class="d-block"><img height="350px"
                                    src="../assets/foto-produk/<?= $dataProdukTerakhir['gambar_produk'] ?>"
                                    class="card-img-top"></a>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <!-- <span class="avatar me-3 rounded"
                                    style="background-image: url(./static/avatars/000m.jpg)"></span> -->
                                    <div>
                                        <div>
                                            <h3><b><?= $dataProdukTerakhir['nama_produk'] ?></b></h3>
                                        </div>
                                        <div class="text-secondary">Rp. <?= $dataProdukTerakhir['harga'] ?></div>
                                        <?php if($dataProdukTerakhir['stok'] != 0): ?>
                                        <div class="text-secondary">
                                            Tersedia : <?= $dataProdukTerakhir['stok'] ?>
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
                    <div class="col-lg-4 m-2">
                        <hr>
                        <p class="text-center">Produk Terlaris</p>
                        <div class="card card-sm">
                            <div class="ribbon ribbon-top bg-yellow">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                </svg>
                            </div>
                            <a href="detail-produk.php?id_produk=<?= $dataProdukTerlaris['id_produk'] ?>"
                                class="d-block"><img height="350px"
                                    src="../assets/foto-produk/<?= $dataProdukTerlaris['gambar_produk'] ?>"
                                    class="card-img-top"></a>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <!-- <span class="avatar me-3 rounded"
                                    style="background-image: url(./static/avatars/000m.jpg)"></span> -->
                                    <div>
                                        <div>
                                            <h3><b><?= $dataProdukTerlaris['nama_produk'] ?></b></h3>
                                        </div>
                                        <div class="text-secondary">Rp. <?= $dataProdukTerlaris['harga'] ?></div>
                                        <?php if($dataProdukTerlaris['stok'] != 0): ?>
                                        <div class="text-secondary">
                                            Tersedia : <?= $dataProdukTerlaris['stok'] ?>
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
                </div>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>