<?php
session_start();
$auth = $_SESSION["auth"];
$user_code = $_SESSION["user_code"];
$root = $_SESSION["root"];
$class = $_GET['class'];
$page = $_GET['page'];
if ($class != "mk" && $class != "kc" && $class != "or") $class = "mk";
if (!$auth) echo '<script language="JavaScript"> 
                    window.location.href = "auth.php"
                  </script>';
require_once "db/db.php";
$sql = "SELECT * FROM `users` WHERE `code`='$page'"; 
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
if($result!==FALSE){ while($row = mysqli_fetch_array($result)) 
    { $_SESSION['id'] = $row['id']; $_SESSION['login'] = $row['login']; $_SESSION['firstname'] = $row['firstname']; 
      $_SESSION['secondname'] = $row['secondname']; $_SESSION['user_group'] = $row['user_group']; $_SESSION['mail'] = $row['mail']; $_SESSION['cell'] = $row['cell'];}}
if (mysqli_num_rows($result) == 0) echo '<script language="JavaScript"> 
window.location.href = "root.php"
</script>';

?>


<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">  
    <link rel="stylesheet" href="css/main.css">
    <title><?php echo $_SESSION['login']; ?></title>
    <link rel="shortcut icon" href="/icon/user.png" type="image/x-icon">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">ШКАФ</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="auditory.php">Аудитории</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="history.php">Журнал</a>
                </li>
                </ul>
                <?php  
                    if ($root) echo '
                    <form class="form-inline my-2 my-lg-0 method=POST"><button class="btn btn-outline-primary my-2 my-sm-0" name="reg" type="submit">Новый пользователь</button>&#8194;</form>
                    <form class="form-inline my-2 my-lg-0 method=POST"><button class="btn btn-outline-primary my-2 my-sm-0" name="root" type="submit">Управление</button>&#8194;</form>'; ?>
                    <form class="form-inline my-2 my-lg-0 method=POST"><input class="form-control mr-sm-2" type="search" name="input" placeholder="Поиск..." aria-label="Поиск...">
                        <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Найти</button>&#8194;
                        <button class="btn btn-outline-danger my-2 my-sm-0" name="exit" type="submit">Выход</button>
                    </form>
            </div>
        </nav>          
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
                </div>    
                <br>
             </div>             
             <div class="col-md-auto">
                <div class="card mb-3" style="max-width: 18rem;">
                    <ul class="list-group">
                    <li class="list-group-item">На руках:</li>
                    <?php
                        $sql = "SELECT * FROM `data` WHERE `give`='$page'";
                        $res = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($res)){
                            echo '<li class="list-group-item list-group-item-warning">';
                            echo $row['name']; echo "<p style='center'>Код устройтса: "; echo $row['code'];
                            echo '</p></li>';}
                    ?>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="card" style="width: 18rem;">
                    <a href="https://barcode.tec-it.com/barcode.ashx?data=<?php echo $page;?>&code=Code128&dpi=96&dataseparator=&download=true" download="code">
                        <img class="card-img-top" src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $page;?>&code=Code128&dpi=96&dataseparator=' alt='Code'/>
                        
                    </a>
                    <div class="card-body">
                        <a href="https://barcode.tec-it.com/barcode.ashx?data=<?php echo $page;?>&code=Code128&dpi=96&dataseparator=&download=true" download="code">
                        <h6>Cкачать изображение</h6></a>
                        <h6>Индивидуальный номер <?php echo $_SESSION['secondname'];?> для авторизации на утройстве:</h6>
                        <table>
                            <tr>
                                <td>
                                <input class="form-control mr-sm-2" id="code" value="<?php echo $page;?>" readonly></td><td>
                                <button class="btn btn-outline-success my-2 my-sm-0" onclick="myFunction()">Копировать</button></td>
                            </tr>
                        </table>
                    </div>
                </div>    
                <br>
             </div>
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
</body>
</html>
<?php if(isset($_GET['exit'])) {$_SESSION['auth'] = 0; 
                    echo '<script language="JavaScript"> 
                            window.location.href = "index.php"
                          </script>';} 
      if(isset($_GET['root'])) echo '<script language="JavaScript"> 
                                    window.location.href = "root.php"
                                    </script>';
      /*if(isset($_GET['search'])) echo '<script language="JavaScript"> 
                                    window.location.href = "index.php?input='; 
                                echo $input; echo '"
                                    </script>';*/
                                    
?>