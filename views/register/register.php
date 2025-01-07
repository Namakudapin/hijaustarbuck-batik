<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/login.css/style.css">
    <title>Daftar</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <div class="logo" style="text-align: center; margin-bottom: 20px;">
                <img src="/assets/image/logo.png" alt="IT Solution Logo" style="width: 150px;">
            </div>
            <header>Daftar</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Nama</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Kata sandi</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Daftar" required>
                </div>
                <div class="links">
                    Sudah mempunyai akun? <a href="/views/login/login.php">Masuk</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
