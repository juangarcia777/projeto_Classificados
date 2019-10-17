<?php
session_start();
    try{
    $pdo= new PDO("mysql:dbname=projeto_classificados;host=localhost","root","");
    }catch(PDOException $e) {
        echo "Erro..".$e->getMessage();
        exit;
    }
?>