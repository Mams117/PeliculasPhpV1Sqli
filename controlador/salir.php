<?php
session_start();
unset($_SESSION['inicio']);
session_destroy();
header("Location: ../login.php");
exit();