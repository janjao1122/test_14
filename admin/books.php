<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../connect.php";

// (ถ้ามีระบบแอดมินแล้ว ค่อยเปิดใช้)
// if (!isset($_SESSION['admin_login'])) {
//     header("Location: login.php");
//     exit;
// }

// ลบหนังสือ
if (isset($_GET['delete'])) {
    $book_id = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM book WHERE book_id = $book_id");

    header("Location: books.php");
    exit;
}

// ดึงรายการหนังสือทั้งหมด
$result = mysqli_query($conn, "SELECT * FROM book ORDER BY book_id DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการหนังสือ | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background:#f4f6f9;
}
.card{
    margin-top:40px;
}
</style>
</head>

<body>

<div class="container">
    <div class="card shadow">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4> รายการหนังสือ </h4>
                <a href="add_book.php" class="btn btn-primary btn-sm">
                     เพิ่มหนังสือ
                </a>
            </div>

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>ชื่อหนังสือ</th>
                        <th>ผู้แต่ง</th>
                        <th>หมวดหมู่</th>
                        <th>สถานะ</th>
                        <th width="120">จัดการ</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (mysqli_num_rows($result) == 0) { ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            ยังไม่มีหนังสือ
                        </td>
                    </tr>
                <?php } ?>

                <?php while ($book = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="text-center"><?= $book['book_id']; ?></td>
                        <td><?= $book['title']; ?></td>
                        <td><?= $book['author']; ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?= $book['genre']; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($book['status'] == 'available') { ?>
                                <span class="badge bg-success">ว่าง</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">ถูกยืม</span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <a href="books.php?delete=<?= $book['book_id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('ยืนยันการลบหนังสือเล่มนี้?')">
                               ลบ
                            </a>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>

            <a href="dashboard.php" class="btn btn-secondary btn-sm">
                Dashboard
            </a>

        </div>
    </div>
</div>

</body>
</html>
