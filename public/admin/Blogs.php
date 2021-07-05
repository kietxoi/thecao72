<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'TIN TỨC | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php
if(isset($_POST['btnCreate']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $title = check_string($_POST['title']);
    $content = $_POST['content'];
    $display = check_string($_POST['display']);
    $random_code = rand(0,1000);
    if(check_img('img') == true)
    {
        $uploads_dir = '../../assets/storage/images/';
        $tmp_name = $_FILES['img']['tmp_name'];
        $create = move_uploaded_file($tmp_name, $uploads_dir."/".$title."_".$random_code.".png");  
    }
    $CMSNT->insert("blogs", [
        'title'     => $title,
        'content'   => $content,
        'display'   => $display,
        'img'       => BASE_URL('assets/storage/images/'.$title."_".$random_code.".png"),
        'view'      => 0,
        'time'      => gettime(),
        'thoigian'  => time()
    ]);
    admin_msg_success("Thêm bài viết thành công !", "", 2000);

}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tin tức</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">THÊM BÀI VIẾT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" enctype="multipart/form-data" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tiêu đề bài viết</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input type="text" name="title" placeholder="Nhập tiêu đề bài viết"
                                            class="form-control" require>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Ảnh mô tả</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <input class="form-control" type="file" name="img" multiple require>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nội dung bài viết</label>
                                <div class="col-sm-9">
                                    <div class="form-line">
                                        <textarea class="textarea" name="content"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Hiển thị</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="display" required>
                                        <option value="SHOW">SHOW</option>
                                        <option value="HIDE">HIDE</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnCreate" class="btn btn-primary btn-block">
                                <span>THÊM NGAY</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">DANH SÁCH BÀI VIẾT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>TITLE</th>
                                        <th>IMG</th>
                                        <th>THỜI GIAN</th>
                                        <th>HIỂN THỊ</th>
                                        <th>THAO TÁC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `blogs` ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$row['title'];?></td>
                                        <td><img src="<?=$row['img'];?>" width="200px"></td>
                                        <td><span class="badge badge-danger"><?=$row['time'];?></span></td>
                                        <td><?=display($row['display']);?></td>
                                        <td><a type="button" href="<?=BASE_URL('Admin/Blog/Edit/');?><?=$row['id'];?>"
                                                class="btn btn-primary"><i class="fas fa-edit"></i>
                                                <span>EDIT</span></a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>





<script>
$(function() {
    // Summernote
    $('.textarea').summernote()
})
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php 
    require_once("../../public/admin/Footer.php");
?>