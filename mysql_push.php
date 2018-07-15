<?php


require_once 'parse_html&combine.php';
require_once 'create_attributes.php';
require_once 'create_products.php';





$host='localhost';
$dbname='prestashop';
$user='root';
$pass='magister';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);


$url=$argv[1];
$id_product=$argv[2];


try {
   
    $arr=parseHtmlCombine($url);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    var_dump(count($arr));
    $pdo->beginTransaction();
        createattributes($arr,$pdo);
        createproducts($arr,$pdo,$id_product);
    $pdo->commit();
}
catch (Exception $exception){
    $pdo->rollBack();
    var_dump($exception->getMessage());
}


