/*
 * inscription.js
 *
 * Script qui valide les entrées du formulaire d'inscription.
 */

// Display an error.
function displayError(message) {
  // Make sure errors are not hidden.
  document.getElementById('inscription_error').style.display = "block";
  
  // Add the error to the DOM.
  var li =  document.createElement("li");
  li.appendChild(document.createTextNode(message));
  document.getElementById('error_list').appendChild(li);
}

// Remove all errors.
function removeErrors() {
  var list = document.getElementById("error_list");	
  while(list.hasChildNodes()) {
    list.removeChild( list.lastChild );
  }
}

// Ensure form is filled.
function validateFormFilled(fields, data) {
  // Ensure all fields are filled.
  var filled = true;
  for (var i in fields) {
    if (["masculin", "feminin"].indexOf(data[fields[i]]) == -1 && data[fields[i]].value == "") {
      filled = false;
    }
  }
  if (!data["masculin"].checked && !data["feminin"].checked) {
    filled = false;
  }
  if (filled == false) {
    displayError("Veuillez remplir tout le formulaire.");
  }
  
  return filled;
}

// Attach validation listener to the button.
function attachValidation() {
  var form = document.getElementById('inscription');
  
  form.onsubmit = function () {
    removeErrors();
    
    // Fields to validate.
    var fields =  [ "username", "password", "prenom", "nom", "courriel",
      "jour", "mois", "annee", "masculin", "feminin", "theme", "accepte"];
      
    var isFormValid = true;
    
    // data contains the dom objects associated with each field.
    var data = {};
    for (var i in fields) {
      data[fields[i]] = document.getElementById(fields[i]);
    }
    
    isFormValid &= validateFormFilled(fields, data);
    
    if (!isFormValid) {
      return false;
    }
  };
}

window.onload = attachValidation;