<?php
    $hostname = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "mahasiswa";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    
    if (!$conn) {
        die("KOneksi Gagal: " . mysqli_connect_error());
    }
