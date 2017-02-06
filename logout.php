<?php
session_start();

if (!isset($_SESSION['tuvastamine'])) {
	header('Location: avaleht.php');
	exit();
} else {
	setcookie("user", $login, time() - 86400, "/");
	session_destroy();
	header('Location: avaleht.php');
	exit();
}
?>