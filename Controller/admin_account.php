<?php
require_once("./Model/admin_account_model.php");
require_once("./Model/category_model.php");
class admin_account
{
    private $admin_account_model;
    private $category_model;
    function __construct()
    {
        $this->admin_account_model = new admin_account_model();
        $this->category_model = new category_model();
    }

    function run()
    {
        $actionGet = filter_input(INPUT_GET, 'action');

        if (method_exists($this, $actionGet)) {
            $this->$actionGet();
        } else {
            $this->list();
        }
    }

    function login()
    {
        $actionPost = filter_input(INPUT_POST, 'action');
        if ($actionPost == 'signin') {
            $name = filter_input(INPUT_POST, 'username');
            $pass = filter_input(INPUT_POST, 'password');
            $acc = new Entity();
            $acc->name = $name;
            $acc->pass = $pass;
            $check_acc = $this->admin_account_model->login($name, $pass);
            foreach ($check_acc as $info) {
                if ($acc->name == $info->name && $acc->pass == $info->pass && $info->level == 1) {
                    header('Location: http://localhost:8080/bookstore/?controller=admin_home&action=list');
                } else {
                    echo "Vui lòng đăng nhập lại";
                }
            }
        }
        require_once("./View/admin/admin_acc.php");
    }

    function list()
    {
        $list_book = $this->admin_account_model->list();
        include("./View/admin/product/all.php");
    }

    function add()
    {
        $list_category = $this->category_model->listCate();
        $actionPost = filter_input(INPUT_POST, 'action');
        if ($actionPost == 'Save') {
            $title = filter_input(INPUT_POST, 'title');
            $author = filter_input(INPUT_POST, 'author');
            $year = filter_input(INPUT_POST, 'year');
            $price = filter_input(INPUT_POST, 'unitprice');
            $categoryid = implode(",", $_POST['categoryid']);
            $quantity = filter_input(INPUT_POST, 'quantity');
            $des = filter_input(INPUT_POST, 'des');
            $book = new Entity();
            $book->title = $title;
            $book->author = $author;
            $book->year = $year;
            $book->price = $price;
            $book->quantity = $quantity;
            $book->des = $des;
            $book->categoryid = $categoryid;
            $check_add = $this->admin_account_model->insertBook($book);
            $list_book = $this->admin_account_model->list();
            foreach ($list_book as $item) {
                if ($item->title == $title) {
                    $bid = $item->id;
                    $cid = explode(",", $item->cateid);
                    foreach ($cid as $value) {
                        $add_cb = $this->category_model->addCb($bid, $value);
                    }
                }
            }
            if (!$check_add) {
                print 'error';
            } else {
                print 'success';
                header('Location: http://localhost:8080/bookstore/?controller=admin_account&action=list');
            }
        }
        require_once("./View/admin/product/add.php");
    }

