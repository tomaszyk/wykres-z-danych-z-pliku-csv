<?php

require 'polaczenie.php';

        /**
         * Przetwarzanie pliku i zapis do bazy
         */
        if(@$_POST['submit'])
        {
                if($_FILES['file']['name'])
                {
                        $part = explode(".", $_FILES['file']['name']);

                        if($part[1] == 'csv')
                        {
                                $p = fopen($_FILES['file']['tmp_name'], 'r');

                                while($data = fgetcsv($p))
                                {
                                        $col1 = mysqli_real_escape_string($polaczenie, $data[0]);
                                        $col2 = mysqli_real_escape_string($polaczenie, $data[1]);
                                        $col3 = mysqli_real_escape_string($polaczenie, $data[2]);
                                        $col4 = mysqli_real_escape_string($polaczenie, $data[3]);
                                        $col5 = mysqli_real_escape_string($polaczenie, $data[4]);
                                        $col6 = mysqli_real_escape_string($polaczenie, $data[5]);

                                        $polaczenie -> query("INSERT INTO people VALUE ('$col1', '$col2', '$col3', '$col4', '$col5', '$col6')");
                                }

                                fclose($p);

                                /**Po zakończeniu importu użytkownik jest przekierowywany do strony z wykresem */
                                header('Location:wykres.php');
                        }
                }
        }

?>
<!DOCTYPE html>
<html>
        <head>
                <title>Import pliku</title>
                <link rel = "stylesheet" href = "style.css">
        </head>
        <body>
                <div id = "form">
                <form method = "POST" enctype = "multipart/form-data">
                        <h1><label>Wybierz plik csv</label></h1>
                        <label id = "file"><input type = "file" name = "file"></label>
                        <p><input type = "submit" name = "submit" value = "wyślij"></p>
                </form>
                </div>
        <body>
</html>
