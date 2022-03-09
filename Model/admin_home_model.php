<?php
    require_once("db/db.php");
    require_once("entity.php");
    class admin_home_model extends DB{
        public function listAcc() {
            $sql = "SELECT * FROM user";
            $result = DB::execute($sql);
            $user_info = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->id = $row['id'];
                $data->name = $row['name'];
                $data->pass= $row['password'];
                $data->phonenum = $row['phone'];
                $data->email = $row['email'];
                $data->level = $row['level'];
                $user_info[] = $data;
            }
            return $user_info;
        }

        public function listOrd() {
            $sql = "SELECT * FROM orders ";
            $result = DB::execute($sql);
            $ord_info = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->id = $row['id'];
                $data->userid = $row['user_id'];
                $data->ord_date= $row['order_date'];
                $data->ship_add = $row['ship_address'];
                $data->note = $row['note'];
                $ord_info[] = $data;
            }
            return $ord_info;
        }

        public function ordItem($oid) {
            $sql = "SELECT *
            FROM orders o JOIN order_detail od ON o.id = od.order_id
            JOIN book b ON od.book_id = b.id
            AND od.order_id = $oid";
            $result = DB::execute($sql);
            $ord_detail = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->ordid = $row['order_id'];
                $data->uid = $row['user_id'];
                $data->odate = $row['order_date'];
                $data->shipadd= $row['ship_address'];
                $data->bid= $row['book_id'];
                $data->btitle= $row['title'];
                $data->author= $row['author'];
                $data->price = $row['unit_price'];
                $data->quantity = $row['quantity'];
                $data->note = $row['note'];
                $ord_detail[] = $data;
            }
            return $ord_detail;
        }

        public function accUser($aid) {
            $sql = "SELECT * FROM user WHERE id = $aid";
            $result = DB::execute($sql);
            $account = array();
            while($row = mysqli_fetch_array($result)) {
                $data = new Entity();
                $data->id = $row['id'];
                $data->aname = $row['name'];
                $data->phone = $row['phone'];
                $data->email = $row['email'];
                $data->level = $row['level'];
                $account[] = $data;
            }
            return $account;
        }
        
        function editLv($id, $lv) {
            $sql = "UPDATE user SET level = $lv WHERE id = $id ";
            $result = DB::execute($sql);
            return $result;
        }
    }
