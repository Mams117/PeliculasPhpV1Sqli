<?php

if (isset($_POST['fechaInicio']) || !empty($_POST['fechaInicio']) && isset($_POST['fechaFin']) || isset($_POST['fechaFin'])) {
    $fechaIni = $_POST['fechaInicio'];
    $fechaIni2 = strtotime($fechaIni);
    $fechaIniFormateada = date("Y-m-d", $fechaIni2);

    $fechaFin = $_POST['fechaFin'];
    $fechaFin2 = strtotime($fechaFin);
    $fechaFinFormateada = date("Y-m-d", $fechaFin2);

    if ($fechaIni == "" || $fechaFin == "") {
        session_start();
        $_SESSION['mensaTitu'] = "Error al Generar";
        $_SESSION['mensaje'] = "Seleccione un rango en los dos campos de Fecha";
        header("Location: ../reportes.php");
    } else {
        require_once "../modelo/mysql.php";
        $mysql = new MySql();
        $mysql->conectar();
        $consulta = $mysql->efectuarConsulta("SELECT peliculas.idPelicula, peliculas.nombre_Pelicula, peliculas.descripcion_Pelicula, peliculas.fecha FROM peliculas.peliculas WHERE peliculas.estado= 1 AND peliculas.fecha BETWEEN '" . $fechaIniFormateada . "'  AND  '" . $fechaFinFormateada . "'");
        $mysql->desconectar();

        require('../fpdf186/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();

        if ($consulta->num_rows > 0) {
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->Cell(0, 10, 'Reporte de Peliculas', 0, 1, 'C');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(0, 10, 'Rango de Fecha', 0, 1, 'C');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(0, 10, "Fecha Inicio: " . $fechaIni, 0, 1, 'C');
            $pdf->Cell(0, 10, "Fecha Fin: " . $fechaFin, 0, 1, 'C');
            $pdf->Ln(); // Salto de línea después del título
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(10, 10, '#', 1);
            $pdf->Cell(35, 10, 'Nombre', 1);
            $pdf->Cell(45, 10, 'Descripcion', 1);
            $pdf->Cell(20, 10, 'Fecha', 1);
            $pdf->Cell(43, 10, 'Generos', 1);
            $pdf->Cell(43, 10, 'Idioma', 1);
            $pdf->Ln(); // Salto de línea después de los encabezados
            $pdf->SetFont('Arial', '', 8);
            // Llenar la tabla con datos
            while ($row = $consulta->fetch_assoc()) {
                $pdf->Cell(10, 10, $row['idPelicula'], 1);
                $pdf->Cell(35, 10, utf8_decode($row['nombre_Pelicula']), 1);
                $pdf->Cell(45, 10, utf8_decode($row['descripcion_Pelicula']), 1);
                $pdf->Cell(20, 10, $row['fecha'], 1);
                $mysql = new MySql();
                $mysql->conectar();
                $consulta3 = $mysql->efectuarConsulta("SELECT peliculas.generos.genero FROM peliculas.generos INNER JOIN peliculas.generos_has_peliculas INNER JOIN peliculas.peliculas WHERE generos.idGenero = generos_has_peliculas.Generos_idGenero AND peliculas.idPelicula = generos_has_peliculas.Peliculas_idPelicula AND peliculas.idPelicula =" . $row['idPelicula']);
                $mysql->desconectar();
                $generos = "";
                while ($row3 = $consulta3->fetch_assoc()) {
                    $generos = $generos  . $row3['genero'] . ",";
                }
                $pdf->Cell(43, 10, utf8_decode($generos), 1);
                $mysql->conectar();
                $consulta4 = $mysql->efectuarConsulta("SELECT peliculas.idiomas.idioma FROM peliculas.idiomas INNER JOIN peliculas.peliculas_has_idiomas INNER JOIN peliculas.peliculas WHERE idiomas.idIdioma = peliculas_has_idiomas.Idiomas_idIdioma AND peliculas.idPelicula = peliculas_has_idiomas.Peliculas_idPelicula AND peliculas.idPelicula = " . $row['idPelicula']);
                $mysql->desconectar();
                $idiomas = "";
                while ($row4 = $consulta4->fetch_assoc()) {
                    $idiomas = $idiomas  . $row4['idioma'] . ",";
                }
                $pdf->Cell(43, 10, utf8_decode($idiomas), 1);
                $pdf->Ln();
            }
        } else {
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->Cell(0, 10, 'Reporte de Peliculas', 0, 1, 'C');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(0, 10, 'No hay peliculas en el Rango Establecido', 0, 1, 'C');
        }
        

        $pdf->Output();
    }
}
