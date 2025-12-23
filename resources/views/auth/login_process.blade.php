<?php
session_start();
include '/config/database.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$q = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($q);

if($data){
  $_SESSION['login'] = true;
  $_SESSION['role'] = $data['role'];

  if($data['role']=='admin'){
    header("Location: /admin/dashboard.php");
  } else {
    header("Location: /staff/dashboard.php");
  }
} else {
  echo "Login gagal";
}
