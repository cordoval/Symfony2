<?php
 
namespace PHRentals\MainBundle\Twig;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
 
class PHRentalsExtension extends \Twig_Extension
{

	public function getName()
	{
		return 'twigext';
	}
    
    public function getFilters() {
    	return array(
    			'var_dump'   => new \Twig_Filter_Function('var_dump'),
    			'file_ex'   => new \Twig_Filter_Function('file_exists'),
    			'round'   => new \Twig_Filter_Function('round'),
    			'arrondi'  => new \Twig_Filter_Method($this, 'arrondi'),
    			'price_format'  => new \Twig_Filter_Method($this, 'price'),
    			'nonewline'  => new \Twig_Filter_Method($this, 'nonewline'),
    			'clonedate'  => new \Twig_Filter_Method($this, 'clonedate'),
    	);
    }
    
    public function arrondi($number)
    {
    	return ceil($number)*100;
    } 
    
    public function price($number)
    {
    	$number = (double)$number;
    	if($number>=1000000) {
    		return round(($number/1000000), 2)."mil";
    	}
        if($number>=1000) {
    		return round(($number/1000), 2)."k";
    	}
    		return number_format($number);   
    }
    
    public function nonewline($text)
    {
    	$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';
		$text = str_replace($order, $replace, $text);
		$text = preg_replace('!\s+!m', ' ', $text);
		$text = str_replace("\\t",'',$text);
		
    	return $text;
    }
    
    public function clonedate($date)
    {  
    	return clone $date;
    }
    
}