<?php
unset($_SESSION['auth']);
unset($_SESSION['login']); 
unset($_SESSION['password']);
setcookie('auth', null, -1, '/');
session_destroy(); 
header('Location: login.php');