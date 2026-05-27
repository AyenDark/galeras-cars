<?php
session_start();

// Si ya tiene sesión activa, lo mandamos al index directamente
if(isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}

// 1. Incluimos la configuración de las bases de datos
require_once('config/database.php');

// Recibimos los datos limpios de espacios
$e_mail = isset($_POST['email']) ? trim($_POST['email']) : '';
$p_sword = isset($_POST['pasword']) ? trim($_POST['pasword']) : ''; 

if (empty($e_mail) || empty($p_sword)) {
    echo "<script>
            alert('Por favor, llene todos los campos.');
            window.location.href = 'login.html';
          </script>";
    exit();
}

// SEGURIDAD: Escapar el email para evitar Inyección SQL
$e_mail_escaped = pg_escape_string($local_conn, $e_mail);

// 2. Buscamos al usuario ÚNICAMENTE por su correo
// Usamos CONCAT para evitar problemas si un apellido/nombre es NULL
$sql_login = "
SELECT 
    u.id,
    u.email,
    u.pasword,
    CONCAT(u.first_name, ' ', u.last_name) as fullname
FROM users_model u
WHERE u.email = '$e_mail_escaped'
";

$res = pg_query($local_conn, $sql_login);

if($res){
    $num = pg_num_rows($res);
    
    if($num > 0){
        $row = pg_fetch_assoc($res);
        
        // 3. Verificamos la contraseña con el hash
        if(password_verify($p_sword, trim($row['pasword']))){
            
            // Si coincide, creamos la sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_fullname'] = $row['fullname'];
            
            // Redirección limpia mediante JS para que el alert funcione sí o sí
            echo "<script>
                    alert('¡Bienvenido! Inicio de sesión exitoso.');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Contraseña incorrecta.');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('El correo electrónico no está registrado.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }

} else {
    echo "Query error !!!.";
}
?>