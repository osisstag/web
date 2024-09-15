<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/svg+xml">
    <title>Please Wait...</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const redirectTo = params.get('redir') || "login";  

            setTimeout(function() {
                window.location.href = redirectTo; 
            }, 5000); 
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="loader"></div>
    </div>
</body>
<style>
html, body {
  height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #F0F0F0;
  font-family: 'Poppins', sans-serif;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}

.loader {
  width: 100px;
  height: 100px;
  background: url('assets/images/logo_2.png') center center/contain no-repeat; 
  border-radius: 50%;
  animation: pulse 1.5s ease-in-out infinite alternate;
  box-shadow: 0 0 0 0 rgba(0, 0, 255, 0.6); 
}

@keyframes pulse {
  0% {
      transform: scale(1);
      box-shadow: 0 0 0 0 rgba(0, 0, 255, 0.6); 
  }
  100% {
      transform: scale(1.1);
      box-shadow: 0 0 0 20px rgba(0, 0, 255, 0);
  }
}
</style>
</html>
