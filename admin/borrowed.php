<?php
session_start();
include "../connect.php";

$sql = "
    SELECT 
        b.book_id,
        b.title,
        b.author,
        b.genre,
        m.name AS member_name,
        br.borrow_date
    FROM borrow br
    JOIN book b ON br.book_id = b.book_id
    JOIN member m ON br.member_id = m.member_id
    WHERE br.return_date IS NULL
    ORDER BY br.borrow_date DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>หนังสือที่ถูกยืม</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">📕 หนังสือที่ถูกยืม</span>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
    </div>
</nav>

<div class="container">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-3">รายการหนังสือที่ถูกยืม </h4>

            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>ชื่อหนังสือ</th>
                        <th>ผู้แต่ง</th>
                        <th>หมวดหมู่</th>
                        <th>ผู้ยืม</th>
                        <th>วันที่ยืม</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>

                <?php if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= htmlspecialchars($row['author']); ?></td>
                        <td class="text-center">
                            <span class="badge bg-info">
                                <?= htmlspecialchars($row['genre']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['member_name']); ?></td>
                        <td class="text-center"><?= $row['borrow_date']; ?></td>
                        <td class="text-center">
                            <span class="badge bg-danger">ถูกยืม</span>
                        </td>
                    </tr>
                <?php }
                } else { ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            ไม่มีหนังสือที่ถูกยืมอยู่
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

</body>
</html>
