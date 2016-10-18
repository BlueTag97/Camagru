<?php

require_once("image.class.php");
require_once("gallery.class.php");

function CreateGallery($user_id, $pdo)
{
    $gallery = new gallery($user_id, $pdo);
    $html_begin = "<table class='GalleryTable'><tbody>";
    $html_end = "</tbody></table>";
    $html_mid = "<tr>";
    $count = 1;
    $id = 0;
    foreach ($gallery->__get("images") as $image)
    {
        if ($count == 6)
        {
            $html_mid .= "</tr><tr>";
            $count = 1;
        }
        $html_mid .= "
            <td>
                <img src='$image' class='NonSelectedImage' id='Img_$id' onclick='ShowSelectedImage.call(this)'/>
            </td>
        ";
        $count++;
        $id++;
    }
    $html_mid .= "</tr>";
    $table = $html_begin.$html_mid.$html_end."\n";
    $div = "
        <div class='SelectedImage' id='SelectedImageDiv'>
            <img src='' id='SelectedImageImg'>
            <label id='SelectedImageLabel'></label>
            <label id='SelectedImageLikes'>likes</label>
            <button onclick='HideSelectedImage()'>close</button>
        </div>
    ";
    echo $table.$div;
}

?>