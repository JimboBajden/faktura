<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css.css">   
</head>
<body>
<?php   
    $connect=@new mysqli('localhost','root','','faktury');   
    $sql = "SELECT * FROM `faktura` JOIN osoby USING(osoba_id) WHERE faktura_id = {$_GET["faktura_id"]};";
    $osobaInfo = $connect->query($sql)->fetch_assoc();
?>
<button id="drukuj" onclick="drukuj()">drukuj</button>
<form action="index.html"><input id="powrut" type="submit" value="⬅"></form>
<style>
    #drukuj{
        height: 80px;
        width: 100px;
        text-align: center;
        font-size: xx-large;
        position: absolute;
        top: 5%;
        right: 5%;
    }
    #powrut{
        height: 30px;
        width: 50px;
        text-align: center;
        font-size: large;
        position: absolute;
        top: 5%;
        left: 5%;
    }
</style>
<script>
    function drukuj(){
        var buton = document.getElementById("drukuj");
        var buton2 = document.getElementById("powrut");
        buton.style.display = "none";
        buton2.style.display = "none";
        window.print();
        buton.style.display = "block";
        buton2.style.display = "block";
    }
</script>
<center>   
    <div class="sprzedawca">   
        <p id="sprzedawca"><b>Sprzedawca: Zkaład Remontowo Budowlany Usługi Transportowe-<br>Handel STANISŁAW CURZYDŁO </b></p>   
        <b><p>adres: 34-615 SŁOPNICE 956</p></b>
    </div>
    <div class="sprzedawca">
        <b>
            <p>NIP:737-104-72-06</p>
            <p>Bank: BANK SPÓŁDZIELCZY W LIMANOWEJ</p>
            <p>Konto: 73 8804 0000 0060 0606 4112 0001</p>
        </b>
        <?php
            if($osobaInfo["suma_netto"] >= 15000){
                echo "<h3>metoda podzielonej płatności</h3>";
            }
        ?>
        
    </div>
    <div>
        <p>F VAT <span id="fvat"> <?php echo $osobaInfo["count"]; $sql = "SELECT MONTH(data_sprzedarzy) AS m FROM faktura WHERE faktura_id ={$_GET["faktura_id"]}"; $m = $connect->query($sql)->fetch_assoc(); echo "/",$m["m"]?>/2024 </span></p>
    </div>
</center>
<div class="tab">
    <?php 
       
        echo " 
        <p >nabywca: <b>{$osobaInfo["nabywca"]}</b></p>
        <p >adres: <b>{$osobaInfo["adres"]}</b></p>
        <p >nip: <b>{$osobaInfo["nip"]}</b></p>";
    ?>
</div>
<div>
    <?php
    echo"<p>data sprzedarzy: <b>{$osobaInfo["data_sprzedarzy"]}</b></p>
    <p>sposób zapłaty: <b>{$osobaInfo["metoda"]}</b> </p>
    <p >termin zapłaty: <b>{$osobaInfo["termin"]}</b></p>";
    ?>
</div>
<div id="dane">
    <div class="legenda">
        <p id='counter'> lp </p>
        <p id='usluga'> usługa wykonana </p>
        <p id='ilosc'> ilosc</p>
        <p id='cena'> cena za sztuke</p>
        <p id='net'> wartość netto [zł]</p>
        <p id='vat'> vat [%]</p>
        <p id='wvat'> wartość vat [zł]</p>
        <p id='brutto'> wartość brutto [zł]</p>
    </div>
    
    <?php
    $sql = "SELECT * FROM faktury JOIN uslugi USING(usluga_id) WHERE faktura_id = '{$_GET["faktura_id"]}'; ";
    $greg = $connect->query($sql);
    $lp=1;
    while($row= $greg->fetch_assoc()){
        $cena = $row["cena"];
        $wvat = ($row["cena"]/100) * $row["vat"];
        $brutto =  round(($wvat + $row["cena"]),2);
        $wvat = round($wvat,2);
        echo"<div class='uslugi'>
        <p id='counter'> $lp </p>
        <p id='usluga'> {$row["nazwa"]} </p>
        <p id='ilosc'> 1</p>
        <p id='cena'> {$cena} [zł]</p>
        <p id='net'>  {$cena} [zł]</p>
        <p id='vat'> {$row["vat"]}[%]</p>
        <p id='wvat'> {$wvat}[zł]</p>
        <p id='brutto'> {$brutto} [zł]</p>
        </div>";$lp++;
    }
    ?>
</div>
<br><br>
    <div id="sumowanie">
        <div class="test">
            <p>stawka [%]</p>
            <p>wartość netto [zł]</p>
            <p>wartośc vat [zł]</p>
            <p>wartośc brutto [zł]</p>
        </div>
        <?php
        $sql = "SELECT * FROM faktury JOIN uslugi USING(usluga_id) WHERE faktura_id = '{$_GET["faktura_id"]}'; ";
        $greg = $connect->query($sql);
        while($row= $greg->fetch_assoc()){
            $cena = $row["cena"];
            $wvat = ($row["cena"]/100) * $row["vat"];
            $brutto =  round(($wvat + $row["cena"]),2);
            $wvat = round($wvat,2);
            echo"
            <div class='test'>
                <p> {$row["vat"]}</p>
                <p> $cena </p>
                <p> $wvat </p>
                <p> $brutto </p>
            </div>
            ";
        }
        ?>
    </div>
    <?php
    echo"<p>suma netto:<span id='sumaN'>{$osobaInfo["suma_netto"]} zł</span></p>
         <p>suma brutto:<span id='sumaB'>{$osobaInfo["suma_brutto"]} zł</span></p>";
    ?>
    
    <br><br>

    <div class="podpisy">
        <p class="podpis">podpis imienny osoby upoważnionej do odbioru faktury vat</p>
        <p class="podpis2">podpis imienny osoby upoważnionej do wystawienia faktury vat </p>
    </div>
</body>
</html>