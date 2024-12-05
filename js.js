var nabywca = document.getElementById("nabywca");
var adres = document.getElementById("adres");
var nip = document.getElementById("nip");
var fvat = document.getElementById("fvat");
const d = new Date();
//fvat.innerText = "numer/" + d.getMonth() + "/" + d.getFullYear();
var osoba = document.getElementById("osoba");
var fakturaCount = document.getElementById("count");
function myFunction() {
    var x = document.getElementById("mySelect").value;
    const tab = x.split("--");
    nabywca.value = tab[0];
    adres.value = tab[1];
    nip.value = tab[2];
    console.log(tab)
    fvat.innerText = (parseInt(tab[3])+1) + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
    osoba.value = tab[4]
    fakturaCount.value = parseInt(tab[3])+1
}
function data() {
    var x = document.getElementById("data-sprzedarzy");
    var y = document.getElementById("data");
    y.value = x.value;
}
function termin() {
    var x = document.getElementById("termin-zaplaty");
    var y = document.getElementById("termin");
    y.value = x.value;
}
function sposob() {
    var x = document.getElementById("sposob-zaplaty");
    var y = document.getElementById("sposob");
    y.value = x.value;
}

var count = 1;
var test = document.getElementById("dane");
var sumowanie = document.getElementById("sumowanie")
var suma = document.getElementById("sumaB");
var suma2 = document.getElementById("sumaN");
var sumaN=0
var sumab=0
var metoda = document.getElementById("metoda");

var dodaneUslugi = "";
var dozapisu = document.getElementById("dozapisu");

function dodawanie() {
    var x = document.getElementById("dodawanie").value;
    const tab = x.split("--");
    {
    const kontener  = document.createElement("div");
    kontener.setAttribute("class","uslugi");

    var counter = document.createElement("p");
    counter.setAttribute("id","counter")
    var wartosc = document.createTextNode(count);
    count++

    counter.appendChild(wartosc)
    kontener.appendChild(counter)
    
    var usluga = document.createElement("p");
    usluga.setAttribute("id","usluga")
    wartosc = document.createTextNode(tab[0])
    usluga.appendChild(wartosc);
    kontener.appendChild(usluga);

    var ilosc = document.createElement("p");
    ilosc.setAttribute("id","ilosc")
    wartosc = document.createTextNode(1)
    ilosc.appendChild(wartosc);
    kontener.appendChild(ilosc);

    var cena = document.createElement("p");
    cena.setAttribute("id","cena")
    wartosc = document.createTextNode(tab[1])
    cena.appendChild(wartosc);
    kontener.appendChild(cena);

    var net = document.createElement("p");
    net.setAttribute("id","net")
    wartosc = document.createTextNode(tab[1])
    net.appendChild(wartosc);
    kontener.appendChild(net);

    var vat = document.createElement("p");
    vat.setAttribute("id","vat")
    wartosc = document.createTextNode(tab[2])
    vat.appendChild(wartosc);
    kontener.appendChild(vat);

    var wvat = document.createElement("p");
    wvat.setAttribute("id","wvat")
    wartosc = document.createTextNode(tab[3])
    wvat.appendChild(wartosc);
    kontener.appendChild(wvat);

    var brutto = document.createElement("p");
    brutto.setAttribute("id","brutto")
    wartosc = document.createTextNode(tab[4])
    brutto.appendChild(wartosc);
    kontener.appendChild(brutto);
    
    test.appendChild(kontener)
    }
    {
    const kontener  = document.createElement("div");
    kontener.setAttribute("class","test");

    var vat = document.createElement("p");    
    var wartosc = document.createTextNode(tab[2])
    vat.appendChild(wartosc)
    kontener.appendChild(vat)

    var net = document.createElement("p");    
    wartosc = document.createTextNode(tab[3])
    net.appendChild(wartosc)
    kontener.appendChild(net)

    var wvat = document.createElement("p");    
    wartosc = document.createTextNode(tab[2])
    wvat.appendChild(wartosc)
    kontener.appendChild(wvat)

    var brutto = document.createElement("p");    
    wartosc = document.createTextNode(tab[4])
    brutto.appendChild(wartosc)
    kontener.appendChild(brutto)

    sumowanie.appendChild(kontener)
    }
    sumaN+= parseFloat(tab[1])
    sumab+=parseFloat(tab[4])
    suma.innerText= (Math.round(sumab*100))/100
    suma2.innerText= (Math.round(sumaN*100))/100
    if(sumab > 14999){
        metoda.innerText = "metoda podzielonej płatności"
    }
    dodaneUslugi+=tab[5] + ','
    dozapisu.value = dodaneUslugi;
}
