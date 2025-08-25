<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'ادمین') {
    header('Location: login.php');
    exit();
}

include 'config.php';

// افزودن کاربر جدید
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
    $success = "کاربر با موفقیت افزوده شد!";
}

// حذف کاربر
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$delete_id]);
    $success = "کاربر با موفقیت حذف شد!";
}

// دریافت کلیه کاربران
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت کاربران - اعلا نیرو</title>
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
                        <a class="nav-link active" href="users.php">مدیریت کاربران</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">خروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">مدیریت کاربران سیستم</h2>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- فرم افزودن کاربر -->
        <div class="card mt-4">
            <div class="card-header">افزودن کاربر جدید</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">نام کاربری:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">نقش:</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="کاربر عادی">کاربر عادی</option>
                            <option value="ادمین">ادمین</option>
                        </select>
                    </div>
                    <button type="submit" name="add_user" class="btn btn-primary">افزودن کاربر</button>
                </form>
            </div>
        </div>

        <!-- جدول نمایش کاربران -->
        <div class="card mt-5">
            <div class="card-header">لیست کاربران</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام کاربری</th>
                            <th>نقش</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $user['role'] == 'ادمین' ? 'danger' : 'secondary'; ?>">
                                    <?php echo $user['role']; ?>
                                </span>
                            </td>
                            <td><?php echo $user['created_at']; ?></td>
                            <td>
                                <a href="users.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>
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
