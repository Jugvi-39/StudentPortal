<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a237e;
            --secondary: #fff;
            --accent: #ff6f00;
        }
        body {
            background: var(--secondary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #0d1421 !important;
        }
        .navbar .navbar-brand, .navbar .nav-link, .navbar .navbar-brand:visited {
            color: var(--secondary) !important;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .navbar .nav-link.active, .navbar .nav-link:focus, .navbar .nav-link:hover {
            color: var(--accent) !important;
        }
        .btn-primary-custom {
            background: var(--primary);
            color: var(--secondary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 28px;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            background: #111a5c;
            color: var(--secondary);
        }
        .btn-secondary-custom {
            background: var(--secondary);
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 28px;
            transition: all 0.2s;
        }
        .btn-secondary-custom:hover {
            background: var(--primary);
            color: var(--secondary);
        }
        .btn-orange {
            background: var(--accent);
            color: var(--secondary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 28px;
            transition: all 0.2s;
        }
        .btn-orange:hover {
            background: #e65100;
            color: var(--secondary);
        }
        .card, .welcome-card, .dashboard-card, .feature-card {
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 2px solid var(--accent);
        }
        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        .error-message {
            margin-top: 5px;
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
            <?php if (!isset($_SESSION['student_logged_in']) && !isset($_SESSION['admin_logged_in'])): ?>
            <div class="navbar-nav ms-auto">
                <a class="btn btn-primary-custom" href="student_login.php">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <main>