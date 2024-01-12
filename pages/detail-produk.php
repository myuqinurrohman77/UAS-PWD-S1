<?php require_once "bagian/header-detail.php"; ?>
<?php 

require_once "../koneksi/koneksi.php";

$idProduk = $_GET['id_produk'];

$sqlRelasi = "SELECT tbl_produk.id_produk, tbl_produk.nama_produk, tbl_produk.gambar_produk, tbl_produk.harga, tbl_produk.ukuran , tbl_produk.deskripsi, tbl_produk.stok, tbl_kategori.id_kategori, tbl_kategori.nama_kategori FROM tbl_produk JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id_kategori WHERE id_produk=$idProduk";
$ambil = $koneksi->prepare($sqlRelasi);
$ambil->execute();
$dataProduk = $ambil->fetch(PDO::FETCH_ASSOC);

// if(isset($_POST['btn-beli'])){
// 	$_SESSION['jumlah_produk'] = $_POST['jumlah_produk'];

// 	session_write_close();
// }

?>
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="../pages/produk-kategori.php?id_kategori=<?= $dataProduk['id_kategori'] ?>"
                            class="btn btn-info d-none d-sm-inline-block">
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
                            Kategori Serupa
                        </a>
                        <a href="../pages/produk-kategori.php?id_kategori=<?= $dataProduk['id_kategori'] ?>"
                            class="btn btn-info d-sm-none btn-icon" aria-label="Tambah Koleksi">
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
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">
                        <img style="max-width: 100%; max-height: 70vh; margin: auto;" class="rounded-4 fit"
                            src="../assets/foto-produk/<?= $dataProduk['gambar_produk'] ?>" />
                    </div>
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h3 class="title text-dark">
                            <?= $dataProduk['nama_produk'] ?>
                        </h3>
                        <div class="d-flex flex-row my-3">
                            <?php if($dataProduk['stok'] !== 0): ?>
                            <span class="text-muted">
                                <b><?= $dataProduk['stok'] ?></b>
                            </span>
                            <span class="text-success ms-2">tersedia</span>
                            <?php else: ?>
                            <span class="text-danger ms-2"><b>Stok Habis</b>. <?php if($_SESSION['role'] === "2"): ?>
                                <a href="../pages/edit-produk.php?id_produk=<?= $idProduk ?>">Restock</a>
                                <?php endif; ?>
                            </span>
                            <?php endif; ?>

                        </div>

                        <div class="mb-3">
                            <span class="h5">Rp. <?= $dataProduk['harga'] ?></span>
                            <span class="text-muted">/per barang</span>
                        </div>

                        <p>
                            <?= $dataProduk['deskripsi'] ?>
                        </p>

                        <div class="row">
                            <dt class="col-3">Ukuran : </dt>
                            <dd class="col-9"><?= $dataProduk['ukuran'] ?></dd>

                            <dt class="col-3">Kategori :</dt>
                            <dd class="col-9"><?= $dataProduk['nama_kategori'] ?></dd>


                            <!-- <dt class="col-3">Material</dt>
                            <dd class="col-9">Cotton, Jeans</dd> -->

                            <!-- <dt class="col-3">Brand</dt>
                            <dd class="col-9">Reebook</dd> -->
                        </div>

                        <hr />

                        <div class="row mb-4">
                            <!-- <div class="col-md-4 col-6">
                                <label class="mb-2">Size</label>
                                <select class="form-select border border-secondary" style="height: 35px;">
                                    <option>Small</option>
                                    <option>Medium</option>
                                    <option>Large</option>
                                </select>
                            </div> -->
                            <!-- <div class="col-md-4 col-6 mb-3">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        Jumlah
                                    </span>

                                </div>
                            </div> -->
                        </div>
                        <?php if($dataProduk['stok'] !== 0): ?>
                        <a href="#offcanvasBottom" class="btn btn-primary shadow-0" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Beli</a>
                        <?php else: ?>
                        <a href="#" class="btn btn-primary shadow-0 disabled" readonly>Beli</a>
                        <?php endif; ?>
                        <a href="../pages/keranjang.php" class="btn btn-dark shadow-0"> <i
                                class="me-1 fa fa-shopping-basket"></i>
                            <svg style="margin-left: 0.5rem;" xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17h-11v-14h-2" />
                                <path d="M6 5l14 1l-1 7h-13" />
                            </svg>
                        </a>
                        <?php if($_SESSION['role'] === "2"): ?>
                        <a href="../pages/edit-produk.php?id_produk=<?= $dataProduk['id_produk'] ?>"
                            class="btn btn-info shadow-0 ms-4">Edit</a>
                        <a href="#" class="btn btn-danger shadow-0" data-bs-toggle="modal"
                            data-bs-target="#modal-small">Hapus</a>
                        <div class="modal modal-blur fade" id="modal-small" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-title">Yakin menghapus produk?</div>
                                        <div>Produk akan terhapus permanen.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link link-secondary me-auto"
                                            data-bs-dismiss="modal">Batal</button>
                                        <a href="../pages/hapus-produk.php?id_produk=<?= $dataProduk['id_produk'] ?>">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ya,
                                                hapus
                                                produk</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <form action="../pages/load-pembayaran.php" method="post">
                            <div class="offcanvas offcanvas-bottom h-auto" tabindex="-1" id="offcanvasBottom"
                                aria-labelledby="offcanvasBottomLabel">
                                <div class="offcanvas-header">

                                    <h5 class="offcanvas-title" id="offcanvasBottomLabel">
                                        <?= $dataProduk['nama_produk'] ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body small">
                                    <!-- <div style="display: flex ;"><img style="width: auto ; height: 8rem ; margin: auto;"
                                        class="rounded-4 fit"
                                        src="../assets/foto-produk/<?= $dataProduk['gambar_produk'] ?>" /></div>
                                <div> -->
                                    <div>
                                        <h3 id="harga-offcanvas">Rp <span><?= $dataProduk['harga'] ?></span></h3>
                                    </div>
                                    <div>
                                        <h4>Stok : <?= $dataProduk['stok'] ?></h4>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div>Jumlah</div>
                                            <div class="jumlah-total">
                                                <input type="number" required name="jumlah_produk"
                                                    class="form-control mt-2" autocomplete="off" id="jumlah" value="1"
                                                    style="width: 7rem;" min="1" max="<?= $dataProduk['stok'] ?>">
                                            </div>
                                        </div>
                                        <div>
                                            <div>Total</div>
                                            <div class="jumlah-total">
                                                <input type="text" class="form-control mt-2" name="total"
                                                    style="width: 11rem;" id="total" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id_produk" value="<?= $dataProduk['id_produk'] ?>"
                                        style="display: none ;">
                                    <hr>
                                    <button type="submit" name="btn-beli" class="btn btn-primary w-100">Beli
                                        Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script>
    let jumlahProduk = document.getElementById("jumlah");
    let hargaProduk = document.querySelector("#harga-offcanvas span").textContent;
    let totalProduk = document.getElementById("total");

    if (jumlahProduk.value == 1) {
        totalProduk.setAttribute("value", hargaProduk)
    }

    jumlahProduk.addEventListener("input", function() {
        let valueProduk = jumlahProduk.value;
        totalProduk.setAttribute("value", valueProduk * hargaProduk);

    })
    </script>
    <?php require_once "bagian/footer.php"; ?>