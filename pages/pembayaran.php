<?php

session_start();

require_once "../koneksi/koneksi.php";

if($_SESSION['login'] !== true){
	header("Location: login.php");
}

// if($_SERVER['REQUEST_METHOD'] == "POST"){
// 	$_SESSION['id_produk'] = $_POST['id_produk'];
// 	$_SESSION['jumlah_produk'] = $_POST['jumlah_produk'];
// }

$idUser = $_SESSION['id_user'];
// $jumlahProduk = $_SESSION['jumlah_produk'];

// if(empty(trim($jumlahProduk))){
// 	header("Location: pembayaran.php?jumlah_produk=$jumlahProduk&id_produk");
// }

$idProduk = $_SESSION['id_produk'];
$jumlahProduk = $_SESSION['jumlah_produk'];

$userKeseluruhan = "SELECT * FROM tbl_user WHERE id_user = $idUser";
$user = $koneksi->prepare($userKeseluruhan);
$user->execute();
$userSekarang = $user->fetch(PDO::FETCH_ASSOC);

if(!(isset($userSekarang['id_alamat'])) && !(isset($userSekarang['id_e_wallet']))){
	$ambilDataUser = "SELECT nama_lengkap, email FROM tbl_user WHERE id_user = $idUser";
	$data = $koneksi->prepare($ambilDataUser);
	$data->execute();
	$dataUser = $data->fetch(PDO::FETCH_ASSOC);
}else if(!(isset($userSekarang['id_alamat'])) && isset($userSekarang['id_e_wallet'])){
	$ambilDataUser = "SELECT tbl_user.nama_lengkap, tbl_user.email, tbl_e_wallet.id_e_wallet, tbl_e_wallet.username, tbl_e_wallet.jumlah_uang FROM tbl_user JOIN tbl_e_wallet ON tbl_user.id_e_wallet = tbl_e_wallet.id_e_wallet WHERE tbl_user.id_user = $idUser AND tbl_e_wallet.id_user = $idUser";
	$data = $koneksi->prepare($ambilDataUser);
	$data->execute();
	$dataUser = $data->fetch(PDO::FETCH_ASSOC);
}else if(!(isset($userSekarang['id_e_wallet'])) && isset($userSekarang['id_alamat'])){
	$ambilDataUser = "SELECT tbl_user.nama_lengkap, tbl_user.email, tbl_alamat.id_alamat, tbl_alamat.alamat_lengkap, tbl_alamat.kota, tbl_alamat.provinsi, tbl_alamat.kode_pos, tbl_alamat.nomor_telepon FROM tbl_user JOIN tbl_alamat ON tbl_user.id_user = tbl_alamat.id_user WHERE tbl_user.id_user = $idUser AND tbl_alamat.id_user = $idUser";
	$data = $koneksi->prepare($ambilDataUser);
	$data->execute();
	$dataUser = $data->fetch(PDO::FETCH_ASSOC);
}else{
	$ambilDataUser = "SELECT tbl_user.nama_lengkap, tbl_user.email, tbl_alamat.id_alamat , tbl_alamat.alamat_lengkap, tbl_alamat.kota, tbl_alamat.provinsi, tbl_alamat.kode_pos, tbl_alamat.nomor_telepon, tbl_e_wallet.id_e_wallet, tbl_e_wallet.username, tbl_e_wallet.jumlah_uang FROM tbl_user JOIN tbl_alamat ON tbl_user.id_user = tbl_alamat.id_user JOIN tbl_e_wallet ON tbl_user.id_e_wallet = tbl_e_wallet.id_e_wallet WHERE tbl_user.id_user = $idUser AND tbl_alamat.id_user = $idUser AND tbl_e_wallet.id_user = $idUser";
	$data = $koneksi->prepare($ambilDataUser);
	$data->execute();
	$dataUser = $data->fetch(PDO::FETCH_ASSOC);
}



