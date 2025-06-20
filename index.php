<?php
include 'config.php';

$database = new config();
$conn = $database->getConnection();

$sql = "SELECT * FROM contacts ORDER BY id DESC";
$result = $conn->query($sql);

// Gán biến trống để tránh lỗi undefined khi chưa vào chế độ sửa
$name = $phone = $email = $note = "";
$edit_id = null;

if (isset($_POST['edit_id'])) {
    $edit_id = intval($_POST['edit_id']);
    $stmt = $conn->prepare("SELECT name, phone, email, note FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $stmt->bind_result($name, $phone, $email, $note);
    $stmt->fetch();
    $stmt->close();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Contact Manager</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
    body { 
        font-family: 
        Arial; margin: 20px; 
    }
    label { 
        display: block; 
        margin-top: 10px; 
    }
    input, textarea { 
        width: 100%; 
        padding: 6px; 
        margin-top: 5px; 
    }
    .btn { 
        margin-top: 10px; 
        padding: 8px 14px; 
        text-decoration: none; 
        border: 1px solid #333; 
        background: #eee; 
    }
    .error { 
        color: red; 
        margin-top: 10px; 
    }
    </style>
</head>
<body>
    <header>
        <h2>Quản lý Danh bạ Cá nhân (Simple Contact Manager)</h2>
    </header>

    <main>
        <?php if (isset($_POST['show_form'])): ?>
            <h3>📋 Thêm liên lạc mới</h3>
            <form method="post" action="add.php">
                <label>Họ tên:</label>
                <input type="text" name="name" required>

                <label>Số điện thoại:</label>
                <input type="text" name="phone" required>

                <label>Email:</label>
                <input type="email" name="email">

                <label>Ghi chú:</label>
                <textarea name="note"></textarea>

                <button type="submit" name="add_contact" class="btn">Lưu liên lạc</button>
                <a class="btn" href="index.php">Hủy</a>
            </form>
            <hr>

        <?php elseif (isset($_POST['edit_id'])): ?>
            <h2>✏️ Sửa thông tin liên lạc</h2>
            <a class="btn" href="index.php">← Quay lại</a>

            <form action="edit.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">

                <label for="name">Họ và tên:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                <label for="phone">Số điện thoại:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                <label for="note">Ghi chú:</label>
                <textarea name="note"><?php echo htmlspecialchars($note); ?></textarea>

                <button type="submit" class="btn">Lưu thay đổi</button>
            </form>
            <hr>

        <?php else: ?>
            <h2>📒 Danh sách liên lạc</h2>
            <form method="post" style="display:inline;">
                <input type="hidden" name="show_form" value="1">
                <button type="submit" class="btn">➕ Thêm liên lạc</button>
            </form>
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
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn">✏️ Sửa</button>
                                </form>
                                <a class="btn" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">🗑 Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Không có liên lạc nào</td></tr>
                <?php endif; ?>
            </table>
        <?php endif; ?>
    </main>

    <footer>
        <p>Tôi: Lư Minh Thuận - SDT: 0365110212 - Sinh viên khoa: Công nghệ thông tin</p>
    </footer>
</body>
</html>
