<?php

namespace Rosia\ChartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$string=file_get_contents('rosia_data.json') or die("File not found!");
		$data=json_decode($string,true);
		$invent_array=array_column($data,'inventory');
		$invent_refined_array=array_values(array_unique($invent_array));
		sort($invent_refined_array);

        $builder->add('inventory','choice',array('choices'=>$invent_refined_array));
   
    }

    public function getName()
    {
        return 'contact';
    }
}
?>