$ambilDataBarang = "SELECT tbl_produk.id_produk, tbl_produk.nama_produk, tbl_produk.gambar_produk, tbl_produk.harga, tbl_produk.ukuran, tbl_produk.deskripsi, tbl_produk.stok, tbl_kategori.nama_kategori FROM tbl_produk JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id_kategori WHERE tbl_produk.id_produk = $idProduk";
$produk = $koneksi->prepare($ambilDataBarang);
$produk->execute();
$dataProduk = $produk->fetch(PDO::FETCH_ASSOC);

$totalJumlahDikaliHarga = $jumlahProduk * $dataProduk['harga'];

$ongkir = 5000;

$totalPembayaran = $totalJumlahDikaliHarga + $ongkir;


$tidakMemilihPembayaran = false;
$uangTidakCukup = false;
$dataTidakLengkap = false;


$pembayaranSukses = false;

$modalInformasiPembayaran = '<script type="text/javascript">
				document.addEventListener("DOMContentLoaded", function() {
				  var modal = new bootstrap.Modal(document.getElementById("modal-success"));
				  modal.show();
				});
			 </script>';

if(isset($_POST['bayar'])){
	if(isset($dataUser['id_alamat']) && isset($dataUser['id_e_wallet'])){
		if(isset($_POST['e-wallet'])){
			if(!($totalPembayaran > $dataUser['jumlah_uang'])){
				$_SESSION['total_pembayaran'] = $totalPembayaran;

                $kurangiUangUser = "UPDATE tbl_user JOIN tbl_e_Wallet ON tbl_user.id_e_wallet = tbl_e_wallet.id_e_wallet SET tbl_e_Wallet.jumlah_uang = tbl_e_Wallet.jumlah_uang - $totalPembayaran WHERE tbl_user.id_user = $idUser AND tbl_e_wallet.id_e_wallet = {$dataUser['id_e_wallet']}";
                $kurangiUang = $koneksi->prepare($kurangiUangUser);
                $kurangiUang->execute();

					 $kurangiJumlahProduk = "UPDATE tbl_produk SET stok = stok - $jumlahProduk WHERE id_produk = $idProduk";
					 $kurangiProduk = $koneksi->prepare($kurangiJumlahProduk);
					 $kurangiProduk->execute();


                $tambahTransaksi = "INSERT INTO tbl_transaksi (id_user, id_produk, jumlah_produk, total_pembelian) VALUES (:id_user, :id_produk, :jumlah_produk, :total_pembelian)";
                $tambah = $koneksi->prepare($tambahTransaksi);
                $tambah->bindParam(":id_user", $idUser); 
                $tambah->bindParam(":id_produk", $idProduk); 
                $tambah->bindParam(":jumlah_produk", $jumlahProduk);
                $tambah->bindParam(":total_pembelian", $totalPembayaran);
                $tambah->execute();

					 $_SESSION['id_transaksi'] = $koneksi->lastInsertId();
					// var_dump($koneksi->lastInsertId()).PHP_EOL;

                
				$pembayaranSukses = true;
				sleep(2);
				echo $modalInformasiPembayaran;
			}else{
				$uangTidakCukup = true;
			}
		}else{
			$tidakMemilihPembayaran = true;
		}
	}else{
		$dataTidakLengkap = true;
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
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
    <link rel="stylesheet" href="../assets/css-pembayaran/style.css" />
</head>

<body>
    <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="../pages/detail-produk.php?id_produk=<?= $dataProduk['id_produk'] ?>">
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

    <?php if($tidakMemilihPembayaran): ?>
    <div class="informasi d-flex justify-content-center mt-4">
        <div class="alert alert-danger w-70" role="alert" style="width: 50rem ;">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                </div>
                <div>
                    Anda harus memilih metode pembayaran
                </div>
            </div>
        </div>
    </div>
    <?php elseif($uangTidakCukup): ?>
    <div class="informasi d-flex justify-content-center mt-4">
        <div class="alert alert-danger w-70" role="alert" style="width: 50rem ;">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                </div>
                <div>
                    Uang anda tidak cukup
                </div>
            </div>
        </div>
    </div>
    <?php elseif($dataTidakLengkap): ?>
    <div class="informasi d-flex justify-content-center mt-4">
        <div class="alert alert-danger w-70" role="alert" style="width: 50rem ;">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon mt-2" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                </div>
                <div>
                    Data anda tidak Lengkap
                    <br>
                    Pastikan sudah memiliki Alamat dan E-wallet
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container d-lg-flex">
        <div class="box-1 bg-light user">
            <div class="d-flex align-items-center mb-3 mt-2">
                <!-- <img src="https://images.pexels.com/photos/4925916/pexels-photo-4925916.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500"
                    class="pic rounded-circle" alt="" /> -->
                <p class="fw-bold fs-3">Detail Produk</p>
            </div>
            <div class="box-inner-1">
                <div class="d-flex justify-content-between mb-3 userdetails">
                    <p class="fw-bold fs-4"><?= $dataProduk['nama_produk'] ?></p>
                </div>
                <!-- <p class="mb-2">
                    Rp. 1200000000
                </p> -->
                <div id="my" class="carousel slide carousel-fade img-details" data-bs-ride="carousel"
                    data-bs-interval="2000">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">
                        <img style="max-width: 100%; max-height: 50vh; margin: auto;" class="rounded-4 fit"
                            src="../assets/foto-produk/<?= $dataProduk['gambar_produk'] ?>" />
                    </div>
                </div>
                <p class="dis my-3 info">
                    <?= $dataProduk['deskripsi'] ?>
                </p>
                <div class="ukuran-kategori mt-6">
                    <p class="dis my-3 info">
                        <b>Ukuran : <?= $dataProduk['ukuran'] ?></b>
                    </p>
                    <p class="dis my-3 info">
                        <b>Kategori : <?= $dataProduk['nama_kategori'] ?></b>
                    </p>
                </div>
            </div>
        </div>
        <div class="box-2">
            <div class="box-inner-2">
                <div>
                    <p class="fw-bold fs-3">Detail Pembayaran</p>
                    <p class="dis mb-3">
                        Selesaikan pembelian Anda dengan memberikan detail pembayaran Anda.
                    </p>
                </div>
                <form action="" method="post">

                    <div class="mb-3">
                        <p class="dis fw-bold mb-2">Nama Lengkap</p>
                        <div class="card w-100 p-2">
                            <?= $dataUser['nama_lengkap'] ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="dis fw-bold mb-2">Email</p>
                        <div class="card w-100 p-2">
                            <?= $dataUser['email'] ?>
                        </div>
                    </div>
                    <div>
                        <p class="dis fw-bold mb-2">Alamat</p>
                        <?php if(isset($dataUser['id_alamat'])): ?>
                        <div class="d-flex align-items-center justify-content-between card-atm border rounded">
                            <div class="card w-100 p-2">
                                <?= $dataUser['nama_lengkap'] ?> | <?= $dataUser['nomor_telepon'] ?>
                                <br>
                                <?= $dataUser['alamat_lengkap'] ?>
                                <br>
                                <?= $dataUser['kota'] ?>, <?= $dataUser['provinsi'] ?>
                                <br>
                                <?= $dataUser['kode_pos'] ?>
                            </div>
                        </div>
                        <?php else: ?>
                        <p class="dis fw-bold mb-2"> &#42; <span class="text-warning">Anda belum
                                menambahkan Alamat. <a href="../pages/profile.php">Tambahkan</a></span></p>
                        <?php endif; ?>
                        <div class="my-3 cardname">
                            <p class="dis fw-bold mb-2">Metode Pembayaran</p>
                            <?php if(isset($dataUser['id_e_wallet'])): ?>
                            <label class="form-selectgroup-item flex-fill">
                                <input type="radio" name="e-wallet" value="<?= $dataUser['username'] ?>"
                                    class="form-selectgroup-input">
                                <div class="form-selectgroup-label d-flex align-items-center p-3">
                                    <div class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </div>
                                    <div class="form-selectgroup-label-content d-flex align-items-center">
                                        <span class="avatar me-3"><svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-wallet" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                                                <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                                            </svg></span>
                                        <div>
                                            <div class="font-weight-medium"><b>E-Wallet</b>
                                                (<?= $dataUser['username'] ?>)</div>
                                            <div class="text-secondary">Rp. <?= $dataUser['jumlah_uang'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <?php else: ?>
                            <p class="dis fw-bold mb-2"> &#42; <span class="text-warning">Anda belum
                                    memiliki E-Wallet. <a href="../pages/profile.php">Tambahkan</a></span></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <!-- di atas ada class address -->
                            <!-- <p class="dis fw-bold mb-3">Billing address</p>
                            <select class="form-select" aria-label="Default select example">
                                <option selected hidden>United States</option>
                                <option value="1">India</option>
                                <option value="2">Australia</option>
                                <option value="3">Canada</option>
                            </select> -->
                            <!-- <div class="d-flex">
                                <input class="form-control zip" type="text" placeholder="ZIP" />
                                <input class="form-control state" type="text" placeholder="State" />
                            </div>
                            <div class="my-3">
                                <p class="dis fw-bold mb-2">VAT Number</p>
                                <div class="inputWithcheck">
                                    <input class="form-control" type="text" value="GB012345B9" />
                                    <span class="fas fa-check"></span>
                                </div>
                            </div> -->
                            <!-- <div class="my-3">
                                <p class="dis fw-bold mb-2">Discount Code</p>
                                <input class="form-control text-uppercase" type="text" value="BLACKFRIDAY"
                                    id="discount" />
                            </div> -->
                            <div class="d-flex flex-column dis mt-5">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p>Harga Produk</p>
                                    <p>Rp. <?= $dataProduk['harga'] ?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p>Jumlah Produk</p>
                                    <p><?= $jumlahProduk ?> x</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p>Subtotal</p>
                                    <p>Rp. <?= $totalJumlahDikaliHarga ?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p>Ongkir</p>
                                    <p><?= $ongkir ?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="fw-bold">Total</p>
                                    <p class="fw-bold">
                                        Rp. <?= $totalPembayaran ?>
                                    </p>
                                </div>
                                <input type="submit" class="btn btn-primary mt-2" value="Beli Sekarang" name="bayar">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if($pembayaranSukses): ?>
    <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-success"></div>
                <div class="modal-body text-center py-4">
                    <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M9 12l2 2l4 -4" />
                    </svg>
                    <h3>Pembayaran Sukses</h3>
                    <div class="text-secondary">Pembayaran anda sebesar Rp. <?= $totalPembayaran ?> berhasil. Produk
                        akan segera diproses.</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a
                                    href="../pages/detail-produk.php?id_produk=<?= $dataProduk['id_produk'] ?>"
                                    class="btn w-100">
                                    Kembali
                                </a></div>
                            <div class="col"><a href="../pages/detail-pembayaran.php" class="btn btn-success w-100">
                                    Detail pembayaran
                                </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
    var valcode = document.querySelector("#discount");
    var namecode = document.querySelector("#code");
    namecode.textContent = valcode.value;

    var closeBtn = document.querySelector(".close");
    var couponCode = document.querySelector(".couponCode");
    closeBtn.addEventListener("click", function() {
        close();
    });
    valcode.addEventListener("change", function() {
        checkDiscountCoupon();
    });

    function checkDiscountCoupon() {
        if (valcode.value.length === 0) {
            // namecode.style.display = "none"
            close();
        } else {
            couponCode.classList.remove("d-none");
            namecode.style.display = "inline";
            namecode.textContent = valcode.value;
        }
    }

    function close() {
        couponCode.classList.add("d-none");
        valcode.value = "";
    }
    </script>
</body>

</html>