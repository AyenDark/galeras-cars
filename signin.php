<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}


// Recibimos los datos tal cual los tienes en tu HTML y base de datos (con una 's')
$e_mail = $_POST['email'] ?? '';
$p_sword = $_POST['pasword'] ?? ''; 

// Buscamos al usuario ÚNICAMENTE por su correo
$sql_login = "
SELECT 
    u.id,
    u.email,
    u.pasword, -- Traemos el hash guardado en el signup
    u.first_name || ' ' || u.last_name as fullname
FROM users_model u
WHERE u.email = '$e_mail'
";

$res = pg_query($local_conn, $sql_login);

if($res){
    $num = pg_num_rows($res);
    $row = pg_fetch_assoc($res);
    if($num > 0){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_fullname'] = $row['fullname'];
        header ('refresh: 0;url=index.php');
    }else{
        echo "<script> alert ('Email or password not found.') </script>";
        header ('refresh: 0;url=register.html');

    }

}else{
    echo "Query error !!!.";
}

?>