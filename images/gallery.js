function ShowSelectedImage()
{
    var div = document.getElementById("SelectedImageDiv");
    var label = document.getElementById("SelectedImageLabel");
    var likes = document.getElementById("SelectedImageLikes");
    var img = document.getElementById("SelectedImageImg");
    var request = new XMLHttpRequest();
    var img_id = this.getAttribute("id");
    var url = "images/gallery.php";
    var json;

    request.open("POST", url, true);
    request.onreadystatechange = function ()
    {
        if (request.readyState == 4 && request.status == 200)
        {
            json = JSON.parse(request.responseText);
            img.src = json.image_path;
            label.innerText = json.image_name;
            likes.innerText = "Likes: " + json.image_likes + " Dislikes: " + json.image_dislikes;
            div.style.display = "block";
        }
    };

    request.send(JSON.stringify({"image_id":img_id, "action":"selected"}));
}

function LikeImage()
{
    var img = document.getElementById("SelectedImageImg");
    var likes = document.getElementById("SelectedImageLikes");
    var request = new XMLHttpRequest();
    var url = "images/gallery.php";
    var json;

    request.open("POST", url, true);
    request.onreadystatechange = function ()
    {
        if (request.readyState == 4 && request.status == 200)
        {
            json = JSON.parse(request.responseText);
            likes.innerText = "Likes: " + json.image_likes + " Dislikes: " + json.image_dislikes;
        }
    };

    var src = (img.src.split("camagru/")[1]).replace("%20", " ");
    request.send(JSON.stringify({"img_src":src, "action":"like"}));
}

function DislikeImage()
{
    var img = document.getElementById("SelectedImageImg");
    var likes = document.getElementById("SelectedImageLikes");
    var request = new XMLHttpRequest();
    var url = "images/gallery.php";
    var json;

    request.open("POST", url, true);
    request.onreadystatechange = function ()
    {
        if (request.readyState == 4 && request.status == 200)
        {
            json = JSON.parse(request.responseText);
            likes.innerText = "Likes: " + json.image_likes + " Dislikes: " + json.image_dislikes;
        }
    };

    var src = (img.src.split("camagru/")[1]).replace("%20", " ");
    request.send(JSON.stringify({"img_src":src, "action":"dislike"}));
}

function HideSelectedImage()
{
    var div = document.getElementById("SelectedImageDiv");
    div.style.display = "none";
}