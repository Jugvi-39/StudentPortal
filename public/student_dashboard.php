<?php
session_start();
require_once '../private/includes/databaseconnection.php';
require_once '../private/student/student.class.php';
require_once '../private/config/database.php';

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$config = include '../private/config/database.php';
$student = new Student($config);
$student_info = $student->getStudentById($student_id);
if (!$student_info) {
    session_destroy();
    header("Location: student_login.php");
    exit();
}
$error_message = '';
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_profile'])) {
    $student_name = trim($_POST['student_name']);
    $student_email = trim($_POST['student_email']);
    $student_dept = trim($_POST['student_dept']);
    $student_gender = $_POST['student_gender'];
    $student_contact = trim($_POST['student_contact']);
    $student_address = trim($_POST['student_address']);
    $student_birthday = $_POST['student_birthday'];
    if (empty($student_name) || empty($student_email)) {
        $error_message = "Name and email are required.";
    } elseif (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        $update_result = $student->updateStudentProfile(
            $student_id, $student_name, $student_email, $student_dept, $student_gender, $student_contact, $student_address
        );
        if ($update_result) {
            $success_message = "Profile updated successfully!";
            $student_info = $student->getStudentById($student_id);
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message = "All password fields are required.";
    } elseif ($new_password !== $confirm_new_password) {
        $error_message = "New passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        $error_message = "New password must be at least 6 characters long.";
    } else {
        $change_result = $student->changePassword($student_id, $current_password, $new_password);
        if ($change_result) {
            $success_message = "Password changed successfully!";
        } else {
            $error_message = "Failed to change password. Please check your current password.";
        }
    }
}
include 'includes/header.php';
?>
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="welcome-section card mb-4 p-4" style="border-color:#ff6f00; background:#fff;">
                <div class="text-center">
                    <h1 class="fw-bold mb-2" style="color:#1a237e;">
                        <i class="fas fa-graduation-cap me-3"></i>
                        Welcome, <?php echo htmlspecialchars($student_info['name']); ?>!
                    </h1>
                    <p class="mb-0" style="color:#1a237e;">Student ID: <?php echo htmlspecialchars($student_info['st_id']); ?></p>
                </div>
            </div>
            <div class="dashboard-card card mb-4 p-4">
                <h3 class="mb-4" style="color:#1a237e;">
                    <i class="fas fa-user me-2"></i>Your Profile Information
                </h3>
                <div class="profile-info">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-id-card me-2"></i>Student ID:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['st_id']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-user me-2"></i>Full Name:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['name']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-envelope me-2"></i>Email:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['email']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-graduation-cap me-2"></i>Program:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['program']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-phone me-2"></i>Contact:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['contact']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-venus-mars me-2"></i>Gender:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['gender']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-birthday-cake me-2"></i>Date of Birth:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['bday']); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-map-marker-alt me-2"></i>Address:</strong>
                            <p class="mb-0"><?php echo htmlspecialchars($student_info['address']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-card card mb-4 p-4">
                <h3 class="mb-4" style="color:#1a237e;">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center p-3" style="border-color:#ff6f00;">
                            <div class="card-body">
                                <i class="fas fa-edit fa-3x mb-3 feature-icon"></i>
                                <h5 class="card-title" style="color:#1a237e;">Edit Profile</h5>
                                <p class="card-text">Update your personal information</p>
                                <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    Edit Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center p-3" style="border-color:#ff6f00;">
                            <div class="card-body">
                                <i class="fas fa-key fa-3x mb-3 feature-icon"></i>
                                <h5 class="card-title" style="color:#1a237e;">Change Password</h5>
                                <p class="card-text">Update your account password</p>
                                <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center p-3" style="border-color:#ff6f00;">
                            <div class="card-body">
                                <i class="fas fa-sign-out-alt fa-3x mb-3 feature-icon"></i>
                                <h5 class="card-title" style="color:#1a237e;">Logout</h5>
                                <p class="card-text">Sign out of your account</p>
                                <a href="logout.php" class="btn btn-secondary-custom">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student_info['name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="student_email" name="student_email" value="<?php echo htmlspecialchars($student_info['email']); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_dept" class="form-label">Program/Department</label>
                            <input type="text" class="form-control" id="student_dept" name="student_dept" value="<?php echo htmlspecialchars($student_info['program']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_gender" class="form-label">Gender</label>
                            <select class="form-control" id="student_gender" name="student_gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo ($student_info['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($student_info['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($student_info['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_contact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="student_contact" name="student_contact" value="<?php echo htmlspecialchars($student_info['contact']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_birthday" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="student_birthday" name="student_birthday" value="<?php echo $student_info['bday']; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="student_address" class="form-label">Address</label>
                        <textarea class="form-control" id="student_address" name="student_address" rows="3"><?php echo htmlspecialchars($student_info['address']); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_profile" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-key me-2"></i>Change Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="change_password" class="btn btn-orange">
                        <i class="fas fa-key me-2"></i>Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
