<?php
require_once("./Model/category_model.php");
class category
{
    private $category_model;
    function __construct()
    {
        $this->category_model = new category_model();
    }

    function run() {
        $actionGet = filter_input(INPUT_GET, 'action');

        if (method_exists($this, $actionGet)) {
            $this->$actionGet();
        }
        else {
            $this->list();
        }
    }

    function list()
    {
        $list_cate = $this->category_model->listCate();
        include("View/admin/category/all.php");
    }

    function add() {
        $actionPost = filter_input(INPUT_POST, 'action');
        if ($actionPost == 'Save') {
            $name = filter_input(INPUT_POST, 'name');
            $des = filter_input(INPUT_POST, 'des');
            $cate = new Entity();
            $cate->name = $name;
            $cate->des = $des;
            $check_add = $this->category_model->insertCate($cate);
            if (!$check_add) {
                print 'error';
            }
            else {
                print 'success';
                header('Location: http://localhost:8080/bookstore/?controller=category&action=list');
            }
        }
        require_once("./View/admin/category/add.php");
    }
    
    function delete() {
        $id = filter_input(INPUT_POST, 'categoryid');
        $deleteCategory = $this->category_model->deleteCate($id);
        if ($deleteCategory) {
            print json_encode(array('check'=>true,'message'=>"Delete successfully!"));
        }
        else {
            print json_encode(array('check'=>false,'message'=>"Delete NOT successfully! Error"));
        }
    }

    function catebook() {
        $list_cb = $this->category_model->listCb();
        require_once("./View/admin/category/cate_book.php");
    }
}
?>