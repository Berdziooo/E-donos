<?php
// Połączenie z bazą
$host = "localhost";      // adres serwera
$user = "root";           // użytkownik (domyślnie w XAMPP)
$pass = "";               // hasło (puste w XAMPP)
$dbname = "e_donos";      // nazwa bazy danych

$conn = new mysqli($host, $user, $pass, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("<h2>Błąd połączenia z bazą danych: " . $conn->connect_error . "</h2>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pobranie danych z formularza
    $imie = trim($_POST['imie'] ?? '');
    $nazwisko = trim($_POST['nazwisko'] ?? '');
    $opis = trim($_POST['opis'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $komenda = trim($_POST['komenda'] ?? 'brak danych');

    // Walidacja danych
    if ($imie === '' || $nazwisko === '' || $opis === '' || $data === '') {
        die("<h2>Błąd: nie wypełniłeś wszystkich pól.</h2><a href='zawiadomienie.html'>Powrót</a>");
    }

    // Przygotowanie zapytania SQL z ochroną przed SQL Injection
    $stmt = $conn->prepare("
        INSERT INTO zgloszenia (imie, nazwisko, data_zdarzenia, opis, komenda)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $imie, $nazwisko, $data, $opis, $komenda);

    // Wykonanie zapytania
    if ($stmt->execute()) {
        $id = $stmt->insert_id;

        echo "<!DOCTYPE html>
        <html lang='pl'>
        <head>
            <meta charset='UTF-8'>
            <title>Zapisano</title>
            <style>
                body { font-family: Arial; text-align:center; background:#eee; padding-top:50px; }
                a { background:#0078d4; color:white; padding:10px 15px; border-radius:5px; text-decoration:none; }
            </style>
        </head>
        <body>
            <h1>Zgłoszenie zapisane!</h1>
            <p>ID zgłoszenia: <b>$id</b></p>
            <p><a href='zawiadomienie.html'>Powrót</a></p>
        </body>
        </html>";
    } else {
        echo "<h2>Błąd zapisu do bazy: " . $stmt->error . "</h2>";
    }

    $stmt->close();
}

$conn->close();
?>
