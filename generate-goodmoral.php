<?php

require_once("fpdf186/fpdf.php");

require_once('includes/connecttodb.php');

//To fetch the Brgy Officials
$sqlquery="SELECT * FROM brgy_officials";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();

$results=$stmt->fetchAll(PDO::FETCH_ASSOC); 

//Declare the variables will be used in the document
$residentno=($_POST['resident_no']);
$fname=utf8_decode($_POST['firstname']);
$mname=utf8_decode($_POST['middlename']);
$lname=utf8_decode($_POST['lastname']);
if(isset($_POST['suffix'])){
    $suffix=$_POST['suffix'];
}else{
    $suffix="";
}
$documentdesc='Certificate of Good Moral';
$nowdate= date("Y-m-d H:i:s");
$completeaddress=utf8_decode($_POST['address']);
$presentedid=$_POST['presented_id'];
$IDnumber=$_POST['IDnum'];
$purpose=$_POST['purpose'];
$residentsince=$_POST['r_since'];
$docurequestdata=[$residentno];

//Insert Certificate Description to tbl_documents
$sqlquery2="INSERT INTO tbl_documents (document_desc) VALUES(?)";
$stmt2=$pdo->prepare($sqlquery2);
$stmt2->execute([$documentdesc]);

//Insert the person details regarding the certificate
$sqlquery3 = "INSERT INTO tbl_docu_request (resident_no, document_no, date_requested, presented_id, IDnumber, purpose)
              SELECT :residentno, MAX(document_id), :nowdate, :presentedid, :IDnumber, :purpose
              FROM tbl_documents";
$alldatatorequest = [
    ':residentno' => $residentno,
    ':nowdate' => $nowdate,
    ':presentedid' => $presentedid,
    ':IDnumber' => $IDnumber,
    ':purpose' => $purpose
];
$stmt3 = $pdo->prepare($sqlquery3);
$stmt3->execute($alldatatorequest);

//Fetch the certificate images
$sqlquery4="SELECT * FROM `certificate-img`";
$stmt4=$pdo->prepare($sqlquery4);
$stmt4->execute();

$results4=$stmt4->fetchAll(PDO::FETCH_ASSOC); 

//Fetch the age from the SQL trigger result
$request_id = $pdo->lastInsertId();

$sqlquery5="SELECT age FROM tbl_docu_request WHERE request_id = ?";
$stmt5=$pdo->prepare($sqlquery5);
$stmt5->execute([$request_id]);
$AgeResult= $stmt5->fetchAll();
$Age=$AgeResult;
$pdo=null;

//Put the Official Name in Array
$officialname=[];

foreach($results as $officials){    

    $officialname[]=$officials['official_name'];
}

//Put logos in array for display
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
$pdf -> SetFont('Cambria','BU',25);
$pdf->SetTextColor(0, 0, 0);
$text = 'CERTIFICATE OF';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(110 + (135-70-$w)/2, max($maxY, 60));
$pdf -> Cell($w, 1, $text, 0, 1, 'C');

$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',25);
$pdf->SetTextColor(0, 0, 0);
$text = 'GOOD MORAL';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(120 + (148-102-$w)/2, max($maxY, 70));
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
$pdf -> SetFont('Cambria','B',12);
$pdf->SetTextColor(0, 0, 0);
$text = 'This is to certify that ,';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(60 + (185-70-$w)/2, max($maxY, 97));
$pdf -> Cell($w, 10, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria Bold', '', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','',14);
$pdf -> SetXY(130 + (130-70-$w)/2, max($maxY, 90));
$text = $fname ." ". substr($mname, 0,1)."."." " .$lname. " " . $suffix;
$pdf -> Cell(50, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> SetFont('Cambria','',12);
$pdf -> SetXY(70 + (130-70-$w)/2, max($maxY, 98));
$text2 = "of legal age, is a bonafide resident of this barangay, with postal";
$pdf -> Cell($w, 24, wrapText($pdf,$text2,130), 0, 'L');


$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(60 + (145-70-$w)/2, max($maxY, 104));
$text = 'address located at';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');


$pdf -> AddFont('Cambria Bold', '', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','',12);
$pdf -> SetXY(95 + (145-70-$w)/2, max($maxY, 104));
$text = "Blk 8 Lot 4 Jeremiah st Cielito Homes";
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

$pdf -> AddFont('Cambria', 'B', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(70 + (165-80-$w)/2, max($maxY, 118));
$text = 'This further certifies that';
$pdf -> MultiCell(140, 24, wrapText($pdf,$text,130), 0, 'J');

$pdf -> AddFont('Cambria Bold', '', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','',14);
$pdf -> SetXY(118 + (165-80-$w)/2, max($maxY, 118));
$text = $fname ." ". substr($mname, 0,1)."."." " .$lname. " " . $suffix;
$pdf -> Cell(50, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', 'B', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(110 + (70-80-$w)/2, max($maxY, 124));
$text = 'is known to be to be of good moral character, a law-abiding citizen';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(38 + (215-80-$w)/2, max($maxY, 130));
$text = ' and has no derogatory record in our barangay.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(60 + (240-120-$w)/2, max($maxY, 142));
$text = 'This certification is being issued upon the request of';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(60 + (230-140-$w)/2, max($maxY, 148));
$text = 'the above-mentioned name for';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria Bold', '', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','',14);
$pdf -> SetXY(120 + (230-140-$w)/2, max($maxY, 148));
$text = $purpose;
$pdf -> Cell(50, 24, wrapText($pdf,$text,130), 0, 'C');

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
$pdf -> SetXY(30 + (288-100-$w)/2, max($maxY, 160));
$text = 'Issued this'.' '. date('d').'th day of '.date('F Y').' '.'at Barangay 177';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(40 + (265-100-$w)/2, max($maxY, 166));
$text = 'Cielito Homes Subdivision, Camarin, Caloocan City.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

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

$pdf -> AddFont('Cambria', 'BI', 'cambria.php');
$pdf -> SetFont('Cambria','BI',8);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetXY(156, 220);
$text = 'NOT VAILD WITHOUT DRY SEAL';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'R');

$pdf -> AddFont('Cambria', 'BI', 'cambria.php');
$pdf -> SetFont('Cambria','BI',11);
$pdf->SetTextColor(255, 0, 0);
$pdf -> SetXY(156, 225);
$text = 'VAILD FOR (3 MONTHS) ';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'C');

$pdf -> AddFont('Cambria', 'BI', 'cambria.php');
$pdf -> SetFont('Cambria','BI',8);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetXY(162, 230);
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