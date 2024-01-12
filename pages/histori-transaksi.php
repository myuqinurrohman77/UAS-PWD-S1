<?php require_once "bagian/header.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$idUser = $_SESSION['id_user'];
$sql = "SELECT * FROM tbl_transaksi JOIN tbl_produk ON tbl_transaksi.id_produk = tbl_produk.id_produk WHERE tbl_transaksi.id_user = $idUser";
$data = $koneksi->prepare($sql);
$data->execute();
$dataTransaksi = $data->fetchAll(PDO::FETCH_ASSOC);

// var_dump($dataTransaksi == null).PHP_EOL;

?>
<div class="page-wrapper">
    <!-- Page header -->
    <?php if($dataTransaksi != null): ?>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Halaman
                    </div>
                    <h2 class="page-title">
                        Histori Transaksi
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($dataTransaksi != null): ?>
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Jumlah Dibeli</th>
                                    <th>Ongkir</th>
                                    <th>Total</th>
                                    <th>Waktu Transaksi</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataTransaksi as $dt): ?>
                                <td data-label="Title">
                                    <div class="text-secondary"><?= $dt['nama_produk'] ?></div>
                                </td>
                                <td class="text-secondary">
                                    <div class="text-secondary"><?= $dt['harga'] ?></div>
                                </td>
                                <td class="text-secondary">
                                    <div class="text-secondary"><?= $dt['jumlah_produk'] ?></div>
                                </td>
                                <td class="text-secondary">
                                    <div class="text-secondary">5000</div>
                                </td>
                                <td class="text-secondary">
                                    <div class="text-secondary"><?= $dt['total_pembelian'] ?></div>
                                </td>
                                <td class="text-secondary">
                                    <div class="text-secondary"><?= $dt['created_at'] ?></div>
                                </td>
                                <td class="text-secondary">
                                    <a href="../pages/detail-transaksi.php?id_transaksi=<?= $dt['id_transaksi'] ?>">
                                        <div class="text-white btn btn-info">Detail</div>
                                    </a>
                                </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="page page-center">
                <div class="container-tight py-4">
                    <div class="empty">
                        <div class="empty-img"><img src="./static/illustrations/undraw_web_shopping_re_owap.svg"
                                height="128" alt="">
                        </div>
                        <p class="empty-title">Anda belum melakukan transaksi</p>
                        <p class="empty-subtitle text-secondary">
                            Kami Punya Berbagai Pilihan Menarik!
                        </p>
                        <div class="empty-action">
                            <a href="../pages/produk.php" class="btn btn-primary">
                                <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-shopping-bag" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z" />
                                    <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
                                </svg>
                                Mulai berbelanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>