<?php

# connection to DB
define("DB_HOST", 'localhost');
define("DB_DATABASE", 'printers');
define("DB_USERNAME", 'jato');
define("DB_PASSWORD", 'cheese7100');

// check connection
if (!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weir Hall Printers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style type="text/css">
        .brand {
            background: #1a237e !important;
        }

        .brand-text {
            color: #1a237e !important;
        }

        .title {
            margin-left: 15%;
        }

        .highlight {
            background: #8d6e63 !important;
        }

        table {
            border: 2px solid black;
            table-layout: fixed;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        th,
        td {
            border: 1px solid black;
            width: 150px;
            overflow: hidden;
        }

        progress {
            background-color: white;
            color: #1a237e;
            border: black 2px solid;
            width: 76%;
            height: 1.6rem;

        }

        h3 {
            font-size: 40px;
            margin-left: 90px;
            margin-top: auto;
            margin-right: auto;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="grey lighten-4">
    <div class="navbar-fixed">
        <nav class="brand">
            <div class="nav-wrapper">
                <a href="#" class="title brand-logo">Weir Hall Printers</a>
                <ul id="nav-mobile" class="right">
                    <li><a href="printers.php">Adler North</a></li>
                    <li><a href="printer3.php">Adler South</a></li>
                    <li><a href="printer2.php">Weir 209</a></li>
                    <li><a href="printer3.php">Weir 232</a></li>
                </ul>
            </div>
        </nav>

    </div>

    <br>
    <br>

    <?php

    $sql = "SELECT * FROM printer3supplies LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cycles = $row['cycles'];
            echo '<h3>Current Cycles: ' . $cycles . ' </h3>';
        }
    }


    $sql = "SELECT * FROM printer3supplies ORDER BY ink DESC LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ink = $row['ink'];
            echo '<h3>Ink Level: <progress value="' . $ink . '" max="100">' . $ink . '</progress> </h3>';
        }
    }


    ?>



    <table>
        <thead>
            <tr>
                <th>Number</th>
                <th>Date</th>
                <th>Time</th>
                <th>Cycles</th>
                <th>Event</th>
                <th>Firmware</th>
                <th>Description</th>
            </tr>
        </thead>

        <tbody>


            <?php

            $sql = "SELECT * FROM printer3";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $number = $row['number'];
                    $date = $row['date'];
                    $time = $row['time'];
                    $cycles = $row['cycles'];
                    $event = $row['event'];
                    $firmware = $row['firmware'];
                    $description = $row['description'];
                    echo '<tr>
                            <td>' . $number . '</td>
                            <td>' . $date . '</td>
                            <td>' . $time . '</td>
                            <td>' . $cycles . '</td>
                            <td>' . $event . '</td>
                            <td>' . $firmware . '</td>
                            <td>' . $description . '</td>
                            </tr>';
                }
            }

            ?>
        </tbody>
    </table>

</body>