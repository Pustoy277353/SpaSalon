<?php
if (isset($_POST['register'])) {
    $newUsername = $_POST['new_login'] ?? null;
    $newPassword = $_POST['new_password'] ?? null;

    if (empty($newUsername) || empty($newPassword)) {
    } else {
        $hashedPassword = md5($newPassword);
        $registrationDate = date('Y-m-d H:i:s');

        $users = include('db_users.php');

        $userExists = false;
        foreach ($users as $user) {
            if ($user['login'] === $newUsername) {
                $userExists = true;
                break;
            }
        }
        if (!$userExists) {
            $users[] = ['login' => $newUsername, 'password' => $hashedPassword, 'registration_date' => $registrationDate];
            file_put_contents('db_users.php', '<?php return ' . var_export($users, true) . ';');
            echo "Вы спешно зарегестрировались.";
        } else {
            echo "Пользователь с таким логином уже есть";
        }
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
<body>
    <form action="reg.php" method="post">
        <input name="new_login" type="text" placeholder="Логин">
        <input name="new_password" type="password" placeholder="Пароль">
        <input name="register" type="submit" value="Register">
    </form>
    <a href="login.php">Войти</a>
</body>
</html>
