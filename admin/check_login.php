<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ecommercettt");
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ");
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // 🔑 เปรียบเทียบรหัสตรง ๆ
    if ($password === $row['password']) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_name'] = $row['username'];

        header("Location: dashboard.php");
        exit();
    } else {
        echo "รหัสผ่านไม่ถูกต้อง";
    }
} else {
    echo "ไม่พบผู้ใช้";
}
