<?php

require_once("model/DB.php");

class User extends DB
{
    // ログイン
    public function login($arr)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":email" => $arr['email'],
            ":password" => $arr['password']
        ];
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result;
    }

    // アカウント作成
    public function createAccount($arr)
    {
        $sql = "INSERT INTO users(name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":name" => $arr['name'],
            ":email" => $arr['email'],
            ":password" => $arr['password'],
            ":role" => 0,
        ];
        $stmt->execute($params);
    }

    // アイコン変更
    public function editIcon($arr)
    {
        $sql = "INSERT INTO users(user_icon) VALUES (:user_icon)";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":user_icon" => $arr["user_icon"]
        ];
        $stmt->execute($params);
    }

    // カテゴリー追加
    public function addCategory($arr)
    {
        $sql = "INSERT INTO categorys(category, user_id) VALUES (:category, :user_id)";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":category" => $arr['category'],
            ":user_id" => $arr['user_id'],
        ];
        $stmt->execute($params);
    }

    // ムービー追加
    public function addMovie($arr)
    {
        $sql = "INSERT INTO movies(title, link, category_id) VALUES (:title, :link, :category_id)";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":title" => $arr['title'],
            ":link" => $arr['link'],
            ":category_id" => $arr['category_id']
        ];
        $stmt->execute($params);
    }

    // カテゴリー参照
    public function findCategoryById($arr)
    {
        $sql = "SELECT * FROM categorys WHERE user_id = :user_id";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":user_id" => $arr["user_id"]
        ];
        $stmt->execute($params);
        $category = $stmt->fetchAll();
        return $category;
    }

    // ムービー参照
    public function findMovieByCategoryId($arr)
    {
        $sql = "SELECT * FROM movies WHERE category_id = :category_id";
        $stmt = $this->dbh->prepare($sql);
        $params = [
            ":category_id" => $arr["category_id"],
        ];
        $stmt->execute($params);
        $movie = $stmt->fetchAll();
        return $movie;
    }
}
