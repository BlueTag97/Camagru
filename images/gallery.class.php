<?php

require_once ("image.class.php");

class gallery
{
    private $images;
    private $user_id;
    private $pdo;

    public function __construct($user_id, PDO $pdo)
    {
        $this->user_id = $user_id;
        $this->pdo = $pdo;
        if ($user_id != -1)
            $this->images = $this->GetImages();
        else
            $this->images = $this->GetAllImages();
    }

    private function GetImages()
    {
        $imgs = array();
        $statement = $this->pdo->prepare("
            SELECT image_tbl.*
            FROM image_tbl
            INNER JOIN (user_tbl INNER JOIN gallery_tbl ON user_tbl.user_id = gallery_tbl.user_id)
            ON image_tbl.image_id = gallery_tbl.image_id
            WHERE user_tbl.user_id = :usr_id;
        ");
        $statement->bindParam(":usr_id", $this->user_id);
        if ($statement->execute() == true)
        {
            $results = $statement->fetchAll();
            foreach ($results as $result)
            {
                array_push($imgs, new image(
                    $result["image_id"],
                    $result["image_name"],
                    $result["image_path"],
                    $result["image_public"],
                    $result["image_likes"],
                    $this->pdo
                ));
            }
        }
        return $imgs;
    }

    private function GetAllImages()
    {
        $imgs = array();
        $results = $this->pdo->query("SELECT * FROM image_tbl WHERE image_public = TRUE;")->fetchAll();
        foreach ($results as $result)
        {
            array_push($imgs, new image(
                $result["image_id"],
                $result["image_name"],
                $result["image_path"],
                $result["image_public"],
                $result["image_likes"],
                $this->pdo
            ));
        }
        return $imgs;
    }

    function __get($name)
    {
        if ($name == "user_id")
            return $this->user_id;
        else if ($name == "images")
            return $this->images;
        return null;
    }

    public function GetImageById($id)
    {
        foreach ($this->images as $image)
        {
            if ($image->__get("id") == $id)
                return $image;
        }
        return null;
    }

    public function GetImageByName($name)
    {
        $results = array();
        foreach ($this->images as $image)
        {
            if ($image->__get("name") == $name)
                array_push($results, $image);
        }
        return $results;
    }

    public function GetImageByPath($path)
    {
        foreach ($this->images as $image)
        {
            if ($image->__get("path") == $path)
                return $image;
        }
        return null;
    }

    public function AddImage($name, $path, $public)
    {
        $statement = $this->pdo->prepare("
            INSERT INTO image_tbl(image_name, image_path, image_public)
            VALUES (:img_name, :img_path, :img_public);
        ");
        $statement->bindParam(":img_name", $name);
        $statement->bindParam(":img_path", $path);
        $statement->bindParam(":img_public", $public);
        if ($statement->execute() == true)
        {
            $data = $this->pdo->query("
                SELECT image_id
                FROM image_tbl
                WHERE image_id = (SELECT MAX(image_id) FROM image_tbl);
            ")->fetch();
            array_push($this->images, new image($data["image_id"], $name, $path, $public, 0, $this->pdo));
            $statement = $this->pdo->prepare("
                INSERT INTO gallery_tbl(image_id, user_id)
                VALUES (:img_id, :usr_id);
            ");
            $statement->bindParam(":img_id", $data["image_id"]);
            $statement->bindParam(":usr_id", $this->user_id);
            if ($statement->execute() == true)
                return true;
            else
                return false;
        }
        else
            return false;
    }

    public function DeleteImage($id)
    {
        $statement = $this->pdo->prepare("
            DELETE
            FROM gallery_tbl
            WHERE image_id = :img_id AND user_id = :usr_id;
            DELETE
            FROM image_tbl
            WHERE image_id = :img_id;
        ");
        $statement->bindParam(":img_id", $id);
        $statement->bindParam(":usr_id", $this->user_id);
        if ($statement->execute() == true)
        {
            $count = 0;
            foreach ($this->images as $img)
            {
                if ($img->__get("id") == $id)
                    unset($this->images[$count]);
                $count++;
            }
            return true;
        }
        return false;
    }

    public function __toString()
    {
        $count = count($this->images);
        return "Gallery belonging to user with ID: $this->user_id. Contains $count images.";
    }

    public static function Doc()
    {
        return file_get_contents("gallery.class.txt");
    }
}

?>