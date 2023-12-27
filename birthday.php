<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $login = $_SESSION['login'] ?? null;
    $birthday = $_POST['date'] ?? null;

    if ($login && $birthday) {
        $users = include('db_users.php');

        foreach ($users as &$user) {
            if ($user['login'] === $login) {
                $user['birthday'] = $birthday;
                break;
            }
        }

        file_put_contents('db_users.php', '<?php return ' . var_export($users, true) . ';');
    }
}

header('Location: index.php');
exit();
?>
