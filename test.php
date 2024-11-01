<script>

// Get all "valeur1" input fields
var valeurInputs1 = document.querySelectorAll('input[id="valeur1"]');
// Loop through each "valeur1" input field
valeurInputs1.forEach(function (input) {
  var row1 = input.parentNode.parentNode;
  var valeurMinInput1 = row.querySelector('input[id="valeur_min1"]');
  var valeurMaxInput1 = row.querySelector('input[id="valeur_max1"]');
  var nokCheckbox1 = row.querySelector('input[id="nok1"]');
  var okCheckbox1 = row.querySelector('input[id="ok1"]');
  // Enable checkboxes on input change
  input.addEventListener("input", function () {
    checkValue1(this, nokCheckbox1, okCheckbox1);
  });

  // Disable "valeur1" input if valeur_min1 or valeur_max1 is empty
  disableInputIfEmpty(valeurMinInput1, input);
  disableInputIfEmpty(valeurMaxInput1, input);

  // Disable "valeur1" input if valeur_min1 or valeur_max1 changes
  valeurMinInput1.addEventListener("input", function () {
    disableInputIfEmpty(this, input);
  });

  valeurMaxInput1.addEventListener("input", function () {
    disableInputIfEmpty(this, input);
  });
});

function checkValue1(input, nokCheckbox1, okCheckbox1) {
  var valeur1 = parseFloat(input.value);
  var row1 = input.parentNode.parentNode;
  var valeurMin1 = parseFloat(row.querySelector('input[id="valeur_min1"]').value);
  var valeurMax1 = parseFloat(row.querySelector('input[id="valeur_max1"]').value);

  if (valeur1 < valeurMin1 || valeur1 > valeurMax1) {
    nokCheckbox1.checked = true;
    okCheckbox1.checked = false;
  } else {
    nokCheckbox1.checked = false;
    okCheckbox1.checked = true;
  }
}

function disableInputIfEmpty(input, targetInput) {
  if (input.value === "") {
    targetInput.disabled = true;
  } else {
    targetInput.disabled = false;
  }
}
</script>