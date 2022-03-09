<?php
    require_once("db/db.php");
    require_once("entity.php");
    class category_model extends DB{
        public function listCate() {
            $sql = "SELECT * FROM category";
            $result = DB::execute($sql);
            $cate_info = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->id = $row['id'];
                $data->name = $row['name'];
                $data->des= $row['description'];
                $cate_info[] = $data;
            }
            return $cate_info;
        }

        public function insertCate($cate) {
            $sql = "INSERT INTO category (id, name, description) VALUES (NULL, '{$cate->name}', '{$cate->des}') ";
            $results = DB::execute($sql);
            return $results;
        }
        
        public function deleteCate($id) {
            $sql = "DELETE FROM category WHERE id = $id";
            $result = DB::execute($sql);
            return $result;
        }

        public function addCb($bookid, $cateid) {
            $sql = "INSERT INTO category_book (id, book_id, category_id) 
                VALUES (NULL, '{$bookid}', '{$cateid}') ";
            $result = DB::execute($sql);
            return $result;
        }

        public function listCb() {
            $sql = "SELECT cb.book_id, b.title, cb.category_id, c.name
                FROM book b JOIN category_book cb ON b.id = cb.book_id
                JOIN category c ON cb.category_id = c.id ORDER BY book_id ASC";
            $result = DB::execute($sql);
            $listcb = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->bookid = $row['book_id'];
                $data->booktitle = $row['title'];
                $data->cateid = $row['category_id'];
                $data->catename = $row['name'];
                $listcb[] = $data;
            }
            return $listcb;
        }

        public function deleteCb($bookid) {
            $sql = "DELETE FROM category_book WHERE book_id = $bookid";
            $result = DB::execute($sql);
            return $result;
        }

        public function checkCb() {
            $sql = "SELECT * FROM category_book";
            $result = DB::execute($sql);
            $checkcb = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->bookid = $row['book_id'];
                $data->cateid = $row['category_id'];
                $checkcb[] = $data;
            }
            return $checkcb;
        }
    }
?>
