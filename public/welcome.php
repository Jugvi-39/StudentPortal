<?php
$title_name = "Welcome to Student Portal";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: #1a237e;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        .welcome-quote {
            font-size: 1.5rem;
            font-style: italic;
            margin: 3rem 0;
            color: #1a237e;
            text-align: center;
            font-weight: 500;
        }
        .card-container {
            padding: 3rem 0;
        }
        .welcome-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 2px solid #ff6f00;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .welcome-card:hover {
            transform: translateY(-5px);
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
            transform: translateY(-2px);
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
            transform: translateY(-2px);
        }
        .feature-icon {
            background: #1a237e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.5rem;
            width: 80px;
            height: 80px;
        }
        .card-title {
            color: #1a237e;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .card-text {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .navbar {
            background: #1a237e !important;
        }
        .navbar .navbar-brand, .navbar .nav-link, .navbar .navbar-brand:visited {
            color: white !important;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .navbar .nav-link.active, .navbar .nav-link:focus, .navbar .nav-link:hover {
            color: #ff6f00 !important;
        }
        .btn-primary-custom {
            background: #1a237e;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 28px;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            background: #111a5c;
            color: white;
        }
        .btn-secondary-custom {
            background: white;
            color: #1a237e;
            border: 2px solid #1a237e;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 28px;
            transition: all 0.2s;
        }
        .btn-secondary-custom:hover {
            background: #1a237e;
            color: white;
        }
        .btn-orange {
            background: #ff6f00;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-orange:hover {
            background: #e65100;
            color: white;
            transform: translateY(-2px);
        }
        .footer {
            background: #1a237e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="welcome.php">
                <i class="fas fa-graduation-cap me-2"></i>
                Student Portal
            </a>
            <div class="navbar-nav ms-auto">
                <a class="btn btn-primary-custom" href="student_login.php">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <main>
        <div class="hero-section">
            <div class="container">
                <h1 class="hero-title">Welcome to Student Portal</h1>
                <p class="hero-subtitle">Your gateway to academic excellence and seamless learning</p>
            </div>
        </div>

        <div class="container">
            <div class="welcome-quote">
                <i class="fas fa-quote-left me-2"></i>
                "Education is the passport to the future, for tomorrow belongs to those who prepare for it today."
                <i class="fas fa-quote-right ms-2"></i>
            </div>

            <div class="card-container">
                <div class="row justify-content-center">
                    <div class="col-md-5 mb-4">
                        <div class="welcome-card">
                            <div class="feature-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h3 class="card-title">For Students</h3>
                            <p class="card-text">Access your academic profile, manage your information, and stay connected with your educational journey.</p>
                            <a href="student_register.php" class="btn btn-orange">
                                <i class="fas fa-rocket me-2"></i>Get Started
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5 mb-4">
                        <div class="welcome-card">
                            <div class="feature-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h3 class="card-title">For Administrators</h3>
                            <p class="card-text">Manage student records, oversee academic data, and maintain the portal with administrative tools.</p>
                            <a href="admin.php" class="btn btn-secondary-custom">
                                <i class="fas fa-cog me-2"></i>Admin Panel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Student Portal. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>