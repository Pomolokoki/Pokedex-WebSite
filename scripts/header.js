
document.getElementById('pokedexPage').addEventListener('click',function(){
  document.location.href = 'Pokedex.php';
});

document.getElementById('typeTablePage').addEventListener('click',function(){
  document.location.href = 'typeTable.php';
});

document.getElementById('mapPage').addEventListener('click',function(){
  document.location.href = 'map.php';
});


const profile = document.querySelectorAll(".Connexion");

profile[0].addEventListener('click',function(){
  document.location.href='login.php';
});

profile[1].addEventListener('click',function(){
  document.location.href='register.php';
});