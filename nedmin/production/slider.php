<!-- header content-->
<?php
include 'header.php';

// slider tablosundan veriler sorgulanıyor.
$slidersor=$db->prepare("SELECT * FROM slider");
$slidersor->execute();
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
                        <h2>Slider Listeleme</h2>
                        <div class="clearfix"></div>
                        <div align="right">
                            <a href="slider-ekle.php"><button class="btn btn-success btn-xs">Yeni Ekle</button></a>
                        </div>

                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            Slider işlemlerinizi bu sayfadan yapabilirsiniz.
                        </p>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                            <tr>
                                <th>Sıra No</th>
                                <th>Fotoğraf</th>
                                <th>Ad</th>
                                <th>URL</th>
                                <th>Slider Sıra</th>
                                <th>Slider Durumu</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tr>
                            </thead>
                            <!-- Slider Listeleme -->
                            <tbody>
                            <?php
                            $say=0;
                            while($slidercek=$slidersor->fetch(PDO::FETCH_ASSOC)){ $say++;
                                ?>
                                <tr>
                                    <td width="20"><?php echo $say;?></td>
                                    <td><img width="200" src="../../<?php echo $slidercek['slider_yol']; ?>" alt=""></td>
                                    <td><?php echo $slidercek['slider_ad']; ?></td>
                                    <td><?php echo $slidercek['slider_link']; ?></td>
                                    <td><?php echo $slidercek['slider_sira']; ?></td>
                                    <td> <center>
                                            <?php
                                            if ($slidercek['slider_durum']==1){?>
                                                <button class="btn btn-success btn-xs">Aktif</button>
                                            <?php }else{?>
                                                <button class="btn btn-danger btn-xs">Pasif</button> <?php } ?>
                                        </center>
                                    </td>
                                    <td><center><a href="slider-duzenle.php?slider_id=<?php echo $slidercek['slider_id']; ?>"><button name="sliderguncelle" class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                                    <td><a href="../netting/islem.php?slider_id=<?php echo $slidercek['slider_id']; ?>&slidersil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

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
