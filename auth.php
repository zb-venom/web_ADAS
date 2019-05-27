<?php
session_start();
$auth = $_SESSION["auth"];
require_once "db/db.php";
?>
 <?php
        session_start();        
        if (isset($_POST['reg'])) echo '<script language="JavaScript"> 
                                            window.location.href = "reg.php"
                                        </script>';
        if (isset($_POST['submit'])) {
            if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} }
                if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
            if (empty($login) or empty($password))
                {
                exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
                }
                $login = stripslashes($login);
                $login = htmlspecialchars($login);
                $password = stripslashes($password);
                $password = htmlspecialchars($password);
                $login = trim($login);
                $password = trim($password);
                $sql = "SELECT * FROM users WHERE login='$login'";
                $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
                $myrow = mysqli_fetch_array($result);
                if (empty($myrow['password']))
                {
                    exit ("Извините, введённый вами login или пароль неверный.");
                }
                else {
                    if ($myrow['password']==$password) {
                    $_SESSION['login']=$myrow['login']; 
                    $_SESSION['id']=$myrow['id'];
                    $_SESSION['user_code']=$myrow['code'];
                    $_SESSION['auth'] = 1;
                    $_SESSION['root']=$myrow['root'];
                    echo '<script language="JavaScript"> 
                            window.location.href = "index.php"
                          </script>';
                    }
                    else {
                        exit ("Извините, введённый вами login или пароль неверный.");
                    }
                }
        }
        ?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">  
    <link rel="stylesheet" href="css/main.css">
    <title>Авторизация</title>
    <link rel="shortcut icon" href="/icon/user.png" type="image/x-icon">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">ШКАФ</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">                
                <?php 
                if ($auth==1) {
                    echo '<form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Поиск..." aria-label="Поиск...">
                        <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Найти</button>
                    </form>';
                }
                else 
                echo '<form class="form-inline my-2 my-lg-0" method="POST">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="auth.php">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reg.php">Зарегестрироваться</a>
                        </li>
                        </ul>
                    </form>';
                ?>
            </div>
        </nav>
    <div class="container">
    <center>
        <div class="card" style="width: 20rem; margin-top: 5%">
            <div class="card-body">
                <h2 class="card-title">Авторизация</h2>
                <form method="post">
                    <p>
                    <label>Ваш логин:<br></label>
                    <input class="form-control mr-sm-2"  name="login" type="text" size="15" maxlength="15"  required>
                    </p>
                    <p>
                    <label>Ваш пароль:<br></label>
                    <input class="form-control mr-sm-2"  name="password" type="password" size="15" maxlength="15"  required>
                    </p>
                    <p>
                    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Войти">            
                    </p>
                </form>
            </div>
        </div>
    </center>
       
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
<?php if($auth) {
                    echo '<script language="JavaScript"> 
                            window.location.href = "index.php"
                          </script>';}?>