<?php
include 'config.php';

$database = new config();
$conn = $database->getConnection();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Liên lạc không hợp lệ.");
}

$id = intval($_GET['id']);


// --- Lấy dữ liệu hiện tại ---
$stmt = $conn->prepare("SELECT name, phone, email, note FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $phone, $email, $note);

if (!$stmt->fetch()) {
    die("Không tìm thấy liên lạc.");
}
$stmt->close();

// --- Xử lý cập nhật ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $note  = trim($_POST['note']);

    if (empty($name)) {
        $errors[] = "Vui lòng nhập tên.";
    }
    if (empty($phone)) {
        $errors[] = "Vui lòng nhập số điện thoại.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE contacts SET name = ?, phone = ?, email = ?, note = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $phone, $email, $note, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa liên lạc</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 6px; margin-top: 5px; }
        .btn { margin-top: 10px; padding: 8px 14px; text-decoration: none; border: 1px solid #333; background: #eee; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>✏️ Sửa thông tin liên lạc</h2>
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
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label for="phone">Số điện thoại:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label for="note">Ghi chú:</label>
        <textarea name="note" rows="3"><?php echo htmlspecialchars($note); ?></textarea>

        <button type="submit" class="btn">Lưu thay đổi</button>
    </form>

</body>
</html>
