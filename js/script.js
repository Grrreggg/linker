document.addEventListener("DOMContentLoaded", init);
var submit, copy, field

//GET ELEMENTS WE NEED AND CREATE EVENT LISTENERS
function init(){
    submit = document.getElementById('submit');
    copy = document.getElementById('copy');
    field = document.getElementById('field');

    submit.addEventListener("click", linker);
    copy.addEventListener("click", copy_link);
    field.addEventListener('keypress', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) { 
            linker();
            e.preventDefault();
        }
    });
}

function linker(){
    var url = field.value;
    send_request(url);
}

function copy_link(){
    field.select();
    document.execCommand("copy");
}

function send_request(url){
    if (url.length == 0) {
        return;
    }else{
        var xmlhttp = new XMLHttpRequest();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                field.value = this.responseText;
            }
        };
        xmlhttp.open("GET", "creator.php?url=" + url, true);
        xmlhttp.send();
    }
}

