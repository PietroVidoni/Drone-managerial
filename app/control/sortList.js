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

function updateButtons(infoButtons, flyButtons, removeButtons){
    for (var i = 0; i < infoButtons.length; i++) {
        infoButtons[i].addEventListener('click', function () {
            popupEl.style.display = 'block';

            var name = this.getAttribute('data-name');
            var model = this.getAttribute('data-model');
            var fly_hours = this.getAttribute('data-fly_hours');
            var last_man = this.getAttribute('data-last_man');
            
            
            titleEl.innerHTML = name;

            descriptionEl.innerHTML = "Model: " + model + "<br>Ore volo: " + fly_hours + "<br>Last Manutenction: " + last_man;
        });
    }

    for (var i = 0; i < flyButtons.length; i++) {
        flyButtons[i].addEventListener('click', function() {
            var droneID = this.getAttribute('data-id');
        
            var form = document.createElement('form');
            form.method = 'post';
            form.action = '../view/homePage.php?page=startFlyPage';
        
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'droneID';
            input.value = droneID;
        
            form.appendChild(input);
        
            document.body.appendChild(form);
            form.submit();
        }); 
    }

    for (var i = 0; i < removeButtons.length; i++) {
        removeButtons[i].addEventListener('click', function() {
            var droneID = this.getAttribute('data-id');
        
            var form = document.createElement('form');
            form.method = 'post';
            form.action = '../model/removeDrone.php';
        
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'droneID';
            input.value = droneID;
        
            form.appendChild(input);
        
            document.body.appendChild(form);
            form.submit();
        });
        
    }
}