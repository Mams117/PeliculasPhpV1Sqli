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
$consulta3 = $mysql->efectuarConsulta("SELECT COUNT(peliculas.peliculas.idPelicula) AS cantidadPeli FROM peliculas.peliculas WHERE estado=1");
$mysql->desconectar();

$row3 = mysqli_fetch_array($consulta3);
$cantidadPeliculas = $row3['cantidadPeli'];


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
        'color' => ['rgb' => '00000'], // Color de fuente rojo
    ],
    'fill' => [
        'fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00b96a'], // Color de fondo amarillo
    ],
];

$sheet->getStyle('C3')->applyFromArray($styleArray);
$sheet->getStyle('D3')->applyFromArray($styleArray);
$sheet->getStyle('E3')->applyFromArray($styleArray);
$sheet->getStyle('C4')->applyFromArray($styleArray);
$sheet->getStyle('D4')->applyFromArray($styleArray);
$sheet->getStyle('C6')->applyFromArray($styleArray);
$sheet->getStyle('D6')->applyFromArray($styleArray);
// Agrega datos a la hoja de trabajo
$i = 8;
$sheet->setCellValue('C3', 'Reporte Promedio de Peliculas');
$sheet->setCellValue('C4', 'Por Genero e Idioma');
$sheet->setCellValue('C6', 'Por Generos: ');
while ($row = mysqli_fetch_array($consulta)) {
    $sheet->setCellValue('C' . $i, $row['genero'] . " :");
    $mysql->conectar();
    $consulta4 = $mysql->efectuarConsulta("SELECT COUNT(peliculas.idPelicula) AS cantidad FROM peliculas.peliculas INNER JOIN peliculas.generos 
    INNER JOIN peliculas.generos_has_peliculas WHERE 
    generos.idGenero = generos_has_peliculas.Generos_idGenero AND 
    peliculas.idPelicula = generos_has_peliculas.Peliculas_idPelicula AND generos.idGenero =" . $row['idGenero']);
    $mysql->desconectar();
    while ($row4 = mysqli_fetch_array($consulta4)) {
        $resultado = 0;
        $cantGeneros = $row4['cantidad'];
        if ($cantidadPeliculas == 0 || $cantGeneros == 0) {
            $resultado = 0;
        } else {
            $resultado =  $cantGeneros / $cantidadPeliculas;
        }
        $sheet->setCellValue('D' . $i, $resultado);
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
        $resultado2 = 0;
        $cantIdiomas = $row5['cantidad'];
        if ($cantidadPeliculas == 0 || $cantIdiomas == 0) {
            $resultado2 = 0;
        } else {
            $resultado2 = $cantIdiomas / $cantidadPeliculas;
        }

        $sheet->setCellValue('D' . $i + 3, $resultado2);
    }
    $i = $i + 1;
}

// Crea un objeto Writer para guardar el archivo
$writer = new Xlsx($spreadsheet);

// Nombre del archivo Excel
$filename = 'reportePromedio.xlsx';

// Configura las cabeceras para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Guarda el archivo en la salida (output)
$writer->save('php://output');

exit;
