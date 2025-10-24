<?php
$plik = "dane.txt";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imie = trim($_POST['imie'] ?? '');
    $nazwisko = trim($_POST['nazwisko'] ?? '');
    $opis = trim($_POST['opis'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $komenda = trim($_POST['komenda'] ?? 'brak danych');

    if ($imie === '' || $nazwisko === '' || $opis === '' || $data === '') {
        die("<h2>Błąd: nie wypełniłeś wszystkich pól.</h2><a href='zawiadomienie.html'>Powrót</a>");
    }

    if (!file_exists($plik)) {
        $id = 1;
    } else {
        $linie = file($plik, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (count($linie) > 0) {
            $ostatnia = end($linie);
            $czesci = explode('|', $ostatnia);
            $id = intval($czesci[0]) + 1;
        } else {
            $id = 1;
        }
    }

    $timestamp = date("Y-m-d H:i:s");
    $zapis = "$id | $timestamp | $imie | $nazwisko | $data | $opis | $komenda" . PHP_EOL;

    if (file_put_contents($plik, $zapis, FILE_APPEND | LOCK_EX) === false) {
        die("<h2>Błąd zapisu do pliku. Sprawdź uprawnienia.</h2>");
    }

    echo "<!DOCTYPE html>
    <html lang='pl'><head><meta charset='UTF-8'><title>Zapisano</title>
    <style>
    body { font-family: Arial; text-align:center; background:#eee; padding-top:50px; }
    a { background:#0078d4; color:white; padding:10px 15px; border-radius:5px; text-decoration:none; }
    </style></head><body>
    <h1>Zgłoszenie zapisane!</h1>
    <p>ID: <b>$id</b></p>
    <p><a href='zawiadomienie.html'>Powrót</a></p>
    </body></html>";
} else {
    echo "Błąd: formularz nie został wysłany poprawnie.";
}
?>
