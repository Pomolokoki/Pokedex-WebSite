document.getElementById('PokeLogo').addEventListener('click',function(){
  document.location.href = 'pokedex.php';
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

document.getElementById('itemsPage').addEventListener('click',function(){
  document.location.href = 'items.php';
});

document.getElementById('attackPage').addEventListener('click',function(){
  document.location.href = 'pokemonMove.php';
});

document.getElementById('forumPage').addEventListener('click',function(){
  document.location.href = 'forum.php';
});


let login = document.getElementById('Login')
if (login)
{
  login.addEventListener('click', function(){
    document.location.href = 'login.php';
  });
}

document.addEventListener('click', (e) => {
  if (document.getElementsByClassName("nav-items")[0].getBoundingClientRect().x > -5 && !document.getElementById("theBugerParent").contains(e.target))
    {
    document.getElementById("check").click();
  }
})