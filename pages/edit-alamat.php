<?php require_once "bagian/header-profile.php"; ?>
<?php

require_once "../koneksi/koneksi.php";


$idUser = $_SESSION['id_user'];
$ambilAlamat = "SELECT tbl_alamat.alamat_lengkap, tbl_alamat.kota, tbl_alamat.provinsi, tbl_alamat.kode_pos, tbl_alamat.nomor_telepon FROM tbl_user JOIN tbl_alamat ON tbl_user.id_alamat = tbl_alamat.id_alamat WHERE tbl_user.id_user=$idUser";
$ambilAlamatUser = $koneksi->prepare($ambilAlamat);
$ambilAlamatUser->execute();
$dataAlamat = $ambilAlamatUser->fetch(PDO::FETCH_ASSOC);

$gagalMengedit = false;
$berhasilMengedit = false;
if(isset($_POST['edit_alamat'])){
	$idUser = $_SESSION['id_user'];
	$alamat_lengkap = $_POST['alamat_lengkap'];
	$kota = $_POST['kota'];
	$provinsi = $_POST['provinsi'];
	$kode_pos = $_POST['kode_pos'];
	$nomor_telepon = $_POST['nomor_telepon'];

	if(trim(empty($alamat_lengkap)) || trim(empty($kota)) || trim(empty($provinsi)) || trim(empty($kode_pos)) || trim(empty($nomor_telepon))){
		$gagalMengedit = true;
	}else{
		$sql = "UPDATE tbl_alamat SET alamat_lengkap = :alamat_lengkap, kota = :kota, provinsi = :provinsi, kode_pos = :kode_pos, nomor_telepon = :nomor_telepon WHERE id_user = $idUser";
		$tambah = $koneksi->prepare($sql);
		$tambah->bindParam(":alamat_lengkap", $alamat_lengkap);
		$tambah->bindParam(":kota", $kota);
		$tambah->bindParam(":provinsi", $provinsi);
		$tambah->bindParam(":kode_pos", $kode_pos);
		$tambah->bindParam(":nomor_telepon", $nomor_telepon);
		$tambah->execute();
		
		// $idAlamatSekarang = $koneksi->lastInsertId();
		// $tambahAlamatUser = "UPDATE tbl_user SET id_alamat = :id_alamat_sekarang WHERE id_user = $idUser";
		// $tambahAlamat = $koneksi->prepare($tambahAlamatUser);
		// $tambahAlamat->bindParam(":id_alamat_sekarang", $idAlamatSekarang);
		// $tambahAlamat->execute();
		
		$berhasilMengedit = true;
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
            <?php if($gagalMengedit): ?>
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
                        Gagal mengedit alamat
                    </div>
                </div>
            </div>
            <?php elseif($berhasilMengedit): ?>
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
                        Berhasil mengedit alamat
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
                                    <textarea name="alamat_lengkap" id="" cols="40"
                                        rows="7"><?= $dataAlamat['alamat_lengkap'] ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Kota</label>
                                    <p class="card-subtitle">* <span class="text-warning">Kota anda saat ini</span></p>
                                    <input type="text" class="form-control" name="kota" id="kota"
                                        value="<?= $dataAlamat['kota'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <p class="card-subtitle">* <span class="text-warning">Provinsi anda saat ini</span>
                                    </p>
                                    <input type="text" class="form-control" name="provinsi" id="provinsi"
                                        value="<?= $dataAlamat['provinsi'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Kode Pos</label>
                                    <p class="card-subtitle">* <span class="text-warning">Kode Pos Tempat Anda
                                            Tinggaal</span>
                                        <input type="number" class="form-control" name="kode_pos"
                                            value="<?= $dataAlamat['kode_pos'] ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Nomer Telepon</label>
                                    <p class="card-subtitle">* <span class="text-warning">Nomor telepon aktif
                                            anda</span>
                                        <input type="number" class="form-control" name="nomor_telepon"
                                            value="<?= $dataAlamat['nomor_telepon'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="../pages/profile.php" class="btn btn-warning">
                            kembali
                        </a>
                        <button type="submit" class="btn btn-primary" name="edit_alamat">Edit Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>