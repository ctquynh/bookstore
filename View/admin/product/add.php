<?php
include_once("./View/admin/layout/header.php");
include_once("./View/admin/layout/navbar.php");
include_once("./View/admin/layout/sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm sách</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Thêm sách</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Thông tin sách</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label>Tên sách</label>
                  <input type="text" class="form-control" name="title" placeholder="Nhập tên sách">
                </div>
                <div class="form-group">
                  <label>Tác giả</label>
                  <input type="text" class="form-control" name="author" placeholder="Nhập tên tác giả">
                </div>
                <div class="form-group">
                  <label>Thể loại</label> <br>
                  <?php foreach ($list_category as $category) :?>
                      <input type="checkbox" name="categoryid[]" value="<?php echo $category->id ?>">
                      <label><?php echo ($category->id . ' - ' . $category->name) ?></label><br>
                  <?php endforeach; ?>
                </div>
                <div class="form-group">
                  <label>Năm xuất bản</label>
                  <input type="text" class="form-control" name="year" placeholder="Nhập năm xuất bản">
                </div>
                <div class="form-group">
                  <label>Đơn giá</label>
                  <input type="text" class="form-control" name="unitprice" placeholder="Nhập đơn giá">
                </div>
                <div class="form-group">
                  <label>Số lượng</label>
                  <input type="text" class="form-control" name="quantity" placeholder="Nhập số lượng">
                </div>
                <div class="form-group">
                  <label>Mô tả</label>
                  <textarea class="form-control" name="des" placeholder="Nhập mô tả"></textarea>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button value="Save" name="action" class="btn btn-primary">Lưu</button>
                <a href="http://localhost:8080/bookstore/?controller=admin_account&action=list" 
                class="btnCancel btn btn-secondary" style="margin-left: 12px;"> Hủy </a>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once("./View/admin/layout/footer.php") ?>