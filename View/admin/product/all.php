<?php
include_once("./View/admin/layout/header.php");
include_once("./View/admin/layout/navbar.php");
include_once("./View/admin/layout/sidebar.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.edit.content-wrapper').hide();
        $('#Modal').on('show.bs.modal', function(event) {
            var a = $(event.relatedTarget)
            var id = a.data('bid')
            var title = a.data('title')
            $('.modal-body input#id').val(id)
            $('.modal-body input#title').val(title)
            $('.modal-body input#quan').val('')
        })

        $('.btnSaveImp').on('click', function() {
            if (!confirm("Are you sure to save this change"))
                return false;
            var _data = $('form.formImp').serialize();
            $.ajax({
                url: 'index.php?controller=admin_account&action=import',
                data: {
                    data: _data,
                },
                type: 'POST',
                dataType: 'json',
                success: function(imp) {
                    console.log(imp);
                    alert(imp.message);
                    location.reload();
                }
            });
        });

        
        $('.btnEdit').on('click', function() {
            $('.edit.content-wrapper').show();
            $('.all.content-wrapper').hide();
            var _bid = $(this).data('bid');
            $.ajax({
                url: 'index.php?controller=admin_account&action=edit',
                data: {
                    bookid: _bid
                },
                type: 'POST',
                success: function(edit) {
                    $('form.formEdit').html(edit);
                }
            });
        });

        $('.btnCancel').on('click', function() {
            $('.edit.content-wrapper').hide();
            $('.all.content-wrapper').show();
        });

        $('.btnUpdate').on('click', function() {
            if (!confirm("Are you sure to save this change"))
                return false;
            var _data = $('form.formEdit').serialize();
            $.ajax({
                url: 'index.php?controller=admin_account&action=update',
                data: {
                    data: _data,
                },
                type: 'POST',
                dataType: 'html',
                success: function(update) {
                    console.log(update);
                    var datajson = JSON.parse(update);
                    console.log(datajson);
                    alert(datajson.message);
                    location.reload();
                }
            });
        });

        $('.btnDelete').on('click', function() {
            if (!confirm("Are you sure to delete this row"))
                return false;

            var _bid = $(this).data('bid');
            var _currentRow = $(this).parent().parent();
            // console.log(_currentRow);
            $.ajax({
                url: 'index.php?controller=admin_account&action=delete',
                data: {
                    bookid: _bid
                },
                type: 'POST',
                dataType: 'html',
                success: function(deleteb) {
                    console.log(deleteb);
                    var datajson = JSON.parse(deleteb);
                    console.log(datajson);
                    if (datajson.check) {
                        $(_currentRow).remove();
                    } else {
                        alert(datajson.message);
                    }
                }
            });
        });

    });
</script>


<!-- All Book -->
<!-- Content Wrapper. Contains page content -->
<div class="all content-wrapper" style="min-height: 1299.69px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tất cả sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tất cả sách</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-size: 1.5rem">Danh mục</h3>
                            <div class="card-tools" style="display:flex; align-items: center">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div id="content">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 90px;">Mã sách</th>
                                            <th style="width: 560px;">Tên sách</th>
                                            <th>Tác giả</th>
                                            <th style="width: 140px;">Năm xuất bản</th>
                                            <th style="width: 100px">Mã loại</th>
                                            <th style="width: 120px;">Đơn giá</th>
                                            <th style="width: 100px;">Số lượng</th>
                                            <th style="width: 52px;"></th>
                                            <th style="width: 52px;"></th>
                                            <th style="width: 52px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($list_book as $book) {
                                            echo '<tr>
                                                    <td>' . $book->id . '</td>
                                                    <td>' . $book->title . '</td>
                                                    <td>' . $book->author . '</td>
                                                    <td>' . $book->release_date . '</td>
                                                    <td>' . $book->cateid . '</td>
                                                    <td>' . $book->unit_price . '</td>
                                                    <td>' . $book->quantity_in_stock . '</td>
                                                    <td>
                                                        <a href="#" class="btnImp btn btn-primary" data-toggle="modal" data-target="#Modal"
                                                        data-bid="' . $book->id . '" data-title="' . $book->title . '" style="height: 28px; padding: 0 12px">
                                                            Nhập
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btnEdit btn btn-warning" data-bid="' . $book->id . '" style="height: 28px; padding: 0 12px">
                                                            Sửa
                                                        </a>
                                                    </td>
                                                    <td style="padding-right: 0.75rem;">
                                                        <a href="#" class="btnDelete btn btn-danger" data-bid="' . $book->id . '" style="height: 28px; padding: 0 12px">
                                                            Xóa
                                                        </a>
                                                    </td>
                                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel" style="font-weight: 550;">Nhập sách</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="formImp" style="font-size: 18px;">
                                        <div class="form-group row">
                                            <div class="col-3" style="padding: 6px 8px;">Mã sách:</div>
                                            <input type="text" class="form-control col-9" name="id" id="id" style="border:hidden; font-size: 18px" readonly>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-3" style="padding: 6px 8px;">Tên sách:</div>
                                            <input type="text" class="form-control col-9" name="title" id="title" style="border:hidden; font-size: 18px" readonly>
                                        </div>
                                        <div class="form-group">
                                            <p>Số lượng nhập:</p>
                                            <input type="text" class="form-control" name="quantity" id="quan">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btnSaveImp btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.Modal -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- /.All Book -->


<!-- Edit Book -->
<!-- Content Wrapper. Contains page content -->
<div class="edit content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật thông tin sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Cập nhật sách</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- column -->
                <div class="col">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin sách</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="edit card-body">
                            <form class="formEdit"></form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btnUpdate btn btn-success">Cập nhật</button>
                            <button type="submit" class="btnCancel btn btn-primary" style="margin-left: 12px">Hủy</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col  -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- /.Edit Book -->



<?php include_once("./View/admin/layout/footer.php") ?>