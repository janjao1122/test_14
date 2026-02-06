<?php
session_start();
include "connect.php";

// ต้องล็อกอินก่อน
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];

// คืนหนังสือ
if (isset($_GET['borrow_id'])) {
    $borrow_id = intval($_GET['borrow_id']);

    // หา book_id (และเช็กว่าเป็นของคนนี้จริง)
    $sql = "SELECT book_id FROM borrow 
            WHERE borrow_id = $borrow_id 
            AND member_id = $member_id 
            AND status = 'borrowed'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $book_id = $row['book_id'];

        // อัปเดตการคืน
        mysqli_query($conn, "
            UPDATE borrow 
            SET status = 'returned', return_date = NOW() 
            WHERE borrow_id = $borrow_id
        ");

        // อัปเดตสถานะหนังสือ
        mysqli_query($conn, "
            UPDATE book 
            SET status = 'available' 
            WHERE book_id = $book_id
        ");
    }

    header("Location: return.php");
    exit;
}

// ดึงหนังสือที่ยังไม่คืน
$sql = "
SELECT b.borrow_id, bo.title, bo.author, b.borrow_date
FROM borrow b
JOIN book bo ON b.book_id = bo.book_id
WHERE b.member_id = $member_id 
AND b.status = 'borrowed'
";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>คืนหนังสือ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">
    <h3 class="mb-3"> คืนหนังสือ</h3>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>ชื่อหนังสือ</th>
                <th>ผู้แต่ง</th>
                <th>วันที่ยืม</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>

        <?php if (mysqli_num_rows($result) == 0) { ?>
            <tr>
                <td colspan="5" class="text-center text-muted">
                    ไม่มีหนังสือที่ต้องคืน
                </td>
            </tr>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['borrow_id']; ?></td>
                <td><?= $row['title']; ?></td>
                <td><?= $row['author']; ?></td>
                <td><?= $row['borrow_date']; ?></td>
                <td>
                    <a href="return.php?borrow_id=<?= $row['borrow_id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('ยืนยันการคืนหนังสือ?')">
                       คืนหนังสือ
                    </a>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary">กลับหน้าหลัก</a>
</div>
</body>
</html>
