function CheckValid(id, listid) {
    var x = document.getElementById(id).value;
    var y = document.getElementById(listid).options;
    var valid = false;
    for (var i = 0; i < y.length; i++) {
        if (y[i].value == x) {
            valid = true;
            break;
        }
    }
    if (!valid) {
        document.getElementById("submit").disabled = true;
        document.getElementById(id).style.borderColor = "red";
    } else {
        document.getElementById("submit").disabled = false;
        document.getElementById(id).style.borderColor = "transparent";
    }
}