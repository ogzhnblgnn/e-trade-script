<!-- header content-->
<?php
include 'header.php';

// menu tablosundaki veriler listeleniyor
$menusor=$db->prepare("SELECT * FROM menu");
$menusor->execute();
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
                        <h2>Menü Listeleme</h2>
                        <div class="clearfix"></div>
                        <div align="right">
                            <a href="menu-ekle.php"><button class="btn btn-success btn-xs">Yeni Ekle</button></a>
                        </div>

                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            Menü işlemlerinizi bu sayfadan yapabilirsiniz.
                        </p>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                            <tr>
                                <th>Sıra No</th>
                                <th>Kayıt Adı</th>
                                <th>Menü URL</th>
                                <th>Menü Sıra</th>
                                <th>Menü Durumu</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tr>
                            </thead>
                            <tbody>

                            <!-- Menülerin Listelenmesi -->

                            <?php
                            $say=0;
                            while($menucek=$menusor->fetch(PDO::FETCH_ASSOC)){ $say++;
                                ?>
                                <tr>
                                    <td width="20"><?php echo $say;?></td>
                                    <td><?php echo $menucek['menu_ad']; ?></td>
                                    <td><?php echo $menucek['menu_url']; ?></td>
                                    <td><?php echo $menucek['menu_sira']; ?></td>
                                    <td> <center>
                                        <?php
                                        if ($menucek['menu_durum']==1){?>
                                        <button class="btn btn-success btn-xs">Aktif</button>
                                        <?php }else{?>
                                        <button class="btn btn-danger btn-xs">Pasif</button> <?php } ?>
                                        </center>
                                    </td>
                                    <td><center><a href="menu-duzenle.php?menu_id=<?php echo $menucek['menu_id']; ?>"><button name="menuguncelle" class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                                    <td><a href="../netting/islem.php?menu_id=<?php echo $menucek['menu_id']; ?>&menusil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></td>
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
