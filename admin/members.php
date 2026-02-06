<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ecommercettt");
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ");
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อมูลสมาชิก</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .header {
            background: #343a40;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: #ffc107;
            text-decoration: none;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 220px;
            background: #212529;
            min-height: 100vh;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #495057;
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #4e73df;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>ข้อมูลสมาชิก</h2>
        <a href="dashboard.php">ย้อนกลับ</a>
    </div>

    <div class="container">

        <div class="sidebar">
            <a href="dashboard.php">🏠 Dashboard</a>
            <a href="members.php">👥 ข้อมูลสมาชิก</a>
            <a href="add_book.php">📚 เพิ่มหนังสือ</a>
            <a href="books.php">📖 รายการหนังสือ</a>
            <a href="borrowed.php">🔄 หนังสือที่ถูกยืม</a>
        </div>

        <div class="content">
            <table>
                <tr>
                    <th>รหัสสมาชิก</th>
                    <th>ชื่อสมาชิก</th>
                    <th>ที่อยู่</th>
                    <th>เบอร์โทร</th>
                </tr>

                <?php
                $sql = "SELECT * FROM member";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['member_id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['phone']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>ไม่พบข้อมูลสมาชิก</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>
</html>
