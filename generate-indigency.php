<?php

require_once("fpdf186/fpdf.php");
require_once('includes/connecttodb.php');

global $pdo;

$sqlquery="SELECT * FROM brgy_officials";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();

$results=$stmt->fetchAll(PDO::FETCH_ASSOC); 

$residentno=($_POST['resident_no']);
$fname=utf8_decode($_POST['firstname']);
$mname=utf8_decode($_POST['middlename']);
$lname=utf8_decode($_POST['lastname']);
if(isset($_POST['suffix'])){
    $suffix=$_POST['suffix'];
}else{
    $suffix="";
}
$documentdesc='Certificate of Residency';
$nowdate= date("Y-m-d H:i:s");
$completeaddress=utf8_decode($_POST['address']);
$presentedid=$_POST['presented_id'];
$IDnumber=$_POST['IDnum'];
$purpose=$_POST['purpose'];
$agency=$_POST['agency'];
$residentsince=$_POST['r_since'];
$docurequestdata=[$residentno, ];

$sqlquery="SELECT TIMESTAMPDIFF(YEAR, `birth_date`, NOW()) AS Age FROM resident WHERE resident_id=?";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute([$residentno]);
$AgeResult= $stmt->fetchAll();
$Age=$AgeResult[0]['Age'];

$sqlquery2="INSERT INTO `tbl-documents`(`document-desc`, age) VALUES(?,?)";
$stmt2=$pdo->prepare($sqlquery2);
$stmt2->execute([$documentdesc, $Age]);

$sqlquery3 = "INSERT INTO `tbl_docu_request` (`resident-no`, `document-no`, `date_requested`, `presented_id`, `IDnumber`, `purpose`)
              SELECT :residentno, MAX(`document-id`), :nowdate, :presentedid, :IDnumber, :purpose
              FROM `tbl-documents`";
$alldatatorequest = [
    ':residentno' => $residentno,
    ':nowdate' => $nowdate,
    ':presentedid' => $presentedid,
    ':IDnumber' => $IDnumber,
    ':purpose' => $purpose
];
$stmt3 = $pdo->prepare($sqlquery3);
$stmt3->execute($alldatatorequest);


$sqlquery4="SELECT * FROM `certificate-img`";
$stmt4=$pdo->prepare($sqlquery4);
$stmt4->execute();

$results4=$stmt4->fetchAll(PDO::FETCH_ASSOC); 



$pdo=null;

$officialname=[];

foreach($results as $officials){    

    $officialname[]=$officials['official_name'];
}

$logo=[];

foreach($results4 as $filename){
    $logo[]=$filename['filename'];
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


//Include the Logos Here
$pdf -> Image('img/'.$logo[2], 5,10,25,25);

$pdf -> Image('img/'.$logo[0], 29,12,23,23);

$pdf -> Image('img/'.$logo[1], 170,12,23,23);

$pdf -> Image('img/'.$logo[3], -33,5,280,297);

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

$pdf -> AddFont('Cambria Bold', '', 'cambriabold.php'); 
$pdf -> SetFont('Cambria Bold','', 13);
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

$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(80 + (200-70-$w)/2, max($maxY, 82));
$text2 = "na si";
$pdf -> Cell($w, 24, wrapText($pdf,$text2,130), 0, 'L');

$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(160 + (200-70-$w)/2, max($maxY, 82));
$text2 = ", nakatira  sa";
$pdf -> Cell($w, 24, wrapText($pdf,$text2,130), 0, 'L');

$pdf -> AddFont('Cambria Bold', 'B', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','B',14);
$pdf -> SetXY(95 + (200-70-$w)/2, max($maxY, 82));
$text = $fname ." ". substr($mname, 0,1)."."." " .$lname. " " . $suffix;
$pdf -> Cell(50, 24, wrapText($pdf,$text,130), 0, 'C');


$pdf -> AddFont('Cambria Bold', '', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','B',13);
$pdf -> SetXY(90 + (180-70-$w)/2, max($maxY, 89));
$text = wordwrap($completeaddress, 100, "<br>\n");
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

$pdf -> AddFont('Cambria  Bold', '', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','B',13);
$pdf -> SetXY(77 + (230-140-$w)/2, max($maxY, 132));
$text = strtoupper($purpose);
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> SetFont('Cambria','',13);
$pdf -> SetXY(110 + (200-70-$w)/2, max($maxY, 132));
$text2 = " mula sa tanggapan ng";
$pdf -> Cell($w, 24, wrapText($pdf,$text2,130), 0, 'L');

$pdf -> AddFont('Cambria Bold', 'BU', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','BU',13);
$pdf -> SetXY(75 + (230-80-$w)/2, max($maxY, 138));
$text = strtoupper($agency);
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
$text = 'Ipinagkaloob ngayong ika-'.date('d').' ng '. date('F Y').' sa tanggapan';
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