<?php

require_once("fpdf186/fpdf.php");
require_once('includes/connecttodb.php');

$sqlquery="SELECT * FROM brgy_officials";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();

$results=$stmt->fetchAll(PDO::FETCH_ASSOC); 
$pdo=null;

$officialname=[];
$officialposition=[];

foreach($results as $officials){    

    $officialname[]=$officials['official_name'];
}

// Footer function
class MyPDF extends FPDF {
    function Footer() {
        $this->SetY(-18); 
        $this->SetFont('Cambria', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 10, 'Cielito Homes Subd., Camarin, Lungsod ng Caloocan, M.M.', 0, 0, 'C');

        
        $this->SetY(-12); // set the y position of the footer
        $this->SetFont('Cambria', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 10, 'Tel. No. 8364-7073 / Mobile No. 0999-403-1692 E-mail Add,: 177Barangay@gmail.com', 0, 0, 'C');
    }
}

//Set the Paper Size and Add the page
global $pdf;

$pdf = new MyPDF ('P', 'mm', "Letter");
$pdf -> AddPage();

$fname="";
$mname="";
$lname="";
$suffix="";


//Include the Logos Here
$pdf -> Image('img/BagongPinas.jpeg', 5,10,25,25);

$pdf -> Image('img/CaloocanCityLogo.png', 29,12,23,23);

$pdf -> Image('img/Brgy177.png', 170,12,23,23);

$pdf -> Image('img/watermark.png', -33,5,280,297,'PNG' );

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10); // set the margin bottom to 10 mm

//Header Text Here 
$pdf -> AddFont('OldEnglishTextMT', 'B', 'oldenglishtextmt.php'); 
$pdf -> SetFont('OldEnglishTextMT','B',17);
$text = 'Republic of the Philippines';
$w=$pdf->GetStringWidth($text);
$pdf -> SetX((216-$w)/2);
$pdf -> Cell($w, 8, $text, 0, 1, 'C');

$pdf -> AddFont('Rockwell', 'B', 'rockwell.php'); 
$pdf -> SetFont('Rockwell','B',17);
$text = 'BARANGAY 177, SONA 15, DISTRICT 1';
$w=$pdf->GetStringWidth($text);
$pdf -> SetX((216-$w)/2);
$pdf -> Cell($w, 8, $text, 0, 1, 'C');

$pdf -> AddFont('Cambria', 'B', 'cambria.php'); 
$pdf -> SetFont('Cambria','B',17);
$text = 'TANGGAPAN NG PUNONG BARANGAY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetX((216-$w)/2);
$pdf -> Cell($w, 8, $text, 0, 1, 'C');

//Draw Line for the separation   of header
$pdf -> SetLineWidth(0.5);
$pdf -> Line(1,40,220,40);
//Draw Line for the separation of Footer
$pdf -> SetLineWidth(0.5);
$pdf -> Line(1,260,220,260);
//Draw Line for the separation of Official List
$pdf -> SetLineWidth(0.5);
$pdf -> Line(70,40,70,260);

//For the Brgy Officials List
$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php');
$pdf -> SetFont('Bookman Old Style','U',13);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[0]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,48);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php');
$pdf -> SetFont('Bookman Old Style','',10);
$pdf->SetTextColor(79, 98, 40);
$text = 'PUNONG BARANGAY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,54);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$maxY = $pdf->GetY();

$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',21);
$pdf->SetTextColor(0, 0, 0);
$text = 'PAGPAPATUNAY NA MAHIRAP';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(110 + (140-70-$w)/2, max($maxY, 52));
$pdf -> Cell($w, 1, $text, 0, 1, 'C');

