// type selected on the first row, to select column
let selectedType = [(type1 = null), (type2 = null)];
// type selected on the first column, to select row
let selectedTypeRow = [(type1 = null), (type2 = null)];

let selectedCell = [0, 0];

// hightlight the selected type
function keepType() {
  let grid = document.getElementById("grid");
  let childs = grid.children;

  for (let i = 0; i < childs.length; i++) {
    childs[i].style.opacity = 0.5;
    let xy = childs[i].id.split(";"); // row or column ?

    // if a type is selected, will be in first
    if (selectedType.type1 != null) {
      if (
        xy[1] == selectedType.type1 ||
        xy[1] == selectedType.type2 ||
        xy[1] == 0
      ) {
        // mean a row and a colum are selected
        if (selectedTypeRow.type1 != null) {
          if (
            xy[0] == selectedTypeRow.type1 ||
            xy[0] == selectedTypeRow.type2 ||
            xy[0] == 0
          ) {
            childs[i].style.opacity = 1;
          }
          continue; // bcs row + column
        }
        childs[i].style.opacity = 1;
      }
    }
    // if a type is selected, will be in first
    else if (selectedTypeRow.type1 != null) {
      if (
        xy[0] == selectedTypeRow.type1 ||
        xy[0] == selectedTypeRow.type2 ||
        xy[0] == 0
      ) {
        // mean a row and a colum are selected
        if (selectedType.type1 != null) {
          if (
            xy[1] == selectedType.type1 ||
            xy[1] == selectedType.type2 ||
            xy[1] == 0
          ) {
            childs[i].style.opacity = 1;
          }
          continue; // bcs row + column
        }
        childs[i].style.opacity = 1;
      }
    }
    // all normal
    else {
      childs[i].style.opacity = 1;
    }
  }
}

// light the full board (when reseting selected) (not selected = not lighted)
function fullBoard() {
  let grid = document.getElementById("grid");
  let childs = grid.children;
  for (let i = 0; i < childs.length; i++) {
    childs[i].style.opacity = 1;
  }
  selectedCell = [0, 0];
}

//called but from the html element
function selectType(id, isRow) {
  // reset button
  if (id == null && isRow == null) {
    fullBoard();
    selectedType.type1 = null;
    selectedType.type2 = null;
    selectedTypeRow.type1 = null;
    selectedTypeRow.type2 = null;
    return;
  }

  var tab = selectedTypeRow;
  // change the table depending on who is calling the function
  if (isRow == false) {
    tab = selectedType;
  }
  // nothing was selected
  if (tab.type1 == null) {
    tab.type1 = id;
    keepType();
  }
  // deselection of the first type
  else if (tab.type1 == id) {
    if (tab.type2 != null) {
      tab.type1 = tab.type2;
      tab.type2 = null;
      keepType();
      return;
    }
    tab.type1 = null;
    keepType();
  }
  // selection of a 2nd type
  else if (tab.type2 == null) {
    tab.type2 = id;
    keepType();
  }
  // deselection of 2nd type
  else if (tab.type2 == id) {
    tab.type2 = null;
    keepType();
  }
}

function selectCell(x, y) {
  if (selectedCell[0] == x && selectedCell[1] == y) {
    fullBoard();
    return;
  }
  selectedCell = [x, y];
  selectedType.type1 = null;
  selectedType.type2 = null;
  selectedTypeRow.type1 = null;
  selectedTypeRow.type2 = null;
  selectType(x, true);
  selectType(y, false);
}
