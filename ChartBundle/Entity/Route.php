<?php
	namespace Rosia\ChartBundle\Entity;

	class Route{
	public function route_data($selected_route=array()){

	$selected_route=$selected_route;

	$string=file_get_contents('rosia_data.json') or die("File not found!");
	$data=json_decode($string,true);

	
	$invent_array=array_column($data,'inventory');
	$quant_array=array_column($data,'quantity');
	$shoproute_array=array_column($data,'shoproute');
	$shopname_array=array_column($data,'shopname');

	$invent_refined_array=array_values(array_unique($invent_array));
	sort($invent_refined_array);
	$quant_refined_array=array_values(array_unique($quant_array));
	$shoproute_refined_array=array_values(array_unique($shoproute_array));
	sort($shoproute_refined_array);
	$shopname_refined_array=array_values(array_unique($shopname_array));



	

	
	$keys_route=array_keys($shoproute_array,$selected_route);

	$selected_route_shop=array();
	$selected_route_invent=array();

	$invent_route=array();
	$quant_route=array();

	foreach ($keys_route as $key => $value) {
		array_push($selected_route_shop,$shopname_array[$value]);
		array_push($selected_route_invent,$invent_array[$value]);
		//$invent_quant_route[$invent_array[$value]]=$quant_array[$value];
		array_push($invent_route, $invent_array[$value]);
		array_push($quant_route, $quant_array[$value]);

	}
	

	$unique_selected_shop_route=array_values(array_unique($selected_route_shop));
	sort($unique_selected_shop_route);
	$unique_selected_invent_route=array_values(array_unique($selected_route_invent));
	sort($unique_selected_invent_route);

	$invent_dummy_array=array();
	$invent_refined_array=array();
	
		for($i=0;$i<sizeof($invent_route);$i++)
		{
					
			if(in_array($invent_route[$i],$invent_dummy_array))
			{
				
					
						$j=array_keys($invent_route,$invent_route[$i]);
						
						$quantity=0;
						
						foreach ($j as $key => $value) 
						{
							$quantity+=$quant_route[$value];
							
						}
						
						$invent_refined_array[$invent_route[$i]]=$quantity;
						
			
			}

			else{
				
				
				$invent_refined_array[$invent_route[$i]]=$quant_route[$i];
				array_push($invent_dummy_array,$invent_route[$i]);
			
				
				
			}
			
		}
ksort($invent_refined_array);
$invent_refined_array=array_values($invent_refined_array);
$final_invent_route=array();

for($i=0;$i<sizeOf($invent_refined_array);$i++){
	$final_invent_route[$i]=array();
	array_push($final_invent_route[$i], $unique_selected_invent_route[$i],$invent_refined_array[$i]);
}

//var_dump($final_invent_route);
//var_dump($unique_selected_invent_route);
$shop_invent_quant=array();
for ($i=0; $i < sizeOf($unique_selected_shop_route); $i++) { 
		$shop_invent_quant[$i]=array();
		$j=array_keys($shopname_array,$unique_selected_shop_route[$i]);
		foreach ($j as $key => $value) {
			$shop_invent_quant[$i][$invent_array[$value]]=$quant_array[$value];
			
	}
}


//var_dump($shop_invent_quant);
$final_array=array();

for ($i=0; $i < sizeOf($shop_invent_quant); $i++) {
	$final_array[$i]=array();
	array_push($final_array[$i], $unique_selected_shop_route[$i]);
	for ($j=0; $j < sizeOf($unique_selected_invent_route); $j++) { 
		$k=array_keys($shop_invent_quant[$i]);
		if(in_array($unique_selected_invent_route[$j],$k)){

			//$final_array[$i]=;
			array_push($final_array[$i], $shop_invent_quant[$i][$unique_selected_invent_route[$j]]);
			

		}
		else{
			array_push($final_array[$i],null);
			
		}
	}
	}
	return [$final_array,$unique_selected_invent_route,$final_invent_route];
	}
}


?>