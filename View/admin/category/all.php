<?php
include_once("./View/admin/layout/header.php");
include_once("./View/admin/layout/navbar.php");
include_once("./View/admin/layout/sidebar.php");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btnDelete').on('click', function() {
            if (!confirm("Are you sure to delete this row"))
                return false;

            var _cid = $(this).data('cid');
            var _currentRow = $(this).parent().parent();
            // console.log(_currentRow);
            $.ajax({
                url: 'index.php?controller=category&action=delete',
                data: {
                    categoryid: _cid
                },
                type: 'POST',
                dataType: 'html',
                success: function(deletec) {
                    console.log(deletec);
                    var datajson = JSON.parse(deletec);
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 1299.69px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tất cả thể loại</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tất cả thể loại</li>
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

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã loại</th>
                                        <th>Tên loại</th>
                                        <th>Mô tả</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list_cate as $cate) {
                                        echo '<tr>
                                                <td style="width: 78px">' . $cate->id . '</td>
                                                <td style="width: 250px">' . $cate->name . '</td>
                                                <td> <p>' . $cate->des . '</p> </td>
                                                <td style="padding-right: 0.75rem;">
                                                    <a href="#" class="btnDelete btn btn-danger" data-cid="' . $cate->id . '" style="height: 28px; padding: 0 12px">
                                                        Xóa
                                                    </a>
                                                </td>
                                            </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once("./View/admin/layout/footer.php") ?>