<?php
session_start();
$auth = $_SESSION["auth"];
$user_code = $_SESSION["user_code"];
$root = $_SESSION["root"];
$class = $_GET['class'];
if ($class != "mk" && $class != "kc" && $class != "or" && $class != "") $class = "";
if (!$auth) echo '<script language="JavaScript"> 
                    window.location.href = "auth.php"
                  </script>';
require_once "db/db.php";
?>


<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">  
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="/icon/search.png" type="image/x-icon">
    <title>Информация</title>
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
                    <a class="nav-link active" href="auditory.php">Информация</a>
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
          
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs">                    
                    <?php if (isset($_GET['search'])){
                    $class="search";
                    echo '<li class="nav-item">
                        <a class="nav-link active">Результаты поиска</a>
                     </li>'; }?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($class=="") echo "active";?>" href="?class=">Всё</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($class=="mk") echo "active";?>" href="?class=mk">Микрокотроллеры</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($class=="kc") echo "active";?>" href="?class=kc">Кейсы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($class=="or") echo "active";?>" href="?class=or">Другое</a>
                    </li>  
                </ul>
                <div class="scroll-table" style="height: 500px;">
                    <table border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered mb-0">
                            <tr>
                                <td>CODE</td><td>SERIAL</td><td>NAME</td><td>GIVE</td>
                            </tr>
                            <?php          
                            $input = $_GET['input'];
                            if ($class == "search")        
                                $sql = "SELECT * FROM `data` WHERE `name` LIKE '%$input%' or `name` LIKE '$input%' or `name` LIKE '%$input'";
                            else if ($class == "")        
                                $sql = "SELECT * FROM `data`";
                            else
                                $sql = "SELECT * FROM `data` WHERE `class`='$class' ORDER BY 'id' DESC";
                            $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
                            if($result!==FALSE){
                                while($row = mysqli_fetch_array($result)) {
                                    if ($row["give"] == "В наличии")
                                        printf("<tr><td>&nbsp;%s&nbsp; </td><td>&nbsp;%s&nbsp; </td><td><a href='?search=&input=%s'>  &nbsp;%s&nbsp; </a></td><td> &nbsp;%s&nbsp; </td></tr>",
                                    $row["code"], $row["serial"], $row["name"], $row["name"], $row["give"]);
                                }
                                mysqli_free_result($result);
                            }
                            ?>
                    </table>  
                </div>
            </div>
        </div> 
        <div class="toast ml-auto" role="alert" data-delay="3000" data-autohide="true" style="position: absolute; bottom: 10; right: 25;">
            <div class="toast-header" >
                <strong class="mr-auto text-primary">Подсказка</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="toast-body">
                Что-бы найти необходимое оборудование воспользуйтесь поиском или нажмите на название обородувания в таблице.
            </div>
        </div>       
            
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>   
    $('.toast').toast('show');
</script>
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