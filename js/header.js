document.addEventListener('DOMContentLoaded', function () {
  var login = document.createElement('button');
  var register = document.createElement('button');

  /*Paramètres du bouton login*/
  login.type = 'button';
  login.innerHTML = "Connexion";
  login.className = 'Connexion';
  login.id = "Login";
  login.onclick = function () {
    // ...
  };
  /*Paramètres du bouton register*/
  register.type = 'button';
  register.innerHTML = "S'inscrire";
  register.className = 'Connexion';
  register.id = "Register"
  register.onclick = function () {
    // ...
  };


  var container = document.getElementById('Profile');
  container.appendChild(login);
  container.appendChild(register);

}, false);

document.getElementById('pokedexPage').addEventListener('click',function(){
  document.location.href = './Pokedex/Pokedex.php';
});

document.getElementById('mapPage').addEventListener('click',function(){
  document.location.href = 'map.html';
});