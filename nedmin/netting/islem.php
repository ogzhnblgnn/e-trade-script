<?php
include 'baglan.php';
include '../production/fonksiyon.php';
ob_start();
session_start();

// Kök dizindeki register.php den POST ile gelen kullanicikaydet formu (Siteye kullanıcı kaydı oluşturma)


if (isset($_POST['kullanicikaydet'])) {
    echo $kullanici_adsoyad=htmlspecialchars($_POST['kullanici_adsoyad']); echo "<br>";
    echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); echo "<br>";

    echo $kullanici_passwordone=$_POST['kullanici_passwordone']; echo "<br>";
    echo $kullanici_passwordtwo=$_POST['kullanici_passwordtwo']; echo "<br>";

    //Girilen şifre ikinci kez istenerek doğrulama sağlanıyor

    if ($kullanici_passwordone==$kullanici_passwordtwo) {
        if (strlen($kullanici_passwordone>=6)) {
            $kullanicisor=$db->prepare("select * from kullanici where kullanici_mail=:mail");
            $kullanicisor->execute(array(
                'mail' => $kullanici_mail
            ));

            $say=$kullanicisor->rowCount();
            // say değişkeni rowCount ile bize 0 veya 1 döndürüyor(Eşdeğer bir kullanıcı olup olmadığını kontrol ediyoruz.)
            if ($say==0) {
                $password=md5($kullanici_passwordone);  //Girilen parola veritabanında md5 şifreleme ile tutuluyor.
                $kullanici_yetki=1;     // Yetki = 1 -> Standart Kullanıcı
                                        // Yetki = 5 -> Admin

                // Kullanıcıyı veritabanına kayıt işlemi
                $kullanicikaydet=$db->prepare("INSERT INTO kullanici SET
					kullanici_adsoyad=:kullanici_adsoyad,
					kullanici_mail=:kullanici_mail,
					kullanici_sifre=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
                $insert=$kullanicikaydet->execute(array(
                    'kullanici_adsoyad' => $kullanici_adsoyad,
                    'kullanici_mail' => $kullanici_mail,
                    'kullanici_password' => $password,
                    'kullanici_yetki' => $kullanici_yetki
                ));
                // İkili şifre doğrulama hatasızsa ve böyle bir kullanıcı daha önceden yoksa kayıt işlemi başarılıdır.
                if ($insert) {
                    header("Location:../../index.php?durum=loginbasarili");
                } else {
                    header("Location:../../register.php?durum=basarisiz");
                }
            } else {   // Daha önce böyle bir kullanici_mail kayıtlıysa kayıt başarısızdır.
                header("Location:../../register.php?durum=mukerrerkayit");
            }
        } else {
            header("Location:../../register.php?durum=eksiksifre");
        }
    } else {
        header("Location:../../register.php?durum=farklisifre");
    }
}


// Register.php den gelen sliderkaydet formu(Anasayfadaki slider'a fotoğraf ekleme)


