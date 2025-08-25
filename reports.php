<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// دریافت داده‌ها برای گزارش
$stmt_assets = $pdo->query("SELECT * FROM assets ORDER BY id DESC");
$assets = $stmt_assets->fetchAll();

$stmt_customers = $pdo->query("SELECT * FROM customers ORDER BY id DESC");
$customers = $stmt_customers->fetchAll();
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش‌ها - اعلا نیرو</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="dashboard.php">داشبورد</a>
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
                        <a class="nav-link active" href="reports.php">گزارش‌ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">خروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">گزارش‌های سیستم</h2>

        <!-- گزارش دارایی‌ها -->
        <div class="card mt-4">
            <div class="card-header">گزارش دارایی‌ها</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام دستگاه</th>
                            <th>شماره سریال</th>
                            <th>تاریخ خرید</th>
                            <th>وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td><?php echo $asset['id']; ?></td>
                            <td><?php echo $asset['name']; ?></td>
                            <td><?php echo $asset['serial_number']; ?></td>
                            <td><?php echo $asset['purchase_date']; ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    if ($asset['status'] == 'فعال') echo 'success';
                                    elseif ($asset['status'] == 'غیرفعال') echo 'danger';
                                    else echo 'warning';
                                ?>">
                                    <?php echo $asset['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- گزارش مشتریان -->
        <div class="card mt-5">
            <div class="card-header">گزارش مشتریان</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام کامل</th>
                            <th>تلفن</th>
                            <th>شرکت</th>
                            <th>آدرس</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['id']; ?></td>
                            <td><?php echo $customer['full_name']; ?></td>
                            <td><?php echo $customer['phone']; ?></td>
                            <td><?php echo $customer['company']; ?></td>
                            <td><?php echo substr($customer['address'], 0, 50); ?>...</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
