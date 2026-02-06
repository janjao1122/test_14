<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$member_id  = $_SESSION['member_id'];
$book_id    = $_POST['book_id'];
$borrow_date = $_POST['borrow_date'];

/* 1️⃣ บันทึกประวัติการยืม */
$sql = "INSERT INTO borrow (member_id, book_id, borrow_date)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $member_id, $book_id, $borrow_date);
$stmt->execute();

/* 2️⃣ เปลี่ยนสถานะหนังสือเป็น borrowed */
$update = "UPDATE book 
           SET status = 'borrowed' 
           WHERE book_id = ?";

$stmt2 = $conn->prepare($update);
$stmt2->bind_param("i", $book_id);
$stmt2->execute();

/* 3️⃣ กลับหน้า index */
header("Location: index.php");
exit;
