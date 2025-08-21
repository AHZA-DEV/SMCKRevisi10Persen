<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$db_name = "db_smck"; 

$conn = mysqli_connect("$host", "$username", "$password", "$db_name");

if (mysqli_connect_errno()) {
  echo "Gagal Nyambunng ke MySQL Baca bang--->: " . mysqli_connect_error();
}