<?php
require_once("./Model/admin_home_model.php");
require_once("./Model/admin_account_model.php");
class admin_home
{
    private $admin_home_model;
    private $admin_account_model;
    function __construct()
    {
        $this->admin_home_model = new admin_home_model();
        $this->admin_account_model = new admin_account_model();
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

    function list()
    {
        $list_acc = $this->admin_home_model->listAcc();
        $list_ord = $this->admin_home_model->listOrd();
        $book = count($this->admin_account_model->list());
        $sale = count($list_acc);
        $mem = count($list_ord);
        include("View/admin/home.php");
    }

    function order()
    {
        $oid = filter_input(INPUT_POST, 'orderid');
        $order = $this->admin_home_model->ordItem($oid);
        if (!$order) {
            print json_encode(array('check' => false, 'message' => 'Lỗi câu lệnh truy vấn'));
        } else {
            $html = '<p style="margin-left: 16px; font-size: 18px;"> Mã đơn hàng : ' . $oid . '<br> Mã khách hàng : ' . $order[0]->uid . '
            <br> Địa chỉ : ' . $order[0]->shipadd . '<br> Ngày : ' . $order[0]->odate . '</p>';
            if ($order[0]->note) {
                $html .= '<p style="text-align: end;">* Ghi chú : '.$order[0]->note.'</p>';
            }
            $html .= '<table class="table table-bordered">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="width: 40px;">TT</th>';
            $html .= '<th>Tên sách</th>';
            $html .= '<th style="width: 40px;">SL</th>';
            $html .= '<th style="width: 80px;">Đơn Giá</th>';
            $html .= '<th style="width: 105px;">Thành Tiền</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            $stt = 0;
            $total = 0;
            $quan = 0;
            foreach ($order as $ord) {
                $sum = $ord->quantity * $ord->price;
                $stt++;
                $total = $total + ($ord->price * $ord->quantity);
                $quan = $quan + $ord->quantity;
                $html .= '<tr>';
                $html .= '<td>' . $stt . '</td>';
                $html .= '<td>' . $ord->btitle . '</td>';
                $html .= '<td>' . $ord->quantity . '</td>';
                $html .= '<td>' . $ord->price . '</td>';
                $html .= '<td>' . $sum . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<div class="row"> <div class="col-md-3 ml-md-auto" style="font-size: 18px;"> Tổng SL : ' . $quan . '</div> </div>';
            $html .= '<div class="row"> <div class="col-md-3 ml-md-auto" style="font-size: 18px;"> Tổng tiền : ' . $total . '</div> </div>';
            print json_encode(array('check' => true, 'message' => $html));
        }
    }

    function account()
    {
        $aid = filter_input(INPUT_POST, 'accid');
        $acc = $this->admin_home_model->accUser($aid);
        if (!$acc) {
            print json_encode(array('check' => false, 'message' => 'Lỗi câu lệnh truy vấn'));
        } else {
            foreach ($acc as $a) {
                $html = '<div class="form-group row">';
                $html .= '<p class="col-sm-4">ID</p>';
                $html .= '<input readonly class="col-sm-8 form-control-plaintext" name="id" 
                style="color: white; font-size: 18px; padding: 0 7.5px; margin-bottom: 16px" value="' . $a->id . '">';
                $html .= '</div>';
                $html .= '<div class="form-group row">';
                $html .= '<p class="col-sm-4">Tên tài khoản</p>';
                $html .= '<p class="col-sm-8">' . $a->aname . '</p>';
                $html .= '</div>';
                $html .= '<div class="form-group row">';
                $html .= '<p class="col-sm-4">Số điện thoại</p>';
                $html .= '<p class="col-sm-8">' . $a->phone . '</p>';
                $html .= '</div>';
                $html .= '<div class="form-group row">';
                $html .= '<p class="col-sm-4">Email</p>';
                $html .= '<p class="col-sm-8">' . $a->email . '</p>';
                $html .= '</div>';
                $html .= '<div class="form-group row">';
                $html .= '<p class="col-sm-4">Level</p>';
                $html .= '<input class="col-sm-8 form-control" name="level" value="' . $a->level . '">';
                $html .= '</div>';
            }
            print json_encode(array('check' => true, 'message' => $html));
        }
    }

    function saveacc()
    {
        $adata = filter_input(INPUT_POST, "data");
        parse_str($adata, $adata_arr);
        $aid = $adata_arr['id'];
        $alv = $adata_arr['level'];
        $acc = $this->admin_home_model->editLv($aid, $alv);
        if ($acc) {
            print json_encode(array('check'=>true,'message'=>"Save successfully!"));
        }
        else {
            print json_encode(array('check'=>false,'message'=>"Save NOT successfully! Error"));
        }
    }
}
