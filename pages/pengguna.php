<?php require_once "bagian/header-admin.php"; ?>
<?php
require_once "../koneksi/koneksi.php";

$sql = "SELECT id_user, nama_lengkap, email, role, foto_profile, created_at FROM tbl_user";
$ambil = $koneksi->prepare($sql);
$ambil->execute();
$dataUser = $ambil->fetchAll(PDO::FETCH_ASSOC);

// var_dump($dataUser).PHP_EOL;


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
                        Data Pengguna
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Daftar</th>
                                    <th>Role</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dataUser as $dt): ?>
                                <tr>
                                    <td data-label="Name">
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2"
                                                style="background-image: url(../assets/foto-profile/<?= $dt['foto_profile'] ?>)"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium"><?= $dt['nama_lengkap'] ?></div>
                                                <div class="text-secondary"><a href="#"
                                                        class="text-reset"><?= $dt['email'] ?></a></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Title">
                                        <div class="text-secondary"><?= $dt['created_at'] ?></div>
                                    </td>
                                    <td class="text-secondary" data-label="Role">
                                        <?php if($dt['role'] === "1"): ?>
                                        User
                                        <?php elseif($dt['role'] === "2"): ?>
                                        Admin
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td>
                                        <?php if($_SESSION['id_user'] != $dt['id_user']): ?>
                                        <div class="btn-list flex-nowrap">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">
                                                        Edit
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </td> -->
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "bagian/footer.php"; ?>