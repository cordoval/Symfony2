<?php
namespace PHRentals\MainBundle\Controller;

class PDF extends \Fpdf_Fpdf
{
	 
	// Page footer
	function Footer()
	{
		global $pdf_footer;
		
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		$this->SetX(60);
		// Times italic 8
		$this->SetFont('Times','',9);
		// Page number
		$this->Cell(0,10,$pdf_footer,0,0,'C');
		
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		$this->SetX(198);
		$this->SetFont('Times','I',11);
		//Page number
		$this->Cell(10,10,$this->PageNo().'/{nb}',0,0,'R');
		
	}
	
	// Page header
	function Header()
	{
		global $header;
		global $path;
		global $head_title;
		global $head_address;
		global $other_title;
		global $other_address;
		
		$this->SetY(5);
		//$this->SetX(60);
		$this->Cell(150);
		$this->SetFont('Times','',11);
		//$this->Cell(0,10,$header,0,0,'C');
		$this->Cell(44,5,$header,0,0,'R');
		
		// LEFT COLUMN
		$this->SetLineWidth(0.5);
		$this->SetDrawColor(30,28,91);
		$this->Line( 50, 0, 50, 500 );
		
		// Logo
		$this->Image($path.'/img/logo_pdf.jpg',8,25,35);
		// Times bold 15
		$this->SetFont('Copperplate Gothic Bold','',10);
		// Move to the right
		$this->Ln(67);
		
		
		//$left = "Head Office";
		$this->MultiCell(0,5,$head_title);
		
		$this->SetFont('Copperplate Gothic Light','',8);
		$left = "Young Place
118/46, Soi 23
Sukhumvit Road
Wattana, Bangkok
Thailand, 10110
Tel: 662 662 8062-3
Fax: 662 662 0091
";
		$this->MultiCell(0,5,$head_address);
		$this->Ln(10);
		$this->SetFont('Copperplate Gothic Bold','',9);
		$left = "Pattaya Office";
		$this->MultiCell(0,5,$other_title);
		
		$this->SetFont('Copperplate Gothic Light','',8);
		$left = "View Talay 4
489/2, Soi 5
Jomtien, Pattaya
Thailand, 20150
Tel: 6638 059 635
Fax: 6638 059 636";
		$this->MultiCell(0,5,$other_address);
		
		$this->SetY(25);
		$this->Cell(70);
		
	}
}
?>