<?php
session_start();

if ($_COOKIE['auth'] != true) {
    header('Location: login.php');
    exit();
}
error_reporting(true)

?>

<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    require __DIR__ . '/functions.php';

    $users = include('db_users.php');

    $login = $_SESSION['login'] ?? null;

    echo "<h1>Добро пожаловать в Spa-салон, $login</h1>";
    ?>

    <a href='logout.php'>Выход</a><br>
    <div class=cont>
        <div class="block">
            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzOTAwNXwwfDF8c2VhcmNofDJ8fG1hc3NhZ2V8ZW58MHx8fHwxNzAwNjU4ODUxfDA&ixlib=rb-4.0.3&q=80&w=1080" alt="Изображение 1">
            <p>Массаж</p>
        </div>

        <div class="block">
            <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzOTAwNXwwfDF8c2VhcmNofDN8fG1hc3NhZ2V8ZW58MHx8fHwxNzAwNjU4ODUxfDA&ixlib=rb-4.0.3&q=80&w=1080" alt="Изображение 2">
            <p>Горячие камни</p>
        </div>

        <div class="block">
            <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzOTAwNXwwfDF8c2VhcmNofDJ8fGZhY2lhbC1jYXJlfGVufDB8fHx8MTcwMTIzOTEyM3ww&ixlib=rb-4.0.3&q=80&w=1080" alt="Изображение 3">
            <p>Уход за лицом</p>
        </div>
    </div>
    <?php
    $userData = null;
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            $userData = $user;
            break;
        }
    }

    if (!$userData || !isset($userData['registration_date'])) {
        exit();
    }

    $registrationDate = $userData['registration_date'];
    $currentTime = new DateTime('now');
    $expirationTime = new DateTime($registrationDate);
    $expirationTime->modify('+24 hours');

    if ($currentTime < $expirationTime) {
        $interval = $currentTime->diff($expirationTime);
        echo ('Скидка сгорит через ' . $interval->format('%h часов %i минут %s секунд') . '<br>');
    } else {
        echo ('Скидка истекла.<br>');
    }

    $birthday = $_POST['date'] ?? null;
    $login = $userData['login'];
    $users = include('db_users.php');

    foreach ($users as $user) {
        if ($user['login'] === $login) {
            $userBirthday = new DateTime($user['birthday']);
            $currentDate = new DateTime('now');

            $userBirthday->setDate($currentDate->format('Y'), $userBirthday->format('m'), $userBirthday->format('d'));

            $daysUntilBirthday = $currentDate->diff($userBirthday)->days;

            if ($daysUntilBirthday > 0) {
                echo "До дня рождения осталось {$daysUntilBirthday} дней.";
            } elseif ($daysUntilBirthday === 0) {
                echo "С днем рождения! Получите персональную скидку 5% на все услуги салона!";
            }

            break;
        }
    }

    if (empty($userData['birthday'])) {
    ?>
        <form action="birthday.php" method="post">
            <label for="date">Введите дату рождения:</label>
            <input type="date" id="date" name="date" required>
            <input type="submit" name="submit" value="Сохранить">
        </form>
    <?php
    }
    ?>


</body>

</html>