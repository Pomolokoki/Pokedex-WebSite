let selectedType = [ // type selected on the first row, to select column
    type1 = null,
    type2 = null,
];
let selectedTypeRow = [ // type selected on the first column, to select row
    type1 = null,
    type2 = null,
];

function keepType() { // hightlight the selected type
    let grid = document.getElementById("grid");
    let childs = grid.children;
    
    for (let i = 0; i < childs.length; i++) {
        childs[i].style.opacity = 0.5;
        let xy = childs[i].id.split(";"); // row or column ?

        if (selectedType.type1 != null) { // if a type is selected, will be in first
            if (xy[1] == selectedType.type1 || xy[1] == selectedType.type2 || xy[1] == 0) {
                if (selectedTypeRow.type1 != null) { // mean a row and a colum are selected
                    if (xy[0] == selectedTypeRow.type1 || xy[0] == selectedTypeRow.type2 || xy[0] == 0) {
                        childs[i].style.opacity = 1;
                    }
                    continue; // bcs row + column
                }
                childs[i].style.opacity = 1;
            }
        }
        else if (selectedTypeRow.type1 != null) { // if a type is selected, will be in first
            if (xy[0] == selectedTypeRow.type1 || xy[0] == selectedTypeRow.type2 || xy[0] == 0) {
                if (selectedType.type1 != null) {  // mean a row and a colum are selected
                    if (xy[1] == selectedType.type1 || xy[1] == selectedType.type2 || xy[1] == 0) {
                        childs[i].style.opacity = 1;
                    }
                    continue; // bcs row + column
                }
                childs[i].style.opacity = 1;
            }
        }
        else { // all normal
            childs[i].style.opacity = 1;
        }
    }
}

function fullBoard() { // light the full board (when reseting selected) (not selected = not lighted)
    let grid = document.getElementById("grid")
    let childs = grid.children
    for (let i = 0; i < childs.length; i++) {
        childs[i].style.opacity = 1;
    }
}


function selectType(id, isRow) { //called but the html element
    
    if (id == null && isRow == null) { // reset button
        fullBoard()
        selectedType.type1 = null
        selectedType.type2 = null
        selectedTypeRow.type1 = null
        selectedTypeRow.type2 = null
        return
    }
    
    var tab = selectedTypeRow
    if (isRow == false) { // change the table depending on who is calling the function
        tab = selectedType
    }
    if (tab.type1 == null) { // nothing was selected
        tab.type1 = id
        keepType()
    }
    else if (tab.type1 == id) { // deselection of the first type
        if (tab.type2 != null) {
            tab.type1 = tab.type2
            tab.type2 = null
            keepType()
            return
        }
        tab.type1 = null
        keepType()
    }
    else if (tab.type2 == null) { // selection of a 2nd type
        tab.type2 = id
        keepType()
    }
    else if (tab.type2 == id) { // deselection of 2nd type
        tab.type2 = null
        keepType()
    }
}