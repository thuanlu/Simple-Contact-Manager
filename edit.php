<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id    = intval($_POST['id']);
    $name  = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $note  = trim($_POST['note']);
    $errors = [];

    if (empty($name)) $errors[] = "Vui lòng nhập tên.";
    if (empty($phone)) $errors[] = "Vui lòng nhập số điện thoại.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";

    if (empty($errors)) {
        $db = new config();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE contacts SET name = ?, phone = ?, email = ?, note = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $phone, $email, $note, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    } else {
        // Nếu cần bạn có thể truyền lỗi lại bằng session hoặc query string
        echo "<p style='color:red;'>Có lỗi xảy ra. Vui lòng quay lại.</p>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
