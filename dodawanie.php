<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="index.html">powrót</a>
    <?php   
        $connect=@new mysqli('localhost','root','','faktury');   
        if(isset($_GET["uslugi"])){
            $kategoria = "INSERT INTO `uslugi` (`nazwa`, `cena`, `vat`) VALUES ('{$_GET["nazwa"]}', '{$_GET["cena"]}', '{$_GET["vat"]}')";
            $connect->query($kategoria);
            echo '<script>alert("dodane")</script>'; 
        }
        if(isset($_GET["osoby"])){           
            $osoba = "INSERT INTO `osoby` (`nabywca`, `adres`, `nip`) VALUES ('{$_GET["nabywca"]}', '{$_GET["adres"]}', '{$_GET["nip"]}')";
            $connect->query($osoba);
            $sql = "INSERT INTO `faktura` (`faktura_id`, `osoba_id`, `count`) VALUES (NULL, '$connect->insert_id', '0');";
            $connect->query($sql);
            echo '<script>alert("dodane")</script>'; 
        }
    ?>  
    <h1>dodawanie usługi</h1>
    <form>
        <input type="hidden" name="uslugi">
        <textarea  name="nazwa" type="text" placeholder="nazwa usługi" required></textarea>
        <input name="cena" type="text" placeholder="cena usługi" required>
        <input name="vat" placeholder="vat" type="text" required>
        <input type="submit">
    </form>
    <h1>dodawnie osób</h1>
    <form action="" method="get">
        <input type="hidden" name="osoby"> 
        <textarea  type="text" name="nabywca" placeholder="nabywca/nazwa firmy"></textarea>
        <input type="text" name="adres" placeholder="adres">
        <input  type="text" name="nip" placeholder="nip">
        <input type="submit">
    </form>
    <style>
        form{
            display: flex;
            align-items: center;
        }
        textarea{
            width: 200px;
        }
    </style>
</body>
</html>