<script>
    function toggleHiddenRow(checkbox) {
        var row = checkbox.parentNode.parentNode;
        var posteID = row.querySelector('input[name^="check_status_nok"]').getAttribute('name').match(/\[(.*?)\]/)[1];
        var parameterID = row.querySelector('input[name^="check_status_nok"]').getAttribute('name').match(/\[(.*?)\]/g)[1].replace(/\[|\]/g, '');
        var hiddenRow = document.getElementById('hiddenRow_' + posteID + '_' + parameterID);
        if (checkbox.checked) {
            hiddenRow.style.display = 'table-row';
        } else {
            hiddenRow.style.display = 'none';
        }

    }

    function uncheckOther(checkbox) {
        var rowCheckboxes = checkbox.parentNode.getElementsByTagName('input');
        for (var i = 0; i < rowCheckboxes.length; i++) {
            if (rowCheckboxes[i].type === 'checkbox' && rowCheckboxes[i] !== checkbox) {
                rowCheckboxes[i].checked = false;
            }
        }
    }

    // Get all "valeur" input fields
    var valeurInputs = document.querySelectorAll('input[id="valeur"]');
    // Loop through each "valeur" input field
    valeurInputs.forEach(function (input) {
        var row = input.parentNode.parentNode;
        var valeurMinInput = row.querySelector('input[id="valeur_min"]');
        var valeurMaxInput = row.querySelector('input[id="valeur_max"]');
        var nokCheckbox = row.querySelector('input[id="nok"]');
        var okCheckbox = row.querySelector('input[id="ok"]');
        // Enable checkboxes on input change
        input.addEventListener("input", function () {
            checkValue(this, nokCheckbox, okCheckbox);
        });

        // Disable "valeur" input if valeur_min or valeur_max is empty
        disableInputIfEmpty(valeurMinInput, input);
        disableInputIfEmpty(valeurMaxInput, input);

        // Disable "valeur" input if valeur_min or valeur_max changes
        valeurMinInput.addEventListener("input", function () {
            disableInputIfEmpty(this, input);
        });

        valeurMaxInput.addEventListener("input", function () {
            disableInputIfEmpty(this, input);
        });
    });


    function checkValue(input, nokCheckbox, okCheckbox) {
        var valeur = parseFloat(input.value);
        var row = input.parentNode.parentNode;
        var valeurMin = parseFloat(row.querySelector('input[id="valeur_min"]').value);
        var valeurMax = parseFloat(row.querySelector('input[id="valeur_max"]').value);


        if (valeur < valeurMin || valeur > valeurMax) {
            nokCheckbox.checked = true;
            okCheckbox.checked = false;

        } else {
            nokCheckbox.checked = false;
            okCheckbox.checked = true;
        }
    }

    function disableInputIfEmpty(input, targetInput) {
        if (input.value === "") {
            targetInput.disabled = true;
        } else {
            targetInput.disabled = false;
        }
    }


    
    function uncheckOther(checkbox) {
        var otherCheckbox = checkbox.id === "ok" ? checkbox.parentNode.parentNode.querySelector('input[id="nok"]') : checkbox.parentNode.parentNode.querySelector('input[id="ok"]');
        if (checkbox.checked) {
            otherCheckbox.checked = false;
        }
    }

    function uncheckOther1(checkbox) {
        var otherCheckbox = checkbox.id === "ok1" ? checkbox.parentNode.parentNode.querySelector('input[id="nok1"]') : checkbox.parentNode.parentNode.querySelector('input[id="ok1"]');
        if (checkbox.checked) {
            otherCheckbox.checked = false;
        }
    }

    // Get all matricule inputs
    const matriculeInputs = document.querySelectorAll('input[name^="matricule"]');
    // Loop through each matricule input
    matriculeInputs.forEach(matriculeInput => {

        // Get all inputs in the current row
        const rowInputs = matriculeInput.parentNode.parentNode.parentNode.querySelectorAll('input[name="valeur"], input[type="checkbox"]');

        // Disable inputs if matricule is empty
        if (matriculeInput.value === "") {
            rowInputs.forEach(rowInput => {
                rowInput.disabled = true;
            });
        }
        // Enable inputs if matricule is not empty
        matriculeInput.addEventListener("input", () => {
            if (matriculeInput.value !== "") {
                rowInputs.forEach(rowInput => {
                    rowInput.disabled = false;
                });
            } else {
                rowInputs.forEach(rowInput => {
                    rowInput.disabled = true;
                });
            }
        });

    });

    var valeur1Inputs = document.querySelectorAll('input[id="valeur1"]');
    // Loop through each "valeur1" input field
    valeur1Inputs.forEach(function (input) {
        var row = input.parentNode.parentNode;
        var valeurMin1Input = row.querySelector('input[id="valeur_min1"]');
        var valeurMax1Input = row.querySelector('input[id="valeur_max1"]');
        var nok1Checkbox = row.querySelector('input[id="nok1"]');
        var ok1Checkbox = row.querySelector('input[id="ok1"]');
        // Enable checkboxes on input change
        input.addEventListener("input", function () {
            checkValue(this, nok1Checkbox, ok1Checkbox);
        });

        // Disable "valeur1" input if valeur_min1 or valeur_max1 is empty
        disableInputIfEmpty(valeurMin1Input, input);
        disableInputIfEmpty(valeurMax1Input, input);

        // Disable "valeur1" input if valeur_min1 or valeur_max1 changes
        valeurMin1Input.addEventListener("input", function () {
            disableInputIfEmpty(this, input);
        });

        valeurMax1Input.addEventListener("input", function () {
            disableInputIfEmpty(this, input);
        });
    });


</script>


<style>
    input[type=checkbox] {
        width: 30px;
        height: 30px;
        color: red;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }


    table-hover tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }
</style>