<?php
require_once("db/db.php");
require_once("entity.php");
class admin_account_model extends DB
{
    public function login($name, $pass)
    {
        $sql = "SELECT * FROM user WHERE name = '$name' AND password = '$pass'";
        $result = DB::execute($sql);
        $acc_info = array();
        while ($row = mysqli_fetch_array($result)) {
            $data = new Entity();
            $data->name = $row['name'];
            $data->pass = $row['password'];
            $data->level = $row['level'];
            $acc_info[] = $data;
        }
        return $acc_info;
    }

    public function list() {
        $sql = "SELECT * FROM book";
        $result = DB::execute($sql);
        $arry_info = array();
        while ($row = mysqli_fetch_array($result)) {
            $data = new Entity();
            $data->id = $row['id'];
            $data->title = $row['title'];
            $data->author = $row['author'];
            $data->release_date = $row['release_date'];
            $data->unit_price = $row['unit_price'];
            $data->quantity_in_stock = $row['quantity_in_stock'];
            $data->des = $row['description'];
            $data->cateid = $row['category_id'];
            $arry_info[] = $data;
        }
        return $arry_info;
    }

    public function bookInfo($id) {
        $sql = "SELECT * FROM book WHERE id = $id";
        $result = DB::execute($sql);
        $arry_info = array();
        while ($row = mysqli_fetch_array($result)) {
            $data = new Entity();
            $data->id = $row['id'];
            $data->title = $row['title'];
            $data->author = $row['author'];
            $data->release_date = $row['release_date'];
            $data->unit_price = $row['unit_price'];
            $data->quantity_in_stock = $row['quantity_in_stock'];
            $data->des = $row['description'];
            $data->cateid = $row['category_id'];
            $arry_info[] = $data;
        }
        return $arry_info;
    }

    public function insertBook($book)
    {
        $sql = "INSERT INTO book (id, title, author, release_date, unit_price, quantity_in_stock, description, category_id) 
            VALUES (NULL, '{$book->title}', '{$book->author}', '{$book->year}', '{$book->price}', '{$book->quantity}', '{$book->des}', '{$book->categoryid}') ";
        $results = DB::execute($sql);
        return $results;
    }

    public function editBook($book)
    {
        $sql = "UPDATE book SET unit_price = '{$book->price}', quantity_in_stock = '{$book->quantity}', description = '{$book->des}', category_id = '{$book->cateid}'
            WHERE id = {$book->id} ";
        $result = DB::execute($sql);
        return $result;
    }

    public function impBook($book) {
        $sql = "UPDATE book SET quantity_in_stock = '{$book->quantity}' WHERE id = {$book->id} ";
        $result = DB::execute($sql);
        return $result;
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM book WHERE id = $id";
        $result = DB::execute($sql);
        return $result;
    }
}
?>
