var xhr = function(params, success, error) {
    //params : object
    // method, url, data...
    //o5 = "Yip" || "Yop" // t || t renvoie "Yip"
    var method = params.method || "GET";
    // en php < 7:
    // $method = isset($params->method )?$params->method  : 'GET';
    // en php >= 7
    // $method = $params->method ?? "GET";
    var data = params.data || null;
    var url = params.url;
    if (method === 'GET' && data !== null)
        url = url + data;
    var req = new XMLHttpRequest();
    req.onreadystatechange = function() {
            if (req.readyState === 4) {
                if (req.status >= 200 && req.status < 304) {
                    // Si on n'a pas de parametre type on part du principe qu'on veut une reponse json
                    if (params.type === undefined) {
                        if (req.responseType !== 'json') {
                            // cas IE qui ne renvoie pas de json                      
                            var resp = JSON.parse(req.responseText);
                        } else {
                            var resp = req.response;
                        }
                    } else if (params.type === 'text') {
                        var resp = req.responseText;
                    } else {
                        // blob, arraybuffer etc
                        var resp = req.response;
                    }
                    success(resp);
                } else if (req.status === 0) {
                    error(req.status + ' [Network failed]')

                } else { error(req.statusText) }
            }
        }
        //req.onerror = function() { error( 'err') }
    req.ontimeout = function() {
        console.error("The request for " + url + " timed out.");
    };
    req.open(method, url, true);
    //req.timeout = 3000; // 3s
    req.setRequestHeader('X-Requested-With', 'xmlhttprequest');
    req.responseType = params.type || 'json';
    req.send(data);
};

function afficheMenu(obj) {

    var idMenu = obj.id;
    var idSousMenu = 'sous' + idMenu;
    var sousMenu = document.getElementById(idSousMenu);


    /**	si le sous-menu correspondant au menu cliqué    **/
    /** est caché alors on l'affiche, sinon on le cache **/

    if (sousMenu.style.display == "none") {
        sousMenu.style.display = "block";
    } else {
        sousMenu.style.display = "none";
    }
}


function ouvrirfenetre() {
    var liste = window.open("", "liste", "width=450,height=650");
}



$('#myTable').bootstrapTable({
    showExport: true
});
$('#myTable').bootstrapTable('refreshOptions', {
    exportDataType: 'all',
    exportOptions: {
        fileName: 'export_stagiaire'
    }
});


var $table = $('#maTable');
$(function() {
    $('#toolbar').find('select').change(function() {
        $table.bootstrapTable('refreshOptions', {
            exportDataType: $(this).val()
        });
    });
})

var trBoldBlue = $("maTable");

$(trBoldBlue).on("click", "tr", function() {
    $(this).toggleClass("bold-blue");
});

$(window).on('resize', function() {
    var win = $(this);
    if ((win.width() > 600) && (win.width() < 1200)) {
        $('#sidebar').removeClass('col-md-3');
        $('#sidebar').addClass('col-md-6');
    } else {
        $('#sidebar').removeClass('col-md-6');
        $('#sidebar').addClass('col-md-3');
    }
});
const periods = document.querySelectorAll('[data-periode]');
const typeFormation = document.getElementById('id_formation');
const formations = document.getElementsByClassName('formation');
const buttons = document.getElementsByClassName('ajax');
const container = document.getElementById('container');
const table = document.getElementById('formTest');

const hideElement = function(event) {
    let elem = event.target.value
    periods.forEach(function(periode) {
        let el = periode.getAttribute('data-formation');
        if (el !== elem) {
            periode.disabled = true;
            periode.checked = false;
        } else {
            periode.disabled = false;
        }
    })
}
const sendData = function(form) {
    var formData = new FormData(form);
    var url = form.action;
    var method = form.method;
    // params est un objet=> { url: url, data: formData, type: 'text', method: 'POST' }
    xhr({ url: url, data: formData, type: 'text', method: method },
        function(resp) { // callback success dans xhr
            if (!resp.error) {
                container.innerHTML = resp;
            } else {

            }

        },
        function(e) { // callback error dans var Xhr
            return console.log('Update : Network request failed');
        });
}

const changeFormation = function(event) {
    debugger
    let element = event.target;
    let value = element.value;
    let id_stagiaire = element.getAttribute('data-stagiaire');
    let periodesStagiaire = document.querySelectorAll(`[data-id="${id_stagiaire}"]`);
    periodesStagiaire.forEach(function(periode) {
        let id_formation = periode.getAttribute('data-formation');
        if (id_formation !== element.value) {
            periode.checked = false;
            periode.disabled = true;
        } else {
            periode.checked = false;
            periode.disabled = false;
        }
    })
    sendData(form);
}



if (typeFormation) {
    typeFormation.addEventListener('change', hideElement, false);
}
setInterval(function() {
    for (var i = 0; i < formations.length; i++) {
        formations[i].addEventListener('change', changeFormation, false);
    }
}, 1000);