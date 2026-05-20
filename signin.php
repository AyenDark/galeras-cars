<?php

require('config/database.php');

$e_mail = $_POST['email'];
$p_sword = $_POST['pswd'];

$sql_login = "
SELECT * FROM users_model
WHERE email = '$e_mail'
";
$res = pg_query($local_conn, $sql_login);

if($res){
    if(pg_num_rows($res) > 0){
        $user = pg_fetch_assoc($res);
        if(password_verify($p_sword, $user['pasword'])){
            header('Location: index.html');
        } else {
            echo "<script>alert('Password incorrecto')</script>";
            header('refresh:0;url=login.html');
        }
    } else {
        echo "<script>alert('Usuario no encontrado')</script>";
        header('refresh:0;url=login.html');
    }
} else {
    echo "Query error !!!";
}
?>