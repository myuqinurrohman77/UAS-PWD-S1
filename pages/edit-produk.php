<?php require_once "bagian/header-admin.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$idProduk = $_GET['id_produk'];

$sql = "SELECT tbl_produk.id_produk, tbl_produk.nama_produk, tbl_produk.gambar_produk, tbl_produk.harga, tbl_produk.ukuran, tbl_produk.deskripsi, tbl_produk.stok, tbl_kategori.id_kategori, tbl_kategori.nama_kategori FROM tbl_produk JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id_kategori WHERE id_produk=$idProduk";

$dataSebelumUpdate = $koneksi->prepare($sql);
$dataSebelumUpdate->execute();
$dataProdukSebelumUpdate = $dataSebelumUpdate->fetch(PDO::FETCH_ASSOC);

$sqlKategori = "SELECT * FROM tbl_kategori";
$ktgr = $koneksi->prepare($sqlKategori);
$ktgr->execute();
$dataKategori = $ktgr->fetchAll(PDO::FETCH_ASSOC);




$gagalUpdate = false;
$berhasilUpdate = false;

if(isset($_POST['edit_barang'])){
	$namaProduk = $_POST['nama_produk'];
	$gambarProduk = $_FILES['gambar_produk']['name'];
	$hargaProduk = $_POST['harga_produk'];
	$ukuranProduk = $_POST['ukuran_produk'];
	$stokProduk = $_POST['stok_produk'];
	$kategoriProduk = $_POST['kategori_produk'];
	$deskripsiProduk = $_POST['deskripsi_produk'];
	$idKategori = $_POST['kategori_produk'];
	$gambarProdukInfo = $_FILES['gambar_produk'];

	$waktu = date("Y-m-d H:i:s");
	$namaGambar = $gambarProduk;
	$gabungan = md5($namaGambar.$waktu);
	$tipeGambar = substr($gambarProdukInfo['type'], 6, 15);
	$hasilHash = "$gabungan.$tipeGambar";
	
	if((empty($namaProduk) || trim($namaProduk) == "") || (empty($hargaProduk) || trim($hargaProduk) == "") || (empty($stokProduk) || trim($stokProduk) == "") || (empty($kategoriProduk) || trim($kategoriProduk) == "") || (empty($deskripsiProduk) || trim($deskripsiProduk) == "")){
		$gagalUpdate = true;
	}else{
		$berhasilUpdate = true;
		if($gambarProdukInfo['name'] === ""){
			$tambahProduk = "UPDATE tbl_produk SET nama_produk = :nama_produk, harga = :harga, ukuran = :ukuran, deskripsi = :deskripsi, stok = :stok, id_kategori = :id_kategori WHERE tbl_produk.id_produk=$idProduk";
			$tambah = $koneksi->prepare($tambahProduk);
			$tambah->bindParam(":nama_produk", $namaProduk);
			$tambah->bindParam(":harga", $hargaProduk);
			$tambah->bindParam(":ukuran", $ukuranProduk);
			$tambah->bindParam(":deskripsi", $deskripsiProduk);
			$tambah->bindParam(":stok", $stokProduk);
			$tambah->bindParam(":id_kategori", $idKategori);
			$hasil = $tambah->execute();
		}else{

			if(file_exists("../assets/foto-produk/".$dataProdukSebelumUpdate['gambar_produk'])){
				$tambahProduk = "UPDATE tbl_produk SET nama_produk = :nama_produk, gambar_produk = :gambar_produk, harga = :harga, ukuran = :ukuran, deskripsi = :deskripsi, stok = :stok, id_kategori = :id_kategori WHERE tbl_produk.id_produk=$idProduk";
				$tambah = $koneksi->prepare($tambahProduk);
				$tambah->bindParam(":nama_produk", $namaProduk);
				$tambah->bindParam(":gambar_produk", $hasilHash);
				$tambah->bindParam(":harga", $hargaProduk);
				$tambah->bindParam(":ukuran", $ukuranProduk);
				$tambah->bindParam(":deskripsi", $deskripsiProduk);
				$tambah->bindParam(":stok", $stokProduk);
				$tambah->bindParam(":id_kategori", $idKategori);
				$hasil = $tambah->execute();
				move_uploaded_file($gambarProdukInfo['tmp_name'], "../assets/foto-produk/".$hasilHash);
				unlink("../assets/foto-produk/".$dataProdukSebelumUpdate['gambar_produk']);
			}else{
				var_dump($dataProdukSebelumUpdate['gambar_produk']).PHP_EOL;
			}
		}
	}
}



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
                        Tambah Produk
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($gagalUpdate): ?>
            <div class="alert alert-danger" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>
                    </div>
                    <div>
                        Gagal mengedit produk
                    </div>
                </div>
            </div>
            <?php elseif($berhasilUpdate): ?>
            <div class="alert alert-success" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l5 5l10 -10" />
                        </svg>
                    </div>
                    <div>
                        Berhasil mengedit produk
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <form class="card" method="post" action="" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_produk"
                                        value="<?= $dataProdukSebelumUpdate['nama_produk'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" class="form-control" name="gambar_produk"
                                        value="<?= $dataProdukSebelumUpdate['gambar_produk'] ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="harga_produk"
                                        value="<?= $dataProdukSebelumUpdate['harga'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok_produk"
                                        value="<?= $dataProdukSebelumUpdate['stok'] ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select" id="select-users" value="" name="kategori_produk">
                                        <?php $idKategoriSekarang = $dataProdukSebelumUpdate['id_kategori'] ?>
                                        <?php foreach($dataKategori as $dtkategori): ?>
                                        <option value="<?= $dtkategori['id_kategori'] ?>"
                                            <?= $dtkategori['id_kategori'] == $idKategoriSekarang ? "selected" : "" ?>>
                                            <?= $dtkategori['nama_kategori'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Ukuran</label>
                                    <input type="text" class="form-control" name="ukuran_produk"
                                        value="<?= $dataProdukSebelumUpdate['ukuran'] ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 mb-0">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea rows="5" class="form-control"
                                        name="deskripsi_produk"><?= $dataProdukSebelumUpdate['deskripsi'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/produk.php" class="btn btn-warning">
                            kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="edit_barang">Edit barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>