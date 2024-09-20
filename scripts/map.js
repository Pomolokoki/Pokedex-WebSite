function MapScrolled(WheelEvent)
{
    console.log(WheelEvent)
    console.log("hehe");
}
let img = document.getElementById("map")
let imgP = document.getElementById("smallMapFrame")

imgP.addEventListener("wheel", function(e) {
    console.log(img.style.height, img.style.maxHeight, img.style.getPropertyValue("maxHeight"), img.style.getPropertyValue("max-height"))
    console.log(parseFloat(img.style.height), parseFloat(img.style.maxHeight))
    if (e.deltaY < 0)
    {
        console.log(img.style.height)
        if (parseFloat(img.style.height) > 3000)
            return

        img.style.height = img.clientHeight * 1.1 + "px";
        img.style.width = img.clientWidth * 1.1 + "px";
        let a = parseFloat(img.offsetLeft) //+ parseFloat(img.style.width) ;
        let b = parseFloat(img.offsetTop) //+ parseFloat(img.style.height) ;
        img.style.left = (e.offsetX - (e.offsetX - a) * 1.1) + "px";
        img.style.top = (e.offsetY - (e.offsetY - b) * 1.1) + "px";
        //pos.y = at.y - (at.y - pos.y) * 1.1;
    }
    else if (e.deltaY > 0)
    {
        img.style.height = img.clientHeight * 0.9 + "px";
        img.style.width = img.clientWidth * 0.9 + "px";
        let a = parseFloat(img.offsetLeft) //- parseFloat(img.style.width) ;
        let b = parseFloat(img.offsetTop) //- parseFloat(img.style.width) ;
        img.style.left = (e.offsetX - (e.offsetX - a) * 0.9) + "px";
        img.style.top = (e.offsetY - (e.offsetY - b) * 0.9) + "px";
    }
})

let drag = false;
let offsetX = 0;
let offsetY = 0;

imgP.addEventListener("mousedown", function(e)
{
    offsetX = e.offsetX - img.offsetLeft
    offsetY = e.offsetY - img.offsetTop
    drag = true
})
document.addEventListener("mouseup", function(e)
{
    drag = false
})
document.onmousemove = function(e)
{
    if (drag)
    {
        img.style.left =  e.offsetX - offsetX + "px";
        img.style.top =  e.offsetY - offsetY + "px";
    }
}

function center()
{
    img.style.width=''
    img.style.height=''
    img.style.left = imgP.offsetWidth / 2 - parseFloat(img.offsetWidth) / 2 + "px"
    img.style.top = imgP.offsetHeight / 2 - parseFloat(img.offsetHeight) / 2 + "px"
}

document.getElementById("centered").addEventListener("click", center)
center();