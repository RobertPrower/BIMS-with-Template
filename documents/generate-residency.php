<?php

require_once("fpdf186/fpdf.php");
include_once('../includes/connecttodb.php');

$sqlquery="SELECT * FROM brgy_officials";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();
$results=$stmt->fetchAll(PDO::FETCH_ASSOC); 

$nowdate= date("Y-m-d H:i:s"); //Get the date now
$nowtime = time(); //Get the time now
$fileName = "certificate_of_residency/"."generated_pdf_" . time() . ".pdf";
$username = null;
$issuingdeptno = null;
$residentsince=$_POST['r_since'];
$completeaddress=utf8_decode($_POST['address']);
$fname=utf8_decode($_POST['firstname']);
$mname=utf8_decode($_POST['middlename']);
$lname=utf8_decode($_POST['lastname']);

if(isset($_POST['suffix'])){
    $suffix=$_POST['suffix'];
}else{
    $suffix="";
}
$presentedid=$_POST['presented_id'];
$purpose=$_POST['purpose'];
$residentno=($_POST['resident_no']);
$IDnumber=$_POST['IDnum'];

$sqlquery2 = "CALL determine_docu_type('Certificate_of_Residency'); 
            INSERT INTO tbl_cert_audit_trail(issuing_dept_no, date_issued, expiration, time_issued)
            VALUES (?,?,DATE_ADD(CURDATE(), INTERVAL 3 MONTH), CURTIME())";
$stmt2=$pdo->prepare($sqlquery2);
$stmt2->execute([$issuingdeptno, $nowdate]);
// Close the cursor of the previous statement
$stmt2->closeCursor();

$sqlquery3="SELECT * FROM `certificate-img`";
$stmt3=$pdo->prepare($sqlquery3);
$stmt3->execute();
$results3=$stmt3->fetchAll(PDO::FETCH_ASSOC); 

$sqlquery4 = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile) 
            VALUES (:residentno,:presentedid, :IDnumber, :purpose, :filenames);";
$alldatatorequest = [
    ':residentno' => $residentno,
    ':presentedid' => $presentedid,
    ':IDnumber' => $IDnumber,
    ':purpose' => $purpose,
    ':filenames' => $fileName
];
$stmt3 = $pdo->prepare($sqlquery4);
$stmt3->execute($alldatatorequest);


$request_id = $pdo->lastInsertId();

$sqlquery5="SELECT age FROM tbl_docu_request WHERE request_id = ?";
$stmt5=$pdo->prepare($sqlquery5);
$stmt5->execute([$request_id]);
$AgeResult= $stmt5->fetchAll();
$Age=$AgeResult;

//Close the Database Connection
$pdo=null;

$officialname=[];

foreach($results as $officials){    

    $officialname[]=$officials['official_name'];
}

$logo=[];

foreach($results3 as $filename){
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
$pdf -> Image('../img/'.$logo[2], 5,10,25,25);

$pdf -> Image('../img/'.$logo[0], 29,12,23,23);

$pdf -> Image('../img/'.$logo[1], 170,12,23,23);

$pdf -> Image('../img/'.$logo[3], -33,5,280,297);

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

//Draw Line for the separation of header
$pdf -> SetLineWidth(0.5);
$pdf -> Line(1,40,220,40);
//Draw Line for the separation of Footer
$pdf -> SetLineWidth(0.5);
$pdf -> Line(1,260,220,260);
//Draw Line for the separation of Official List
$pdf -> SetLineWidth(0.5);
$pdf -> Line(70,40,70,260);

//For the Brgy Officials List
$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php');
$pdf -> SetFont('Bookman Old Style Bold','U',13);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[0]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,48);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php');
$pdf -> SetFont('Bookman Old Style Bold','',10);
$pdf->SetTextColor(79, 98, 40);
$text = 'PUNONG BARANGAY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,54);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$maxY = $pdf->GetY();

$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',25);
$pdf->SetTextColor(0, 0, 0);
$text = 'CERTIFICATION';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(110 + (135-70-$w)/2, max($maxY, 50));
$pdf -> Cell($w, 1, $text, 0, 1, 'C');

