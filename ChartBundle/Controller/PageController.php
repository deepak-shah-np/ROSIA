<?php
namespace Rosia\ChartBundle\Controller;
use Rosia\ChartBundle\Entity\Task;
use Rosia\ChartBundle\Entity\Route;
use Rosia\ChartBundle\Form\EnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\ElasticaBundle\Configuration\Search;

class PageController extends Controller{
	public function indexAction(){
		
		
		return $this->render('PractiseChartBundle:Page:index.html.twig');
	}


	public function toptenAction(){


		$string=file_get_contents('rosia_data.json');
		$data=json_decode($string,true);

		$invent_array=array();
		$invent_dummy_array=array();
		$invent_refined_array=array();
		$quant_array=array();
		$invent_quantity_array=array();
		$invent_refined_array1=array();
		$inv_quan_refined_array=array();

		$invent_array = array_column($data, 'inventory');
		$quant_array=array_column($data,'quantity');
		for($i=0;$i<sizeof($quant_array);$i++)
		{
			$invent_quantity_array[$invent_array[$i]]=$quant_array[$i];
		}



		for($i=0;$i<sizeof($invent_array);$i++)
		{
					
			if(in_array($invent_array[$i],$invent_dummy_array))
			{
				
					
						$j=array_keys($invent_array,$invent_array[$i]);
						
						$quantity=0;
						
						foreach ($j as $key => $value) 
						{
							$quantity+=$quant_array[$value];
							
						}
						
						$invent_refined_array[$invent_array[$i]]=$quantity;
						
			
			}

			else{
				
				
				$invent_refined_array[$invent_array[$i]]=$quant_array[$i];
				array_push($invent_dummy_array,$invent_array[$i]);
			
				
				
			}
			
		}


				
				arsort($invent_refined_array);
				
				$invent_refined_array=array_slice($invent_refined_array,0,10);

				$final_array=array();
				$final_array[0]=array();
				$k=1;
				array_push($final_array[0],"Inventory","Quantity");
				foreach ($invent_refined_array as $key => $value) {
					$final_array[$k]=array();
					# code...
					array_push($final_array[$k],$key,$value);
					$k++;

				}
				$json_data=json_encode($final_array);


		return $this->render('PractiseChartBundle:Page:topten.html.twig',array('string'=>$json_data));
	}

