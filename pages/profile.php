<?php require_once "bagian/header-profile.php"; ?>
<?php 

require_once "../koneksi/koneksi.php";

$idUser = $_SESSION['id_user'];
$sql = "SELECT * FROM tbl_user WHERE id_user=$idUser";
$data = $koneksi->prepare($sql);
$data->execute();
$dataUser = $data->fetch(PDO::FETCH_ASSOC);

$ambilAlamat = "SELECT tbl_alamat.alamat_lengkap, tbl_alamat.kota, tbl_alamat.provinsi, tbl_alamat.kode_pos, tbl_alamat.nomor_telepon FROM tbl_user JOIN tbl_alamat ON tbl_user.id_alamat = tbl_alamat.id_alamat WHERE tbl_user.id_user=$idUser";
$ambilAlamatUser = $koneksi->prepare($ambilAlamat);
$ambilAlamatUser->execute();
$dataAlamat = $ambilAlamatUser->fetch(PDO::FETCH_ASSOC);
// var_dump($dataAlamat).PHP_EOL;

$uang = "SELECT tbl_e_wallet.jumlah_uang FROM tbl_user JOIN tbl_e_wallet ON tbl_user.id_e_wallet = tbl_e_wallet.id_e_wallet WHERE tbl_user.id_user = $idUser";
$uangUser = $koneksi->prepare($uang);
$uangUser->execute();
$dataUang = $uangUser->fetch(PDO::FETCH_ASSOC);

// var_dump($dataUang['jumlah_uang']).PHP_EOL;

// if(isset($dataUang['jumlah_uang']) && $dataUang['jumlah_uang'] !== NULL){
// 	var_dump($dataUang['jumlah_uang']).PHP_EOL;
// }else{
// 	echo "Uang kosong";
// }

?>
<div class="page-wrapper">
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Akun Saya</h2>
                            <h3 class="card-title">Detail Profile Pengguna</h3>
                            <div class="row align-items-center">
                                <div class="col-auto"><span class="avatar avatar-xl"
                                        style="background-image: url(../assets/foto-profile/<?= $_SESSION['foto_profile'] ?>)"></span>
                                </div>
                            </div>
                            <h3 class="card-title mt-4">Nama Lengkap</h3>
                            <div>
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" class="form-control w-auto"
                                            value="<?= $_SESSION['nama_lengkap'] ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title mt-4">Email</h3>
                            <p class="card-subtitle">This contact will be shown to others publicly, so choose it
                                carefully.</p>
                            <div>
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" class="form-control w-auto" value="<?= $_SESSION['email'] ?>"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title mt-4">E-Wallet</h3>
                            <?php if(!(isset($dataUser['id_e_wallet']))): ?>
                            <p class="card-subtitle text-danger"><b>E-Wallet belum dihubungkan</b></p>
                            <a href="masuk-e-wallet.php" class="btn btn-primary">Hubungkan E-Wallet</a>
                            <?php else: ?>
                            <h3>Uang E-Wallet Anda : Rp.
                                <?= (is_null($dataUang['jumlah_uang']) || $dataUang['jumlah_uang'] == "") ? "0" : $dataUang['jumlah_uang'] ?>
                            </h3>
                            <a href="top-up-e-wallet.php" class="btn btn-primary">Top Up E-Wallet</a>
                            <?php endif; ?>

                            <h3 class="card-title mt-4">Alamat</h3>
                            <?php if(!(isset($dataUser['id_alamat']))): ?>
                            <p class="card-subtitle text-danger"><b>Alamat belum ditambahkan</b></p>
                            <a href="tambah-alamat.php" class="btn btn-primary">Tambahkan Alamat</a>
                            <?php else: ?>
                            <div>
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <textarea name="alamat" id="" disabled cols="40" rows="8">
<?= $dataAlamat['alamat_lengkap'] ?>
														  <?= $dataAlamat['kota'] ?>
														  <?= $dataAlamat['provinsi'] ?>
														  <?= $dataAlamat['kode_pos'] ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- <h3>TEST</h3> -->
                            <h3 class="card-title mt-4">Informasi</h3>
                            <p class="card-subtitle">Pastikan anda selalu mengganti password anda setiap sebulan sekali,
                                untuk menghindari pencurian data.</p>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="beranda.php" class="btn">
                                    Kembali
                                </a>
                                <a href="edit-profile.php" class="btn btn-primary">
                                    Edit
                                </a>
                                <a href="bagian/logout.php" class="btn btn-warning">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "bagian/footer.php"; ?>