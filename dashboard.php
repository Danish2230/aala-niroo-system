<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// دریافت تعداد دارایی‌ها
$stmt_assets = $pdo->query("SELECT COUNT(*) as total_assets FROM assets");
$total_assets = $stmt_assets->fetch()['total_assets'];

// دریافت تعداد مشتریان
$stmt_customers = $pdo->query("SELECT COUNT(*) as total_customers FROM customers");
$total_customers = $stmt_customers->fetch()['total_customers'];

// دریافت تعداد کاربران
$stmt_users = $pdo->query("SELECT COUNT(*) as total_users FROM users");
$total_users = $stmt_users->fetch()['total_users'];
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد - سامانه مدیریت اعلا نیرو</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">اعلا نیرو</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">داشبورد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assets.php">مدیریت دارایی‌ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customers.php">مدیریت مشتریان</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">مدیریت کاربران</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php">گزارش‌ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">خروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">داشبورد مدیریت</h1>
        <p class="text-center">به سامانه مدیریت شرکت <strong>اعلا نیرو</strong> خوش آمدید.</p>

        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">تعداد دارایی‌ها</h5>
                        <p class="card-text display-4"><?php echo $total_assets; ?></p>
                        <a href="assets.php" class="btn btn-primary">مشاهده دارایی‌ها</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">تعداد مشتریان</h5>
                        <p class="card-text display-4"><?php echo $total_customers; ?></p>
                        <a href="customers.php" class="btn btn-primary">مشاهده مشتریان</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">تعداد کاربران</h5>
                        <p class="card-text display-4"><?php echo $total_users; ?></p>
                        <a href="users.php" class="btn btn-primary">مشاهده کاربران</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
