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
    foreach ($gallery->__get("images") as $image)
    {
        if ($count == 6)
        {
            $html_mid .= "</tr><tr>";
            $count = 1;
        }
        $id = $image->__get("id");
        $html_mid .= "
            <td>
                <img src='$image' class='NonSelectedImage' id='Img_$id' onclick='ShowSelectedImage.call(this)'/>
            </td>
        ";
        $count++;
    }
    $html_mid .= "</tr>";
    $table = $html_begin.$html_mid.$html_end."\n";
    $div = "
        <div class='SelectedImage' id='SelectedImageDiv'>
            <img src='' id='SelectedImageImg'>
            <label id='SelectedImageLabel'></label>
            <label id='SelectedImageLikes'>likes</label>
            <button id='SelectedImageUpVote' onclick='LikeImage()'>like</button>
            <button id='SelectedImageDownVote' onclick='DislikeImage()'>dislike</button>
            <ul id='SelectedImageComments'></ul>
            <form id='SelectedImageCommentForm'>
                <textarea name='NewComment' ></textarea><br/>
                <input type='submit' name='add_comment' value='Add comment'>
            </form>
            <button id='SelectedImageClose' onclick='HideSelectedImage()'>close</button>
        </div>
    ";
    echo $table.$div;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    require_once("../config/database.php");
    require_once("../config/database_connect.class.php");

    $data = json_decode(stripslashes(file_get_contents("php://input")), true);
    $pdo = database_connect::GetInstance()->GetPDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->query("USE $DB_NAME;");
    if ($data["action"] == "selected")
    {
        $statement = $pdo->prepare("
            SELECT * FROM image_tbl WHERE image_id = :img_id;
        ");
        $id = intval((explode('_', $data["image_id"])[1]));
        $statement->bindParam(":img_id", $id);
        $statement->execute();
        echo json_encode($statement->fetch());
    }
    else if ($data["action"] == "like")
    {
        $statement = $pdo->prepare("
            UPDATE image_tbl SET image_likes = image_likes + 1 WHERE image_path = :path;
        ");
        $statement->bindParam(":path", $data["img_src"]);
        $statement->execute();
        $statement = $pdo->prepare("
            SELECT image_likes, image_dislikes FROM image_tbl WHERE image_path = :path;
        ");
        $statement->bindParam(":path", $data["img_src"]);
        $statement->execute();
        echo json_encode($statement->fetch());
    }
    else if ($data["action"] == "dislike")
    {
        $statement = $pdo->prepare("
            UPDATE image_tbl SET image_dislikes = image_dislikes + 1 WHERE image_path = :path;
        ");
        $statement->bindParam(":path", $data["img_src"]);
        $statement->execute();
        $statement = $pdo->prepare("
            SELECT image_likes, image_dislikes FROM image_tbl WHERE image_path = :path;
        ");
        $statement->bindParam(":path", $data["img_src"]);
        $statement->execute();
        echo json_encode($statement->fetch());
    }
}

?>