<?php
session_start();
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "users_database"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['uname'];
    $password = $_POST['password'];
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    $secret_key = "6Leeqi0qAAAAAKhbX9kqmUcRtqw4MSkmBlC5Tw5s";
    $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($recaptcha_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_keys = json_decode($response, true);

    if ($response_keys["success"]) {
        $username = mysqli_real_escape_string($conn, $username);
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: loading?redir=welcome");
                exit();
            } else {
                $error_message = "Password salah.";
            }
        } else {
            $error_message = "Username tidak ditemukan.";
        }
    } else {
        $error_message = "Verifikasi reCAPTCHA gagal.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/svg+xml">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login | OSIS</title>
    <script>
        function showError(message) {
            const errorMessageDiv = document.getElementById('error-message');
            errorMessageDiv.innerText = message;
            errorMessageDiv.style.display = 'block';
        }

        window.onload = function() {
            <?php if ($error_message != ""): ?>
                showError("<?php echo $error_message; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <div class="box">
        <span class="borderLine"></span>
        <form action="login.php" method="POST">
            <img src="assets/images/logo.png" width="162" height="50">
            <h2>Sign In</h2>

            <div class="inputBox">
                <input type="text" name="uname" required="required">
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="password" required="required">
                <span>Password</span>
                <i></i>
            </div>
            <div class="g-recaptcha" style="margin-top : 15px;" data-sitekey="6Leeqi0qAAAAAG5ClhpbKosijbunaL3oiboW70ar"></div>
            <div id="error-message" class="error-message" style="display: none;"></div>
            <input type="submit" value="Login">
        </form>
    </div>
  </div>
</div>
</body>

<style>
    .error-message {
        color: #fff;
        background-color: #f44336;
        padding: 10px;
        margin-top: 15px;
        border-radius: 5px;
        text-align: center;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    img {
        max-width: 100%;
        height: auto;
        margin-bottom: 30px;
    }
    
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #F0F0F0;
        font-family: 'Poppins', sans-serif;
    }
    
    .box {
        position: relative;
        border-radius: 8px;
        background: #000;
        width: 390px;
        height: 520px;
        overflow: hidden;
    }
    
    .box::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 390px;
        height: 520px;
        background: linear-gradient(0deg,transparent, transparent, #002df3, #002df3, #002df3);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
    }
    
    .box::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 390px;
        height: 465px;
        background: linear-gradient(0deg,transparent, transparent, #002df3, #002df3, #002df3);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: 3s;
    }
    
    .borderLine {
        position: absolute;
        top: 0;
        inset: 0;
    }
    
    .borderLine::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 390px;
        height: 465px;
        background: linear-gradient(0deg,transparent, transparent, #f3ef00, #f3ef00, #f3ef00);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: -1.5s;
    }
    
    .borderLine::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 390px;
        height: 465px;
        background: linear-gradient(0deg,transparent, transparent, #f3ef00, #f3ef00, #f3ef00);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: -4.5s;
    }
    
    @keyframes animate {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    
    .box form {
        position: absolute;
        inset: 4px;
        background: #B7B7B7;
        padding: 50px 40px;
        border-radius: 8px;
        z-index: 2;
        display: flex;
        flex-direction: column;
    }
    
    .box form h2 {
        text-align: center;
        letter-spacing: 0.1em;
        font-weight: 500;
    }
    
    .box form .inputBox {
        position: relative;
        width: 300px;
        margin-top: 25px;
    }
    
    .box form .inputBox input{
        position: relative;
        width: 100%;
        background: transparent;
        outline: none;
        box-shadow: none;
        padding: 20px 10px 10px;
        border: none;
        transition: 0.5s;
        z-index: 10;
        letter-spacing: 0.05em;
        font-size: 1em;
    }
    
    .box form .inputBox span{
        position: absolute;
        left: 0;
        padding: 20px 0px 10px;
        pointer-events: none;
        transition: 0.5s;
        font-size: 1em;
        letter-spacing: 0.05em;
    }
    
    .box form .inputBox input:valid ~ span, 
    .box form .inputBox input:focus ~ span
    {
        color: #000;
        font-size: 0.75em;
        transform: translateY(-34px);
    }
    
    .box form .inputBox i{
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #fff;
        overflow: hidden;
        border-radius: 4px;
        pointer-events: none;
        transition: 0.5s;
    }
    
    .box form .inputBox input:valid ~ i, 
    .box form .inputBox input:focus ~ i
    {
        height: 44px;
    }
    
    .box form .links {
        display: flex;
        justify-content: left;
    }
    
    .box form .links a{
        margin: 10px 0;
        font-size: 0.75em;
        color: #000;
        text-decoration: none;
    }
    
    .box form .links a:hover,
    .box form .links a:nth-child(2)
    {
        color: blue;
    }
    
    .box form input[type="submit"] {
        border: none;
        outline: none;
        padding: 9px 25px;
        background: #fff;
        cursor: pointer;
        font-size: 0.9em;
        border-radius: 4px;
        font-weight: 600;
        width: 100px;
        margin-top: 10px;
    }
    
    .box form input[type="submit"]:active {
        opacity: 0.8;
    }
</style>
</html>
