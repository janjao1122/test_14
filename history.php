<?php
session_start();
include "connect.php";

// ต้องล็อกอินก่อน
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id'];

// ดึงประวัติการยืม–คืน (ไม่ใช้ status)
$sql = "
SELECT 
    b.borrow_id,
    bo.title,
    bo.author,
    bo.genre,
    b.borrow_date,
    b.return_date
FROM borrow b
JOIN book bo ON b.book_id = bo.book_id
WHERE b.member_id = '$member_id'
ORDER BY b.borrow_date DESC
";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ประวัติการยืม–คืนหนังสือ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">📚 ห้องสมุดออนไลน์</a>
        <span class="text-white">
            <?= $_SESSION['name']; ?>
        </span>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4">📖 ประวัติการยืม–คืนหนังสือ</h3>

    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>ชื่อหนังสือ</th>
                <th>ผู้แต่ง</th>
                <th>หมวดหมู่</th>
                <th>วันที่ยืม</th>
                <th>วันที่คืน</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>

        <?php if (mysqli_num_rows($result) == 0) { ?>
            <tr>
                <td colspan="7" class="text-center text-muted">
                    ยังไม่มีประวัติการยืมหนังสือ
                </td>
            </tr>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['borrow_id']; ?></td>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= htmlspecialchars($row['author']); ?></td>
                <td>
                    <span class="badge bg-info">
                        <?= htmlspecialchars($row['genre']); ?>
                    </span>
                </td>
                <td><?= $row['borrow_date']; ?></td>
                <td>
                    <?= $row['return_date'] ? $row['return_date'] : '-'; ?>
                </td>
                <td>
                    <?php if ($row['return_date'] == NULL) { ?>
                        <span class="badge bg-warning text-dark">กำลังยืม</span>
                    <?php } else { ?>
                        <span class="badge bg-success">คืนแล้ว</span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary">⬅ กลับหน้าหลัก</a>
</div>

</body>
</html>
