<?php
session_start();
include 'connect.php';

/* ตรวจสอบว่าล็อกอินหรือยัง */
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

/* ดึงเฉพาะหนังสือที่ว่าง */
$result = $conn->query("SELECT * FROM book WHERE status = 'available'");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยืมหนังสือ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff, #f8fafc);
            font-family: 'Segoe UI', sans-serif;
        }
        .borrow-card {
            max-width: 500px;
            margin: auto;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.1);
        }
        .borrow-card h3 {
            font-weight: bold;
        }
        .btn-primary {
            background: #4f46e5;
            border: none;
        }
        .btn-primary:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card borrow-card p-4">
        <h3 class="mb-4 text-center">📖 ยืมหนังสือ</h3>

        <?php if ($result->num_rows == 0) { ?>
            <div class="alert alert-warning text-center">
                ❌ ไม่มีหนังสือว่างให้ยืม
            </div>
        <?php } else { ?>

        <form action="borrow_save.php" method="post">
            <div class="mb-3">
                <label class="form-label">เลือกหนังสือ</label>
                <select name="book_id" class="form-select" required>
                    <option value="">-- เลือกหนังสือ --</option>
                    <?php while($book = $result->fetch_assoc()) { ?>
                        <option value="<?= $book['book_id']; ?>">
                            <?= $book['title']; ?> (<?= $book['author']; ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">วันที่ยืม</label>
                <input type="date" name="borrow_date" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    ✅ ยืนยันการยืม
                </button>
                <a href="index.php" class="btn btn-outline-secondary">
                    ⬅ กลับหน้าหลัก
                </a>
            </div>
        </form>

        <?php } ?>
    </div>
</div>

</body>
</html>
