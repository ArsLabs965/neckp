<?php
     session_start();
     include "settings/rootway.php";
 if($_SESSION['user'] != NULL){
     header(rootway() . 'main.php');
     exit();
 }


 include "settings/db.php";
 $connection = connect();

 $query = mysqli_query($connection, "SELECT * FROM `user` limit 1");
 if(!($query_clear = mysqli_fetch_assoc($query))){
    header(rootway() . 'first.php');
 }

 $err = 0;
if(isset($_POST['btnlogin'])){
    $mail = mysqli_real_escape_string($connection, $_POST['mail']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    if($mail != '' && $password != ''){
        $query = mysqli_query($connection, "SELECT * FROM `user` WHERE `mail` = '$mail'");
        if(($query_clear = mysqli_fetch_assoc($query))){
            if (password_verify($password, $query_clear['password'])) {
                $_SESSION['user'] = $query_clear['id'];
                header(rootway() . 'main.php');
                exit();
            }else{
                $err = 2;
            }
            
        }else{
            $err = 2;
        }
    }else{
        $err = 1;
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@300&display=swap" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="/img/row.png">
    <title>Вход - НЕ-ЦКП</title>
</head>
<body>
   <main class="upper center">
   <h1 class="titlewhite">Вход</h1>
        <div class="login">
            <form action="" method="post">
            Почта<br><br>
            <input class="inp" type="email" value="<?php echo $_POST['mail']; ?>" name="mail"><br><br>
            Пароль<br><br>
            <input class="inp" type="password" name="password"><br><br>
            <input class="login__btn" value="Войти" type="submit" name="btnlogin"><br><br>
            </form>
            <a class="login__forget" href="#">Я не помню пароль</a>
        </div>
        <div class="info">
            <p class="info__title"><img class="info__img" src="img/info.png" alt=""> По-другому никак</p>
            <p class="info__main">Чтобы пользоваться сервисом, необходимо войти.</p>
        </div>
        <div class="info">
            <p class="info__title"><img class="info__img" src="img/info.png" alt=""> Не можете войти?</p>
            <p class="info__main">Вы можете восстановить пароль надав на ссылку "Я не помню пароль".</p>
        </div>
   </main>
   <script>
    <?php
        if($err == 1){
            ?>
                alert('Заполните все поля!');
            <?php
        }
        if($err == 2){
            ?>
                alert('Неверная Почта или Пароль');
            <?php
        }
    ?>
   </script>
</body>
</html>