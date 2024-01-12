<?php require_once "bagian/header-profile.php"; ?>
<?php

require_once "../koneksi/koneksi.php";

$gagalMenambahkan = false;
$berhasilMenambahkan = false;

// var_dump($_SESSION['id_user']).PHP_EOL;

if(isset($_POST['tambah_alamat'])){
	$idUser = $_SESSION['id_user'];
	$alamat_lengkap = $_POST['alamat_lengkap'];
	$kota = $_POST['kota'];
	$provinsi = $_POST['provinsi'];
	$kode_pos = $_POST['kode_pos'];
	$nomor_telepon = $_POST['nomor_telepon'];

	if(trim(empty($alamat_lengkap)) || trim(empty($kota)) || trim(empty($provinsi)) || trim(empty($kode_pos)) || trim(empty($nomor_telepon))){
		$gagalMenambahkan = true;
	}else{
		$sql = "INSERT INTO tbl_alamat (id_user, alamat_lengkap, kota, provinsi, kode_pos, nomor_telepon) VALUES (:id_user, :alamat_lengkap, :kota, :provinsi, :kode_pos, :nomor_telepon)";
		$tambah = $koneksi->prepare($sql);
		$tambah->bindParam(":id_user", $idUser);
		$tambah->bindParam(":alamat_lengkap", $alamat_lengkap);
		$tambah->bindParam(":kota", $kota);
		$tambah->bindParam(":provinsi", $provinsi);
		$tambah->bindParam(":kode_pos", $kode_pos);
		$tambah->bindParam(":nomor_telepon", $nomor_telepon);
		$tambah->execute();
		
		$idAlamatSekarang = $koneksi->lastInsertId();
		$tambahAlamatUser = "UPDATE tbl_user SET id_alamat = :id_alamat_sekarang WHERE id_user = $idUser";
		// $tambahAlamatUser = "INSERT INTO tbl_user (id_alamat) VALUES (:id_alamat_sekarang) WHERE id_user=$idUser";
		$tambahAlamat = $koneksi->prepare($tambahAlamatUser);
		$tambahAlamat->bindParam(":id_alamat_sekarang", $idAlamatSekarang);
		$tambahAlamat->execute();
		
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
                        Tambah Alamat Pengguna
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
                        Gagal menambahkan alamat
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
                        Berhasil menambahkan alamat
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
                                    <label class="form-label">Alamat Lengkap Sekitar</label>
                                    <p class="card-subtitle">* <span class="text-warning">Jalan, Kampung, RT/RW</span>
                                    </p>
                                    <textarea name="alamat_lengkap" id="" cols="50" rows="7"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Kota</label>
                                    <p class="card-subtitle">* <span class="text-warning">Kota anda saat ini</span></p>
                                    <input type="text" class="form-control" name="kota" id="kota">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <p class="card-subtitle">* <span class="text-warning">Provinsi anda saat ini</span>
                                    </p>
                                    <input type="text" class="form-control" name="provinsi" id="provinsi">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Kode Pos</label>
                                    <p class="card-subtitle">* <span class="text-warning">Kode Pos Tempat Anda
                                            Tinggal</span>
                                        <input type="number" class="form-control" name="kode_pos">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Nomer Telepon</label>
                                    <p class="card-subtitle">* <span class="text-warning">Nomor telepon aktif
                                            anda</span>
                                        <input type="number" class="form-control" name="nomor_telepon">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/profile.php" class="btn btn-warning">
                            kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="tambah_alamat">Tambahkan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $
    </script>
    <?php require_once "bagian/footer.php"; ?>