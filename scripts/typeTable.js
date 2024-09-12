let typeList = []
let selectedType = [
    type1 = null,
    type2 = null,
];

let doubleType = true
let gidCellHeight = 0;

function doubleTypeChanged()
{
    doubleType = !doubleType;
}

function keepType()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    gidCellHeight = childs[0].style.height
    for(let i = 0; i < childs.length; i++)
    {
        let xy = childs[i].id.split(";")
        if (xy[0] != selectedType.type1 && xy[0] != 0)
        {
            childs[i].style.opacity = 0;
            childs[i].style.order = 1;
            //childs[i]. = red;
        }
        else if (xy[0] != 0){
            childs[i].style.order = 0;
        }
    }
}
function keepTypes()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    for(let i = 0; i < childs.length; i++)
    {
        let xy = childs[i].id.split(";")
        //console.log(childs[i], xy)
        if (xy[0] != selectedType.type1 && xy[0] != selectedType.type2 && xy[0] != 0)
        {
            childs[i].style.opacity = 0;
            childs[i].style.order = 1;
            //childs[i]. = red;
        }
        else if (xy[0] != 0){
            childs[i].style.order = 0;
        }
    }
}

function fullBoard()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    for(let i = 0; i < childs.length; i++)
    {
        childs[i].style.order = 0;
        childs[i].style.opacity = 1;
    }
}

function HighLight()
{
    let grid = document.getElementById("grid")
    let childs = grid.children
    let highlight = document.getElementById("highlight")
    highlight.style.opacity = 1
    for(let i = 0; i < childs.length; i++)
    {
        let xy = childs[i].id.split(";")
        if (xy[0] == selectedType.type1)
        {
            console.log(childs[i].offsetTop)
            highlight.style.top = (childs[i].offsetTop + 15) + "px"
            return;
        }
    }
}
function RemoveHighLight()
{
    let highlight = document.getElementById("highlight")
    highlight.style.opacity = 0
}
function selectType(row)
{
    if (!doubleType)
    {
        if (selectedType.type1 == null)
        {
            selectedType.type1 = row
            console.log("keeptype")
            keepType();
        }
        else if (selectedType.type1 == row)
        {
            selectedType.type1 = null
            fullBoard()
            RemoveHighLight()
        }
    }
    else
    {
        console.log(selectedType)
        if (selectedType.type1 == null)
        {
            selectedType.type1 = row;
            if (row == 0) {
                keepType()
                return
            }
            HighLight()
        }
        else if (row != selectedType.type1 && selectedType.type2 == null)
        {
            selectedType.type2 = row;
            console.log("keepTypes")
            keepTypes()
            RemoveHighLight()
        }
        else if (row == selectedType.type1)
        {
            if(selectedType.type2 == null)
            {
                selectedType.type1 = null;
                fullBoard()
                RemoveHighLight()
            }
            else
            {
                selectedType.type1 = selectedType.type2;
                selectedType.type2 = null;
                fullBoard()
                HighLight()
            }
        }
        else if (row == selectedType.type2)
        {
            selectedType.type2 = null;
            fullBoard()
            HighLight()
        }
        console.log(selectedType)
    }
            
        

}

function setDoubleType()
{
    doubleType = !doubleType
    if (!doubleType)
        selectType['type2'] = null
}