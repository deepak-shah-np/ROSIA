<?php
    namespace Rosia\ChartBundle\Entity;

    class Task{

    public function refining($selected_invent=array()){
    $selected_invent=$selected_invent;
	$string=file_get_contents('rosia_data.json') or die("File not found!");
    $data=json_decode($string,true);

    
    $invent_array=array_column($data,'inventory');
    $quant_array=array_column($data,'quantity');
    $route_array=array_column($data,'shoproute');
    $shopname_array=array_column($data,'shopname');

    $invent_refined_array=array_values(array_unique($invent_array));
    sort($invent_refined_array);
    $quant_refined_array=array_values(array_unique($quant_array));
    $route_refined_array=array_values(array_unique($route_array));
    sort($route_refined_array);
    $shopname_refined_array=array_values(array_unique($shopname_array));
    $final_data=array();


   

        
        $final_data=array();
        $keys_route=array_keys($invent_array,$selected_invent);

        $selected_invent_route=array();
        $selected_invent=array();
        $selected_quant=array();
        $selected_shopname=array();


    foreach ($keys_route as $key => $value) {
        
        array_push($selected_invent_route, $route_array[$value]);
        array_push($selected_invent, $invent_array[$value]);
        array_push($selected_quant, $quant_array[$value]);
        array_push($selected_shopname,$shopname_array[$value]);
    }
    
    
    $unique_selected_route=array_values(array_unique($selected_invent_route));

    $unique_selected_shopname=array_values(array_unique($selected_shopname));
        $route_shop_invent=array();
    for ($i=0; $i < sizeOf($unique_selected_route); $i++) { 
        $route_shop_invent[$unique_selected_route[$i]]=array();
        $k=array_keys($selected_invent_route,$unique_selected_route[$i]);

        $temp_shop=array();
        
        $temp_quant=array();
        foreach ($k as $key => $value) {
            array_push($temp_shop, $selected_shopname[$value]);
            
            array_push($temp_quant, $selected_quant[$value]);
        }
        $temp_unique_shop=array_values(array_unique($temp_shop));

        for ($j=0; $j < sizeOf($temp_unique_shop); $j++) { 
            $route_shop_invent[$unique_selected_route[$i]][$j]=array();
            $m=array_keys($temp_shop,$temp_unique_shop[$j]);
            $quantity=0;
            foreach ($m as $key1 => $value1) {
                $quantity+=$temp_quant[$value1];
            }
            $shop=$temp_unique_shop[$j];
            
            array_push($route_shop_invent[$unique_selected_route[$i]][$j],$shop);
            array_push($route_shop_invent[$unique_selected_route[$i]][$j],$quantity);
            
        }

        
    }

    $final_data=array();
        for($i=0;$i<sizeof($unique_selected_route);$i++)
        {
            $final_data[$i]=array();
            array_push($final_data[$i], $unique_selected_route[$i]);
            $j=array_keys($selected_invent_route,$unique_selected_route[$i]);
            $quantity=0;
            foreach ($j as $key => $value) {
                $quantity+=$selected_quant[$value];
            }
            
            array_push($final_data[$i], $quantity);
    }
    return [$final_data,$route_shop_invent];

}
}


?>