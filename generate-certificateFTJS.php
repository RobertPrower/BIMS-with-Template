<?php

require_once("fpdf186/fpdf.php");
require_once('includes/connecttodb.php');

$sqlquery="SELECT * FROM brgy_officials";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();

$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

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

$pdf = new MyPDF ('P', 'mm', "A4");
$pdf -> AddPage();

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
// $agency=$_POST['agency'];
$residentsince=$_POST['r_since'];
$docurequestdata=[$residentno, ];

$sqlquery4="SELECT * FROM `certificate-img`";
$stmt4=$pdo->prepare($sqlquery4);
$stmt4->execute();
$results4=$stmt4->fetchAll(PDO::FETCH_ASSOC); 

$logo=[];

foreach($results4 as $filename){
    $logo[]=$filename['filename'];
}

$pdo=null;


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
$pdf -> Line(1,280,220,280);


$maxY = $pdf->GetY();


$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',20);
$pdf->SetTextColor(0, 0, 0);
$text = 'CERTIFICATION';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(64 + (135-70-$w), max($maxY, 58));
$pdf -> Cell($w, 1, $text, 0, 1, 'L');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','',12);

// $text = 'I, ROSADEL, SANTOME,, 20 years of age, a resident of 9964 Parkland St., Maligaya Park Subd.,';
// $w = $pdf->GetStringWidth($text);
// $pdf -> SetXY(60 + (60-30-$w), max($maxY, 80));
// $pdf -> Cell($w, 10, $text, 0, 1, 'L');

$pdf -> AddFont('Cambria', 'B', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$text = '(First Time Jobseekers Assistance Act-RA 11261)';
$w = $pdf->GetStringWidth($text);
$pdf -> SetXY(60, max($maxY, 65));
$pdf -> Cell($w, 10, $text, 0, 1, 'L');

$text = 'Caloocan City, since 2003, availing the benefits of Republic Act 11261, otherwise known as the ';
$w = $pdf->GetStringWidth($text);
$pdf -> SetXY(25, max($maxY, 76));
$pdf -> Cell($w, 10, $text, 0, 1, 'L');

$text = 'First Time Jobseeker Act of 2019, do hereby declare agree and undertake to abide and be bound';
$w = $pdf->GetStringWidth($text);
$pdf -> SetXY(25, max($maxY, 82));
$pdf -> Cell($w, 10, $text, 0, 1, 'L');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(25 + (0-43-$w), max($maxY, 88));
$text = 'by the following:';
$pdf -> Cell($w, 10, wrapText($pdf,$text,50), 0, 'J');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 94));
$text = '1.   That this is the first time that I will actively look for a job, and therefore requesting that a';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 100));
$text = 'Barangay Certification be issued in my favor to avail the benefits of the law;';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 106));
$text = '2.   That I am aware that the benefit and privilege/s under the said law shall be valid only for';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 112));
$text = 'one (1) year from the date that the Barangay Certification is issued;';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 118));
$text = '3.   That I can avail the benefits of the law only once.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,150), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 124));
$text = '4.   That I understand that my personal information shall be included in the Roster/List of the';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 130));
$text = 'First Time Jobseeker and will not be used for any unlawful purpose;';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 136));
$text = '5.   That I will inform and/or report to the Barangay personally through text or other means,';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 142));
$text = 'or through my family/relatives once I get employed; and';
$pdf -> Cell($w, 24, wrapText($pdf,$text,180), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 148));
$text = '6.   That I am not a beneficiary of the Job start Program R.A. No. 10889 and other laws that';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 154));
$text = 'give me similar exemptions for the documents or transactions exempted under R.A. No. 11261.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 160));
$text = '7.   That if issued the requested Certification, I will not use the same in any fraud, neither';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 166));
$text = 'falsify nor help and or assist in the fabrication of the said certification.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 172));
$text = '8.   That this undertaking is made solely for the purpose of the obtaining a Barangay';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 178));
$text = 'Certification consistent with the objective of R.A. No.11261 and not for any other';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 184));
$text = '9.   That I consent to the use of my personal information pursuant to the Data Privacy Act and';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(44 + (20-70-$w), max($maxY, 190));
$text = 'other applicable laws, rules, and regulations.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,150), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 200));
$text = 'Signed this '.date('d').' of '. date('F Y').', at Barangay 177, Cielito Homes Subd, Camarin,';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 206));
$text = 'Caloocan City.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(60 + (120-70-$w), max($maxY, 218));
$text = $fname . ' ' . substr($mname, 0, 1) . ' '. $lname;
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php'); 
$pdf -> SetFont('Cambria','',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(60 + (120-70-$w), max($maxY, 224));
$text = 'First Time Jobseeker';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php'); 
$pdf -> SetFont('Cambria','',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 228));
$text = 'Witnessed by:';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> AddFont('Cambria', 'B', 'cambria.php'); 
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(38 + (20-70-$w), max($maxY, 243));
$text = 'HON. DONATA DE GANA-JARITO';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php'); 
$pdf -> SetFont('Cambria','',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(45 + (20-70-$w), max($maxY, 248));
$text = 'Barangay Chairperson';
$pdf -> Cell($w, 24, wrapText($pdf,$text,200), 0, 'C');


$pdf -> Cell(80, 10, '',0,1);

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