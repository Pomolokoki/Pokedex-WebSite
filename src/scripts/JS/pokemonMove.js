const filters = {
  name: document.getElementById("nameFilter"),
  type: document.getElementById("typeFilter"),
  category: document.getElementById("categoryFilter"),
  pc: document.getElementById("pcFilter"),
  pp: document.getElementById("ppFilter"),
  accuracy: document.getElementById("accuracyFilter"),
  priority: document.getElementById("priorityFilter"),
  description: document.getElementById("descriptionFilter"),
  criticity: document.getElementById("criticityFilter")
};
function getTextLang(jsText) {
  const parts = jsText.split("///");
  return parts.length > 1 ? parts[1] : parts[0];
}
let filterValues = {};
Object.keys(filters).forEach(k => filterValues[k] = "");

let currentSortColumn = null;
let ascending = true;

function applyFiltersAndSort() {
  const tbody = document.getElementById("tbody");
  const allRows = Array.from(tbody.getElementsByTagName("tr"));

  // Tri
  if (currentSortColumn !== null) {
    allRows.sort((a, b) => {
      const valA = a.children[currentSortColumn].textContent.trim();
      const valB = b.children[currentSortColumn].textContent.trim();
      const numA = parseFloat(valA);
      const numB = parseFloat(valB);
      if (!isNaN(numA) && !isNaN(numB)) {
        return ascending ? numA - numB : numB - numA;
      }
      return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
    });
  }

  // Réinitialisation
  tbody.innerHTML = "";
  allRows.forEach(row => tbody.appendChild(row));

  // Filtres
  allRows.forEach(row => {
    const cells = row.getElementsByTagName("td");
    let visible = true;

    if (filterValues.name && !cells[0].textContent.toLowerCase().includes(filterValues.name.toLowerCase())) visible = false;
    if (filterValues.type && !cells[1].textContent.toLowerCase().includes(filterValues.type.toLowerCase())) visible = false;
    if (filterValues.category && !cells[2].textContent.toLowerCase().includes(filterValues.category.toLowerCase())) visible = false;
    if (filterValues.pc && cells[3].textContent.trim() !== filterValues.pc) visible = false;
    if (filterValues.pp && cells[4].textContent.trim() !== filterValues.pp) visible = false;
    if (filterValues.accuracy && cells[5].textContent.trim() !== filterValues.accuracy) visible = false;
    if (filterValues.priority && cells[6].textContent.trim() !== filterValues.priority) visible = false;
    if (filterValues.description && !cells[7].textContent.toLowerCase().includes(filterValues.description.toLowerCase())) visible = false;
    if (filterValues.criticity && cells[8].textContent.trim() !== filterValues.criticity) visible = false;

    row.style.display = visible ? "" : "none";
  });
}

function debounce(func, delay = 300) {
  let timeout;
  return function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => func(), delay);
  };
}

// Lier les filtres
Object.entries(filters).forEach(([key, input]) => {
  const isSelect = input.tagName === "SELECT";
  input.addEventListener(isSelect ? "change" : "input", debounce(() => {
    filterValues[key] = input.value.trim();
    applyFiltersAndSort();
  }));
});

// Trier au clic
document.querySelectorAll("#thead .headText").forEach((header, index) => {
  header.addEventListener("click", () => {
    if (currentSortColumn === index) ascending = !ascending;
    else {
      currentSortColumn = index;
      ascending = true;
    }
    applyFiltersAndSort();
  });
});
