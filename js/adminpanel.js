var checkingRealNumber = function (event) {
    var data = this.value;
    if ((event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 0) {
        if (data.indexOf('.') > -1) {
            if (event.charCode == 46)
                event.preventDefault();
        }
    } else
        event.preventDefault();
};

function addListener(list) {
    for (var i = 0; i < list.length; i++) {
        list[i].addEventListener('keypress', checkingRealNumber);
    }
}

$(document).ready(function () {
    var classList = document.getElementsByClassName('number');
    addListener(classList);
});