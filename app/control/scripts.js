
// se uso questo evento fa il logut anche quando aggiorno la pagina

/*window.addEventListener("beforeunload", () => {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'logout.php', true);
    xhr.send();
}); */



$(window).on('unload', () => {
    $.ajax({
        url: '../model/logout.php',
        async: false,
        type: 'GET',
        success: function() {
            console.log('Logout successful');
        },
        error: function() {
            //console.log('Logout failed');
        }
    });
}); 

var sessionUpdateInterval = 90 * 1000; 

// Funzione per inviare una richiesta AJAX al server per aggiornare il timestamp della sessione
function updateSession() {
  $.ajax({
    url: "../control/heartbeat.php",
    type: "POST",
    success: () => {
      //console.log("Session updated");
    },
    error: () => {
      //console.log("Error updating session");
    }
  });
}


function startSessionUpdateInterval() {
  setInterval( () => {
    updateSession();
  }, sessionUpdateInterval);
}

$(document).ready( () => {
  startSessionUpdateInterval();
});

$(document).ready( () => {
    $(document).on("click keypress scroll", () => {
      updateSession();
    });
})
