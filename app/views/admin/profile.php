<?php require APPROOT . '/views/admin/header.php'; ?>
<!-- Main Content -->
<main id="main" class="profile-page">
    <div class="container mt-5">
        <!-- Profile Header -->
        <div class="profile-header">
            <!-- Background Image -->
            <div class="background-image position-relative">
                <img src="<?php echo URLROOT; ?>/public/images/bg.webp" alt="Background" class="img-fluid">
                <button class="btn btn-secondary edit-bg-btn position-absolute top-0 end-0 m-2" data-bs-toggle="modal" data-bs-target="#editBgModal">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>

            <!-- Profile Image -->
            <div class="profile-image-container position-relative">
                <img src="<?php echo URLROOT; ?>/public/images/profile.jpg" alt="Profile Picture" class="profile-image">
                <button class="btn btn-secondary edit-profile-img-btn position-absolute bottom-0 start-50 translate-middle-x" data-bs-toggle="modal" data-bs-target="#editProfileImgModal">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>
        </div>

        <div class="container mt-4">
            <div class="card p-1 shadow-lg" style="background-color: #f8f9fa; border-radius: 10px;">
                <!-- Profile Info -->
                <div class="profile-info">
                    <div class=" align-items-center">
                        <h2 class="user-name mb-0"><?php echo $_SESSION['sessionData']['userName'] ?></h2>
                        <p class="user-email mb-0">Email: <?php echo $_SESSION['sessionData']['userEmail'] ?></p>
                    </div>
                    <p class="user-role mt-3">Role: <?php echo ucwords($_SESSION['sessionData']['role']) ?></p>
                    <button class="btn btn-primary reset-password-btn m-3" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                        Reset Password
                    </button>
                </div>
            </div>
        </div>


    </div>
    <!-- Edit Background Modal -->
    <div class="modal fade" id="editBgModal" tabindex="-1" aria-labelledby="editBgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBgModalLabel">Edit Background</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo URLROOT; ?>/profile/upload_background" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="file" name="background_image" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Image Modal -->
    <div class="modal fade" id="editProfileImgModal" tabindex="-1" aria-labelledby="editProfileImgModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileImgModalLabel">Edit Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo URLROOT; ?>/profile/upload_profile_image" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="file" name="profile_image" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo URLROOT; ?>/profile/reset_password" method="POST">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="currentPassword" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="newPassword" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


<?php require APPROOT . '/views/admin/footer.php'; ?>