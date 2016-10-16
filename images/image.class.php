<?php

class image
{
    private $path;
    private $name;
    private $likes;
    private $id;
    private $pdo;

    public function __construct($id, $name, $path, $likes, PDO $pdo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->likes = $likes;
        $this->pdo = $pdo;
    }

    public function __get($name)
    {
        if ($name == "id")
            return $this->id;
        else if ($name == "name")
            return $this->name;
        else if ($name == "path")
            return $this->path;
        else if ($name == "likes")
            return $this->likes;
        else
            return null;
    }

    public function __set($name, $value)
    {
        if ($name == "name")
        {
            $statement = $this->pdo->prepare("
                UPDATE image_tbl
                SET image_name = :img_name
                WHERE image_id = :img_id;
            ");
            $statement->bindParam(":img_name", $value);
            $statement->bindParam(":img_id", $this->id);
            if ($statement->execute() == true)
            {
                $this->name = $value;
                return true;
            }
            else
                return false;
        }
        else if ($name == "path")
        {
            $statement = $this->pdo->prepare("
                UPDATE image_tbl
                SET image_path = :img_path
                WHERE image_id = :img_id;
            ");
            $statement->bindParam(":img_path", $value);
            $statement->bindParam(":img_id", $this->id);
            if ($statement->execute() == true)
            {
                $this->path = $value;
                return true;
            }
            else
                return false;
        }
        else if ($name == "likes")
        {
            $statement = $this->pdo->prepare("
                UPDATE image_tbl
                SET image_likes = :img_likes
                WHERE image_id = :img_id;
            ");
            $statement->bindParam(":img_likes", $value);
            $statement->bindParam(":img_id", $this->id);
            if ($statement->execute() == true)
            {
                $this->likes = $value;
                return true;
            }
            else
                return false;
        }
        else
            return null;
    }

    public function __toString()
    {
        return $this->path;
    }

    public static function Doc()
    {
        return file_get_contents("image.class.txt");
    }
}

?>