$pdf -> AddFont('Bookman Old Style Bold', 'B', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','B',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'BARANGAY KAGAWAD:';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,68);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD.'.' '. strtoupper($officialname[1]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,82);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php'); 
$pdf -> SetFont('Cambria','B',14);
$pdf->SetTextColor(0, 0, 0);
$text = 'To whom it may concern: ';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(70 + (130-70-$w)/2, max($maxY, 72));
$pdf -> Cell($w, 10, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria Bold', 'B', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','B',14);
$pdf -> SetXY(120 + (130-70-$w)/2, max($maxY, 79));
$text = $fname ." ". substr($mname, 0,1)."."." " .$lname. " " . "$suffix";
$pdf -> Cell(50, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> SetFont('Cambria','',12);
$pdf -> SetXY(80 + (130-70-$w)/2, max($maxY, 80));
$text2 = "This is to certify that ";
$pdf -> Cell($w, 24, wrapText($pdf,$text2,130), 0, 'L');



function boldtext($text){
    global $pdf;
    $pdf -> AddFont('Cambria', '', 'cambria.php');
    $pdf -> SetFont('Cambria','B',16);
    $text = wrapText($pdf,$text,130);
    return $text;
}


$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(90 + (130-70-$w)/2, max($maxY, 87));
$text = 'is a bonafide resident of this barangay located at ';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold Bold', '', 'BookmanOldStyleBold.php');
$pdf -> SetFont('Bookman Old Style Bold Bold','U',9);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[2]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,92);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php');
$pdf -> SetFont('Bookman Old Style Bold','U',10);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. " . strtoupper($officialname[3]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,102);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php');
$pdf -> SetFont('Bookman Old Style Bold','U',10);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[4]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2, 111);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria Bold', 'B', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(70 + (150-80-$w)/2, max($maxY, 95));
$text = $completeaddress;
$pdf -> MultiCell(140, 24, wrapText($pdf,$text,130), 0, 'J');

$pdf -> AddFont('Cambria Bold', 'B', 'cambriabold.php');
$pdf -> SetFont('Cambria Bold','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(105 + (150-80-$w)/2, max($maxY, 102));
$text = 'SINCE '.$residentsince.' UP TO PRESENT.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(30 + (225-80-$w)/2, max($maxY, 110));
$text = 'This certification is being issued upon the request of the above-';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(60 + (230-80-$w)/2, max($maxY, 115));
$text = 'mentioned name for';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',25);
$pdf->SetTextColor(0, 0, 0);
$text = 'PROOF OF RESIDENCY.';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(110 + (130-70-$w)/2, max($maxY, 150));
$pdf -> Cell($w, 1, $text, 0, 1, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[5]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,120);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[6]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,129);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = "KGD. ". strtoupper($officialname[7]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,138);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetXY(30 + (255-100-$w)/2, max($maxY, 165));
$text = 'Given this '. date('d').'th day of '.date('F Y').' at Barangay 177, Cielito';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',12);
$pdf -> SetXY(30 + (285-100-$w)/2, max($maxY, 170));
$text = 'Homes Subdivision, Camarin, Caloocan City.';
$pdf -> Cell($w, 24, wrapText($pdf,$text,130), 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[8]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,150);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'SK-CHAIRPERSON';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,155);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[9]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,163);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'BARANGAY-SECRETARY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,167);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','U',11);
$pdf->SetTextColor(79, 98, 40);
$text = strtoupper($officialname[10]);
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,175);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style Bold', '', 'BookmanOldStyleBold.php'); 
$pdf -> SetFont('Bookman Old Style Bold','',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'TREASURER';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,180);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',8);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetXY(140, 205);
$text = 'NOT VAILD WITHOUT DRY SEAL';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'R');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',11);
$pdf->SetTextColor(255, 0, 0);
$pdf -> SetXY(140, 210);
$text = 'VAILD FOR (3 MONTHS) ';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'C');

$pdf -> AddFont('Cambria', '', 'cambria.php');
$pdf -> SetFont('Cambria','B',8);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetXY(145, 215);
$text = 'FROM THE DATE ISSUED';
$pdf -> Cell($w, 22, wrapText($pdf,$text,160), 0, 'C');

$pdf -> Cell(59, 10, '',0,1);

// Output the PDF (save it temporarily)
$pdf->Output('F', $fileName); 

// Return the file URL as a response
echo json_encode(['file' => $fileName]);
exit();


function wrapText($pdf,$text,$maxWidth){

   $textWidth = $pdf->GetStringWidth($text);
   while($textWidth>$maxWidth){
        $text =substr($text, 0, -1);
        $textWidth = $pdf->GetStringWidth($text);

   }
   return $text;
}




?>