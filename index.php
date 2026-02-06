<?php
session_start();
include "connect.php";

/* ดึงข้อมูลหนังสือ + คนยืม (ถ้ามี) */
$sql = "
SELECT 
    b.title,
    MIN(b.book_id) AS book_id,
    b.author,
    b.genre,
    CASE
        WHEN SUM(b.status = 'available') > 0 THEN 'available'
        ELSE 'borrowed'
    END AS status,
    MAX(br.member_id) AS borrower
FROM book b
LEFT JOIN borrow br ON b.book_id = br.book_id
GROUP BY b.title, b.author, b.genre
";


$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ระบบยืมคืนหนังสือ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- 🔷 Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">ห้องสมุดออนไลน์</a>
            <div>
                <?php if (!isset($_SESSION['member_id'])) { ?>
                    <a href="register.php" class="btn btn-outline-light btn-sm me-2">สมัครสมาชิก</a>
                    <a href="login.php" class="btn btn-outline-light btn-sm">เข้าสู่ระบบ</a>
                <?php } else { ?>

                    <span class="btn btn-warning btn-sm"><?= $_SESSION['name']; ?></span>
                    <a href="logout.php" class="btn btn-danger btn-sm">ออกจากระบบ</a>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h3 class="mb-3">📚 รายการหนังสือ</h3>

        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>ชื่อหนังสือ</th>
                    <th>ผู้แต่ง</th>
                    <th>หมวดหมู่</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($book = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $book['book_id']; ?></td>
                        <td><?= htmlspecialchars($book['title']); ?></td>
                        <td><?= htmlspecialchars($book['author']); ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?= htmlspecialchars($book['genre']); ?>
                            </span>
                        </td>

                        <!-- สถานะ -->
                        <td>
                            <?php if ($book['status'] == 'available') { ?>
                                <span class="badge bg-success">ว่าง</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">ถูกยืม</span>
                            <?php } ?>
                        </td>

                        <!-- ปุ่มจัดการ -->
                        <td>
                            <?php
                            // 📗 หนังสือว่าง
                            if ($book['status'] == 'available') {

                                if (isset($_SESSION['member_id'])) {
                            ?>
                                    <a href="borrow.php?book_id=<?= $book['book_id']; ?>"
                                        class="btn btn-sm btn-success">
                                        จอง
                                    </a>
                                <?php
                                } else {
                                    echo "<span class='text-muted'>กรุณาเข้าสู่ระบบ</span>";
                                }

                                // 📕 หนังสือถูกยืม
                            } else {

                                // ถ้าเราเป็นคนยืม → คืนได้
                                if (isset($_SESSION['member_id']) && $book['borrower'] == $_SESSION['member_id']) {
                                ?>
                                    <a href="return.php?book_id=<?= $book['book_id']; ?>"
                                        class="btn btn-sm btn-warning">
                                        คืนหนังสือ
                                    </a>
                            <?php
                                } else {
                                    echo "<span class='text-danger'>ถูกยืมแล้ว</span>";
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

</body>

</html>