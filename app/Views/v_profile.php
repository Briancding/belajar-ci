<?= $this->extend('Layout') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body pt-3">
        <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">
                    Profile Information
                </h5>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label text-primary fw-bold">
                        Username
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <?php echo $username; ?>
                        <span class="badge bg-danger ms-1"><?php echo $role; ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label text-primary fw-bold">
                        Email
                    </div>
                    <div class="col-lg-9 col-md-8 text-primary">
                        <?php echo $email; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label text-primary fw-bold">
                        Login Time
                    </div>
                    <div class="col-lg-9 col-md-8 text-secondary">
                        <?php echo $loginTime; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 label text-primary fw-bold">
                           Login Status
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <span class="badge bg-success py-2 px-3">
                            <i class="bi bi-check-circle me-1"></i> Sudah Login
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>