document.getElementById('myPage').addEventListener('click',function(){
    document.location.href = 'profile.php';
  });

var loadFile = function(event) {
  let id_user = document.getElementById('ID_User').innerHTML;
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET",`./ajax/getDBData.php?request= 
    UPDATE player SET picture = "${"./img/" + event.target.files[0].name}" WHERE id = ${id_user}
    `)
  xmlhttp.send();
  var image = document.getElementById('output');
  console.log(image.src);
  image.src = URL.createObjectURL(event.target.files[0]);
  console.log(event.target.files[0].name);
  console.log(id_user);
};

let changePP  = document.getElementById('fileImage');


if(changePP){
  changePP.addEventListener("change", function (event) {
    console.log("ftcyvgjokplm");
      const preview = document.getElementById("output");
      const file = event.target.files[0];
      if (file) {
        preview.src = URL.createObjectURL(file);
        const formData = new FormData();
        formData.append("image", file);
        fetch("profile.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => {
            console.log(data);
            console.log("Image uploaded", data);
            console.log(response);
          })
          .catch((error) => console.error("Error:", error));
      }
      document.getElementById("submitButton").click();
    });
  
  
  changePP.addEventListener('change', function(event){
    const output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    document.getElementById('submitButton').click();
  });
}



[...document.querySelectorAll(".pokemon")].forEach(pokemon => {
  pokemon.addEventListener("dblclick", () => {
      console.log("dbb")
      let form = document.createElement('form');
      form.setAttribute('method', 'POST');
      form.setAttribute('action', "./pokedex.php");

      let data = document.createElement('input');
      data.setAttribute('type', 'hidden');
      data.setAttribute('name', 'pokemonId');
      data.setAttribute('value', pokemon.dataset.id);
      form.appendChild(data);

      document.body.appendChild(form);
      form.submit();
  }
  );
});

