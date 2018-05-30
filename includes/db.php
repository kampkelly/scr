<?php 
    $server = 'localhost';
    $username = 'kamp';
    $password = 'winsmor3';
    $db = 'disco150_scrapes';
    
    $conn = mysqli_connect($server,$username,$password,$db);
    if(!$conn){
    die("Connection Failed!:".mysqli_connect_error());
}
?>
