<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mini ERP</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            background: #f1f3f7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            width: 100%;
            max-width: 950px;
            display: flex;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        /* LEFT BRAND PANEL */
        .brand-panel {
            background: #1f2937;
            color: white;
            width: 40%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-panel h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .brand-panel p {
            color: #cbd5e1;
            font-size: 14px;
        }

        /* RIGHT LOGIN */
        .login-panel {
            background: white;
            width: 60%;
            padding: 40px;
        }

        .login-title {
            font-weight: 600;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
        }

        .btn-primary {
            background: #2563eb;
            border: none;
            height: 45px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #1e4ed8;
        }

        .input-icon {
            position: absolute;
            top: 12px;
            left: 12px;
            color: #9ca3af;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            padding-left: 35px;
        }

        .footer-text {
            font-size: 13px;
            color: #888;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- LEFT SIDE -->
    <div class="brand-panel">
        <h2>MINI ERP</h2>
        <p>Enterprise Resource Planning System</p>

        <hr>

        <p>
            Manage employees, departments, projects and tasks from one powerful dashboard.
        </p>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-panel">

        <h4 class="login-title">Login to your account</h4>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger p-2 text-center">
                Invalid username or password
            </div>
        <?php endif; ?>

        <form action="src/login_action.php" method="POST">

            <div class="mb-3 input-group">
                <i class="fa fa-user input-icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3 input-group">
                <i class="fa fa-lock input-icon"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">
                Sign In
            </button>
        </form>

        <div class="footer-text">
            © 2026 Mini ERP System
        </div>

    </div>
</div>

</body>
</html>