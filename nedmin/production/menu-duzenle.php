<!-- header content-->
<?php
include 'header.php';

// menu tablosunda ilgili menu_id'ye sahip menüler listelenmiştir.
$menusor=$db->prepare("SELECT * FROM menu WHERE menu_id=:id");
$menusor->execute(array(
    'id'=>$_GET['menu_id']
));
$menucek=$menusor->fetch(PDO::FETCH_ASSOC);
?>
<!-- /header content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Menü Düzenleme Ekranı<small>

                                <!-- Güncelleme yapıldığında get ile url'de dönen duruma göre alert oluşturuyoruz. -->
                                <?php
                                if($_GET['durum'] =="ok"){?>
                                    <b style="color:green;">Güncelleme Başarılı</b><?php }
                                elseif($_GET['durum']=="no"){?>
                                    <b style="color:red;">Güncelleme Başarısız</b><?php } ?>

                            </small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                            <!-- Başlıklara göre menu tablosundaki verilere erişim (sayfa başında sorgulanmıştır)  -->

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Ad<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $menucek['menu_ad']; ?>" type="text" id="first-name" name="menu_ad" required="required" class="form-control col-md-7 col-xs-12" ">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Detay <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="ckeditor" id="ckeditor1" name="menu_detay"><?php echo $menucek['menu_detay'] ?></textarea>
                                </div>
                            </div>
                            <script>
                                CKEDITOR.replace('ckeditor1',
                                    {

                                        filebrowserBrowseUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',

                                        filebrowserUploadUrl: 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',

                                        filebrowserImageBrowseUrl: 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='

                                    });
                            </script>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü URL<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $menucek['menu_url']; ?>" type="text" id="first-name" name="menu_url"" class="form-control col-md-7 col-xs-12" ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Sıra<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $menucek['menu_sira']; ?>" type="text" id="first-name" name="menu_sira" required="required" class="form-control col-md-7 col-xs-12" ">
                                </div>
                            </div>

                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Durum<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="menu_durum" id="heard" required>
                                        <?php echo $menucek['menu_durum'] == '1' ? 'selected=""' : ''; ?>
                                        <option value="1" <?php echo $menucek['menu_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>
                                        <option value="0" <?php if ($menucek['menu_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>

                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="menu_id" value="<?php echo $menucek['menu_id'] ?>">
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button name="menuguncelle" type="submit" class="btn btn-primary">Güncelle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<!-- footer content -->
<?php
include 'footer.php';
?>
