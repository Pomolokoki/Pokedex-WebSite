document.getElementById('PokeLogo').addEventListener('click',function(){
  document.location.href = 'forum.php';
});
document.getElementById('pokedexPage').addEventListener('click',function(){
  document.location.href = 'pokedex.php';
});

document.getElementById('typeTablePage').addEventListener('click',function(){
  document.location.href = 'typeTable.php';
});

document.getElementById('mapPage').addEventListener('click',function(){
  document.location.href = 'map.php';
});
let login = document.getElementById('Login')
if (login)
{
  login.addEventListener('click', function(){
    document.location.href = 'login.php';
  });
}
