function sort_name(myArray){
    myArray.sort(function (a, b) {
        var nomeA = a.nome.toUpperCase();
        var nomeB = b.nome.toUpperCase();
        if (nomeA < nomeB) {
            return -1;
        }
        if (nomeA > nomeB) {
            return 1;
        }
        return 0;
    });
}

function sort_model(myArray){
    myArray.sort(function (a, b) {
        var nomeA = a.modello.toUpperCase();
        var nomeB = b.modello.toUpperCase();
        if (nomeA < nomeB) {
            return -1;
        }
        if (nomeA > nomeB) {
            return 1;
        }
        return 0;
    });
}

function sort_last_man(myArray){
    myArray.sort((a, b) => a - b);
}

function sort_year(myArray){
    myArray.sort((a, b) => a - b);
}

function sort_fly_hours(myArray){
    myArray.sort((a, b) => a - b);
}

function updateList() {
    var keywords = document.getElementById("keywords").value;
    var selector = document.getElementById("select").value;
  
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("drone-list").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "getDrones.php?keywords=" + keywords + "&selector=" + selector, true);
    xhttp.send();
}

function updatePopUpButtons(infoButtons){
    for (var i = 0; i < infoButtons.length; i++) {
        infoButtons[i].addEventListener('click', function () {
            popupEl.style.display = 'block';

            var nome = this.getAttribute('data-nome');
            titleEl.innerHTML = nome;

            var modello = this.getAttribute('data-modello');
            //TODO add fly hours
            descriptionEl.innerHTML = "Model: " + modello + "<br>Ore volo: ";
        });
    }
}