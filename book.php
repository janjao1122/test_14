<?php
include "connect.php";

$sql = "SELECT * FROM book";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายการหนังสือทั้งหมด</title>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f4f6f9;
        padding: 30px;
    }

    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background: #4b7bec;
        color: white;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .available {
        color: green;
        font-weight: bold;
    }

    .borrowed {
        color: red;
        font-weight: bold;
    }
</style>
</head>

<body>

<h2>📚 รายการหนังสือทั้งหมด</h2>

<table>
    <tr>
        <th>รหัสหนังสือ</th>
        <th>ชื่อหนังสือ</th>
        <th>ผู้แต่ง</th>
        <th>หมวด</th>
        <th>สถานะ</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['book_id']; ?></td>
        <td><?= $row['title']; ?></td>
        <td><?= $row['author'] ?? '-'; ?></td>
        <td><?= $row['genre'] ?? '-'; ?></td>
        <td>
            <?php
                if ($row['status'] == 'available') {
                    echo "<span class='available'>ว่าง</span>";
                } else {
                    echo "<span class='borrowed'>ถูกยืม</span>";
                }
            ?>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
