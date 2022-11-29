<?php

# connection to DB
define("DB_HOST", 'localhost');
define("DB_DATABASE", 'printers');
define("DB_USERNAME", 'jato');
define("DB_PASSWORD", 'cheese7100');

// connect to database
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

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
        .dataButton{
            display: flex;
            flex-wrap: wrap;
            align-content: center;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #010b13;
            background-color: #CE1126;
            border: none;
            margin-left: 215px;
            margin-top: 50px;
            margin-right: auto;
            margin-bottom: auto;
            border-radius: 15px;
            box-shadow: 0 3px #999;
                  }
        .jeffButton{
            display: flex;
            flex-wrap: wrap;
            align-content: center;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #010b13;
            background-color: #eed202;
            border: none;
            margin-left: auto;
            margin-top: 50px;
            margin-right: 215px;
            margin-bottom: auto;
            border-radius: 15px;
            box-shadow: 0 3px #999;
        }
        .alert_button{
            display: right;
        }
        .printerInfo{
            height: 250px;
            width: 50%;
            margin-left: 215px;
            margin-right: auto;
        }

    </style>
</head>

<body class="grey lighten-4">
    <div class="navbar-fixed">
        <nav class="brand">
            <div class="nav-wrapper">
                <a href="#" class="title brand-logo">Weir Hall Printers</a>
                <ul id="nav-mobile" class="right">
                    <li><a href="">Printer 1</a></li>
                    <li><a href="">Printer 2</a></li>
                    <li><a href="">Printer 3</a></li>
                </ul>
            </div>
        </nav>

    </div>
    <div class = "printerInfo">
    <h3 class= "event">Event Log Page</h2>
        <h4 class = "info">Printer Information</h3>
        <p class = "number">Printer Number: 1</p>
        <p class = "serial">Printer Serial Number: VNBCC6V1ZT</p>
    </div>
    <div class = "refresh-button">
    <button class="dataButton">Refresh Data</button>  
    </div>
    <div class = "alert-button">
    <button class="jeffButton">Email Jeff</button>      
        </div>


    <br>
    <br>

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

            $sql = "SELECT * FROM printer1";

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

<form action="" method="post">
    <input type="submit" value="Send details to embassy" />
    <input type="hidden" name="button_pressed" value="1" />
</form>

<?php

if (isset($_POST['button_pressed'])) {
    $to      = "josephjaketo@gmail.com";
    $subject = 'the subject';
    $message = 'hello';
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    

    $retval = mail($to, $subject, $message, $headers);
         
    if( $retval == true ) {
       echo "Message sent successfully...";
    }else {
       echo "Message could not be sent...";
    }
}

?>