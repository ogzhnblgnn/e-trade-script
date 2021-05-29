<!-- header content-->
<?php
include 'header.php';
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
                        <h2>Slider Ekleme Ekranı<small>

                                <!-- Güncelleme yapıldığında get ile url'de dönen duruma göre alert oluşturuyoruz. -->

                                <?php
                                if($_GET['durum'] =="ok"){?>
                                    <b style="color:green;">Güncelleme Başarılı</b><?php }
                                elseif($_GET['durum']=="no"){?>
                                    <b style="color:red;">Güncelleme Başarısız</b><?php } ?>

                            </small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form action="../netting/islem.php" enctype="multipart/form-data" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                            <!-- İlgili alanlar islem.php ye gönderiliyor POST('sliderkaydet')-->

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" id="first-name"  name="slider_yol"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Ad<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input placeholder="Slider Adını Giriniz" type="text" id="first-name" name="slider_ad" required="required" class="form-control col-md-7 col-xs-12" ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider URL</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input placeholder="Slider URL Giriniz" type="text" id="first-name" name="slider_link" class="form-control col-md-7 col-xs-12" ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Sıra<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input placeholder="Slider Sırasını Giriniz"  type="text" id="first-name" name="slider_sira" required="required" class="form-control col-md-7 col-xs-12" ">
                                </div>
                            </div>

                            <label placeholder="Slider Durumunu Giriniz" class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Durum<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="slider_durum" id="heard" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="sliderkaydet" type="submit" class="btn btn-primary">Kaydet</button>
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
