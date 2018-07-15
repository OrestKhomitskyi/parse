<?php

function createattributes($arr,PDO $pdo)
{


    $attr_group_pos=0;
    $attr_value_pos=0;

    foreach ($arr as $item)
    {
        foreach ($item as $key => $value) {

            $check_for_attribute_avail="SELECT * FROM prestashop.ps_attribute_group_lang WHERE name='{$key}'";


            //Then create attribute group
            if(!$pdo->query($check_for_attribute_avail)->fetch())
            {
                if($key=="price" || $key=="" || $key=="weight")
                    continue;

                $create_attr_group="INSERT INTO prestashop.ps_attribute_group (is_color_group, group_type, `position`) VALUES(0,'select',{$attr_group_pos})";
                $pdo->exec($create_attr_group);
                $attr_group_pos++;
                $selectLast="SELECT id_attribute_group FROM ps_attribute_group ORDER BY id_attribute_group DESC LIMIT 1";

                $st=$pdo->query($selectLast);
                $data=$st->fetch();
                $lastid=$data['id_attribute_group'];

                $langs_sql="SELECT id_lang FROM prestashop.ps_lang";

                $langs=$pdo->query($langs_sql)->fetchAll();

                foreach ($langs as $lang)
                {
                    $id_l=$lang['id_lang'];
                    $create_attr_group_lang="INSERT INTO prestashop.ps_attribute_group_lang (id_attribute_group,id_lang, name, public_name) VALUES ({$lastid},{$id_l},'{$key}','{$key}')";
                    $pdo->exec($create_attr_group_lang);
                }


                $create_attr_group_shop="INSERT INTO prestashop.ps_attribute_group_shop (id_attribute_group, id_shop) VALUES ({$lastid},1)";

                $pdo->exec($create_attr_group_shop);
            }

            //Create attribute value

            $id_group_sql="SELECT id_attribute_group FROM prestashop.ps_attribute_group_lang WHERE name='{$key}'";

            $id_group=$pdo->query($id_group_sql)->fetch()['id_attribute_group'];

//            $check_if_value_exists="
//                SELECT ps_attribute_lang.id_attribute,ps_attribute_group_lang.name as 'group_name',prestashop.ps_attribute_lang.name as 'value'
//                FROM prestashop.ps_attribute_lang
//                JOIN ps_attribute ON prestashop.ps_attribute.id_attribute
//                JOIN prestashop.ps_attribute_group_lang ON prestashop.ps_attribute_group_lang.id_attribute_group
//                WHERE ps_attribute_lang.name='{$value}'";

            $check_if_value_exists="SELECT id_attribute_group
            FROM prestashop.ps_attribute_lang 
            JOIN prestashop.ps_attribute ON ps_attribute_lang.id_attribute=ps_attribute.id_attribute
            WHERE ps_attribute_lang.name='{$value}' AND id_attribute_group={$id_group}
            ";
            $res=$pdo->query($check_if_value_exists)->fetch();
            if(!$res)
            {
                $create_attribute_value="INSERT INTO prestashop.ps_attribute (id_attribute_group, color, `position`) VALUES({$id_group},'',{$attr_value_pos})";
                $attr_value_pos++;
                $pdo->exec($create_attribute_value);

                $selectLast="SELECT id_attribute FROM prestashop.ps_attribute ORDER BY id_attribute DESC LIMIT 1";
                $idlast=$pdo->query($selectLast)->fetch()['id_attribute'];

                $langs_sql="SELECT id_lang FROM prestashop.ps_lang";

                $langs=$pdo->query($langs_sql)->fetchAll();

                foreach ($langs as $lang)
                {
                    $id_l=$lang['id_lang'];
                    $create_attribute_value_lang="INSERT INTO prestashop.ps_attribute_lang (id_attribute, id_lang, `name`) VALUES ({$idlast},{$id_l},'{$value}')";
                    $pdo->exec($create_attribute_value_lang);
                }



                $create_attribute_shop="INSERT INTO prestashop.ps_attribute_shop (id_attribute, id_shop) VALUES ({$idlast},1)";
                $pdo->exec($create_attribute_shop);

            }
        }
    }

}

