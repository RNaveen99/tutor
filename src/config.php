<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if ($conn === false) {
    die('Error: could not connect to server'.mysqli_connect_error());
} else {
    $sql = 'create database if not exists project';
    mysqli_query($conn, $sql);
    
    mysqli_select_db($conn, "project");
    
    $sql = 'create table if not exists users(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(30) NOT NULL,
                email VARCHAR(30) NOT NULL UNIQUE,
                username VARCHAR(20) NOT NULL UNIQUE,
                password VARCHAR(80) NOT NULL, 
                privileges INT DEFAULT "0",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                notes_url VARCHAR(50) )';  
    // if (! mysqli_query($conn, "select 1 from users")) {
    //     mysqli_query($conn, $sql);
    // }
    mysqli_query($conn, $sql);

    $sql = 'create table if not exists topics(
                topic_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                topic_name VARCHAR(30) NOT NULL UNIQUE,
                md_file_name VARCHAR(30) NOT NULL,
                md_file_url VARCHAR(80) NOT NULL,
                text_file_name VARCHAR(30) NOT NULL,
                text_file_url VARCHAR(80) NOT NULL)';
    mysqli_query($conn, $sql);    
    
    $sql = 'create table if not exists quiz(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                question varchar(220) NOT NULL,
                option1 varchar(52) NOT NULL,
                option2 varchar(52) NOT NULL,
                option3 varchar(52) NOT NULL,
                option4 varchar(52) NOT NULL,
                answer varchar(52) NOT NULL )';
    mysqli_query($conn, $sql);         
    
    $sql = 'create table if not exists requesttopic(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                topic_name varchar(30) NOT NULL,
                status varchar(20) NOT NULL)';
    mysqli_query($conn, $sql);
}



?>
