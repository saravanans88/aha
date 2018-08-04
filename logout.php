<?php
session_start();
if(isset($_SESSION['sessionlogin'])){
  unset($_SESSION['sessionlogin']);
  session_destroy();
  }
  header("Location:index.php");
?>
