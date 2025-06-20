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
    
</head>
<body>

</body>
</html>
