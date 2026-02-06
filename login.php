<?php
session_start();
include "connect.php";

if (isset($_POST['login'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM member WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['member_id'] = $row['member_id'];
            $_SESSION['name'] = $row['name'];
            echo "<script>alert('เข้าสู่ระบบสำเร็จ');</script>";
            header("Location: index.php"); // หน้าแรกหลัง login
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง');</script>";
        }
    } else {
        echo "<script>alert('ไม่พบชื่อผู้ใช้');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบ</title>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #667eea, #764ba2);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box {
        width: 380px;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    label {
        font-weight: bold;
        margin-top: 10px;
        display: block;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    button {
        width: 100%;
        margin-top: 20px;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        background: linear-gradient(135deg, #43cea2, #185a9d);
    }
</style>
</head>

<body>

<div class="box">
    <h2>🔐 เข้าสู่ระบบ</h2>

    <form method="post">
        <label>ชื่อ</label>
        <input type="text" name="name" required>

        <label>รหัสผ่าน</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">เข้าสู่ระบบ</button>
    </form>
</div>

</body>
</html>
