<?php require_once "bagian/header-admin.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$gagalMenambahkan = false;
$berhasilMenambahkan = false;

if(isset($_POST['tambah_gambar'])){
	$gambar = $_FILES['gambar_galeri'];
	if(trim($gambar['name']) === ""){
		$gagalMenambahkan = true;
	}else{
		$date = date("Y-m-d H:i:s");
		$namaGambar = $gambar['name'];
		$gabungan = $namaGambar.$date;
		$hasilHashing = md5($gabungan);

		$tipeGambar = substr($gambar['type'], 6, 15);

		$hasil = "$hasilHashing.$tipeGambar";
		
		$sql = "INSERT INTO tbl_galeri (nama_gambar) VALUES (:nama_gambar)";
		$tambah = $koneksi->prepare($sql);
		$tambah->bindParam(":nama_gambar", $hasil);
		$tambah->execute();
		move_uploaded_file($gambar['tmp_name'], "../assets/galeri/".$hasil);
		$berhasilMenambahkan = true;
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
                        Tambah Gambar Galeri
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($gagalMenambahkan): ?>
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
                        Gagal menambahkan gambar
                    </div>
                </div>
            </div>
            <?php elseif($berhasilMenambahkan): ?>
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
                        Berhasil menambahkan gambar
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <form class="card" method="post" action="" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-sm-6 col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" class="form-control" name="gambar_galeri" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/galeri.php" class="btn btn-warning">
                            kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="tambah_gambar">Tambahkan foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>