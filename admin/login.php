<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>
*{
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

body{
    height:100vh;
    margin:0;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#4e73df,#1cc88a);
}

.login-box{
    background:#fff;
    width:340px;
    padding:35px 30px;
    border-radius:15px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.login-box h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.login-box h2 span{
    color:#4e73df;
}

.login-box input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    transition:0.3s;
}

.login-box input:focus{
    outline:none;
    border-color:#4e73df;
    box-shadow:0 0 5px rgba(78,115,223,0.5);
}

.login-box button{
    width:100%;
    padding:12px;
    background:#4e73df;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

.login-box button:hover{
    background:#2e59d9;
}

.login-box .note{
    text-align:center;
    font-size:12px;
    color:#888;
    margin-top:15px;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>🔐 <span>Admin</span> Login</h2>

    <form method="post" action="check_login.php">
        <input type="text" name="username" placeholder="👤 Username" required>
        <input type="password" name="password" placeholder="🔑 Password" required>
        <button type="submit">เข้าสู่ระบบ</button>
    </form>
</div>

</body>
</html>
