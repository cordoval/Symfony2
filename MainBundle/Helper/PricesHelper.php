<?php 
namespace PHRentals\MainBundle\Helper;

use Doctrine\ORM\EntityManager;

class PricesHelper {

    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function findSeasonFactor(\DateTime $dateMiddle) {
        
    	
    	$seasonDates = $this->entityManager->getRepository('PHRentalsMainBundle:Settings')->findSeasonDates();
    	$found = '';
    	
    	foreach($seasonDates as $key => $season) {
    		
    		foreach($season as $pair) {
    			
    			// is $dateFrom between dates?
    			$year = $dateMiddle->format('Y');
    			$from = date_create_from_format('j F Y', $pair['from'].' '.$year);
    			$to = date_create_from_format('j F Y', $pair['to'].' '.$year);
    			
    			
    			if ($dateMiddle >= $from && $dateMiddle <= $to) {
    				$found = $key;
    			}
    			
    			/*
    			// is $dateTo between dates?
    			$year = $dateTo->format('Y');
    			$from = date_create_from_format('j F Y', $pair['from'].' '.$year);
    			$to = date_create_from_format('j F Y', $pair['to'].' '.$year);
    			*/

    			//print($key.' '. $from->format('Y-m-d').' - '.$to->format('Y-m-d').' / '.$dateMiddle->format('Y-m-d').' '.$found.'<br>');
    			
    		}
    		
    	}
    	$found = str_replace("SeasonDates", "", $found);
    	return $found;
    }
    
    public function findDeposit ($total) {
    	
    	$percent = $this->entityManager->getRepository('PHRentalsMainBundle:Settings')->getValueByKey('deposit');
    	
    	return round($total*$percent/100/100)*100;
    }
    
    public function noToWords2($no)
    {
    	$words = array('0'=> '' ,'1'=> 'One' ,'2'=> 'Two' ,'3' => 'Three','4' => 'Four','5' => 'Five','6' => 'Six','7' => 'Seven','8' => 'Eight','9' => 'Nine','10' => 'Ten','11' => 'Eleven','12' => 'Twelve','13' => 'Thirteen','14' => 'Fourteen','15' => 'Fifteen','16' => 'Sixteen','17' => 'Seventeen','18' => 'Eighteen','19' => 'Nineteen','20' => 'Twenty','30' => 'Thirty','40' => 'Fourty','50' => 'Fifty','60' => 'Sixty','70' => 'Seventy','80' => 'Eighty','90' => 'Ninety','100' => 'Hundred','1000' => 'Thousand', '100000' => 'Hundred Thousand','10000000' => 'Million');
    	
    	if($no == 0)
    		return ' ';
    	else {           
    		$novalue='';
    		$highno=$no;
    		$remainno=0;
    		$value=100;
    		$value1=1000;
    	while($no>=100)    {
    		if(($value <= $no) &&($no  < $value1))    {
    			$novalue=$words["$value"];
    			$highno = (int)($no/$value);
    			$remainno = $no % $value;
    			break;
    		}
    		$value= $value1;
    		$value1 = $value * 100;
    	}
    	if(array_key_exists("$highno",$words))
    		return $words["$highno"]." ".$novalue." ".$this->noToWords($remainno);
    	else {
    		$unit=$highno%10;
    		$ten =(int)($highno/10)*10;
    		return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->noToWords($remainno);
    	}
    	}
    }
    
    public function noToWords( $number ){
	    $hyphen      = '-';
	    $conjunction = ' and ';
	    $separator   = ', ';
	    $negative    = 'negative ';
	    $decimal     = ' point ';
	    $dictionary  = array(
	        0                   => 'Zero',
	        1                   => 'One',
	        2                   => 'Two',
	        3                   => 'Three',
	        4                   => 'Four',
	        5                   => 'Five',
	        6                   => 'Six',
	        7                   => 'Seven',
	        8                   => 'Eight',
	        9                   => 'Nine',
	        10                  => 'Ten',
	        11                  => 'Eleven',
	        12                  => 'Twelve',
	        13                  => 'Thirteen',
	        14                  => 'Fourteen',
	        15                  => 'Fifteen',
	        16                  => 'Sixteen',
	        17                  => 'Seventeen',
	        18                  => 'Eighteen',
	        19                  => 'Nineteen',
	        20                  => 'Twenty',
	        30                  => 'Thirty',
	        40                  => 'Fourty',
	        50                  => 'Fifty',
	        60                  => 'Sixty',
	        70                  => 'Seventy',
	        80                  => 'Eighty',
	        90                  => 'Ninety',
	        100                 => 'Hundred',
	        1000                => 'Thousand',
	        1000000             => 'Million',
	        1000000000          => 'Billion',
	        1000000000000       => 'Trillion',
	        1000000000000000    => 'Quadrillion',
	        1000000000000000000 => 'Quintillion'    	
	    		
	    );
	    
	    if (!is_numeric($number)) {
	        return false;
	    }
	    
	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
	        // overflow
	        trigger_error(
	            'noToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
	            E_USER_WARNING
	        );
	        return false;
	    }
	
	    if ($number < 0) {
	        return $negative . $this->noToWords(abs($number));
	    }
	    
	    $string = $fraction = null;
	    
	    if (strpos($number, '.') !== false) {
	        list($number, $fraction) = explode('.', $number);
	    }
	    
	    switch (true) {
	        case $number < 21:
	            $string = $dictionary[$number];
	            break;
	        case $number < 100:
	            $tens   = ((int) ($number / 10)) * 10;
	            $units  = $number % 10;
	            $string = $dictionary[$tens];
	            if ($units) {
	                $string .= $hyphen . $dictionary[$units];
	            }
	            break;
	        case $number < 1000:
	            $hundreds  = $number / 100;
	            $remainder = $number % 100;
	            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
	            if ($remainder) {
	                $string .= $conjunction . $this->noToWords($remainder);
	            }
	            break;
	        default:
	            $baseUnit = pow(1000, floor(log($number, 1000)));
	            $numBaseUnits = (int) ($number / $baseUnit);
	            $remainder = $number % $baseUnit;
	            $string = $this->noToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
	            if ($remainder) {
	                $string .= $remainder < 100 ? $conjunction : $separator;
	                $string .= $this->noToWords($remainder);
	            }
	            break;
	    }
	    
	    if (null !== $fraction && is_numeric($fraction)) {
	        $string .= $decimal;
	        $words = array();
	        foreach (str_split((string) $fraction) as $number) {
	            $words[] = $dictionary[$number];
	        }
	        $string .= implode(' ', $words);
	    }
	    
	    return $string;
	}
	
	public function ordinalSuffix($num) {
		$suffixes = array("st", "nd", "rd");
		$lastDigit = $num % 10;
	
		if(($num < 20 && $num > 9) || $lastDigit == 0 || $lastDigit > 3) return "th";
	
		return $suffixes[$lastDigit - 1];
	}
    
    
}