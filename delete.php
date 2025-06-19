<?php
include 'config.php';

$database = new config();
$conn = $database->getConnection();

// Kiểm tra ID có hợp lệ không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Liên lạc không hợp lệ.");
}

$id = intval($_GET['id']);

// Kiểm tra liên lạc tồn tại không
$stmt_check = $conn->prepare("SELECT id FROM contacts WHERE id = ?");
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows === 0) {
    $stmt_check->close();
    die("Liên lạc không tồn tại.");
}
$stmt_check->close();

// Thực hiện xóa
$stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Quay về danh sách
header("Location: index.php");
exit();
?>
