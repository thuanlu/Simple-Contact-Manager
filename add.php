<?php
include 'config.php';

$database = new config();
$conn = $database->getConnection();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $note  = trim($_POST['note']);

    // Kiểm tra dữ liệu
    if (empty($name)) {
        $errors[] = "Vui lòng nhập tên.";
    }
    if (empty($phone)) {
        $errors[] = "Vui lòng nhập số điện thoại.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    }

    // Nếu không có lỗi thì thêm vào database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, note) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $note);
        $stmt->execute();
        $stmt->close();

        // Chuyển hướng về trang danh sách
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm liên lạc</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 6px; margin-top: 5px; }
        .btn { margin-top: 10px; padding: 8px 14px; text-decoration: none; border: 1px solid #333; background: #eee; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>➕ Thêm liên lạc mới</h2>
    <a class="btn" href="index.php">← Quay lại</a>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="name">Họ và tên:</label>
        <input type="text" name="name" required>

        <label for="phone">Số điện thoại:</label>
        <input type="text" name="phone" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="note">Ghi chú:</label>
        <textarea name="note" rows="3"></textarea>

        <button type="submit" class="btn">Lưu liên lạc</button>
    </form>

</body>
</html>
