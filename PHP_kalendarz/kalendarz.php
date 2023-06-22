<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Organizer</title>
    <link rel="stylesheet" href="./styl5.css">
</head>

<body>
<div id="tlok">
    <img src="tlo.jpg" id="boublek">

    <div id="dropdown">
        <span>Menu</span>
        <ul>
            <li onclick="showBanner('bannerOne')">Przeglądaj</li>
            <li onclick="showBanner('bannerTwo')">Dodaj wydarzenie</li>
        </ul>
    </div>

    <div id="bannerOne">
        <span class="close-btn" onclick="closeBanner('bannerOne')">X</span>
        <?php
        $con = mysqli_connect('localhost', 'root', '', 'egzamin5');
        $q = "SELECT miesiac, rok FROM zadania WHERE dataZadania = '2020-07-01';";
        $res = mysqli_query($con, $q);
        while ($row = mysqli_fetch_array($res)) {
            echo "<h1>miesiąc: $row[0], rok: $row[1]</h1>";
        }
        ?>
        <form action="./kalendarz.php" method="GET">
            <label>Wybierz miesiąc:
                <select name="miesiac">
                    <option value="styczen">Styczeń</option>
                    <option value="luty">Luty</option>
                    <option value="marzec">Marzec</option>
                    <option value="kwiecien">Kwiecień</option>
                    <option value="maj">Maj</option>
                    <option value="czerwiec">Czerwiec</option>
                    <option value="lipiec">Lipiec</option>
                    <option value="sierpien">Sierpień</option>
                    <option value="wrzesien">Wrzesień</option>
                    <option value="pazdziernik">Październik</option>
                    <option value="listopad">Listopad</option>
                    <option value="grudzien">Grudzień</option>
                </select>
                <button type="submit">Wyświetl</button>
            </label>
        </form>
    </div>

    <div id="Calendar-container">
        <?php
        if (isset($_GET['miesiac'])) {
            $miesiac = $_GET['miesiac'];
            $q = "SELECT dataZadania, wpis FROM zadania WHERE miesiac = '$miesiac';";
            $res = mysqli_query($con, $q);
            while ($row = mysqli_fetch_array($res)) {
                echo "<div class='dzien'>
                            <h5>$row[0]</h5>
                            <p>$row[1]</p>
                        </div>";
            }
        }
        ?>
    </div>

    <div id="bannerTwo">
        <span class="close-btn" onclick="closeBanner('bannerTwo')">X</span>
        <form action="./kalendarz.php" method="GET">
            <label>Wybierz dzień:<br>
                <input type="number" name="dzien" min="1" max="31">
            </label><br>
            <label>Wybierz miesiąc:<br>
                <select name="miesiac">
                    <option value="styczen">Styczeń</option>
                    <option value="luty">Luty</option>
                    <option value="marzec">Marzec</option>
                    <option value="kwiecien">Kwiecień</option>
                    <option value="maj">Maj</option>
                    <option value="czerwiec">Czerwiec</option>
                    <option value="lipiec">Lipiec</option>
                    <option value="sierpien">Sierpień</option>
                    <option value="wrzesien">Wrzesień</option>
                    <option value="pazdziernik">Październik</option>
                    <option value="listopad">Listopad</option>
                    <option value="grudzien">Grudzień</option>
                </select>
            </label><br>
            <label>Dodaj wpis:<br>
                <input type="text" name="wpis">
            </label><br>
            <button type="submit" name="wyslij">DODAJ</button>
        </form>
        <?php
        if (isset($_GET['wyslij'])) {
            $dzien = $_GET['dzien'];
            $miesiac = $_GET['miesiac'];
            $wpis = $_GET['wpis'];
            $q = "UPDATE zadania SET wpis = '$wpis' WHERE miesiac = '$miesiac' AND DAY(dataZadania) = $dzien;";
            mysqli_query($con, $q);

            // Reload the page to update the event list
            echo '<script type="text/javascript">
                    window.location.href = "./kalendarz.php?miesiac=' . $miesiac . '";
                </script>';
        }
        mysqli_close($con);
        ?>
    </div>
</div>

<script>
    function showBanner(bannerId) {
        var banners = document.querySelectorAll('[id^="banner"]');
        for (var i = 0; i < banners.length; i++) {
            banners[i].style.display = 'none';
        }
        document.getElementById(bannerId).style.display = 'block';
    }

    function closeBanner(bannerId) {
        document.getElementById(bannerId).style.display = 'none';
    }
</script>
</body>

</html>
