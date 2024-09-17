document.addEventListener('DOMContentLoaded', function() {
    var button = document.createElement('button');
    button.type = 'button';
    button.innerHTML = "Connexion";
    button.className = 'Connexion';
    button.id = "Login";
    // button.style.backgroundColor = "yellow";
  
    button.onclick = function() {
      // ...
    };

    var button2 = document.createElement('button');
    button2.type = 'button';
    button2.innerHTML = "S'inscrire";
    button2.className = 'Connexion';
    button2.id = "Register"
    // button2.style.backgroundColor = "green";
  
    button2.onclick = function() {
      // ...
    };

    var container = document.getElementById('Access');
    container.appendChild(button);
    container.appendChild(button2);
    
  }, false);