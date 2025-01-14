let header = document.getElementById("thead");
let container = document.getElementById("moveContainer");
let nameFilter = document.getElementById("nameFilter");
let typeFilter = document.getElementById("typeFilter");
let categoryFilter = document.getElementById("categoryFilter");
let pcFilter = document.getElementById("pcFilter");
let ppFilter = document.getElementById("ppFilter");
let accuracyFilter = document.getElementById("accuracyFilter");
let priorityFilter = document.getElementById("priorityFilter");
let descriptionFilter = document.getElementById("descriptionFilter");
let criticityFilter = document.getElementById("criticityFilter");

// current filters
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
};

let inputsKeys = Object.keys(inputs);
let listAtk = document.getElementsByTagName('tr');
var column = "0";

// let the fake header be at sameplace at old one
container.addEventListener('scroll', () => {
    header.scrollLeft = container.scrollLeft; 
})
// let the fake header where the real one should be
header.addEventListener('mousewheel', (e) => {
    if (!e.shiftKey) return;
    header.scrollLeft += e.deltaY;
    container.scrollLeft += e.deltaY; 
})

// sort all moves
var lastColumn = "0";
function sort()
{
    let table = document.getElementById("moveList");
    let rows = Array.from(table.rows);
    rows.splice(0, 2); // removes the 2 headers

    if (lastColumn == column)
        lastColumn = '-1';
    else
        lastColumn = column;

    // sort
    rows.sort((a,b) => {
        // td = row index [column]
        let td1 = a.getElementsByTagName('td')[parseInt(column)];
        let td2 = b.getElementsByTagName('td')[parseInt(column)];
        
        // commpare td1 / td2
        if (td1 == undefined)
            return 1;
        if (td2 == undefined)
            return -1;
        if (!isNaN(parseInt(td1.innerHTML))) {
            let result;
            if (isNaN(parseInt(td2.innerHTML)))
                result = -1;
            if (parseInt(td1.innerHTML) < parseInt(td2.innerHTML))
                result = -1;
            else if (parseInt(td1.innerHTML) > parseInt(td2.innerHTML))
                result = 1;
            else
                result = 0;
            if (lastColumn == '-1')
                result *= -1;
            return result;
        }
        else {
            if (lastColumn == '-1')
                return td2.innerHTML.localeCompare(td1.innerHTML);
            return td1.innerHTML.localeCompare(td2.innerHTML);
        }
    })
    // old way of sorting taking way to much time
    //
    // while (sorting) {
    //     listAtk = document.getElementsByTagName('tr')
        
    //     sorting = false;
    //     for (i = 1; i < listAtk.length - 1; i++) {
    //         toReplace = false;
    //         let td1 = listAtk[i].getElementsByTagName('td')[parseInt(column)];
    //         let td2 = listAtk[i + 1].getElementsByTagName('td')[parseInt(column)];
    //         if (td1 == undefined || td2 == undefined) continue;
    //         if (td1.innerHTML.toLowerCase() > td2.innerHTML.toLowerCase()) {                shouldSwitch = true;
    //             toReplace = true;
    //             break;
    //         }
    //     }
    //     if (toReplace) {
    //         listAtk[i].parentNode.insertBefore(listAtk[i + 1], listAtk[i]);
    //         sorting = true;
    //     }
    // }

    // actualise the table
    let body = document.getElementById("tbody")
    body.innerHTML = "";
    for (let i = 0; i < rows.length; ++i) {
        body.appendChild(rows[i]);
    }
}

//update the filter array
function filter()
{
    for (i = 0; i < listAtk.length; i++) {

        tds = listAtk[i].getElementsByTagName('td');
        if (tds.length == 0) continue;

        listAtk[i].style.display = "";
        for (j = 0; j < inputsKeys.length; ++j) {
            if (!tds[j].innerHTML.includes(inputs[inputsKeys[j]])) {
                listAtk[i].style.display = "none";
                break;
            }
        }
    }
    sort();
}

// filter inputs
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


// sorter inputs
let listHeads = document.getElementsByClassName('headText');
for (let i = 0; i < listHeads.length; ++i)
{
    listHeads[i].addEventListener('click', () => {
        column = listHeads[i].dataset.id;
        sort();
    })
}