	public function timelineAction(){
		$string=file_get_contents('rosia_data.json') or die("not found");
		$data=json_decode($string,true);

		$invent_array=array();
		$invent_dummy_array=array();
		$invent_refined_array=array();
		$quant_array=array();
		$invent_quantity_array=array();
		$invent_refined_array1=array();
		

		$invent_array = array_column($data, 'inventory');
		$quant_array=array_column($data,'quantity');

		for($i=0;$i<sizeof($quant_array);$i++){
			$invent_quantity_array[$invent_array[$i]]=$quant_array[$i];
		}



		for($i=0;$i<sizeof($invent_array);$i++)
		{
					
			if(in_array($invent_array[$i],$invent_dummy_array))
			{
				
					
						$j=array_keys($invent_array,$invent_array[$i]);
						
						$quantity=0;
						
						foreach ($j as $key => $value) 
						{
							$quantity+=$quant_array[$value];
							
						}
						
						$invent_refined_array[$invent_array[$i]]=$quantity;
			
			}

			else{
				
				
				$invent_refined_array[$invent_array[$i]]=$quant_array[$i];
				array_push($invent_dummy_array,$invent_array[$i]);
			}
			
		}
				arsort($invent_refined_array);
				$invent_refined_array=array_slice($invent_refined_array,0,10);
				$topten_invent=array_keys($invent_refined_array);



		$date_array=array_column($data,'order_date');
		$date_refined_array=array_values(array_unique($date_array));
		sort($date_refined_array);

			for($k=0;$k<sizeOf($date_refined_array);$k++){
				$invent_refined_dummy_array[$k]=array();
				$quant_refined_dummy_array[$k]=array();
				$j=array_keys($date_array,$date_refined_array[$k]);
				
				foreach($j as $key=>$value){
					
						array_push($invent_refined_dummy_array[$k],$invent_array[$value]);
						array_push($quant_refined_dummy_array[$k], $quant_array[$value]);
						
				}
			}
			

		for($m=0;$m<sizeOf($date_refined_array);$m++){
			$timeline_array[$m]=array();
			$invent_dummy_array1[$m]=array();
			//array_push($timeline_array[$m], $date_refined_array[$m]);
			$k=array_keys($date_array,$date_refined_array[$m]);
					foreach ($k as $key => $value) {
						
						$quantity=0;									
						if (in_array($invent_array[$value], $invent_dummy_array1[$m])) {
							
							$j=array_keys($invent_refined_dummy_array[$m],$invent_array[$value]);
							foreach ($j as $key1 => $value1) {
								
								$quantity+=$quant_refined_dummy_array[$m][$value1];

							}
							
							$timeline_array[$m][$invent_array[$value]]=$quantity;
						}
						else
						{
							$timeline_array[$m][$invent_array[$value]]=$quant_array[$value];
							array_push($invent_dummy_array1[$m], $invent_array[$value]);
						}
			}				
	}
	
		$key_array=array();
	array_push($key_array, "Date");
	for ($i=0; $i < sizeOf($topten_invent); $i++) { 
		array_push($key_array,$topten_invent[$i]);
	}

	for ($i=0; $i < sizeOf($date_refined_array); $i++) { 
			$final_timeline[$i]=array();
			$k=array_keys($timeline_array[$i]);
			array_push($final_timeline[$i], $date_refined_array[$i]);
			for ($j=0; $j < sizeOf($topten_invent); $j++) { 
				
				if(in_array($topten_invent[$j],$k))
				{
					//echo $i."=>".$timeline_array[$i][$topten_invent[$j]]."<br/>";
					//echo "hello"."<br/>";
					array_push($final_timeline[$i],$timeline_array[$i][$topten_invent[$j]]);
					//$p=$timeline_array[$i][$topten_invent[$j]];
				}
				else
				{
					//echo $final_timeline[$i][$topten_invent[$j]]=null;
					//echo "null"."<br/>";
					array_push($final_timeline[$i],0);
				}
			}
			
		}

		

		return $this->render('PractiseChartBundle:Page:timeline.html.twig',array('data_rows'=>json_encode($final_timeline),'data_cols'=>json_encode($key_array)));
	}

	public function packageAction(Request $request){

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
	$route_invent_shop=array();
	$task=new Task();
    $post = Request::createFromGlobals();
    
if ($post->request->has('submit')) {
        $selected_invent = $post->request->get('invent');
       	list($final_data,$route_invent_shop)=$task->refining($selected_invent);
		
    } else {
        $selected_invent = 'Not any inventory Selected';
    }


    
		
	  
        
        //var_dump($data);
        return $this->render('PractiseChartBundle:Page:package.html.twig', array('inventory_name'=>$selected_invent,'invent_refined_array'=>$invent_refined_array,'final_data'=>json_encode($final_data),'route_invent_shop'=>json_encode($route_invent_shop)));		

	}
	
	public function tableAction(){
		$string=file_get_contents('rosia_data.json');
		return $this->render('PractiseChartBundle:Page:table.html.twig',array('string'=>$string));
	}

	public function routeAction(){
		$string=file_get_contents('rosia_data.json') or die("File not found!");
		$data=json_decode($string,true);

	
		
		$shoproute_array=array_column($data,'shoproute');

		

		
		$shoproute_refined_array=array_values(array_unique($shoproute_array));
		sort($shoproute_refined_array);
		$post = Request::createFromGlobals();
		$final_array=array();
		$unique_route_name=array();
		$final_invent_route=array();
		$route= new Route();

		if ($post->request->has('submit')) {
        $selected_route = $post->request->get('route');
       	list($final_array,$unique_route_name,$final_invent_route)=$route->route_data($selected_route);
		
    	} else {
        $selected_route = 'Not any inventory Selected';
    	}
		


		return $this->render('PractiseChartBundle:Page:route.html.twig',array('route_refined'=>$shoproute_refined_array,'route_name'=>$selected_route,'final_array'=>json_encode($final_array),'unique_selected_invent_route'=>json_encode($unique_route_name),'final_invent_route'=>json_encode($final_invent_route)));
	}
	
}

?>