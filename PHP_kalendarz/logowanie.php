
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
<div id="tlo">
    <img src="tlo.jpg" id="bouble">
<div class="login-container">
    <div id="pic">
        <img src="tumblr_1669c05a404d3ea05dc1b9bcb06097a0_13b2bb8c_540.png" id="cmy">
    </div>
<div id="dane">
    <form action="" method="POST">

        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="radio" id="login" name="action" value="login" checked> Zaloguj<br>

        <input type="radio" id="create_account" name="action" value="create_account">Utwórz konto<br><br>

        <input type="submit" name="submit" value="Wykonaj">
        <div class="message-container">
            <?php
            // Funkcja do nawiązywania połączenia z bazą danych
            function connectToDatabase() {
                $conn = mysqli_connect('localhost', 'root', '', 'egzamin5');
                if (!$conn) {
                    die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
                }

                return $conn;
            }

            // Funkcja do dodawania nowego konta do tabeli 'logowanie'
            function createAccount($conn, $username, $password) {
                // Sprawdzenie, czy login nie istnieje już w bazie danych
                $existingUserQuery = "SELECT * FROM logowanie WHERE username = '$username'";
                $existingUserResult = mysqli_query($conn, $existingUserQuery);
                if (mysqli_num_rows($existingUserResult) > 0) {
                    echo '<br><br><br>Login już istnieje.<br>';
                    return;
                }

                // Sprawdzenie, czy hasło nie jest puste
                if (empty($password)) {
                    echo '<br><br><br>Hasło nie może być puste.<br>';
                    return;
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO logowanie (username, password) VALUES ('$username', '$hashedPassword')";

                if (mysqli_query($conn, $sql)) {
                    echo '<br><br><br>Konto zostało utworzone.<br>';
                } else {
                    echo '<br><br><br>Błąd tworzenia konta: ' . mysqli_error($conn) . '<br>';
                }
            }

            // Funkcja do weryfikacji danych logowania
            function verifyLogin($conn, $username, $password) {
                $sql = "SELECT * FROM logowanie WHERE username = '$username'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $hashedPassword = $row['password'];

                    if (password_verify($password, $hashedPassword)) {
                        // Ustawienie ciasteczka z nazwą użytkownika
                        setcookie('username', $username, time() + (86400 * 30), '/'); // ważne przez 30 dni

                        // Przekierowanie do strony kalendarz.php po zalogowaniu
                        header('Location: kalendarz.php');
                        exit();
                    }
                }

                echo 'Nieprawidłowe dane logowania.<br>';
            }

            // Sprawdzenie, czy formularz został przesłany
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $action = $_POST['action'];

                $conn = connectToDatabase();

                if ($action === 'login') {
                    verifyLogin($conn, $username, $password);
                } elseif ($action === 'create_account') {
                    createAccount($conn, $username, $password);
                }

                mysqli_close($conn);
            }
            ?>
        </div>
    </form>
</div>
</div>
</div>
</body>

</html>
