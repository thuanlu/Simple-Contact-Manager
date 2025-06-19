<?php
include 'config.php';

$database = new config();
$conn = $database->getConnection();

$sql = "SELECT * FROM contacts ORDER BY id DESC";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Contact Manager</title>
    <link rel="stylesheet" href="assets/style.css">
    
</head>
<body>
    <header>
        <h2>Quản lý Danh bạ Cá nhân (Simple Contact Manager)</h2>
    </header>
    
    <main>
        <h2>📒 Danh sách liên lạc</h2>
        <a class="btn" href="add.php">➕ Thêm liên lạc</a>
        <br><br>

        <table>
            <tr>
                <th>Tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['note']); ?></td>
                        <td>
                            <a class="btn" href="edit.php?id=<?php echo $row['id']; ?>">✏️ Sửa</a>
                            <a class="btn" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">🗑 Xóa</a>
                        </td>
                    </tr>

                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Không có liên lạc nào</td></tr>
            <?php endif; ?>
        </table>
    </main>

    <footer>
        <p>Tôi: Lư Minh Thuận - SDT: 0365110212 - Sinh viên khoa: Công nghệ thông tin</p>
    </footer>
</body>
</html>