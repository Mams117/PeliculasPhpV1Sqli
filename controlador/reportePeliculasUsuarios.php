<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['idUser']) || !empty($_POST['idUser'])) {

    require('../fpdf186/fpdf.php');
    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';
    $pdf = new FPDF();
    $pdf->AddPage();

    if ($_POST['idUser'] == 0) {
        session_start();
        $_SESSION['mensaTitu'] = "Error al Generar";
        $_SESSION['mensaje'] = "Seleccione al menos algun usuario para generar un reporte";
        header("Location: ../reportes.php");
    } else {
        $idUser = $_POST['idUser'];
        require_once "../modelo/mysql.php";
        $mysql = new MySql();
        $mysql->conectar();
        $consulta = $mysql->efectuarConsulta("SELECT peliculas.peliculas.idPelicula, peliculas.peliculas.nombre_Pelicula, 
        peliculas.peliculas.descripcion_Pelicula, peliculas.peliculas.fecha FROM peliculas.peliculas WHERE peliculas.estado = 1 AND peliculas.peliculas.Usuarios_idUsuario=" . $idUser);
        $mysql->desconectar();

        ////////////

        $mysql = new MySql();
        $mysql->conectar();
        $consulta2 = $mysql->efectuarConsulta("SELECT peliculas.usuarios.user FROM peliculas.usuarios WHERE idUsuario=" . $idUser);
        $mysql->desconectar();
        $row2 = mysqli_fetch_array($consulta2);
        $nameUser = $row2['user'];

        /////




        if ($consulta->num_rows > 0) {
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->Cell(0, 10, 'Reporte de Usuario', 0, 1, 'C');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(0, 10, "Nombre De Usuario: " . $nameUser . "", 0, 1, 'C');
            $pdf->Ln(); // Salto de línea después del título
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(10, 10, '#', 1);
            $pdf->Cell(35, 10, 'Nombre', 1);
            $pdf->Cell(45, 10, 'Descripcion', 1);
            $pdf->Cell(15, 10, 'Fecha', 1);
            $pdf->Cell(45, 10, 'Generos', 1);
            $pdf->Cell(45, 10, 'Idioma', 1);
            $pdf->Ln(); // Salto de línea después de los encabezados
            $pdf->SetFont('Arial', '', 6);
            // Llenar la tabla con datos
            $ancho_celda = 60;
            $alto_celda = 10;
            while ($row = $consulta->fetch_assoc()) {
                $pdf->Cell(10, 10, $row['idPelicula'], 1);
                $pdf->Cell(35, 10, utf8_decode($row['nombre_Pelicula']), 1);
                $pdf->Cell(45, 10, utf8_decode($row['descripcion_Pelicula']), 1);
                $pdf->Cell(15, 10, utf8_decode($row['fecha']), 1);
                $mysql = new MySql();
                $mysql->conectar();
                $consulta3 = $mysql->efectuarConsulta("SELECT peliculas.generos.genero FROM peliculas.generos INNER JOIN peliculas.generos_has_peliculas INNER JOIN peliculas.peliculas WHERE generos.idGenero = generos_has_peliculas.Generos_idGenero AND peliculas.idPelicula = generos_has_peliculas.Peliculas_idPelicula AND peliculas.idPelicula =" . $row['idPelicula']);
                $mysql->desconectar();
                $generos = "";
                while ($row3 = $consulta3->fetch_assoc()) {
                    $generos = $generos . $row3['genero'] . ",";
                }

                $pdf->Cell(45, 10, utf8_decode($generos), 1);
                $mysql->conectar();
                $consulta4 = $mysql->efectuarConsulta("SELECT peliculas.idiomas.idioma FROM peliculas.idiomas INNER JOIN peliculas.peliculas_has_idiomas INNER JOIN peliculas.peliculas WHERE idiomas.idIdioma = peliculas_has_idiomas.Idiomas_idIdioma AND peliculas.idPelicula = peliculas_has_idiomas.Peliculas_idPelicula AND peliculas.idPelicula = " . $row['idPelicula']);
                $mysql->desconectar();
                $idiomas = "";
                while ($row4 = $consulta4->fetch_assoc()) {
                    $idiomas = $idiomas  . $row4['idioma'] . ",";
                }
                $pdf->Cell(45, 10, utf8_decode($idiomas), 1);
                $pdf->Ln();
            }
        } else {
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->Cell(0, 10, 'Reporte de Usuario', 0, 1, 'C');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(0, 10, 'El Usuario No tiene Peliculas Agregadas', 0, 1, 'C');
        }
        $pdf->Output();




        // Configurar la instancia de PHPMailer

        try {
            $email_user = "am17222001@gmail.com";
            $email_password = "rads ollm knxh nebn";
            $the_subject = "Phpmailer prueba by Evilnapsis.com";
            $address_to = "msmario1722@gmail.com";
            $from_name = "am17222001@gmail.com";
            $phpmailer = new PHPMailer(true);

            // ———- datos de la cuenta de Gmail ——————————-
            $phpmailer->Username = $email_user;
            $phpmailer->Password = $email_password;
            //———————————————————————–
            $phpmailer->SMTPDebug = 1;
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "smtp.gmail.com"; // GMail
            $phpmailer->Port = 465;
            $phpmailer->IsSMTP(); // use SMTP
            $phpmailer->SMTPAuth = true;

            $phpmailer->setFrom($phpmailer->Username, $from_name);
            $phpmailer->AddAddress($address_to); // recipients email

            $phpmailer->Subject = $the_subject;
            $phpmailer->Body .= "<h1 style='color:#3498db;'>Reportes!</h1>";
            $phpmailer->Body .= "<p>Aqui los reportes</p>";
            $phpmailer->Body .= "<p>Fecha y Hora: " . date("d-m-Y h:i:s") . "</p>";
            $phpmailer->IsHTML(true);
            $phpmailer->Send();
            $pdf->Output();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    }
} else {
    session_start();
    $_SESSION['mensaTitu'] = "Error al Generar";
    $_SESSION['mensaje'] = "Seleccione al menos algun usuario para generar un reporte";
    header("Location: ../reportes.php");
}
