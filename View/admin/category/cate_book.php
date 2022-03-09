<?php
include_once("./View/admin/layout/header.php");
include_once("./View/admin/layout/navbar.php");
include_once("./View/admin/layout/sidebar.php");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 1299.69px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thể loại - Sách</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Thể loại - Sách</li>
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
                                        <th>Mã sách</th>
                                        <th>Tên sách</th>
                                        <th>Mã loại</th>
                                        <th>Tên loại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list_cb as $cb) {
                                        echo '<tr>
                                                <td>' . $cb->bookid . '</td>
                                                <td>' . $cb->booktitle . '</td>
                                                <td>' . $cb->cateid . '</td>
                                                <td>' . $cb->catename . '</td>
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