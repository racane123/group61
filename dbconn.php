<?php
 $host = 'localhost';
 $username = 'root';
 $password = '';
 $dbname = 'group61';
 $port = 3308;


 $conn = mysqli_connect($host,$username,$password, $dbname,$port);


 if(!$conn){
    die("Error Connections " . mysqli_connect_error());
 }


 