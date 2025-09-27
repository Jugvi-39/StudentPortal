<?php
session_start();
require_once '../private/includes/databaseconnection.php';
require_once '../private/student/student.class.php';
require_once '../private/config/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['student_login'])) {
    $student_id = $_POST['student_id'];
    $student_password = $_POST['student_password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;
    
    if (empty($student_id) || empty($student_password)) {
        $error_message = "Please fill in all fields.";
    } else {
        $config = include '../private/config/database.php';
        $student = new Student($config);
        $login_result = $student->loginStudent($student_id, $student_password);
        
        if ($login_result) {
            if ($remember_me) {
                setcookie('remember_student', $student_id, time() + (86400 * 30), '/');
            }
            
            header("Location: student_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid student ID or password.";
        }
    }
}

if (isset($_COOKIE['remember_student']) && !isset($_SESSION['student_logged_in'])) {
    $config = include '../private/config/database.php';
    $student = new Student($config);
    $student_id = $_COOKIE['remember_student'];
    $_SESSION['student_logged_in'] = true;
    $_SESSION['student_id'] = $student_id;
    header("Location: student_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
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
        <div class="col-md-6 col-lg-4">
            <div class="login-card card p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-graduation-cap fa-3x mb-3 feature-icon"></i>
                    <h2 class="fw-bold" style="color:#1a237e;">Student Login</h2>
                    <p class="text-muted">Welcome back! Please sign in to continue.</p>
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
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">
                            <i class="fas fa-id-card me-2"></i>Student ID
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="student_id" 
                               name="student_id" 
                               placeholder="Enter your Student ID"
                               value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="student_password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="student_password" 
                               name="student_password" 
                               placeholder="Enter your password"
                               required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" 
                               class="form-check-input" 
                               id="remember_me" 
                               name="remember_me">
                        <label class="form-check-label" for="remember_me">
                            Remember me for 30 days
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" 
                                name="student_login" 
                                class="btn btn-primary-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-2">Don't have an account?</p>
                    <a href="student_register.php" class="btn btn-secondary-custom">
                        <i class="fas fa-user-plus me-2"></i>Register Here
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
