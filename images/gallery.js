function ShowSelectedImage() {
    var div = document.getElementById("SelectedImageDiv");
    var label = document.getElementById("SelectedImageLabel");
    label.innerText = this.getAttribute("id");
    div.style.display = "block";
}

function HideSelectedImage() {
    var div = document.getElementById("SelectedImageDiv");
    div.style.display = "none";
}