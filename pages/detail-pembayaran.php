<?php

session_start();

if(!($_SESSION['login'] == "true")){
	header("Location: ../pages/login.php");
}

require_once "../koneksi/koneksi.php";

// var_dump($_SESSION['id_user']).PHP_EOL;
// var_dump($_SESSION['id_produk']).PHP_EOL;
// var_dump($_SESSION['jumlah_produk']).PHP_EOL;
// var_dump($_SESSION['total_pembayaran']).PHP_EOL;

$transaksiBarusan = $_SESSION['id_transaksi'];
$sqlDataTransaksi = "SELECT * FROM tbl_transaksi WHERE id_transaksi = $transaksiBarusan";
$data = $koneksi->prepare($sqlDataTransaksi);
$data->execute();
$dataTransaksi = $data->fetchAll(PDO::FETCH_ASSOC);

// var_dump($dataTransaksi).PHP_EOL;

$sqlDataTransaksi = "SELECT tbl_user.id_user, tbl_user.nama_lengkap, tbl_user.email, tbl_alamat.alamat_lengkap, tbl_alamat.kota, tbl_alamat.provinsi, tbl_alamat.kode_pos, tbl_alamat.nomor_telepon, tbl_produk.nama_produk, tbl_produk.harga, tbl_produk.ukuran, tbl_kategori.nama_kategori, tbl_transaksi.jumlah_produk, tbl_transaksi.total_pembelian, tbl_transaksi.created_at FROM tbl_transaksi JOIN tbl_user ON tbl_transaksi.id_user = tbl_user.id_user JOIN tbl_alamat ON tbl_alamat.id_alamat = tbl_user.id_alamat JOIN tbl_produk ON tbl_transaksi.id_produk = tbl_produk.id_produk JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id_kategori WHERE tbl_transaksi.id_transaksi = $transaksiBarusan";
$dataDua = $koneksi->prepare($sqlDataTransaksi);
$dataDua->execute();
$isiTransaksi = $dataDua->fetch(PDO::FETCH_ASSOC);
// var_dump($isiTransaksi).PHP_EOL;


?>

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/tabler-flags.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/tabler-payments.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet" />
    <link href="./dist/css/demo.min.css?1692870487" rel="stylesheet" />
    <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";
    }
    </style>
</head>

<body>
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="../pages/produk.php">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-arrow-back-up" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 14l-4 -4l4 -4" />
                                            <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Kembali
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                Detail Pembayaran
                            </h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                                <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <path
                                        d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                </svg>
                                Print Detail Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card card-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="h3">Grand Legacy</p>
                                    <address>
                                        Jln. Malioboro<br>
                                        Yogyakarta, Daerah Istimewa Yogyakarta<br>
                                        Indonesia, 55213<br>
                                        grandlegacy@gmail.com
                                    </address>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="h3">Client</p>
                                    <address>
                                        <?= $isiTransaksi['nama_lengkap'] ?><br>
                                        <?= $isiTransaksi['alamat_lengkap'] ?><br>
                                        <?= $isiTransaksi['kota'] ?>, <?= $isiTransaksi['provinsi'] ?><br>
                                        Indonesia, <?= $isiTransaksi['kode_pos'] ?><br>
                                        <?= $isiTransaksi['email'] ?><br>
                                    </address>
                                </div>
                                <div class="col-12 my-5">
                                    <h1>Invoice GL/00<?= $isiTransaksi['id_user'] ?></h1>
                                </div>
                            </div>
                            <table class="table table-transparent table-responsive fs-4">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Produk</th>
                                        <th class="text-center" style="width: 1%">Kuantitas</th>
                                        <th class="text-end" style="width: 1%">Harga Produk</th>
                                        <th class="text-end" style="width: 8rem">Jumlah</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <p class="strong mb-1"><?= $isiTransaksi['nama_produk'] ?></p>
                                        <div class="text-secondary">Ukuran : <?= $isiTransaksi['ukuran'] ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?= $isiTransaksi['jumlah_produk'] ?>
                                    </td>
                                    <td class="text-end"><?= $isiTransaksi['harga'] ?></td>
                                    <td class="text-end"><?= $isiTransaksi['jumlah_produk'] * $isiTransaksi['harga'] ?>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td class="text-center">2</td>
                                    <td>
                                        <p class="strong mb-1">Online Store Design &amp; Development</p>
                                        <div class="text-secondary">Design/Development for all popular modern browsers
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        1
                                    </td>
                                    <td class="text-end">$20.000,00</td>
                                    <td class="text-end">$20.000,00</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>
                                        <p class="strong mb-1">App Design</p>
                                        <div class="text-secondary">Promotional mobile application</div>
                                    </td>
                                    <td class="text-center">
                                        1
                                    </td>
                                    <td class="text-end">$3.200,00</td>
                                    <td class="text-end">$3.200,00</td>
                                </tr> -->
                                <tr>
                                    <td colspan="4" class="strong text-end">Subtotal</td>
                                    <td class="text-end">Rp.
                                        <?= $isiTransaksi['jumlah_produk'] * $isiTransaksi['harga'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="strong text-end">Ongkos Kirim</td>
                                    <td class="text-end">Rp. 5000</td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="4" class="strong text-end">Vat Due</td>
                                    <td class="text-end">$5.000,00</td>
                                </tr> -->
                                <tr>
                                    <td colspan="4" class="font-weight-bold text-uppercase text-end"><b>Total
                                            Keseluhuran</b>
                                    </td>
                                    <td class="font-weight-bold text-end"><?= $isiTransaksi['total_pembelian'] ?></td>
                                </tr>
                            </table>
                            <p class="text-secondary text-center mt-5">Terima kasih banyak telah berbisnis dengan kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank"
                                        class="link-secondary" rel="noopener">Documentation</a></li>
                                <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a>
                                </li>
                                <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank"
                                        class="link-secondary" rel="noopener">Source code</a></li>
                                <li class="list-inline-item">
                                    <a href="https://github.com/sponsors/codecalm" target="_blank"
                                        class="link-secondary" rel="noopener">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon text-pink icon-filled icon-inline" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                        </svg>
                                        Sponsor
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; 2023
                                    <a href="." class="link-secondary">Tabler</a>.
                                    All rights reserved.
                                </li>
                                <li class="list-inline-item">
                                    <a href="./changelog.html" class="link-secondary" rel="noopener">
                                        v1.0.0-beta20
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>

</html>