if (isset($_POST['sliderkaydet'])) {


    $uploads_dir = '../../dimg/slider';
    @$tmp_name = $_FILES['slider_yol']["tmp_name"];
    @$name = $_FILES['slider_yol']["name"];

    //resmin isminin benzersiz olması

    $benzersizsayi1=rand(20000,32000);
    $benzersizsayi2=rand(20000,32000);
    $benzersizsayi3=rand(20000,32000);
    $benzersizsayi4=rand(20000,32000);
    $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
    $refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

    // slider fotoğrafının veritabanına kayıt işlemi

    $kaydet=$db->prepare("INSERT INTO slider SET
		slider_ad=:slider_ad,
		slider_sira=:slider_sira,
		slider_link=:slider_link,
		slider_durum=:slider_durum,
		slider_yol=:slider_yol
		");
    $insert=$kaydet->execute(array(
        'slider_ad' => $_POST['slider_ad'],
        'slider_sira' => $_POST['slider_sira'],
        'slider_link' => $_POST['slider_link'],
        'slider_durum' =>$_POST['slider_durum'],
        'slider_yol' => $refimgyol
    ));

    //İşlem sonucu Get methodu ile url'e bildirilir.

    if ($insert) {
        Header("Location:../production/slider.php?durum=ok");
    } else {
        Header("Location:../production/slider.php?durum=no");
    }
}


// genel-ayar.php den gelen logoduzenle formu (Admin panelde genel ayarlarda logoyu güncelleme)


if (isset($_POST['logoduzenle'])) {
    $uploads_dir = '../../dimg';
    @$tmp_name = $_FILES['ayar_logo']["tmp_name"];
    @$name = $_FILES['ayar_logo']["name"];

    $benzersizsayi4=rand(20000,32000);
    $refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;

    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

    $duzenle=$db->prepare("UPDATE ayar SET
		ayar_logo=:logo
		WHERE ayar_id=0");
    $update=$duzenle->execute(array(
        'logo' => $refimgyol
    ));

    if ($update) {
        $resimsilunlink=$_POST['eski_yol'];
        unlink("../../$resimsilunlink");
        Header("Location:../production/genel-ayar.php?durum=ok");
    } else {
        Header("Location:../production/genel-ayar.php?durum=no");
    }

}

// Adminin panele girişi için nedmin/production/login php.den admingiris formu alındığında
// kullanici_mail,yetki ve sifre baz alınarak session oluşturulması
// yetki = 5 -> Admin
// yetki = 1 -> Standart kullanıcı olarak baz alınmıştır.


if (isset($_POST['admingiris'])){
    $kullanici_mail=$_POST['kullanici_mail'];
    $kullanici_sifre=md5($_POST['kullanici_sifre']);

    $kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail AND kullanici_sifre=:sifre AND kullanici_yetki=:yetki");
    $kullanicisor->execute(array(
        'mail'=> $kullanici_mail,
        'sifre' => $kullanici_sifre,
        'yetki' => 5
    ));
    echo $say=$kullanicisor->rowCount();
    if ($say==1){
        $_SESSION['kullanici_mail']=$kullanici_mail;
        Header("Location:../production/index.php");
        exit;
    }else {
        Header("Location:../production/login.php?durum=no");    //başarısız olması durumunda giriş ekranına tekrar yönlendirilir ve get ile url'ye durum=no gönderilir.
        exit;
    }

}
// Giriş ekranı header alanında yapılacağından
// Kullanıcıların siteye giriş yapması için kök dizindeki header.php'den kullanicigiris formu alınır
// kullanici_mail,yetki,durum ve sifre baz alınarak session oluşturulması

if (isset($_POST['kullanicigiris'])) {

    echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);
    echo $kullanici_password=md5($_POST['kullanici_password']);

    $kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail AND kullanici_yetki=:yetki AND kullanici_sifre=:password AND kullanici_durum=:durum");
    $kullanicisor->execute(array(
        'mail' => $kullanici_mail,
        'yetki' => 1,
        'password' => $kullanici_password,
        'durum' => 1
    ));
    $say=$kullanicisor->rowCount();

    //Say değişkeni ile kullanicisor dizisinde 1 mi 0 mı döndüğü kontrol edilir (Böyle bir kullanıcı var mı yok mu)
    //Eğer varsa giriş başarılı sayılır ve session başlatılır

    if ($say==1) {
        echo $_SESSION['userkullanici_mail']=$kullanici_mail;
        header("Location:../../");
        exit;

        // Eğer rowCount bize 0 döndürüyorsa böyle bir kullanıcı olmadığından giriş başarısız olur
        // Başarısız giriş GET methodu ile url'e bildirilir.

    } else {
        header("Location:../../?durum=basarisizgiris");
    }
}

// Kullanıcı güncelleme işlemleri admin panel tarafından da müdahale edilebileceğinden
// nedmin/production altındaki kullanici-duzenle.php den kullaniciduzenle formu alınır
// mevcut bilgilerin yerine admin tarafından girilen bilgiler set edilir.

if (isset($_POST['kullaniciguncelle'])) {
    $kullanici_id=$_POST['kullanici_id'];
    $ayarkaydet=$db->prepare("UPDATE kullanici SET
    kullanici_tc=:kullanici_tc,
    kullanici_adsoyad=:kullanici_adsoyad,
    kullanici_mail=:kullanici_mail,
    kullanici_gsm=:kullanici_gsm,
    kullanici_unvan=:kullanici_unvan,
    kullanici_adres=:kullanici_adres,
    kullanici_il=:kullanici_il,
    kullanici_ilce=:kullanici_ilce,
    kullanici_yetki=:kullanici_yetki,
    kullanici_durum=:kullanici_durum
    WHERE kullanici_id={$_POST['kullanici_id']}
    ");
    $update=$ayarkaydet->execute(array(
        'kullanici_tc'=>$_POST['kullanici_tc'],
        'kullanici_adsoyad'=>$_POST['kullanici_adsoyad'],
        'kullanici_mail'=>$_POST['kullanici_mail'],
        'kullanici_gsm'=>$_POST['kullanici_gsm'],
        'kullanici_unvan'=>$_POST['kullanici_unvan'],
        'kullanici_adres'=>$_POST['kullanici_adres'],
        'kullanici_il'=>$_POST['kullanici_il'],
        'kullanici_ilce'=>$_POST['kullanici_ilce'],
        'kullanici_yetki'=>$_POST['kullanici_yetki'],
        'kullanici_durum'=>$_POST['kullanici_durum']
    ));

    //Güncelleme işleminin sonucuna bağlı olarak değişen bir gösterge eklemek için get ile url'e durum bildirisi yapılır

    if($update){
        Header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");

    }
    else{
        Header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");

    }
}

// nedmin/production/kullanicilar.php den kullanicisil formu alınır
// kullanici_id baz alınarak seçili kullanıcı veritabanından silinir

if($_GET['kullanicisil']=="ok"){
    $sil=$db->prepare("DELETE FROM kullanici WHERE kullanici_id=:id");
    $delete=$sil->execute(array(
        'id'=>$_GET['kullanici_id']
    ));
    //İşlem sonucu get methodu ile bildirilir
    if($delete){
        Header("Location:../production/kullanicilar.php?sil=ok");
    }
    else{
        Header("Location:../production/kullanicilar.php?sil=no");
    }
}


//  Genel ayarlar ekranında adminden alınan bilgilerin ayar tablosuna set edilmesi için
// genel-ayar.php den POST ile gelen genelayarkaydet formu alınır.

if(isset($_POST['genelayarkaydet'])){
    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_title=:ayar_title,
    ayar_description=:ayar_description,
    ayar_keywords=:ayar_keywords,
    ayar_author=:ayar_author
    WHERE ayar_id=0
    ");

    $update=$ayarkaydet->execute(array(
        'ayar_title' => $_POST['ayar_title'],
        'ayar_description' => $_POST['ayar_description'],
        'ayar_keywords' => $_POST['ayar_keywords'],
        'ayar_author' => $_POST['ayar_author']
    ));

        // İşlem sonucu url'e GET methodu ile bildirilir.
    if ($update){
        Header("Location:../production/genel-ayar.php?durum=ok");
    }
    else{
        Header("Location:../production/genel-ayar.php?durum=no");
    }
}

// nedmin/production/iletisim-ayar.php den gelen iletisimayarkaydet formu alınır
// Admin panelde Genel Ayarlar/İletişim Ayarları sekmesi üzerinden girilen bilgiler ayar tablosunda ilgili alanlara set edilir.


if(isset($_POST['iletisimayarkaydet'])){
    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_tel=:ayar_tel,
    ayar_gsm=:ayar_gsm,
    ayar_fax=:ayar_fax,
    ayar_mail=:ayar_mail,
    ayar_il=:ayar_il,
    ayar_ilce=:ayar_ilce,
    ayar_adres=:ayar_adres,
    ayar_mesai=:ayar_mesai
    WHERE ayar_id=0
    ");

    $update=$ayarkaydet->execute(array(
        'ayar_tel' => $_POST['ayar_tel'],
        'ayar_gsm' => $_POST['ayar_gsm'],
        'ayar_fax' => $_POST['ayar_fax'],
        'ayar_mail' => $_POST['ayar_mail'],
        'ayar_il' => $_POST['ayar_il'],
        'ayar_ilce' => $_POST['ayar_ilce'],
        'ayar_adres' => $_POST['ayar_adres'],
        'ayar_mesai' => $_POST['ayar_mesai']
    ));

    if ($update){
        Header("Location:../production/iletisim-ayar.php?durum=ok");
    }
    else{
        Header("Location:../production/iletisim-ayar.php?durum=no");
    }
}

// nedmin/production/api-ayar.php den gelen apiayarkaydet formu alınır
// Admin panelde Genel Ayarlar/Api Ayarları sekmesi üzerinden girilen bilgiler ayar tablosunda ilgili alanlara set edilir.

if(isset($_POST['apiayarkaydet'])){
    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_maps=:ayar_maps,
    ayar_analystic=:ayar_analystic,
    ayar_zopim=:ayar_zopim
    WHERE ayar_id=0
    ");

    $update=$ayarkaydet->execute(array(
        'ayar_maps' => $_POST['ayar_maps'],
        'ayar_analystic' => $_POST['ayar_analystic'],
        'ayar_zopim' => $_POST['ayar_zopim']
    ));

    if ($update){
        Header("Location:../production/api-ayar.php?durum=ok");
        exit;
    }
    else{
        Header("Location:../production/api-ayar.php?durum=no");
        exit;
    }
}

// nedmin/production/sosyal-ayar.php den gelen sosyalayarkaydet formu alınır
// Admin panelde Genel Ayarlar/Sosyal Ağlar sekmesi üzerinden girilen bilgiler ayar tablosunda ilgili alanlara set edilir

if(isset($_POST['sosyalayarkaydet'])){
    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_facebook=:ayar_facebook,
    ayar_twitter=:ayar_twitter,
    ayar_google=:ayar_google,
    ayar_youtube=:ayar_youtube
    WHERE ayar_id=0
    ");

    $update=$ayarkaydet->execute(array(
        'ayar_facebook' => $_POST['ayar_facebook'],
        'ayar_twitter' => $_POST['ayar_twitter'],
        'ayar_google' => $_POST['ayar_google'],
        'ayar_youtube' => $_POST['ayar_youtube']
    ));

    if ($update){
        Header("Location:../production/genel-ayar.php?durum=ok");
        exit;
    }
    else{
        Header("Location:../production/genel-ayar.php?durum=no");
        exit;
    }
}

// nedmin/production/mail-ayar.php den gelen mailayarkaydet formu alınır
// Admin panelde Genel Ayarlar/Mail Ayarları sekmesi üzerinden girilen bilgiler ayar tablosunda ilgili alanlara set edilir

if(isset($_POST['mailayarkaydet'])){
    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_smtphost=:ayar_smtphost,
    ayar_smtpuser=:ayar_smtpuser,
    ayar_smtppassword=:ayar_smtppassword,
    ayar_smtpport=:ayar_smtpport
    WHERE ayar_id=0
    ");

    $update=$ayarkaydet->execute(array(
        'ayar_smtphost' => $_POST['ayar_smtphost'],
        'ayar_smtpuser' => $_POST['ayar_smtpuser'],
        'ayar_smtppassword' => $_POST['ayar_smtppassword'],
        'ayar_smtpport' => $_POST['ayar_smtpport']
    ));

    if ($update){
        Header("Location:../production/mail-ayar.php?durum=ok");
        exit;
    }
    else{
        Header("Location:../production/mail-ayar.php?durum=no");
        exit;
    }
}

// nedmin/production/hakkimizda.php den gelen hakkimizdakaydet formu alınır
// Admin panelde Hakkımızda sekmesi üzerinden girilen bilgiler ayar tablosunda ilgili alanlara set edilir.

if(isset($_POST['hakkimizdakaydet'])) {
    $ayarkaydet = $db->prepare("UPDATE hakkimizda SET
    hakkimizda_baslik=:hakkimizda_baslik,
    hakkimizda_icerik=:hakkimizda_icerik,
    hakkimizda_video=:hakkimizda_video,
    hakkimizda_vizyon=:hakkimizda_vizyon,
    hakkimizda_misyon=:hakkimizda_misyon
    WHERE hakkimizda_id=0
    ");

    $update = $ayarkaydet->execute(array(
        'hakkimizda_baslik' => $_POST['hakkimizda_baslik'],
        'hakkimizda_icerik' => $_POST['hakkimizda_icerik'],
        'hakkimizda_video' => $_POST['hakkimizda_video'],
        'hakkimizda_vizyon' => $_POST['hakkimizda_vizyon'],
        'hakkimizda_misyon' => $_POST['hakkimizda_misyon']
    ));

    if ($update){
        Header("Location:../production/hakkimizda.php?durum=ok");
        exit;
    }
    else{
        Header("Location:../production/hakkimizda.php?durum=no");
        exit;
    }

}

// nedmin/production/menu-duzenle.php den gelen menuguncelle formu alınır
// Admin panelde Menü Ayar sekmesi üzerinden girilen bilgiler ayar tablosunda ilgili alanlara set edilir.
// Menüler sitedeki navbar üzerinde bulunan sayfa bağlantılarını oluşturur.

if (isset($_POST['menuguncelle'])) {
    $menu_id=$_POST['menu_id'];
    $menu_seourl=seo($_POST['menu_ad']);
    $ayarkaydet=$db->prepare("UPDATE menu SET
    menu_ad=:menu_ad,
    menu_detay=:menu_detay,
    menu_url=:menu_url,
    menu_sira=:menu_sira,
    menu_seourl=:menu_seourl,
    menu_durum=:menu_durum
    WHERE menu_id={$_POST['menu_id']}
    ");
    $update=$ayarkaydet->execute(array(
        'menu_ad'=>$_POST['menu_ad'],
        'menu_detay'=>$_POST['menu_detay'],
        'menu_url'=>$_POST['menu_url'],
        'menu_sira'=>$_POST['menu_sira'],
        'menu_seourl'=>$menu_seourl,
        'menu_durum'=>$_POST['menu_durum']
    ));
    if($update){
        Header("Location:../production/menu-duzenle.php?menu_id=$menu_id&durum=ok");
        exit;
    }
    else{
        Header("Location:../production/menu-duzenle.php?menu_id=$menu_id&durum=no");
        exit;
    }
}

// nedmin/production/menu.php den GET methodu ile gelen menusil formu alınır
// ilgili menu_id ye sahip menümüz menu tablosundan silinir.

if($_GET['menusil']=="ok"){
    $sil=$db->prepare("DELETE FROM menu WHERE menu_id=:id");
    $delete=$sil->execute(array(
        'id'=>$_GET['menu_id']
    ));
    if($delete){
        Header("Location:../production/menu.php?sil=ok");
        exit;
    }
    else{
        Header("Location:../production/menu.php?sil=no");
        exit;
    }
}

// nedmin/production/menu-ekle.php den gelen menuekle formu alınır.
// Admin panelde Menü Ayar/Yeni Ekle sekmesinde girilen bilgiler menu tablosuna set edilir.

if (isset($_POST['menuekle'])) {
    $menu_seourl=seo($_POST['menu_ad']);
    $menuekle=$db->prepare("INSERT INTO menu SET
    menu_ad=:menu_ad,
    menu_detay=:menu_detay,
    menu_url=:menu_url,
    menu_sira=:menu_sira,
    menu_seourl=:menu_seourl,
    menu_durum=:menu_durum
    ");
    $insert=$menuekle->execute(array(
        'menu_ad'=>$_POST['menu_ad'],
        'menu_detay'=>$_POST['menu_detay'],
        'menu_url'=>$_POST['menu_url'],
        'menu_sira'=>$_POST['menu_sira'],
        'menu_seourl'=>$menu_seourl,
        'menu_durum'=>$_POST['menu_durum']
    ));
    if($insert){
        Header("Location:../production/menu.php?durum=ok");
        exit;
    }
    else{
        Header("Location:../production/menu.php?durum=no");
        exit;
    }
}


?>