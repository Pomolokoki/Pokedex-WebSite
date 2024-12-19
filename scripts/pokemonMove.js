let header = document.getElementById("thead");
let container = document.getElementById("moveContainer");
let nameFilter = document.getElementById("nameFilter")
let typeFilter = document.getElementById("typeFilter")
let categoryFilter = document.getElementById("categoryFilter")
let pcFilter = document.getElementById("pcFilter")
let ppFilter = document.getElementById("ppFilter")
let accuracyFilter = document.getElementById("accuracyFilter")
let priorityFilter = document.getElementById("priorityFilter")
let descriptionFilter = document.getElementById("descriptionFilter")
let criticityFilter = document.getElementById("criticityFilter")

let inputs = {
    nameInput : '',
    typeInput : '',
    categoryInput : '',
    pcInput : '',
    ppInput : '',
    accuracyInput : '',
    priorityInput : '',
    descriptionInput : '',
    criticityInput : ''
}
let inputsKeys = Object.keys(inputs);


container.addEventListener('scroll', () => {
    // console.log(container.scrollLeft)
    header.scrollLeft = container.scrollLeft; 
})
header.addEventListener('mousewheel', (e) => {
    // console.log(container, e)
    if (!e.shiftKey) return;
    header.scrollLeft += e.deltaY;
    container.scrollLeft += e.deltaY; 
})

let listAtk = document.getElementsByTagName('tr')

function sort()
{
    console.log("name :", nameInput, "\ntype :", typeInput, "\ncategory :", categoryInput, "\npc :", pcInput, "\npp :", ppInput, "\naccuracy :", accuracyInput, "\npriority :", priorityInput, "\ndescription :", descriptionInput, "\ncriticity :", criticityInput)

}
function filter()
{
    console.log(inputs, listAtk)
    for (i = 0; i < listAtk.length; i++) {
        tds = listAtk[i].getElementsByTagName('td');
        if (tds.length == 0) continue;
        listAtk[i].style.display = "";
        for (j = 0; j < inputsKeys.length; ++j) {
            console.log(tds[j].innerHTML, inputs[inputsKeys[j]])
            if (!tds[j].innerHTML.includes(inputs[inputsKeys[j]])) {
                console.log("unview")
                listAtk[i].style.display = "none";
                break;
            }
        }
    }
}

nameFilter.addEventListener('input', () => {
    inputs.nameInput = nameFilter.value;
    filter();
})
typeFilter.addEventListener('change', () => {
    inputs.typeInput = typeFilter.value;
    filter();
})
categoryFilter.addEventListener('change', () => {
    inputs.categoryInput = categoryFilter.value;
    filter();
})
pcFilter.addEventListener('input', () => {
    inputs.pcInput= pcFilter.value;
    filter();
})
ppFilter.addEventListener('input', () => {
    inputs.ppInput = ppFilter.value;
    filter();
})
accuracyFilter.addEventListener('input', () => {
    inputs.accuracyInput = accuracyFilter.value;
    filter();
})
priorityFilter.addEventListener('input', () => {
    inputs.priorityInput = priorityFilter.value;
    filter();
})
descriptionFilter.addEventListener('input', () => {
    inputs.descriptionInput = descriptionFilter.value;
    filter();
})
criticityFilter.addEventListener('input', () => {
    inputs.criticityInput = criticityFilter.value;
    filter();
})