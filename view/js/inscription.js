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
function validateFormFilled(fields, data, errors) {
  // Ensure all fields are filled.
  var filled = true;
  for (var i in fields) {
    if (["masculin", "feminin", "accepte"].indexOf(data[fields[i]]) == -1 && data[fields[i]].value == "") {
      filled = false;
    }
  }
  if (!data["masculin"].checked && !data["feminin"].checked) {
    filled = false;
  }
  if (filled == false) {
    errors.push("Veuillez remplir tout le formulaire.");
  }
}

// Ensure "nom" and "prenom" fields are valid.
function validateName(fields, data, errors) {
  var re = /^[a-zA-Záéíóäëiöúàèììù_ ]{2,}$/;
  if (!(re.test(data["nom"].value)) || !(re.test(data["prenom"].value))) {
    errors.push("Les noms et prénoms doivent contenir uniquement des" +
      " lettres, espaces, tirets et au minimum 2 caractères.");
  }
}

// Ensure email is valid.
function validateEmail(fields, data, errors) {
  var re = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
  if (!(re.test(data["courriel"].value))) {
    errors.push("Courriel invalide.");
  }
}

// Ensure username is valid.
function validateUsername(fields, data, errors) {
  if (!(/^[a-zA-Z0-9]{5,}$/.test(data["username"].value))) {
    errors.push("Le nom d’utilisateur inclut des lettres sans accents et chiffres" +
      " uniquement. Minimum 5 caractères.");
  }
}

// Ensure user agrees with terms.
function validateTerms(fields, data, errors) {
  if (!data["accepte"].checked) {
    errors.push("Vous devez être en accord avec les termes de la license.");
  }
}

// Attach validation listener to the button.
function attachValidation() {
  var form = document.getElementById('inscription');
  
  form.onsubmit = function () {
    // Fields to validate.
    var fields =  [ "username", "password", "prenom", "nom", "courriel",
      "jour", "mois", "annee", "masculin", "feminin", "theme", "accepte"];

    // data contains the dom objects associated with each field.
    var data = {};
    for (var i in fields) {
      data[fields[i]] = document.getElementById(fields[i]);
    }
    
    // Pass the data to a list of validators.
    var errors = [];
    var validators = [ validateFormFilled, validateName, validateUsername, validateTerms,
      validateEmail ];
    for (var i = 0; i < validators.length; i++) {
      validators[i](fields, data, errors);
    }
    
    if (errors) {
      // Display errors
      removeErrors();
      for (var i = 0; i < errors.length; i++) {
        displayError(errors[i]);
      }
      // Stop submission of form.
      return false;
    }
  };
}

window.onload = attachValidation;