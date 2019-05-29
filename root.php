<?php
session_start();
$auth = $_SESSION["auth"];
$user_code = $_SESSION["user_code"];
$root = $_SESSION["root"];
$class = $_GET['class'];
if (isset($_GET['search'])) {echo '<script language="JavaScript"> 
    window.location.href = "auditory.php?search=&input='; echo $_GET['input']; echo '"
    </script>';}
if (!$root) echo '<script language="JavaScript"> 
                    window.location.href = "index.php"
                  </script>';
if ($class != "mk" && $class != "kc" && $class != "or") $class = "mk";
if (!$auth) echo '<script language="JavaScript"> 
                    window.location.href = "auth.php"
                  </script>';

if(isset($_GET['reg'])) echo '<script language="JavaScript"> 
                    window.location.href = "reg.php"
                    </script>';
require_once "db/db.php";
if (isset($_GET['delete'])){
            $id = $_GET['id'];
    $sql = "DELETE FROM `data` WHERE `id`='$id'";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
}
if (isset($_POST['save'])){
            $id = $_POST['id'];
            $code = $_POST['code'];
            $serial = $_POST['serial'];
            $name = $_POST['name'];
            foreach($_POST['classSelect'] as $class);
    $sql = "UPDATE `data` SET `serial`='$serial',`name`='$name',`class`='$class' WHERE `code`='$code'";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
    echo '<script language="JavaScript"> 
        window.location.href = "root.php"
    </script>';
}
if (isset($_POST['add'])){
            $id = $_POST['id'];
            $code = $_POST['code'];
            $serial = $_POST['serial'];
            $name = $_POST['name'];
            foreach($_POST['classSelect'] as $class);
    $sql = "INSERT INTO `data`(`code`, `serial`, `name`, `give`, `class`) VALUES ('$code','$serial','$name','В наличии','$class')";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
} 

if (isset($_POST['filter'])){
    foreach($_POST['serch_order'] as $by);
    $input2 = $_POST['input2'];       
    $sql = "SELECT * FROM `data` WHERE `$by` LIKE '%$input2%' or `name` LIKE '$input2%' or `name` LIKE '%$input2'";}
else
    $sql = "SELECT * FROM `data` ORDER BY id ASC";
if ($_GET['by'] == "serial1")
    $sql = "SELECT * FROM `data` ORDER BY serial ASC";  
if ($_GET['by'] == "serial2")
    $sql = "SELECT * FROM `data` ORDER BY serial DESC";                              
if ($_GET['by'] == "code1")
    $sql = "SELECT * FROM `data` ORDER BY code ASC";  
if ($_GET['by'] == "code2")
    $sql = "SELECT * FROM `data` ORDER BY code DESC"; 
if ($_GET['by'] == "name1")
    $sql = "SELECT * FROM `data` ORDER BY name ASC";  
if ($_GET['by'] == "name2")
    $sql = "SELECT * FROM `data` ORDER BY name DESC";  
if ($_GET['by'] == "give1")
    $sql = "SELECT * FROM `data` ORDER BY give ASC";  
if ($_GET['by'] == "give2")
    $sql = "SELECT * FROM `data` ORDER BY give DESC";  
if ($_GET['by'] == "class1")
    $sql = "SELECT * FROM `data` ORDER BY class ASC";  
if ($_GET['by'] == "class2")
    $sql = "SELECT * FROM `data` ORDER BY class DESC";  
                        
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
?>


<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">  
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="/icon/edit.png" type="image/x-icon">
    <title>Управление</title>
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
                if ($root) echo '
                <form class="form-inline my-2 my-lg-0 method=POST"><button class="btn btn-outline-primary my-2 my-sm-0" name="reg" type="submit">Новый пользователь</button>&#8194;</form>
                <form class="form-inline my-2 my-lg-0 method=POST"><button class="btn btn-outline-primary my-2 my-sm-0" name="root" type="submit">Управление</button>&#8194;</form>'; ?>
                <form class="form-inline my-2 my-lg-0 method=POST"><input class="form-control mr-sm-2" type="search" name="input" placeholder="Поиск..." aria-label="Поиск...">
                    <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Найти</button>&#8194;
                    <button class="btn btn-outline-danger my-2 my-sm-0" name="exit" type="submit">Выход</button>
                </form>
            </div>
        </nav><br>
        <div class="container"> 
        <?php 
        $id = $_GET['id'];
        if($result!==FALSE){ while($row = mysqli_fetch_array($result)) { if ($row['id'] == $id) break; } } 
        if (isset($_GET['edit'])){
            if ($row["class"] == "mk") {$option3 = "mk"; $option4 = "kc"; $option5 = "or";} else if ($row["class"] == "kc") {$option3 = "kc"; $option4 = "or"; $option5 = "mk";} else {$option3 = "or"; $option4 = "mk"; $option5 = "kc";};
            printf ('<form method="POST"><div class="scroll-table"><table border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered mb-0"><tr>
                     <td>CODE</td>
                     <td>SERIAL</td>
                     <td>NAME</td>
                     <td>CLASS</td>
                     <td>Действие</td>
                     </tr>
                     <tr>
                     <td><input class="form-control mr-sm-2" type="text" name="code" value="%s" readonly></td>
                     <td><input class="form-control mr-sm-2" type="text" name="serial" value="%s"></td>
                     <td><input class="form-control mr-sm-2" type="text" name="name" value="%s"></td>
                     <td><select class="custom-select" name="classSelect[]">
                     <option value="%s">%s</option>
                     <option value="%s">%s</option>
                     <option value="%s">%s</option></td>
                     <td><button class="btn btn-outline-success my-2 my-sm-0" name="save" type="submit">Сохранить</button></td>
                     </tr></table></div></form>', 
                     $row["code"], $row["serial"], $row["name"], $option3, $option3, $option4, $option4, $option5, $option5, $row["class"]);                     
        } 
        else {   
            date_default_timezone_set("UTC");
            $gen_code = date("iBHNsBdN");        
        if ($row["class"] == "mk") {$option3 = "mk"; $option4 = "kc"; $option5 = "or";} else if ($row["class"] == "kc") {$option3 = "kc"; $option4 = "or"; $option5 = "mk";} else {$option3 = "or"; $option4 = "mk"; $option5 = "kc";};
            printf ('<form method="POST"><div class="scroll-table"><table border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered mb-0"><tr>
            <td>CODE</td>
            <td>SERIAL</td>
            <td>NAME</td>
            <td>CLASS</td>
            <td>Действие</td>
            </tr>
            <tr>
            <td><input class="form-control" type="text" name="code" value="%s" readonly></td>
            <td><input class="form-control" type="text" name="serial" required></td>
            <td><input class="form-control" type="text" name="name" required></td>
            <td><select class="custom-select" name="classSelect[]">
            <option value="%s">%s</option>
            <option value="%s">%s</option>
            <option value="%s">%s</option></td>
            <td><button class="btn btn-outline-success my-2 my-sm-0" name="add" type="submit">Добавить</button></td>
            </tr></table></div></form>', 
            $gen_code, $option3, $option3, $option4, $option4, $option5, $option5, $row["class"]);

        }       
        $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
        ?>
        <form class="form-inline my-2 my-lg-0" method="POST">
                <div style="margin: auto;">
                <kbd class="btn btn-outline-dark disabled" >Искать по</kbd>
                <select class="custom-select" name="serch_order[]">
                    <option value="code">CODE</option>
                    <option value="serial">SERIAL</option>
                    <option value="name">NAME</option>
                    <option value="give">GIVE</option>
                    <option value="class">CLASS</option>
                </select>&nbsp;<input class="form-control mr-sm-2" type="search" name="input2" placeholder="Поиск..." aria-label="Поиск...">
                <button class="btn btn-outline-success my-2 my-sm-0" name="filter" type="submit">Поиск</button>&nbsp;
                <button class="btn btn-outline-danger my-2 my-sm-0" name="emply" type="submit">Сбросить</button> </div>
        </form>
        <br>
        <center><h5>Результат <?php echo mysqli_num_rows(mysqli_query($link, $sql));?>/<?php echo mysqli_num_rows(mysqli_query($link, "SELECT * FROM `data`"));?></h5></center>
        <div class="scroll-table" style="height: 500px;">
            <table border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered mb-0">                  
                        <thead>
                            <tr>
                                <th><a href="?by=code1">&#8593;</a><a href="?by=code2">&#8595;</a> CODE</th>
                                <th><a href="?by=serial1">&#8593;</a><a href="?by=serial2">&#8595;</a> SERIAL</th>
                                <th><a href="?by=name1">&#8593;</a><a href="?by=name2">&#8595;</a> NAME</th>
                                <th><a href="?by=give1">&#8593;</a><a href="?by=give2">&#8595;</a> GIVE</th>
                                <th><a href="?by=class1">&#8593;</a><a href="?by=class2">&#8595;</a> Class</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($result!==FALSE){
                                while($row = mysqli_fetch_array($result)) {
                                    printf("<tr><td> &nbsp;%s&nbsp;</td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;<a href='user.php?page=%s'>%s</a>&nbsp; </td><td> &nbsp;%s&nbsp; </td><td><a href='?delete=1&by=%s&id=%s'>Удалить</a><a href='?edit=1&by=%s&id=%s&class=%s'>   Редактировать</a></td></tr>",
                                    $row["code"], $row["serial"], $row["name"], $row["give"], $row["give"], $row["class"], $_GET['by'], $row["id"] , $_GET['by'], $row["id"], $row["class"] ); 
                                }
                                mysqli_free_result($result);
                            }
                            ?>
                        </tbody>
            </table>
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
            
?>   