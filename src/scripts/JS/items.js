function isNumber(value) {
  let reg = new RegExp("^[0-9]+$");
  return reg.test(value);
}

function rechercheInput() {
  console.log("marche po");
  var input, filter, tr, tbody,td
  input = document.getElementById("inputName");
  filter = input.value.toUpperCase();
  tbody = document.getElementById("itemListBody");
  tr = document.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (!td) {
      continue;
    }
    txtValue = td.innerHTML || td.innerText || td.textContent;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      tr[i].style.display = "";
      //recherche2();
    } else {
      tr[i].style.display = "none";
      //recherche2();
    }
  }
}

function rechercheBoth() {
    console.log("marche po3");
    var inputName,inputCategory, filterName,filterCategory, tr, tbody,td
    inputName = document.getElementById("inputName");
    inputCategory = document.getElementById("inputCategory");
    filterName = inputName.value.toUpperCase();
    filterCategory = inputCategory.value.toUpperCase();
    tbody = document.getElementById("itemListBody");
    tr = document.getElementsByTagName("tr");
  
    for (i = 0; i < tr.length; i++) {
      tdName = tr[i].getElementsByTagName("td")[0];
      tdCategory = tr[i].getElementsByTagName("td")[1];
      if (!tdName || !tdCategory) {
        continue;
      }
      txtValueName = tdName.innerHTML || tdName.innerText || tdName.textContent;
      txtValueCategory = tdCategory.innerHTML || tdCategory.innerText || tdCategory.textContent;
      if (txtValueName.toUpperCase().indexOf(filterName) > -1 && txtValueCategory.toUpperCase().indexOf(filterCategory) > -1) {
        tr[i].style.display = "";
        if(filterCategory == "ALL"){
            tr[i].style.display = "";
          }
      } else {
        tr[i].style.display = "none";
        if(filterCategory == "ALL"){
            tr[i].style.display = "";
          }
      }
      if(filterCategory == "ALL" && txtValueName.toUpperCase().indexOf(filterName) > -1 && txtValueCategory.toUpperCase().indexOf(filterCategory) > -1){
        tr[i].style.display = "";
      }
    }
  }

function rechercheCategory() {
    console.log("marche po category");
    var input, filter, tr, tbody,td
    input = document.getElementById("inputCategory");
    filter = input.value.toUpperCase();
    tbody = document.getElementById("itemListBody");
    tr = document.getElementsByTagName("tr");
  
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (!td) {
        continue;
      }
      txtValue = td.innerHTML || td.innerText || td.textContent;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        //recherche();
      } else {
        tr[i].style.display = "none";
        //recherche();
      }
      if(filter == "ALL"){
        tr[i].style.display = "";
        //recherche();
      }
    }
  }


  function rechercheCategItem() {
    const nameInput = document.getElementById("inputName").value.toUpperCase();
    const categorySelect = document.getElementById("inputCategory").value.toUpperCase();
    const tbody = document.getElementById("itemListBody");
    const rows = tbody.getElementsByTagName("tr");
    
    Array.from(rows).forEach(row => {
        const nameCell = row.getElementsByTagName("td")[0];
        const categoryCell = row.getElementsByTagName("td")[1];
        
        if (nameCell && categoryCell) {
            const name = nameCell.textContent || nameCell.innerText;
            const category = categoryCell.textContent || categoryCell.innerText;
            
            const nameMatch = name.toUpperCase().includes(nameInput);
            const categoryMatch = categorySelect === "ALL" || category.toUpperCase().includes(categorySelect);
            
            
            row.style.display = nameMatch && categoryMatch ? "" : "none";
        }
    });
}

document.getElementById("inputCategory").addEventListener("change", rechercheCategItem);
document.getElementById("inputName").addEventListener("input", rechercheCategItem);
