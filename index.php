<?php
session_start();
$auth = $_SESSION["auth"];
$user_code = $_SESSION["user_code"];
$root = $_SESSION["root"];
if (isset($_GET['search'])) {echo '<script language="JavaScript"> 
window.location.href = "auditory.php?search=&input='; echo $_GET['input']; echo '"
</script>';} 
if(isset($_GET['exit'])) {$_SESSION['auth'] = 0; 
    echo '<script language="JavaScript"> 
            window.location.href = "index.php"
          </script>';} 
if(isset($_GET['root'])) echo '<script language="JavaScript"> 
                    window.location.href = "root.php"
                    </script>';
if (!$auth) echo '<script language="JavaScript"> 
                    window.location.href = "auth.php"
                  </script>';
require_once "db/db.php";               
ini_set('date.timezone', 'Asia/Novosibirsk');
$sql = "SELECT * FROM `users` WHERE `code`='$user_code'"; 
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
if($result!==FALSE){ while($row = mysqli_fetch_array($result)) 
    { $_SESSION['id'] = $row['id']; $_SESSION['login'] = $row['login']; $_SESSION['firstname'] = $row['firstname']; 
      $_SESSION['secondname'] = $row['secondname']; $_SESSION['user_group'] = $row['user_group']; $_SESSION['mail'] = $row['mail']; $_SESSION['cell'] = $row['cell'];}}
if (isset($_GET['delete_post']))
{
    $id_post = $_GET['id_post'];
    $sql = "DELETE FROM `news` WHERE `id`='$id_post'"; 
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
}
if (isset($_POST['new_post']))
{
    $date = date("d m в H:i");
    $_monthsList = array(
        "01" => "января",
        "02" => "февраля",
        "03" => "марта",
        "04" => "апреля",
        "05" => "мая",
        "06" => "июня",
        "07" => "июля",
        "08" => "августа",
        "09" => "сентября",
        "10" => "октября",
        "11" => "ноября",
        "12" => "декабря"
    );
    $title = $_POST['title'];
    $message = $_POST['message'];
    if(isset($_POST['danger']) && $_POST['danger'] == '1') 
    {
        $danger = '1';
    }
    $firstname = $_SESSION['firstname'];
    $secondname = $_SESSION['secondname'];
    $_mD = date("m");   
    $date = str_replace($_mD, "$_monthsList[$_mD]", $date);  
    $sql = "INSERT INTO `news`(`title`, `message`, `author`, `date`, `danger`) VALUES ('$title','$message','$firstname $secondname', '$date', '$danger')"; 
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
}
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">  
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="/icon/main.png" type="image/x-icon">
    <title><?php echo $_SESSION['login']; ?></title>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">ШКАФ</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="auditory.php">Информация</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="history.php">Журнал</a>
                </li>
                </ul>
                <?php 
                if ($auth==1) {  
                    if ($root) echo '<form class="form-inline my-2 my-lg-0 method="POST"><button class="btn btn-outline-primary my-2 my-sm-0" name="root" type="submit">Управление</button>&#8194;</form>';
                    echo '<form class="form-inline my-2 my-lg-0 method="POST"><input class="form-control mr-sm-2" type="search" name="input" placeholder="Поиск..." aria-label="Поиск...">
                        <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Найти</button>&#8194;
                        <button class="btn btn-outline-danger my-2 my-sm-0" name="exit" type="submit">Выход</button>
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
        <br>

        <div class="row">
            <div class="col-md-auto">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">Профиль</div>
                    <ul class="list-group list-group-flush bg-dark">
                        <li class="list-group-item list-group-item-dark">Логин: <?php echo $_SESSION['login'];?></li>
                        <li class="list-group-item list-group-item-dark"><?php echo $_SESSION['firstname']; echo " "; echo $_SESSION['secondname'];?></li>
                        <li class="list-group-item list-group-item-dark">E-mail: <?php echo $_SESSION['mail'];?></li>
                        <li class="list-group-item list-group-item-dark">Phone: <?php echo $_SESSION['cell'];?></li>
                        </ul>  
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#notification">На руках <span class="badge badge-primary badge-pill"><?php 
$sql = "SELECT * FROM `data` WHERE `give`='$user_code'"; echo mysqli_num_rows(mysqli_query($link, $sql));?></span></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#infocode">Ваш индивидульный номер</button>
                     
                </div>
                <br>
             </div>  
                <div class="col">
                        <form method="POST">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Название</span>
                                        </div>
                                        <input type="text" class="form-control" name="title" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit" name="new_post">Опубликовать</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-2">
                                                <label>Сообщение</label>  
                                            </div>        
                                            <div class="col-2">                                     
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="danger" value="1">
                                                    <label class="form-check-label" >Важное</label>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea style="resize: none;" class="form-control" name="message" rows="6" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php 
                $temp = $_SESSION['firstname'];
                $temp = str_pad($temp, strlen($temp) + 1, " ");
                $temp = str_pad($temp, strlen($temp) + strlen($_SESSION['secondname']), $_SESSION['secondname']);                
                $sql = "SELECT * FROM `news` ORDER BY id DESC";
                $result = mysqli_query($link, $sql); 
                while($row = mysqli_fetch_array($result)) { 
                    echo '<div class="w-100"></div>
                            <div class="col">
                                <div class="card '; if ($row['danger']) echo 'text-white bg-danger'; else echo 'text-white bg-dark'; echo '">
                                        <div class="card-header">';
                                        if ($root || $row['author'] == $temp){
                                        echo '<a class="ml-2 mb-1 close" href="?delete_post=&id_post='; echo $row['id']; echo '">
                                            <span aria-hidden="true">×</span>
                                        </a>';} echo $row['title']; 
                                        echo '</div>
                                            <div class="card-body">
                                                <blockquote class="blockquote mb-0">
                                                    <p>'; echo $row['message']; echo'</p>
                                                    <footer class="blockquote-footer text-white"><cite title="Source Title">'; echo $row['author']; echo '</cite></footer>
                                                </blockquote>
                                                <br>
                                                <p class="card-text"><small>'; echo $row['date']; echo '</small></p>
                                            </div>
                                    </div> <br>  
                            </div> '; 
                }
                ?> 
            </div>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true">
        <!-- Position it -->
        <div style="position: absolute; top: 75; right: 50;">
            <?php 
            $sql = "SELECT * FROM `data` WHERE `give`='$user_code'";
            $result = mysqli_query($link, $sql); 
            while($row = mysqli_fetch_array($result)) {
            echo '<div class="toast" role="alert" aria-live="assertive" data-delay="3000" data-autohide="true">
                    <div class="toast-header" >
                        <strong class="mr-auto text-primary">Внимание!</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Вы не вернули '; echo $row['name'];
            echo '</div>
                </div>';} ?>
         </div>
    </div>
<script>   
    function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("code");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");
}
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>   
    $('.toast').toast('show');
</script>
</body>
</html>
<?php
      /*if(isset($_GET['search'])) echo '<script language="JavaScript"> 
                                    window.location.href = "index.php?input='; 
                                echo $input; echo '"
                                    </script>';*/
                    echo '<div class="modal fade" id="infocode" tabindex="-1" role="dialog" aria-labelledby="#infocode" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Инфо<h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div><div class="modal-body">';            
                    echo '<a href="https://barcode.tec-it.com/barcode.ashx?data='; echo $user_code; echo '&code=Code128&dpi=96&dataseparator=&download=true" download="code">
                      <img class="card-img-top" src="https://barcode.tec-it.com/barcode.ashx?data='; echo $user_code; echo '&code=Code128&dpi=96&dataseparator=" alt="Code"/>
                  </a>
                  <div class="card-body">
                      <a href="https://barcode.tec-it.com/barcode.ashx?data='; echo $user_code; echo '&code=Code128&dpi=96&dataseparator=&download=true" download="code">
                      <h6>Cкачать изображение</h6></a>
                      <h6>Ваш индивидуальный номер для авторизации на утройстве:</h6>
                      <table>
                          <tr>
                              <td>
                              <input class="form-control mr-sm-2" id="code" value="'; echo $user_code; echo'" readonly></td><td>
                              <button class="btn btn-outline-success my-2 my-sm-0" onclick="myFunction()">Копировать</button></td>
                          </tr>
                      </table>
                      </div></div></div></div></div>';


                      echo '<div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="#notification" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Уведомления<h5><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><div class="modal-body">';
                                    $res = mysqli_query($link, $sql);
                                    if (mysqli_num_rows(mysqli_query($link, $sql)) == 0)
                                        echo '<h5 class="card-title">Уведомлений нет!</h5>';
                                    else {
                                        echo '<ul class="list-group">
                                            <li class="list-group-item">Вы не вернули:</li>';
                                        while ($row = mysqli_fetch_array($res)){
                                            echo '<li class="list-group-item list-group-item-warning">';
                                            echo $row['name']; echo "<p style='center'>Код устройтса: "; echo $row['code'];
                                            echo '</p></li>';
                                        }
                                        echo '</ul>';
                                    }
                        echo '</div></div></div></div></div>'; 
?>  