$pdf -> AddFont('Cambria', 'B', 'cambria.php'); 
$pdf -> SetFont('Cambria','B', 13);
$pdf->SetTextColor(0, 0, 0);
$text = 'SA KINAUUKULAN:';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(80 + (130-102-$w)/2, max($maxY, 77));
$pdf -> Cell($w, 1, $text, 0, 1, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'BARANGAY KAGAWAD:';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,68);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD.'.' '. strtoupper($officialname[1]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,82);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php'); 
$pdf -> SetFont('Cambria','',13);
$pdf->SetTextColor(0, 0, 0);
$text = 'Sa pamamagitan nito ay pinapatunayan ng tanggapang ito';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(78 + (200-70-$w)/2, max($maxY, 82));
$pdf -> Cell($w, 10, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',10);
$pdf -> SetXY(120 + (130-70-$w)/2, max($maxY, 79));
$text = boldtext( $fname ." ". substr($mname, 0,1)."."." " .$lname. " " . $suffix.".");
$pdf -> Cell(50, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(100 + (200-70-$w)/2, max($maxY, 82));
$text2 = "na si ROBERT L. SALAS, nakatira  sa";
$pdf -> Cell($w, 24, wrapText($pdf,$text2,130), 0, 'L');



function boldtext($text){
    global $pdf;
    $pdf -> AddFont('Cambria', '', 'cambria.php');
    $pdf -> SetFont('Cambria','B',16);
    $text = wrapText($pdf,$text,130);
    return $text;
}


$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',13);
$pdf -> SetXY(100 + (180-70-$w)/2, max($maxY, 89));
$text = '4779 Genesis St., Cielito Homes, Camarin,';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(120 + (195-70-$w)/2, max($maxY, 96));
$text = 'Caloocan City.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php');
$pdf -> SetFont('Bookman Old Style','U',9);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[2]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,92);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php');
$pdf -> SetFont('Bookman Old Style','U',10);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. " . strtoupper($officialname[3]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,102);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php');
$pdf -> SetFont('Bookman Old Style','U',10);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[4]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2, 111);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',13);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(80 + (140-80-$w)/2, max($maxY, 102));
$text = 'ay nabibilang sa mahihirap na mamamayan dito sa aming';
$pdf -> MultiCell(140, 24, wrapText($pdf,$text,130), 0, 'J');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',13);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(110 + (160-80-$w)/2, max($maxY, 108));
$text = 'nasasakupan.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(60 + (173-80-$w)/2, max($maxY, 119));
$text = 'Ang pagpapatunay na ito ay ipinagkaloob upang magamit na';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',13);
$pdf -> SetXY(60 + (240-120-$w)/2, max($maxY, 125));
$text = 'basehan upang siya ay makahingi ng tulong na';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',13);
$pdf -> SetXY(77 + (230-140-$w)/2, max($maxY, 132));
$text = 'MEDICAL ASSISTANCE mula sa tanggapan ng';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', 'BU', 'cambria.php');
$pdf -> SetFont('Cambria','BU',13);
$pdf -> SetXY(75 + (230-80-$w)/2, max($maxY, 138));
$text = 'MALASAKIT CENTER.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[5]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,120);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[6]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,129);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[7]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,138);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(76 + (180-100-$w)/2, max($maxY, 155));
$text = 'Ipinagkaloob ngayong ika-29 ng Pebrero, 2024 sa tanggapan';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(74 + (175-100-$w)/2, max($maxY, 161));
$text = 'ng Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(100 + (190-80-$w)/2, max($maxY, 166));
$text = 'ng Caloocan.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[8]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,150);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'SK-CHAIRPERSON';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,155);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[9]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,163);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'BARANGAY-SECRETARY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,167);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[10]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,175);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', '', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'TREASURER';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,180);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',8);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetXY(166, 220);
$text = 'NOT VAILD WITHOUT DRY SEAL';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'R');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',11);
$pdf->SetTextColor(255, 0, 0);
$pdf -> SetXY(165, 225);
$text = 'VAILD FOR (3 MONTHS) ';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',8);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetXY(169, 230);
$text = 'FROM THE DATE ISSUED.';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'C');

$pdf -> Cell(59, 10, '',0,1);

$pdf -> Output();

function wrapText($pdf,$text,$maxWidth){

   $textWidth = $pdf->GetStringWidth($text);
   while($textWidth>$maxWidth){
        $text =substr($text, 0, -1);
        $textWidth = $pdf->GetStringWidth($text);

   }
   return $text;
}


?>