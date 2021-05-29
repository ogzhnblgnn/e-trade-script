<!-- header content-->
<?php
include 'header.php';

// kullanici tablosundan veriler sorgulanıyor

$kullanicisor=$db->prepare("SELECT * FROM kullanici");
$kullanicisor->execute();
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
                        <h2>Kullanıcılar<small>Users</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            Kullanıcı İşlemlerinizi Bu Sayfadan Yapabilirsiniz.
                        </p>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                            <tr>
                                <th>Kayıt Tarihi</th>
                                <th>Ad Soyad</th>
                                <th>Mail Adresi</th>
                                <th>Telefon</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tr>
                            </thead>
                            <!-- Kullanıcıları listeleme -->
                            <tbody>
                            <?php
                            while($kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?php echo $kullanicicek['kullanici_zaman']; ?></td>
                                    <td><?php echo $kullanicicek['kullanici_adsoyad']; ?></td>
                                    <td><?php echo $kullanicicek['kullanici_mail']; ?></td>
                                    <td><?php echo $kullanicicek['kullanici_gsm']; ?></td>
                                    <td><center><a href="kullanici-duzenle.php?kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>"><button name="kullaniciguncelle" class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                                    <td><a href="../netting/islem.php?kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>&kullanicisil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></td>
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