    function edit()
    {
        $id = filter_input(INPUT_POST, 'bookid');
        $info_book = $this->admin_account_model->bookInfo($id);
        $list_category = $this->category_model->listCate();

        foreach ($info_book as $info) {

            $id = $info->id;
            $title = $info->title;
            $author = $info->author;
            $date = $info->release_date;
            $price = $info->unit_price;
            $quantity = $info->quantity_in_stock;
            $des = $info->des;
            $cid = explode(",", $info->cateid);
?>
            <div class="form-group">
                <label>Mã sách</label>
                <input type="text" class="form-control" name="id" placeholder="Nhập mã sách" value="<?php echo $id ?>" readonly>
            </div>
            <div class="form-group">
                <label>Tên sách</label>
                <input type="text" class="form-control" name="title" placeholder="Nhập tên sách" value="<?php echo $title ?>" readonly>
            </div>
            <div class="form-group">
                <label>Tác giả</label>
                <input type="text" class="form-control" name="author" placeholder="Nhập tên tác giả" value="<?php echo $author ?>" readonly>
            </div>
            <div class="form-group">
                <label>Thể loại</label><br>
                <?php foreach ($list_category as $category) :
                    if (in_array($category->id, $cid)) : ?>
                        <input type="checkbox" checked="checked" name="categoryid[]" value="<?php echo $category->id ?>">
                        <label><?php echo ($category->id . ' - ' . $category->name) ?></label><br>
                    <?php else : ?>
                        <input type="checkbox" name="categoryid[]" value="<?php echo $category->id ?>">
                        <label><?php echo ($category->id . ' - ' . $category->name) ?></label><br>
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Năm xuất bản</label>
                <input type="text" class="form-control" name="year" placeholder="Nhập năm xuất bản" value="<?php echo $date ?>" readonly>
            </div>
            <div class="form-group">
                <label>Đơn giá</label>
                <input type="text" class="form-control" name="unitprice" placeholder="Nhập đơn giá" value="<?php echo $price ?>">
            </div>
            <div class="form-group">
                <label>Số lượng</label>
                <input type="text" class="form-control" name="quantity" placeholder="Nhập số lượng" value="<?php echo $quantity ?>">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" name="des" placeholder="Nhập mô tả" value="<?php echo $des ?>"><?php echo $des ?></textarea>
            </div>
        <?php
        }
    }

    function update()
    {
        $bdata = filter_input(INPUT_POST, "data");
        parse_str($bdata, $bdata_arr);
        $id = $bdata_arr['id'];
        $quantity = $bdata_arr['quantity'];
        $price = $bdata_arr['unitprice'];
        $cate_id = implode(",", $bdata_arr['categoryid']);
        $des = $bdata_arr['des'];
        $book = new Entity();
        $book->id = $id;
        $book->price = $price;
        $book->cateid = $cate_id;
        $book->des = $des;
        $book->quantity = $quantity;
        $check_up = $this->admin_account_model->editBook($book);
        $category = $this->category_model->checkCb();
        if (empty($category)) {
            $cid = explode(",", $cate_id);
            foreach ($cid as $value) {
                $this->category_model->addCb($id, $value);
            }
        } elseif (!empty($category)) {
            $dem = 0;
            foreach ($category as $cb) {
                if ($cb->bookid != $id) {
                    $dem++;
                    continue;
                } elseif ($cb->bookid == $id) {
                    $this->category_model->deleteCb($id);
                    $cid = explode(",", $cate_id);
                    foreach ($cid as $value) {
                        $this->category_model->addCb($id, $value);
                    }
                    $dem = 0;
                    break;
                }
            }
            if ($dem != 0) {
                $cid = explode(",", $cate_id);
                foreach ($cid as $value) {
                    $this->category_model->addCb($id, $value);
                }
            }
        }

        if ($check_up) {
            print json_encode(array('check' => true, 'message' => "Update successfully!"));
        } else {
            print json_encode(array('check' => false, 'message' => "Update NOT successfully! Error"));
        }
    }

    function import()
    {
        $impdata = filter_input(INPUT_POST, 'data');
        parse_str($impdata, $impdata_arr);
        $bid = $impdata_arr['id'];
        $quantity_imp = $impdata_arr['quantity'];
        $book = new Entity();
        $book->id = $bid;
        $info_book = $this->admin_account_model->bookInfo($bid);
        foreach ($info_book as $books) {
            $book->quantity = (int)$books->quantity_in_stock + (int)$quantity_imp;
        }
        $import = $this->admin_account_model->impBook($book);
        if ($import) {
            print json_encode(array('check' => true, 'message' => "Import successfully!"));
        } else {
            print json_encode(array('check' => false, 'message' => "Import NOT successfully! Error"));
        }
    }

    function delete()
    {
        $id = filter_input(INPUT_POST, 'bookid');
        $deleteBook = $this->admin_account_model->deleteBook($id);
        if ($deleteBook) {
            print json_encode(array('check' => true, 'message' => "Delete successfully!"));
        } else {
            print json_encode(array('check' => false, 'message' => "Delete NOT successfully! Error"));
        }
    }
}
?>