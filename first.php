<?php
     session_start();
     include "settings/rootway.php";

 include "settings/db.php";
 $connection = connect();

 $query = mysqli_query($connection, "SELECT * FROM `user` limit 1");
 if(($query_clear = mysqli_fetch_assoc($query))){
    header(rootway() . 'sign.php');
 }

 $err = 0;
if(isset($_POST['btnlogin'])){
    $mail = mysqli_real_escape_string($connection, $_POST['mail']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    if($mail != '' && $password != ''){
        $cript = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($connection, "INSERT INTO `user` (`mail`, `password`, `role_id`) VALUES ('$mail', '$cript', '1')");
        header(rootway() . 'sign.php');
        exit();
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
    <title>В первый раз - НЕ-ЦКП</title>
</head>
<body>
   <main class="upper center">
        <h1 class="titlewhite">В перый раз</h1>
        <div class="login">
            <form action="" method="post">
            Почта<br><br>
            <input class="inp" type="email" value="<?php echo $_POST['mail']; ?>" name="mail"><br><br>
            Пароль<br><br>
            <input class="inp" type="password" name="password"><br><br>
            <input class="login__btn" value="Создать" type="submit" name="btnlogin"><br><br>
            </form>
        </div>
        <div class="info">
            <p class="info__title"><img class="info__img" src="img/info.png" alt=""> В перый раз</p>
            <p class="info__main">Поскольку на этом сервисе ещё нет ни одного пользователя, мы доверяем вам создать первого главного пользователя. Укажите почту и пароль для входа этого пользователя.</p>
        </div>
   </main>
   <script>
    <?php
        if($err == 1){
            ?>
                alert('Заполните все поля!');
            <?php
        }
    ?>
   </script>
</body>
</html>