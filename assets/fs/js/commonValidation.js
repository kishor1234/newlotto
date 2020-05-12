function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //alert("Only Number Accept");
        return false;
    }
    return true;
}
function onlyAlphabets(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        }
        else if (e) {
            var charCode = e.which;
        }
        else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
            return true;
        else
            return false;
    }
    catch (err) {
        alert(err.Description);
    }
}
function onlyAlphabetswithspace(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        }
        else if (e) {
            var charCode = e.which;
        }
        else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32)
            return true;
        else
            return false;
    }
    catch (err) {
        alert(err.Description);
    }
}
function checkFeatureDate(id) {
    var selectedDate = new Date($(id).val());
    var CurrentDate = new Date();
    if (selectedDate < CurrentDate) {
    } else {
        alert("Feature Date is Not allowd..!");
        $(id).val("");
    }
}
function checPastDate(id) {
    var selectedDate = new Date($(id).val());
    var CurrentDate = new Date();
    if (selectedDate < CurrentDate) {
        alert("Past Date is Not allowd..!");
        $(id).val("");
    } else {
    }
}