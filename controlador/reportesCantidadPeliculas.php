<?php

require_once "../modelo/mysql.php";
$mysql = new MySql();
/////////////
$mysql->conectar();
$consulta = $mysql->efectuarConsulta("SELECT peliculas.generos.idGenero, peliculas.generos.genero FROM peliculas.generos");
$mysql->desconectar();
////////////
$mysql->conectar();
$consulta2 = $mysql->efectuarConsulta("SELECT peliculas.idiomas.idIdioma, peliculas.idiomas.idioma FROM peliculas.idiomas");
$mysql->desconectar();
//////
$mysql->conectar();
$consulta3 = $mysql->efectuarConsulta("SELECT peliculas.usuarios.idUsuario, peliculas.usuarios.user FROM peliculas.usuarios;");
$mysql->desconectar();



require '../vendor/autoload.php'; // Incluye el autoload de Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crea una instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator("Jota")->setTitle("Reporte Cantidad Peliculas");
$spreadsheet->setActiveSheetIndex(0);
// Crea una hoja de trabajo
$sheet = $spreadsheet->getActiveSheet();
$styleArray = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFF'], // Color de fuente rojo
    ],
    'fill' => [
        'fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00b96a'], // Color de fondo amarillo
    ],
];

$sheet->getStyle('C3')->applyFromArray($styleArray);
$sheet->getStyle('D3')->applyFromArray($styleArray);
$sheet->getStyle('E3')->applyFromArray($styleArray);
$sheet->getStyle('C5')->applyFromArray($styleArray);
$sheet->getStyle('D5')->applyFromArray($styleArray);
// Agrega datos a la hoja de trabajo
$i = 7;
$sheet->setCellValue('C3', 'Reporte Cantidad Peliculas');
$sheet->setCellValue('C5', 'Por Generos: ');
while ($row = mysqli_fetch_array($consulta)) {
    $sheet->setCellValue('C' . $i, $row['genero'] . " :");
    $mysql->conectar();
    $consulta4 = $mysql->efectuarConsulta("SELECT COUNT(peliculas.idPelicula) AS cantidad FROM peliculas.peliculas INNER JOIN peliculas.generos 
    INNER JOIN peliculas.generos_has_peliculas WHERE 
    generos.idGenero = generos_has_peliculas.Generos_idGenero AND 
    peliculas.idPelicula = generos_has_peliculas.Peliculas_idPelicula AND generos.idGenero =" . $row['idGenero']);
    $mysql->desconectar();
    while ($row4 = mysqli_fetch_array($consulta4)) {
        $sheet->setCellValue('D' . $i, $row4['cantidad']);
    }
    $i = $i + 1;
}
$sheet->setCellValue('C' . $i + 1, 'Por Idiomas: ');
$sheet->getStyle('C' . $i + 1)->applyFromArray($styleArray);
$sheet->getStyle('D' . $i + 1)->applyFromArray($styleArray);
while ($row2 = mysqli_fetch_array($consulta2)) {
    $sheet->setCellValue('C' . $i + 3, $row2['idioma'] . " :");
    $mysql->conectar();
    $consulta5 = $mysql->efectuarConsulta("SELECT COUNT(peliculas.idPelicula) AS cantidad FROM peliculas.peliculas INNER JOIN peliculas.idiomas 
    INNER JOIN peliculas.peliculas_has_idiomas WHERE 
    idiomas.idIdioma = peliculas_has_idiomas.Idiomas_idIdioma AND 
    peliculas.idPelicula = peliculas_has_idiomas.Peliculas_idPelicula AND idiomas.idIdioma =" . $row2['idIdioma']);
    $mysql->desconectar();
    while ($row5 = mysqli_fetch_array($consulta5)) {
        $sheet->setCellValue('D' . $i + 3, $row5['cantidad']);
    }
    $i = $i + 1;
}
$sheet->setCellValue('C' . $i + 4, 'Por Usuarios: ');
$sheet->getStyle('C' . $i + 4)->applyFromArray($styleArray);
$sheet->getStyle('D' . $i + 4)->applyFromArray($styleArray);
while ($row3 = mysqli_fetch_array($consulta3)) {
    $sheet->setCellValue('C' . $i + 6, $row3['user'] . " :");
    $mysql->conectar();
    $consulta6 = $mysql->efectuarConsulta("SELECT COUNT(peliculas.idPelicula) AS cantidad FROM peliculas.peliculas INNER JOIN peliculas.usuarios 
    WHERE usuarios.idUsuario = peliculas.Usuarios_idUsuario AND usuarios.idUsuario=" . $row3['idUsuario']);
    $mysql->desconectar();
    while ($row6 = mysqli_fetch_array($consulta6)) {
        $sheet->setCellValue('D' . $i + 6, $row6['cantidad']);
    }
    $i = $i + 1;
}


// Crea un objeto Writer para guardar el archivo
$writer = new Xlsx($spreadsheet);

// Nombre del archivo Excel
$filename = 'reporteCantidad.xlsx';
// Configura las cabeceras para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Guarda el archivo en la salida (output)
$writer->save('php://output');



exit;
