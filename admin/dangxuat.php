<?php
  //session_start();
  $tendangnhap = $_COOKIE['username'];
  $pass = $_COOKIE['pass'];
  $idtv = $_COOKIE['id'];
  setcookie('id',$idtv,time()-10,'/','',0,0);
  setcookie('username',$tendangnhap,time()-10,'/','',0,0);
  setcookie('pass',$pass,time()-10,'/','',0,0);
  //session_destroy();

  header('location:login.php');
?>