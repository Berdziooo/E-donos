<?php
// Połączenie z bazą
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "e_donos";

$conn = new mysqli($host, $user, $pass, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("<h2>Błąd połączenia z bazą danych: " . $conn->connect_error . "</h2>");
}

// Pobranie danych z tabeli zgloszenia (najświeższe na górze)
$sql = "SELECT * FROM zgloszenia ORDER BY data_zgloszenia DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista Donosów - E-Donos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray;
            text-align: center;
            padding-top: 50px;
        }

        .navigation {
            display: inline-block;
            background-color: rgb(16, 59, 107);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: sans-serif;
            text-decoration: none;
            margin: 5px;
            transition: background-color 0.2s ease;
        }

        .navigation:hover {
            background-color: aqua;
            color: black;
        }

        h1 {
            color: #222;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
            margin: 20px auto;
            width: 90%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: left;
        }

        th {
            background-color: rgb(16, 59, 107);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .empty {
            text-align: center;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>📋 Lista ostatnich donosów</h1>

    <a href="index.html" class="navigation">Strona Główna</a>
    <a href="zawiadomienie.html" class="navigation">Zawiadomienie</a>
    <a href="obywatel.html" class="navigation">Obywatel</a>
    <a href="komenda.html" class="navigation">Komenda</a>
    <a href="pomoc.html" class="navigation">Pomoc</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Data zgłoszenia</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Data zdarzenia</th>
            <th>Opis</th>
            <th>Komenda</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["data_zgloszenia"]."</td>";
                echo "<td>".$row["imie"]."</td>";
                echo "<td>".$row["nazwisko"]."</td>";
                echo "<td>".$row["data_zdarzenia"]."</td>";
                echo "<td>".$row["opis"]."</td>";
                echo "<td>".$row["komenda"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='empty'>Brak zgłoszeń w bazie</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
