<?php
$user = "postgres.myqacqvmdwgcgvpzlgcz";
$password = "3qe!LBmZ247zZUv";
$db = "postgres";
$host="aws-0-ap-southeast-1.pooler.supabase.com";

try {
	$dsn = "pgsql:host=$host;port=6543;dbname=$db;";
	// make a database connection
	$pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

} catch (PDOException $e) {
	die($e->getMessage());
}