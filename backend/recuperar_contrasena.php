<?php
    require_once "conexion.php";
    require_once '../PHPMailer/src/Exception.php';
    require_once '../PHPMailer/src/PHPMailer.php';
    require_once '../PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $mensaje = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $correo = $_POST['correo'];

        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt -> bind_result($user_id);

        if($stmt->fetch()){
            $stmt->close();

            $token = bin2hex(random_bytes(32));
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $stmt = $conexion->prepare('INSERT INTO password_resets (id_usuario, token, expira) VALUES (?, ?, ?)');
            $stmt->bind_param('iss', $user_id, $token, $expira);
            $stmt->execute();

            $enlace = "http://localhost/to-do-super-pro-/frontend/nueva_contrasena.html?token=$token";

            $email = new PHPMailer(true);
            try {
                $email->isSMTP();
                $email->Host = 'smtp.gmail.com';
                $email->SMTPAuth = true;
                $email->Username = 'alebetan09@gmail.com';
                $email->Password = 'ikotzxbsxbrkperx';
                $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $email->Port = 587;

                $email->setFrom('alebetan09@gmail.com', 'Recuperar Contraseña');
                $email->addAddress($correo);

                $email->isHTML(true);
                $email->Subject = 'Recuperar Contraseña';
                $email->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$enlace'>$enlace</a>. Este enlace expirará en 1 hora.";
                $email->send();
                $mensaje = "Revisa tu correo.";

               
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$email->ErrorInfo}";
            }
        }
    }
?>