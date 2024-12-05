<!DOCTYPE html>   
<html lang="en">   
<head>   
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <title>Document</title>   
    <link rel="stylesheet" href="css.css">   
    <script src="js.js" defer></script>
</head>   
<body>   
<form action="index.html"><input id="powrut" type="submit" value="⬅"></form>
<form action="">
    <input id="osoba" type="hidden" value="" name="osoba">
    <input id="dozapisu" value="" name="dozapisu" type="hidden">
    <input id="count" value="" name="count" type="hidden">
    <input id="data" value="" name="data-sprzedarzy" type="hidden">
    <input id="sposob" value="" name="metoda" type="hidden">
    <input id="termin" value="" name="termin-zaplaty" type="hidden">
    <input type="submit" id="zapisz" value="zapisz">
</form>
<style>
    #zapisz{
        height: 50px;
        width: 80px;
        text-align: center;
        font-size: large;
        position: absolute;
        top: 5%;
        right:5%;
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
    <?php   
        $connect=@new mysqli('localhost','root','','faktury');   
        /**/
        if(isset($_GET["osoba"]) && isset($_GET["dozapisu"])){
            $sql = "INSERT INTO `faktura` (`faktura_id`, `osoba_id`, `count`,`data_sprzedarzy`,`metoda`,`termin`) VALUES (NULL, '{$_GET["osoba"]}', '{$_GET["count"]}','{$_GET["data-sprzedarzy"]}','{$_GET["metoda"]}','{$_GET["termin-zaplaty"]}');";
            $connect->query($sql);
            $uslugi = explode(",",$_GET["dozapisu"],-1);
            $fak = $connect->insert_id;
            $sumaNet = 0;
            $sumaBrutt = 0;
            foreach($uslugi as $x){
                $sql = "INSERT INTO `faktury` ( `faktura_id`, `usluga_id`) VALUES ('$fak', '$x');";
                $connect->query($sql);
                $sql = "SELECT cena, vat FROM uslugi WHERE usluga_id = '$x'";
                $usluga = $connect->query($sql)->fetch_assoc();
                $sumaNet += $usluga["cena"];
                $sumaBrutt += $usluga["cena"] + (($usluga["vat"] * $usluga["cena"])/100);
            }
            $sql = "UPDATE `faktura` SET suma_brutto = '$sumaBrutt', `suma_netto` = '$sumaNet' WHERE `faktura`.`faktura_id` = $fak";
            $connect->query($sql);
            header("Location:faktura_display.php?faktura_id=$fak");
        }
    ?>   

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
            <h3 id="metoda"></h3>
        </div>
        <div>
            <p>F VAT <span id="fvat"> 3/4/2024 </span></p>
        </div>
    </center>
    <div class="tab">
        <select name="rzeczy" onchange="myFunction()" id="mySelect">
            <option value=" " default></option>
        <?php
        $osoby = "SELECT *FROM `osoby` JOIN faktura USING(osoba_id) WHERE osoba_id IN (SELECT osoba_id FROM faktura) GROUP BY osoba_id ORDER BY osoba_id DESC; ";
        $count = "SELECT MAX(count) as max FROM faktura";
        $querry = $connect->query($count);
        $max = $querry->fetch_assoc();
        $joe = $connect->query($osoby);
        while($row = $joe->fetch_assoc()){
            echo "<option value='{$row["nabywca"]}--{$row["adres"]}--{$row["nip"]}--{$max["max"]}--{$row["osoba_id"]}' >  {$row["nabywca"]}--{$row["adres"]}--{$row["nip"]}--{$max["max"]}--{$row["osoba_id"]}</option>";
        }
        ?>
        </select>
        <p >nabywca:<input id="nabywca" type="text"></p>
        <p >adres:<input id="adres" type="text"></p>
        <p >nip:<input id="nip" type="text"></p>
    </div>
    <div>
        <p >data sprzedarzy: <input id="data-sprzedarzy" onchange="data()" type="date"></p>
        <p >sposób zapłaty: <input id="sposob-zaplaty" oninput="sposob()" type="text"></p>
        <p >termin zapłaty: <input id="termin-zaplaty" onchange="termin()" type="date"></p>
    </div>
    <select name="dodawanie" id="dodawanie">
        <option value=''></option>
        <?php
            $sql = "SELECT * FROM `uslugi` ORDER BY usluga_id DESC";
            $greg = $connect->query($sql);
            while($row= $greg->fetch_assoc()){
                $cena = $row["cena"];
                $wvat = ($row["cena"]/100) * $row["vat"];
                $suma += $wvat + $row["cena"];
                $brutto = round(($wvat + $row["cena"]),2);
                $wvat = round($wvat,2);
                echo "<option value='{$row["nazwa"]}--{$cena}--{$row["vat"]}--{$wvat}--{$brutto}--{$row["usluga_id"]}'>{$row["nazwa"]}--{$cena}zł--{$row["vat"]}%--{$wvat}zł--{$brutto}zł</option>";
            }
        ?>
    </select>
    <button id="dodaj" onclick="dodawanie()">dodaj usługę</button>
    <div id="dane">
        <div class="legenda">
            <p id="counter"> lp </p>
            <p id="usluga"> usługa wykonana </p>
            <p id="ilosc"> ilosc</p>
            <p id="cena"> cena za sztuke</p>
            <p id="net"> wartość netto [zł]</p>
            <p id="vat"> vat [%]</p>
            <p id="wvat"> wartość vat [zł]</p>
            <p id="brutto"> wartość brutto [zł]</p>
        </div>

    </div>
    <br><br>
    <div id="sumowanie">
        <div class="test">
            <p>stawka [%]</p>
            <p>wartość netto [zł]</p>
            <p>wartośc vat [zł]</p>
            <p>wartośc brutto [zł]</p>
        </div>
    </div>
    <p>suma netto:<span id="sumaN"></span></p>
    <p>suma brutto:<span id="sumaB"></span></p>
    <br><br>

    <div class="podpisy">
        <p class="podpis">podpis imienny osoby upoważnionej do odbioru faktury vat</p>
        <p class="podpis2">podpis imienny osoby upoważnionej do wystawienia faktury vat </p>
    </div>
    <script>
    // Function to convert input elements into spans
    function convertInputsToSpans() {
        var inputs = document.querySelectorAll('input');
        inputs.forEach(function(input) {
            var span = document.createElement('span');
            span.textContent = input.value;
            span.setAttribute('data-input-type', input.type); // Store input type as a data attribute
            input.parentNode.replaceChild(span, input);
        });
    }
    
    // Function to convert spans back to input elements
    function convertSpansToInputs() {
        var spans = document.querySelectorAll('span[data-input-type]');
        spans.forEach(function(span) {
            var input = document.createElement('input');
            input.type = span.getAttribute('data-input-type'); // Set input type from stored data attribute
            input.value = span.textContent;
            span.parentNode.replaceChild(input, span);
        });
    }
    
    // Function to hide buttons and selects
    function hideButtonsAndSelects() {
        var buttons = document.querySelectorAll('button');
        buttons.forEach(function(button) {
            button.style.display = 'none';
        });
        
        var selects = document.querySelectorAll('select');
        selects.forEach(function(select) {
            if(select.id=="vatSelect"){
                var span = document.createElement('span');
                span.textContent = select.textContent;

                select.parentNode.replaceChild(span,select)
            }else
            select.style.display = 'none';
        });
    }
    
    // Function to reveal buttons and selects
    function revealButtonsAndSelects() {
        var buttons = document.querySelectorAll('button');
        buttons.forEach(function(button) {
            button.style.display = 'block';
        });
        
        var selects = document.querySelectorAll('select');
        selects.forEach(function(select) {
            select.style.display = 'block';
        });
    }
    
    // Get the button element
    var convertButton = document.getElementById('convertButton');
    
    // Add click event listener to the button
    convertButton.addEventListener('click', function() {
        hideButtonsAndSelects(); // Hide buttons and selects before printing
        
        convertInputsToSpans(); // Convert inputs to spans
        
        // Print the page
        window.print();
        
        // Convert spans back to input elements after printing
        convertSpansToInputs();
        
        revealButtonsAndSelects(); // Reveal buttons and selects after printing
    });
</script>

</body>
</html>