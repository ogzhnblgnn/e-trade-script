<?php

try{
    $db=new PDO("mysql:host=localhost;dbname=eticaret;charset=utf8","root","oguzbaba");
    //echo "Başarılı";
}
catch (PDOException $e){
    echo $e->getMessage();
}

?>