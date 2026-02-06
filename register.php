<?php
include "connect.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO member (name, phone, address, password)
            VALUES ('$name', '$phone', '$address', '$hash_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('สมัครสมาชิกสำเร็จ');
                window.location='login.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการสมัครสมาชิก');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 420px;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: none;
            height: 70px;
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
            background: linear-gradient(135deg, #6c63ff, #48c6ef);
        }

        /* 🔹 ปุ่มเข้าสู่ระบบแบบมีกรอบ */
        .login-btn {
            display: block;
            text-align: center;
            margin-top: 12px;
            padding: 10px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            border: 2px solid #6c63ff;
            color: #6c63ff;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #6c63ff;
            color: white;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>📚 สมัครสมาชิกยืม–คืนหนังสือ</h2>

        <form method="post">
            <label>ชื่อ - นามสกุล</label>
            <input type="text" name="name" required>

            <label>เบอร์โทรศัพท์</label>
            <input type="text" name="phone" required>

            <label>ที่อยู่</label>
            <textarea name="address" required></textarea>

            <label>รหัสผ่าน</label>
            <input type="password" name="password" required>

            <button type="submit" name="submit">สมัครสมาชิก</button>

            <!-- ปุ่มเข้าสู่ระบบ -->
            <a href="login.php" class="login-btn">
                เข้าสู่ระบบ
            </a>
        </form>
    </div>

</body>

</html>