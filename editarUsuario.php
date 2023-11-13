<?php


require_once 'modelo/MySQL.php';

//capturo los datos obtenidos en variables

$id = $_GET["id"];

//instanciamos la clase,se llama para usar

$mySql = new MySQL();

//se hace uso del metodo para conectarse a la base de datos

$mySql->conectar();


//se guarda en una variable la consulta utilizando el metodo para dicho proceso

$traerDatos = $mySql->efectuarConsulta("SELECT peliculas.usuarios.usuario, peliculas.usuarios.idusuarios, peliculas.usuarios.password from peliculas.usuarios WHERE peliculas.usuarios.idusuarios=$id");


$row = mysqli_fetch_array($traerDatos);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>SB Admin 2 - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="../css/all.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">
                      Olvidaste la contraseña?
                    </h1>
                    <p class="mb-4">Ingresa tu usuario</p>
                  </div>
                  <form action="../controlador/editarUsuario.php" method="post">
                    <div class="form-group">
                      <input name="id" value="<?php echo $row['idusuario'] ?>" type="hidden">
                      <input type="text" class="form-control form-control-user" name="usuarioEditar" aria-describedby="emailHelp" placeholder="Usuario Nuevo" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="contraseñaEditar" aria-describedby="emailHelp" placeholder="Contraseña Nueva" />
                    </div>
                    <a href="login.html" class="btn btn-primary btn-user btn-block">
                      Actualizar Informacion
                    </a>
                  </form>
                  <hr />
                  <div class="text-center">
                    <a class="small" href="/login.php">Tienes cuenta?Inicia sesion aqui</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="/jquery/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/jquery/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/js/sb-admin-2.min.js"></script>
</body>

</html>