<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

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

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header a {
            color: #ffc107;
            text-decoration: none;
            font-size: 14px;
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

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Admin Dashboard</h1>
        <a href="logout.php">ออกจากระบบ</a>
    </div>

    <div class="container">

        <div class="sidebar">
            <a href="members.php">👥 จัดการสมาชิก</a>
            <a href="add_book.php">📚 เพิ่มหนังสือ</a>
            <a href="books.php">📖 รายการหนังสือ</a>
            <a href="borrowed.php">🔄 หนังสือที่ถูกยืม</a>
        </div>

        <div class="content">
            <div class="card">
                <h2>ยินดีต้อนรับผู้ดูแลระบบ</h2>
                <p>คุณได้เข้าสู่ระบบเรียบร้อยแล้ว</p>
                <p>กรุณาเลือกเมนูจากแถบด้านซ้ายเพื่อจัดการข้อมูล</p>
            </div>
        </div>

    </div>

</body>
</html>
