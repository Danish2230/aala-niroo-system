<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// افزودن دارایی جدید
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_asset'])) {
    $name = $_POST['name'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO assets (name, serial_number, purchase_date, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $serial_number, $purchase_date, $status]);
    $success = "دارایی با موفقیت افزوده شد!";
}

// حذف دارایی
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM assets WHERE id = ?");
    $stmt->execute([$delete_id]);
    $success = "دارایی با موفقیت حذف شد!";
}

// دریافت کلیه دارایی‌ها
$stmt = $pdo->query("SELECT * FROM assets ORDER BY id DESC");
$assets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت دارایی‌ها - اعلا نیرو</title>
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
                        <a class="nav-link active" href="assets.php">مدیریت دارایی‌ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customers.php">مدیریت مشتریان</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">خروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">مدیریت دارایی‌ها</h2>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- فرم افزودن دارایی -->
        <div class="card mt-4">
            <div class="card-header">افزودن دارایی جدید</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">نام دستگاه:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="serial_number" class="form-label">شماره سریال:</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">تاریخ خرید:</label>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">وضعیت:</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="فعال">فعال</option>
                            <option value="غیرفعال">غیرفعال</option>
                            <option value="در حال تعمیر">در حال تعمیر</option>
                        </select>
                    </div>
                    <button type="submit" name="add_asset" class="btn btn-primary">افزودن دارایی</button>
                </form>
            </div>
        </div>

        <!-- جدول نمایش دارایی‌ها -->
        <div class="card mt-5">
            <div class="card-header">لیست دارایی‌ها</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام دستگاه</th>
                            <th>شماره سریال</th>
                            <th>تاریخ خرید</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
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
                            <td>
                                <a href="edit_asset.php?id=<?php echo $asset['id']; ?>" class="btn btn-sm btn-warning">ویرایش</a>
                                <a href="assets.php?delete_id=<?php echo $asset['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
                            </td>
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
