let typeList = []
let selectedType = [
    type1 = null,
    type2 = null,
];
let selectedTypeRow = [
    type1 = null,
    type2 = null,
];

// let doubleType = true
let gidCellHeight = 0;

// function doubleTypeChanged()
// {
//     doubleType = !doubleType;
// }

function keepType()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    gidCellHeight = childs[0].style.height
    for(let i = 0; i < childs.length; i++)
    {
        childs[i].style.opacity = 0.5;
        let xy = childs[i].id.split(";")
        if (selectedType.type1 != null)
        {
            if (xy[1] == selectedType.type1 || xy[1] == selectedType.type2 || xy[1] == 0)
            {
                if (selectedTypeRow.type1 != null)
                {
                    if (xy[0] == selectedTypeRow.type1 || xy[0] == selectedTypeRow.type2 || xy[0] == 0)
                    {
                        childs[i].style.opacity = 1;
                    }
                    continue
                }
                childs[i].style.opacity = 1;
            }
        }
        else if (selectedTypeRow.type1 != null)
        {
            if (xy[0] == selectedTypeRow.type1 || xy[0] == selectedTypeRow.type2 || xy[0] == 0)
            {
                if (selectedType.type1 != null)
                {
                    if (xy[1] == selectedType.type1 || xy[1] == selectedType.type2 || xy[1] == 0)
                    {
                        childs[i].style.opacity = 1;
                    }
                    continue 
                }
                childs[i].style.opacity = 1;
            }
        }
        else
        {
            childs[i].style.opacity = 1;
        }
    }
}
function keepTypes()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    fullGreyBoard()
    keepType()
    for(let i = 0; i < childs.length; i++)
    {
        let xy = childs[i].id.split(";")
        if (row && (xy[0] == selectedType.type2 || xy[0] == 0))
        {
            childs[i].style.opacity = 1;
            // childs[i].style.order = 1;
            //childs[i]. = red;
        }
        else if (!row && (xy[1] == selectedType.type2 || xy[1] == 0))
        {
            childs[i].style.opacity = 1;
            //childs[i]. = red;
        }
    }
}

function fullBoard()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    for(let i = 0; i < childs.length; i++)
    {
        childs[i].style.opacity = 1;
    }
}
function fullGreyBoard()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    for(let i = 0; i < childs.length; i++)
    {
        childs[i].style.opacity = 0.5;
    }
}
function selectType(id, isRow)
{
    if (id == null && isRow == null)
    {
        fullBoard()
        selectedType.type1 = null
        selectedType.type2 = null
        selectedTypeRow.type1 = null
        selectedTypeRow.type2 = null
        return 
    }
    var tab = selectedTypeRow
    if (isRow == false)
    {
        tab = selectedType
    }
    if (tab.type1 == null)
    {
        tab.type1 = id
        console.log("keeptype")
        keepType()
    }
    else if (tab.type1 == id)
    {
        if (tab.type2 != null)
        {
            tab.type1 = tab.type2
            tab.type2 = null
            keepType()
            return
        }
        tab.type1 = null
        keepType()
    }
    else if (tab.type2 == null)
    {
        tab.type2 = id
        console.log("keeptype")
        keepType()
    }
    else if (tab.type2 == id)
    {
        tab.type2 = null
        keepType()
    }
    
    // else
    // {
    //     console.log(selectedType)
    //     if (selectedType.type1 == null)
    //     {
    //         selectedType.type1 = row;
    //         if (row == 0) {
    //             keepType()
    //             return
    //         }
    //         HighLight()
    //     }
    //     else if (row != selectedType.type1 && selectedType.type2 == null)
    //     {
    //         selectedType.type2 = row;
    //         console.log("keepTypes")
    //         keepTypes()
    //         RemoveHighLight()
    //     }
    //     else if (row == selectedType.type1)
    //     {
    //         if(selectedType.type2 == null)
    //         {
    //             selectedType.type1 = null;
    //             fullBoard()
    //             RemoveHighLight()
    //         }
    //         else
    //         {
    //             selectedType.type1 = selectedType.type2;
    //             selectedType.type2 = null;
    //             fullBoard()
    //             HighLight()
    //         }
    //     }
    //     else if (row == selectedType.type2)
    //     {
    //         selectedType.type2 = null;
    //         fullBoard()
    //         HighLight()
    //     }
    //     console.log(selectedType)
    // }
            
        

}

// function setDoubleType()
// {
//     doubleType = !doubleType
//     if (!doubleType)
//         selectType['type2'] = null
// }