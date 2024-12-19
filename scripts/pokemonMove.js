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
let listAtk = document.getElementsByTagName('tr')
var column = "0";

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


function sort()
{
    let sorting = true;
    let toReplace = false;
    let i = 0;
    let j = 0;
    while (sorting) {
        j++;
        if (j == 1005501) { return;}
        listAtk = document.getElementsByTagName('tr')
        
        sorting = false;
        for (i = 1; i < listAtk.length - 1; i++) {
            toReplace = false;
            let td1 = listAtk[i].getElementsByTagName('td')[parseInt(column)];
            // console.log(td1, parseInt(column), listAtk[i].getElementsByTagName('td'), listAtk[i])
            let td2 = listAtk[i + 1].getElementsByTagName('td')[parseInt(column)];
            if (td1 == undefined || td2 == undefined) continue;
            if (td1.innerHTML.toLowerCase() > td2.innerHTML.toLowerCase()) {                shouldSwitch = true;
                toReplace = true;
                break;
            }
        }
        console.log(j, i, listAtk, toReplace)
        if (toReplace) {
            listAtk[i].parentNode.insertBefore(listAtk[i + 1], listAtk[i]);
            sorting = true;
        }
    }
}
function filter()
{
    console.log(inputs, listAtk)
    for (i = 0; i < listAtk.length; i++) {
        tds = listAtk[i].getElementsByTagName('td');
        if (tds.length == 0) continue;
        listAtk[i].style.display = "";
        for (j = 0; j < inputsKeys.length; ++j) {
            // console.log(tds[j].innerHTML, inputs[inputsKeys[j]])
            if (!tds[j].innerHTML.includes(inputs[inputsKeys[j]])) {
                // console.log("unview")
                listAtk[i].style.display = "none";
                break;
            }
        }
    }
    sort();
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


let listHeads = document.getElementsByClassName('headText')

for (let i = 0; i < listHeads.length; ++i)
{
    listHeads[i].addEventListener('click', () => {
        console.log(this, self, listHeads[i])
        column = listHeads[i].dataset.id;
        console.log(column, listHeads[i].dataset.id)
        sort();
    })
}