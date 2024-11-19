var items = document.getElementsByClassName("itemListBody");

var loadItemsInfo = function(id){
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            dataItems = JSON.parse(this.response)[0];
            console.log(dataItems);
        }
    }
}

loadItemsInfo(items.id)