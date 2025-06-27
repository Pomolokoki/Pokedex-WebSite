let currentPage = 1;
const pageSize = 15;
let isLoading = false;

function getTextLang(str, language = "fr") {
  const split = str.split("///");
  if (language === "fr") {
    if (split[1] === "NULL") return split[0];
    return split[1];
  } else {
    return split[0];
  }
}

function getItemNoDescOrEffect($str, $mot) {
  if ($str == "NULL") {
    return "Cet item n'a pas de ".$mot;
  } else {
    return $str;
  }
}

async function fetchEtAffichageItem({ page = 1, append = false } = {}) {
  const name = document.getElementById("inputName").value;
  const category = document.getElementById("inputCategory").value;
  if (isLoading) return;
  isLoading = true;

  try {
    const response = await fetch(
      `../database/get/FromJS/getDBDataItems.php?request=SearchItems&name=${encodeURIComponent(name)}&category=${encodeURIComponent(category)}&page=${page}&pageSize=${pageSize}`
    );
    const data = await response.json();
    const tbody = document.getElementById("itemListBody");
    if (!append) tbody.innerHTML = "";
    if (Array.isArray(data)) {
      data.forEach((item) => {
        const tr = document.createElement("tr");
        tr.setAttribute("data-id", item.id);
        tr.setAttribute("data-name", item.name);
        tr.setAttribute("data-category", item.category);

        tr.innerHTML = `
          <td id='itemNameData'>${getTextLang(item.name, 'fr')}</td>
          <td>${item.pocket}</td>
          <td>${getItemNoDescOrEffect(getTextLang(item.effect, 'fr'), 'effet') ?? "Cet item n'a pas de description"}</td>
          <td>${getItemNoDescOrEffect(getTextLang(item.smallDescription, 'fr'), 'description') ?? "Cet item n'a pas d'effet"}</td>
        `;
        tbody.appendChild(tr);
      });
    }
    if (append && data.length > 0) currentPage++;
  } catch (e) {
    console.error(e);
  } finally {
    isLoading = false;
  }
}

// Pour la recherche (reset page et tableau)
document.getElementById("inputCategory").addEventListener("change", () => {
  currentPage = 1;
  fetchEtAffichageItem({ page: 1, append: false });
});
document.getElementById("inputName").addEventListener("input", () => {
  currentPage = 1;
  fetchEtAffichageItem({ page: 1, append: false });
});

// Pour le scroll infini
document.addEventListener("DOMContentLoaded", () => {
  const itemListDiv = document.querySelector(".itemList");
  if (itemListDiv) {
    itemListDiv.addEventListener("scroll", () => {
      if (
        itemListDiv.scrollTop + itemListDiv.clientHeight >= itemListDiv.scrollHeight - 10
      ) {
        fetchEtAffichageItem({ page: currentPage + 1, append: true });
      }
    });
  }
  // Chargement initial
  fetchEtAffichageItem({ page: 1, append: false });
});

document
  .getElementById("inputCategory")
  .addEventListener("change", fetchEtAffichageItem);
document
  .getElementById("inputName")
  .addEventListener("input", fetchEtAffichageItem);
