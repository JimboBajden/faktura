<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="index.html"><input id="powrut" type="submit" value="⬅"></form>
<style>

    #powrut{
        height: 30px;
        width: 50px;
        text-align: center;
        font-size: large;
        position: absolute;
        top: 5%;
        right: 5%;
    }
    </style>
    <?php
        $connect=@new mysqli('localhost','root','','faktury');   
        $sql = "SELECT * FROM `faktura` JOIN osoby USING(osoba_id) WHERE count != 0 ORDER BY faktura_id DESC; ";
        ?>
    <div> <p>osoba</p> <p>count</p> <p>data</p> <p>brutto</p> <p>netto</p></div>
        <?php
        $greg = $connect->query($sql);
        while($row = $greg->fetch_assoc()){
            echo"<div> <p>{$row["nabywca"]}</p> <p>{$row["count"]}</p> <p>{$row["data_sprzedarzy"]}</p> <p>{$row["suma_brutto"]}</p> <p>{$row["suma_netto"]}</p> <form action='faktura_display.php'> <input type='hidden' name='faktura_id' value='{$row["faktura_id"]}'> <input type='submit' value='zobacz'></form> </div>";
        }
    ?>
        <style>
            div {
                display: flex;
                flex-direction: row;
                width: 100%;
                text-align: center;
            }

            p {
                border: 1px black solid;
                min-width: 10%;
            }

            form {
                display: flex;
                justify-content: center; /* Centers the submit button horizontally */
                align-items: center;    /* Centers the submit button vertically */
            }
        </style>
</body>
</html>