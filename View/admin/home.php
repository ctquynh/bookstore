<?php
include_once("layout/header.php");
include_once("layout/navbar.php");
include_once("layout/sidebar.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('.btnShowOrd').on('click', function() {
      var _oid = $(this).data('oid');
      $.ajax({
        url: 'http://localhost:8080/bookstore/index.php/?controller=admin_home&action=order',
        data: {
          orderid: _oid
        },
        type: 'POST',
        dataType: 'json',
        success: function(order) {
          console.log(order);
          if (order.check)
            $('div.modal-body.orderinfo').html(order.message);
          else
            alert(order.message);
        }
      });
    });
    $('.btnEditAcc').on('click', function() {
      var _aid = $(this).data('aid');
      $.ajax({
        url: 'http://localhost:8080/bookstore/index.php/?controller=admin_home&action=account',
        data: {
          accid: _aid
        },
        type: 'POST',
        dataType: 'json',
        success: function(account) {
          console.log(account);
          if (account.check)
            $('form.formAcc').html(account.message);
          else
            alert(account.message);
        }
      });
    });

    $('.btnSaveAcc').on('click', function() {
      if (!confirm("Are you sure to save this change"))
        return false;
      var _data = $('form.formAcc').serialize();
      $.ajax({
        url: 'http://localhost:8080/bookstore/index.php/?controller=admin_home&action=saveacc',
        data: {
          data: _data,
        },
        type: 'POST',
        dataType: 'html',
        success: function(edit) {
          console.log(edit);
          var datajson = JSON.parse(edit);
          console.log(datajson);
          alert(datajson.message);
          location.reload();
        }
      });
    });
  });
</script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Trang chủ</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Trang chủ</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Books</span>
              <span class="info-box-number"><?php echo $book; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">41,410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number"><?php echo $sale ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">New Members</span>
              <span class="info-box-number"><?php echo $mem ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title" style="font-size: 1.4rem;">Đơn hàng</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>Mã đơn hàng</th>
                      <th>Mã khách hàng</th>
                      <th>Ngày đặt</th>
                      <th>Địa chỉ giao</th>
                      <th>Ghi chú</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <form action="" method="post">
                      <?php
                      foreach ($list_ord as $ord) {
                        echo
                        '<tr>
                        <td>' . $ord->id . '</td>
                        <td>' . $ord->userid . '</td>
                        <td>' . $ord->ord_date . '</td>
                        <td>' . $ord->ship_add . '</td>
                        <td>' . $ord->note . '</td>
                        <td style="width: 60px">
                          <a href="#" class="btnShowOrd btn btn-info" data-toggle="modal" data-target="#ModalScrollable" data-oid="' . $ord->id . '" style="height: 30px; padding: 0 12px"> Xem </a>
                        </td>
                      </tr>';
                      }
                      ?>
                    </form>

                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="modal fade" id="ModalScrollable" tabindex="-1" role="dialog" aria-labelledby="ModalScrollableTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 750px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="ModalScrollableTitle" style="font-weight: 550;">Hóa đơn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body orderinfo">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /.Modal -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title" style="font-size: 1.4rem;">Tài khoản</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tên</th>
                      <th>Điện thoại</th>
                      <th>Email</th>
                      <th>Level</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <form action="" method="post">
                      <?php
                      foreach ($list_acc as $acc) {
                        echo '<tr>
                              <td>' . $acc->id . '</td>
                              <td>' . $acc->name . '</td>
                              <td>' . $acc->phonenum . '</td>
                              <td>' . $acc->email . '</td>
                              <td>' . $acc->level . '</td>
                              <td style="width: 60px">
                                <a href="#" class="btnEditAcc btn btn-warning" data-toggle="modal" data-target="#Modal" 
                                data-aid="' . $acc->id . '" style="height: 28px; padding: 0 12px"> Sửa </a>
                              </td>
                          </tr>';
                      }
                      ?>
                    </form>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="font-weight: 550;">Thông tin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="formAcc" style="margin: 0 16px; font-size: 18px;"></form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btnSaveAcc btn btn-primary">Lưu</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.Modal -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!--/. container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->



<?php include_once("layout/footer.php") ?>