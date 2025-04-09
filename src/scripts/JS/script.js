var elements = document.getElementsByClassName("pokemon");

var myFunction = function() {
    var attribute = this.getAttribute("data-myattribute");
    console.log(this.id)
};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}