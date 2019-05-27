<?php
session_start();
$auth = $_SESSION["auth"];
require_once "db/db.php";
?>
   <?php
        if (isset($_POST['auth'])) echo '<script language="JavaScript"> 
                                            window.location.href = "auth.php"
                                        </script>';
        if (isset($_POST['submit'])){
            if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} }
            if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
            if (isset($_POST['password2'])) { $password2=$_POST['password2']; if ($password2 =='') { unset($password2);} }
            if (isset($_POST['firstname'])) { $firstname=$_POST['firstname']; if ($firstname =='') { unset($firstname);} }
            if (isset($_POST['secondname'])) { $secondname=$_POST['secondname']; if ($secondname =='') { unset($secondname23);} }
            if (isset($_POST['mail'])) { $mail=$_POST['mail']; if ($mail =='') { unset($mail);} }
            if (isset($_POST['cell'])) { $cell=$_POST['cell']; if ($cell =='') { unset($cell);} }
            if (isset($_POST['user_group'])) { $user_group=$_POST['user_group']; if ($user_group =='') { unset($user_group);} }
            if (empty($login) or empty($password)) {
                exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
            }
            $login = stripslashes($login);
            $login = htmlspecialchars($login);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            $password2 = stripslashes($password2);
            $password2 = htmlspecialchars($password2);
            $login = trim($login);
            $password = trim($password);
            $password2 = trim($password2);
            if ($password!=$password2)
                exit ("Пароли не совпадают!");
            $sql = "SELECT id FROM `users` WHERE login='$login'";
            $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
            $myrow = mysqli_fetch_array($result);
            date_default_timezone_set("UTC");
            $user_code = date("HBiNsBdN");
            if (!empty($myrow['id'])) {
                exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
            }
            $sql = "INSERT INTO users (`login`, `password`, `code`, `firstname`, `secondname`, `mail`, `cell`, `user_group`) VALUES('$login','$password','$user_code', '$firstname', '$secondname', '$mail', '$cell', '$user_group')";
            $result2 = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
            if ($result2=='TRUE')
            {
                echo '<script language="JavaScript"> 
                            window.location.href = "auth.php"
                      </script>';
            }
            else {
                echo "Ошибка! Вы не зарегистрированы.";
            }
        }
        ?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">  
    <link rel="stylesheet" href="css/main.css">
    <title>Регистрация</title>
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
                    <h2 class="card-title">Регистрация</h2>
                    <form method="post">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Логин</span>
                            </div>
                            <input class="form-control mr-sm-2" name="login" type="text" size="16" maxlength="16" required>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Пароль</span>
                            </div>
                            <input class="form-control mr-sm-2" name="password" type="password" size="16" maxlength="16" required>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Повторите пароль</span>
                            </div>
                            <input class="form-control mr-sm-2" name="password2" type="password" size="16" maxlength="16" required>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Имя</span>
                            </div>
                            <input class="form-control mr-sm-2" name="firstname" type="text" size="16" maxlength="32" required>
                        </div> 
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Фамилия</span>
                            </div>
                            <input class="form-control mr-sm-2" name="secondname" type="text" size="16" maxlength="32" required>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Почта</span>
                            </div>
                            <input class="form-control mr-sm-2" name="mail" type="mail" size="16" maxlength="64" required>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Телефон</span>
                            </div>
                            <input class="form-control mr-sm-2" id="online_phone" name="cell" type="tel" maxlength="50"
                                autofocus="autofocus" required="required"
                                value="<?=(isset($_POST['phone'])?$_POST['phone']:'+7(___)___-__-__')?>"
                                pattern="\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}"
                                placeholder="+7(___)___-__-__">
                        </div>            
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Группа</span>
                            </div>
                            <input  class="form-control mr-sm-2"  name="user_group" type="text" size="16" maxlength="16" required>
                        </div><br>
                        <p>                        
                        <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Зарегистрироваться">
                        </p>
                    </form>
                </div>
            </div>
        </center>
     
    </div>
<script type="text/javascript">
  function setCursorPosition(pos, e) {
    e.focus();
    if (e.setSelectionRange) e.setSelectionRange(pos, pos);
    else if (e.createTextRange) {
      var range = e.createTextRange();
      range.collapse(true);
      range.moveEnd("character", pos);
      range.moveStart("character", pos);
      range.select()
    }
  }

  function mask(e) {
    var matrix = this.placeholder,// .defaultValue
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, "");
    def.length >= val.length && (val = def);
    matrix = matrix.replace(/[_\d]/g, function(a) {
      return val.charAt(i++) || "_"
    });
    this.value = matrix;
    i = matrix.lastIndexOf(val.substr(-1));
    i < matrix.length && matrix != this.placeholder ? i++ : i = matrix.indexOf("_");
    setCursorPosition(i, this)
  }
  window.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#online_phone");
    input.addEventListener("input", mask, false);
    input.focus();
    setCursorPosition(3, input);
  });
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
<?php if($auth) {
                    echo '<script language="JavaScript"> 
                            window.location.href = "index.php"
                          </script>';}?>