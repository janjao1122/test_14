<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../connect.php"; // ต้องมี $conn

$success = "";
$error = "";

// เมื่อกดบันทึก
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title  = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre  = trim($_POST['genre']);
    $status = 'available'; // ค่าเริ่มต้น

    if ($title == "") {
        $error = "กรุณากรอกชื่อหนังสือ";
    } else {
        $sql = "INSERT INTO book (title, author, genre, status)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $author, $genre, $status);

        if ($stmt->execute()) {
            $success = "✅ เพิ่มหนังสือเรียบร้อย ";
            $_POST = []; // เคลียร์ฟอร์ม
        } else {
            $error = "❌ เกิดข้อผิดพลาดในการบันทึก";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เพิ่มหนังสือ | แอดมิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background:#f4f6f9;
}
.card{
    max-width:420px;
    margin:80px auto;
    border-radius:15px;
}
</style>
</head>

<body>

<div class="card shadow">
    <div class="card-body">
        <h4 class="text-center mb-3">📚 เพิ่มหนังสือ</h4>

        <?php if ($success) { ?>
            <div class="alert alert-success text-center">
                <?= $success ?>
            </div>
        <?php } ?>

        <?php if ($error) { ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="mb-2">
                <label class="form-label">ชื่อหนังสือ</label>
                <input type="text" name="title" class="form-control"
                       value="<?= $_POST['title'] ?? '' ?>" required>
            </div>

            <div class="mb-2">
                <label class="form-label">ผู้แต่ง</label>
                <input type="text" name="author" class="form-control"
                       value="<?= $_POST['author'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">หมวดหมู่</label>
                <input type="text" name="genre" class="form-control"
                       value="<?= $_POST['genre'] ?? '' ?>">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                บันทึกหนังสือ
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                กลับหน้าแรก
            </a>
        </div>
    </div>
</div>

</body>
</html>
