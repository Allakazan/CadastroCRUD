function validateUserForm() {
    var inputs = document.getElementById('userGroups').querySelectorAll('input');
    var countChecked = 0;

    for (var i = 0; i < inputs.length; i++) {
        if(inputs[i].checked)
            countChecked++;
    }

    var canSubmit = countChecked >= 2;

    if (!canSubmit) {
        alert("O usuario precisa ser cadastrados no minimo em 2 grupos");
    }

    return canSubmit;
}