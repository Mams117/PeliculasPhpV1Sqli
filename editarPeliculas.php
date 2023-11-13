
<?php
require_once './modelo/usuario.php';
$usuario = new usuarios();
session_start();
$idUser2 = $_SESSION['idUsuario'];
$nameUser = $_SESSION['user'];
$idPelicula = $_GET['id'];
/////
require_once "modelo/mysql.php";
$mysql = new MySql();
$mysql->conectar();
$consulta = $mysql->efectuarConsulta("SELECT peliculas.generos.idGenero, peliculas.generos.genero FROM peliculas.generos");
$mysql->desconectar();
///
$mysql->conectar();
$consulta2 = $mysql->efectuarConsulta("SELECT peliculas.idiomas.idIdioma, peliculas.idiomas.idioma FROM peliculas.idiomas");
$mysql->desconectar();

///////////////////////
$mysql->conectar();
$consulta3 = $mysql->efectuarConsulta("SELECT peliculas.peliculas.nombre_Pelicula,peliculas.peliculas.descripcion_Pelicula FROM peliculas.peliculas WHERE idPelicula=" . $idPelicula);
$mysql->desconectar();
$row3 = mysqli_fetch_array($consulta3);
$nombrePeli = $row3['nombre_Pelicula'];
$descripcionPeli = $row3['descripcion_Pelicula'];
///////////////////////////
$mysql->conectar();
$consulta4 = $mysql->efectuarConsulta("SELECT peliculas.generos.genero FROM peliculas.generos INNER JOIN peliculas.generos_has_peliculas INNER JOIN peliculas.peliculas WHERE generos.idGenero = generos_has_peliculas.Generos_idGenero AND peliculas.idPelicula = generos_has_peliculas.Peliculas_idPelicula AND peliculas.idPelicula =" . $idPelicula);
$mysql->desconectar();
/////////
$mysql->conectar();
$consulta5 = $mysql->efectuarConsulta("SELECT idiomas.idioma FROM peliculas.idiomas INNER JOIN peliculas.peliculas_has_idiomas INNER JOIN peliculas.peliculas WHERE idiomas.idIdioma = peliculas_has_idiomas.Idiomas_idIdioma AND peliculas.idPelicula = peliculas_has_idiomas.Peliculas_idPelicula AND peliculas.idPelicula =" . $idPelicula);
$mysql->desconectar();
$inicio = $_SESSION['inicio'];
if ($inicio == true) {
    ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Peliculitas donde Miranda<<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>

          

           

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Paginas</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.php">Login</a>
                        <a class="collapse-item" href="registro.php">Registro</a>
                        <a class="collapse-item" href="listarPeliculas.php">Peliculas</a>
                        <a class="collapse-item" href="agregarPeliculas.php">Registrar Peliculas</a>
                        <a class="collapse-item" href="agregarGeneros.php">Registrar Generos</a>
                        <a class="collapse-item" href="agregarIdiomas.php">Registrar Idiomas</a>
                        <a class="collapse-item" href="reportes.php">Reportes</a>
                        
                        <div class="collapse-divider"></div>
                        <!-- <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a> -->
                    </div>
                </div>
            </li>
            
                
                
           

            <!-- Nav Item - Charts -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li> -->

            <!-- Nav Item - Tables -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
          

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nameUser ?></span>
                                <img class="img-profile rounded-circle"
                                    src="./assets/img/User.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"href="./controlador/salir.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Peliculas</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a>
                    </div>

                    <div class="col-8 mt-5">


                    
                    <form method="post" action="./controlador/editarPelicula.php">
                        <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            name="idPelicula" value="<?php echo $idPelicula ?>">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre de la Pelicula</label>
                            <input type="text" class="form-control" id="nombrePelicula" name="nombrePelicula"
                                aria-describedby="emailHelp" value="<?php echo $nombrePeli ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Descripcion de la Pelicula</label>
                            <textarea class="form-control" placeholder="" id="floatingTextarea2" style="height: 100px"
                                name="descripcionPelicula"> <?php echo $descripcionPeli ?> </textarea>
                        </div>
                        <div class="">
                            <label for="exampleInputEmail1" class="form-label mb-2">Los generos seleccionados anteriormente
                                fueron: </label>
                            <ul class="list-group">
                                <li class="list-group-item active" aria-current="true">Generos</li>
                                <?php while ($fila = mysqli_fetch_array($consulta4)) { ?>
                                    <li class="list-group-item">
                                        <?php echo $fila['genero'] ?>
                                    </li>
                                <?php } ?>
                            </ul>

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label mb-2"></label>
                            <h2>Seleccione todos los Generos nuevos de la
                                pelicula <br> Junto a los anteriores</h2>
                            <?php while ($fila = mysqli_fetch_array($consulta)) { ?>
                                <br>
                                <input type="checkbox" name="checkGenero[]" value="<?php echo $fila['idGenero'] ?>"
                                    style="margin-right: 20px;"><label for="checkGenero[]">
                                    <?php echo $fila['genero'] ?>
                                </label>
                            <?php } ?>
                        </div>
                        <div class="mb-3 mt-5">

                            <label for="exampleInputEmail1" class="form-label mb-2">Los idiomas seleccionados anteriormente
                                fueron: </label>
                            <ul class="list-group">
                                <li class="list-group-item active" aria-current="true">Idiomas</li>
                                <?php while ($fila2 = mysqli_fetch_array($consulta5)) { ?>
                                    <li class="list-group-item">
                                        <?php echo $fila2['idioma'] ?>
                                    </li>
                                <?php } ?>
                            </ul>

                        </div>
                        <div class="mb-3 mt-3">
                            <h2>Seleccione todos los Idiomas nuevos de la
                                pelicula <br> Junto a los anteriores</h2>
                            <?php while ($fila2 = mysqli_fetch_array($consulta2)) { ?>
                                <br>
                                <input type="checkbox" name="checkIdioma[]" value="<?php echo $fila2['idIdioma'] ?>"
                                    style="margin-right: 20px;"><label for="checkIdioma[]">
                                    <?php echo $fila2['idioma'] ?>
                                </label>
                            <?php } ?>
                        </div>
                        <h1 style="text-align: center;"><button type="submit" class="btn btn-primary">Actualizar</button>
                        </h1>
                        <br>
                        <br>
                    </form>
                </div>
                </div>

                   


                           
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
     <?php
} else {
    header("Location: ./listarPeliculas.php");
}
?>


