<?php


function createproducts($arr,PDO $pdo,int $idproduct){

    $price=0;
    $weight=0;



    foreach ($arr as $combination)
    {

        //CREATE EMPTY COMBINATION
        $create_combination_sql="
        INSERT INTO prestashop.ps_product_attribute 
        (id_product, reference, supplier_reference, location, ean13, isbn, upc, wholesale_price, price,
         ecotax, quantity, weight, unit_price_impact, default_on, minimal_quantity, low_stock_threshold,
          low_stock_alert, available_date) 
          VALUES($idproduct,'{$combination->sku}','','','','','',0.0000,{$combination->price},0.000,0,{$combination->weight},0.000,null,1,null,0,null)";
        $pdo->exec($create_combination_sql);

        $lastid_sql="SELECT id_product_attribute FROM prestashop.ps_product_attribute ORDER BY id_product_attribute DESC LIMIT 1";
        $lastid=$pdo->query($lastid_sql)->fetch()['id_product_attribute'];

        $create_combination_shop_sql="INSERT INTO prestashop.ps_product_attribute_shop 
        (id_product, id_product_attribute, id_shop, wholesale_price, price, ecotax, weight, unit_price_impact,
         default_on, minimal_quantity, low_stock_threshold, low_stock_alert, available_date) 
          VALUES($idproduct,$lastid,1,0.0000,{$combination->price},0.000,{$combination->weight},0.000,null,1,null,0,null)";

        $pdo->exec($create_combination_shop_sql);


        $id_product_image_sql="SELECT id_image FROM prestashop.ps_image WHERE id_product={$idproduct} LIMIT 1";

        $id_image=$pdo->query($id_product_image_sql)->fetch()['id_image'];

        if($id_image)
        {
            $create_image_product_attribute_sql="INSERT INTO prestashop.ps_product_attribute_image (id_product_attribute, id_image) VALUES ($lastid,$id_image)";

            $pdo->exec($create_image_product_attribute_sql);
        }
        //FILL COMBINAION WITH ATTRIBUTES

        foreach ($combination as $key=>$value)
        {

            if($value==.75)
            {
                $value=0.75;
            }

            if($key=="price"||$key=="weight")
                continue;

            if($key==null||$value==null)
            {
                throw new Exception("ERROR NOT AVAILABLE KEY: {$key}, VALUE: {$value}, SKU: {$combination->sku}");

            }

            $id_attr_sql="SELECT ps_attribute_lang.id_attribute
                        FROM prestashop.ps_attribute_lang
                        JOIN prestashop.ps_attribute ON ps_attribute_lang.id_attribute=ps_attribute.id_attribute
                        JOIN prestashop.ps_attribute_group_lang ON ps_attribute.id_attribute_group=ps_attribute_group_lang.id_attribute_group
                        WHERE prestashop.ps_attribute_lang.name='{$value}' AND prestashop.ps_attribute_group_lang.name='{$key}';";
            $id_attr=$pdo->query($id_attr_sql)->fetch()['id_attribute'].PHP_EOL;

            if(!$id_attr || !$lastid)
            {
                throw new Exception("ERROR");
            }

            $create_attr_combination_sql="INSERT INTO prestashop.ps_product_attribute_combination (id_attribute, id_product_attribute) VALUES ({$id_attr}, {$lastid})";










            $pdo->exec($create_attr_combination_sql);

        }


    }


}
