document.getElementById('myPage').addEventListener('click',function(){
    document.location.href = 'profile.php';
  });

let changePP  = document.getElementById('fileImage');


if(changePP){
  changePP.addEventListener("change", function (event) {
      const file = event.target.files[0];
      if (file) {
        const formData = new FormData();
        formData.append("image", file);
        fetch("profile.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => {            
            console.log(data);
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

