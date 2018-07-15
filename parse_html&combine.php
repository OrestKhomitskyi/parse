<?php

require_once 'vendor/autoload.php';
require_once './Combination.php';



function parseHtmlCombine($url) {


    $data_excel=require_once 'parseexcel.php';


    define('ATTR','attribute_pa_');
    define('SKU','skucol');
    define('BORE',ATTR.'bore');
    define('STROKE',ATTR.'stroke');
    define('ROD',ATTR.'rod');
    define('RETRACTED',ATTR.'retracted');
    define('EXTENDED',ATTR.'extended');
    define('PIN',ATTR.'pin_d');
    define('PSIZE',ATTR.'port_size');
    define('CLOAD',ATTR.'column_load');
    define('PRICE','pricecol');
    //define('REPM',ATTR.'replacement');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $content = curl_exec($ch);

    curl_close($ch);


    phpQuery::newDocument($content);


    $combinations_raw=pq('table tr.is_purchasable');

    /**
     * Ширина, высота, глубина
     */
    $combinations=array();

    foreach ($combinations_raw as $item){
        $sku=pq("td.".SKU,$item)->attr('data-sort-value');
        $bore=pq("td.".BORE,$item)->attr('data-sort-value');
        $stroke=pq("td.".STROKE,$item)->attr('data-sort-value');
        $rod=pq("td.".ROD,$item)->attr('data-sort-value');
        $retracted=pq("td.".RETRACTED,$item)->attr('data-sort-value');
        $ext=pq("td.".EXTENDED,$item)->attr('data-sort-value');
        $pin=pq("td.".PIN,$item)->attr('data-sort-value');
        $pSize=pq("td.".PSIZE,$item)->attr('data-sort-value');
        $col_load=pq("td.".CLOAD,$item)->attr('data-sort-value');
        $price=pq("td.".PRICE,$item)->attr('data-sort-value');
        //$replacement=pq("td.".REPM,$item)->attr('data-sort-value');

        $weight=null;
        $width=null;
        $height=null;
        $depth=null;
        $oil_volume=null;

        try{
            array_walk($data_excel,function ($item,$key,$prefix) use (&$sku,&$weight,&$width,&$height,&$depth,&$oil_volume){

                if($item['sku']==$sku)
                {
                    $weight=$item['weight'];
                    $oil_volume=$item['oil_quarts'];
                    $dimensions=explode('x',$item['box_size']);
                    $width=$dimensions[0];
                    $height=$dimensions[1];
                    $depth=$dimensions[2];
                }

            },'fruit');

            if($weight==null||$width==null||$oil_volume==null||$depth==null||$height==null)
                throw new Exception('ERROR COMBINATION SKU: '.$sku);
        }
        catch (Exception $exception)
        {
            echo $exception->getMessage();
            exit;
        }

        $comb=new Combination($sku,$bore,$stroke,$rod,$retracted,$ext,$pin,$pSize,$col_load,$price,$width,$height,$depth,$weight,$oil_volume);
        $combinations[]=$comb;
    }


    phpQuery::unloadDocuments();

    return $combinations;
}

