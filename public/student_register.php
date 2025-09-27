<?php
session_start();
require_once '../private/includes/databaseconnection.php';
require_once '../private/student/student.class.php';
require_once '../private/config/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['student_register'])) {
    $student_id = trim($_POST['student_id']);
    $student_name = trim($_POST['student_name']);
    $student_email = trim($_POST['student_email']);
    $student_password = $_POST['student_password'];
    $confirm_password = $_POST['confirm_password'];
    $student_dept = trim($_POST['student_dept']);
    $student_gender = $_POST['student_gender'];
    $student_contact = trim($_POST['student_contact']);
    $student_address = trim($_POST['student_address']);
    $student_birthday = $_POST['student_birthday'];
    
    if (empty($student_id) || empty($student_name) || empty($student_email) || empty($student_password)) {
        $error_message = "Please fill in all required fields.";
    } elseif ($student_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($student_password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } elseif (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        $config = include '../private/config/database.php';
        $student = new Student($config);
        $registration_result = $student->registerNewStudent(
            $student_id, 
            $student_name, 
            $student_password, 
            $student_email, 
            $student_birthday, 
            $student_dept, 
            $student_contact, 
            $student_gender, 
            $student_address
        );
        
        if ($registration_result) {
            $success_message = "Registration successful! You can now login.";
        } else {
            $error_message = "Registration failed. Student ID or email might already exist.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: 2px solid #ff6f00;
        }
        .feature-icon {
            width: 50px;
            height: 50px;
            background: #1a237e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        .btn-primary-custom {
            background: #1a237e;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background: #111a5c;
            color: white;
        }
        .btn-secondary-custom {
            background: white;
            border: 2px solid #1a237e;
            color: #1a237e;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-secondary-custom:hover {
            background: #1a237e;
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="register-card card p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus fa-3x mb-3 feature-icon"></i>
                    <h2 class="fw-bold" style="color:#1a237e;">Student Registration</h2>
                    <p class="text-muted">Create your student account to get started.</p>
                </div>

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
                        <br><a href="student_login.php" class="btn btn-secondary-custom mt-2">Login Now</a>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_id" class="form-label">
                                <i class="fas fa-id-card me-2"></i>Student ID *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="student_id" 
                                   name="student_id" 
                                   placeholder="Enter Student ID"
                                   value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="student_name" class="form-label">
                                <i class="fas fa-user me-2"></i>Full Name *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="student_name" 
                                   name="student_name" 
                                   placeholder="Enter your full name"
                                   value="<?php echo isset($_POST['student_name']) ? htmlspecialchars($_POST['student_name']) : ''; ?>"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email Address *
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="student_email" 
                                   name="student_email" 
                                   placeholder="Enter your email"
                                   value="<?php echo isset($_POST['student_email']) ? htmlspecialchars($_POST['student_email']) : ''; ?>"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="student_contact" class="form-label">
                                <i class="fas fa-phone me-2"></i>Contact Number
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="student_contact" 
                                   name="student_contact" 
                                   placeholder="Enter contact number"
                                   value="<?php echo isset($_POST['student_contact']) ? htmlspecialchars($_POST['student_contact']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password *
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="student_password" 
                                   name="student_password" 
                                   placeholder="Enter password (min 6 characters)"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirm Password *
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   placeholder="Confirm your password"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_dept" class="form-label">
                                <i class="fas fa-graduation-cap me-2"></i>Program/Department
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="student_dept" 
                                   name="student_dept" 
                                   placeholder="Enter your program"
                                   value="<?php echo isset($_POST['student_dept']) ? htmlspecialchars($_POST['student_dept']) : ''; ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="student_gender" class="form-label">
                                <i class="fas fa-venus-mars me-2"></i>Gender
                            </label>
                            <select class="form-control" id="student_gender" name="student_gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo (isset($_POST['student_gender']) && $_POST['student_gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo (isset($_POST['student_gender']) && $_POST['student_gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo (isset($_POST['student_gender']) && $_POST['student_gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="student_birthday" class="form-label">
                            <i class="fas fa-birthday-cake me-2"></i>Date of Birth
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="student_birthday" 
                               name="student_birthday"
                               value="<?php echo isset($_POST['student_birthday']) ? $_POST['student_birthday'] : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="student_address" class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>Address
                        </label>
                        <textarea class="form-control" 
                                  id="student_address" 
                                  name="student_address" 
                                  rows="3" 
                                  placeholder="Enter your address"><?php echo isset($_POST['student_address']) ? htmlspecialchars($_POST['student_address']) : ''; ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" 
                                name="student_register" 
                                class="btn btn-primary-custom">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-2">Already have an account?</p>
                    <a href="student_login.php" class="btn btn-secondary-custom">
                        <i class="fas fa-sign-in-alt me-2"></i>Login Here
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="welcome.php" class="text-muted">
                        <i class="fas fa-arrow-left me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
