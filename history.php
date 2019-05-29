<?php
session_start();
$auth = $_SESSION["auth"];
$user_code = $_SESSION["user_code"];
$root = $_SESSION["root"];
if (isset($_GET['search'])) {echo '<script language="JavaScript"> 
window.location.href = "auditory.php?search=&input='; echo $_GET['input']; echo '"
</script>';}
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
    <link rel="shortcut icon" href="/icon/db.png" type="image/x-icon">
    <title>Журнал</title>
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
                    <a class="nav-link active" href="history.php">Журнал</a>
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
        <div class="container">
        <div class="scroll-table" style="height: 500px;">
            <table border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered mb-0">
                <tr>
                    <td>№</td><td>ID пользователя</td><td>ID оборудования</td><td>Дата</td><td>Инфо</td>
                </tr>
                <?php             
                    $sql = "SELECT * FROM `history` ORDER BY 'id' DESC";
                    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
                    if($result!==FALSE){
                        $i = 1;
                    while($row = mysqli_fetch_array($result)) {
                        printf("<tr><td> &nbsp;%s&nbsp;</td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>",
                        $i, $row["user_code"], $row["data_code"], $row["date"], $row["mode"]);
                        $i++;
                    }
                    mysqli_free_result($result);
                }
                ?>
            </table>     
        </div>               
    </div>
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