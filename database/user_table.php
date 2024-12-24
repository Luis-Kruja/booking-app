<?php

include_once '../config/db_connection.php';

global $conn;

$create_users_table = "CREATE TABLE users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL,
	surname VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL,
	phone VARCHAR(15) NOT NULL,
	username VARCHAR(30) NOT NULL,
	password VARCHAR(32) NOT NULL
)";

if ($conn->query($create_users_table) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
