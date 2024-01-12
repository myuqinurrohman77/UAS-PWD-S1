<?php require_once "bagian/header-admin.php"; ?>
<?php 

require_once "../koneksi/koneksi.php";

$kategoriKosong = false;
$kategoriBerhasilDitambahkan = false;
if(isset($_POST['tambah_kategori'])){
	if(trim($_POST['kategori']) == "" || empty($_POST['kategori'])){
		$kategoriKosong = true;
	}else{
		$kategori = $_POST['kategori'];
		$sql = "INSERT INTO tbl_kategori (nama_kategori) VALUES (:kategori_input)";
		$tambah = $koneksi->prepare($sql);
		$tambah->bindParam(':kategori_input', $kategori);
		$hasil = $tambah->execute();

		if($hasil){
			$kategoriBerhasilDitambahkan = true;
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
                        Tambah Kategori
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <?php if($kategoriKosong): ?>
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
                        Gagal menambahkan kategori
                    </div>
                </div>
            </div>
            <?php elseif($kategoriBerhasilDitambahkan): ?>
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
                        berhasil menambahkan kategori
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <form class="card" method="post" action="">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" name="kategori">
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Harga</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/kategori.php" class="btn btn-warning">
                            kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="tambah_kategori">Tambahkan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>