<?php
include('config/database.php');

$f_name  = $_POST['fname'];
$l_name  = $_POST['lname'];
$e_mail  = trim($_POST['email']);
$p_sword = trim($_POST['pasword']);
$enc_pass = password_hash($p_sword, PASSWORD_BCRYPT);
$m_phone = $_POST['mphone'];

//email 
$check_email = "SELECT email FROM users_model WHERE email = '$e_mail'";
$res_email = pg_query($local_conn, $check_email);

if (pg_num_rows($res_email) > 0) {
    echo "Error: El correo electrónico '$e_mail' ya está registrado. Por favor, use uno diferente.\n";
    exit();
}

//telefono 
$check_phone = "SELECT mobile_phone FROM users_model WHERE mobile_phone = '$m_phone'";
$res_phone = pg_query($local_conn, $check_phone);

if (pg_num_rows($res_phone) > 0) {
    echo "Error: El número de celular '$m_phone' ya está registrado en nuestro sistema."; 
    exit();
}


//query to insert into sql
$sql = "INSERT INTO users_model ( first_name, last_name, email, mobile_phone, pasword )
VALUES('$f_name','$l_name','$e_mail','$m_phone','$enc_pass')" ;

// ejecutar 


$res_local = pg_query($local_conn, $sql); 
if ($res_local) {
    // --- PASO B: Si funcionó el anterior, guardar en la nube (Supabase) ---
    $res_supa = pg_query($supa_conn, $sql);

    if ($res_supa) {
        //echo "¡Listo! Guardado en ambos lados.";
        echo "<script>alert('Registro exitoso.'); </script>";
        header('refresh:0;url=login.php');
    } else {    
        echo "Error: Se guardó en local pero no en la nube.";
    }
} else {
    echo "Error: No se pudo guardar ni en local.";
}



?>