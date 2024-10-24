<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');


// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date

// if($_SERVER['REQUEST_METHOD']== "POST"){

    $nowdate= date("Y-m-d H:i:s"); //Get the date now
    $nowtime = time(); //Get the time now
    $username = null;
    $issuingdeptno = null;

    // Define directory for saving the PDF
    $directory = "certificate_of_blotter/";
    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."generated_pdf_" . $nowtime . ".pdf";
    $filename= "generated_pdf_" . $nowtime . ".pdf";

    $residentno = (isset($_POST['residentno']))? $_POST['residentno']:null;
    $rsince=(isset($_POST['r_since']))? sanitizeData($_POST['r_since']): null;
    $completeaddress=(isset($_POST['address']))? sanitizeData(utf8_decode($_POST['address'])) : null;
    // $fname=sanitizeData(utf8_decode($_POST['first_name']));
    // $mname=sanitizeData(utf8_decode($_POST['middle_name']));
    // $lname=sanitizeData(utf8_decode($_POST['last_name']));

    $fname="Robert";
    $mname="Lumauig";
    $lname="Salas";

    $suffix = (isset($_POST['suffix']))? $suffix=$_POST['suffix']: null ;

    $fullname = $fname .' '. $mname .' '. $lname.' '. $suffix;

    // $presentedid=sanitizeData($_POST['presented_id']);
    // $IDnumber=sanitizeData($_POST['id_num']);
    // $purpose = sanitizeData($_POST['purpose']);

    // try{
    //     $pdo->beginTransaction();

        $brgyquery="SELECT * FROM brgy_officials";
        $brgystmt=$pdo->prepare($brgyquery);
        $brgystmt->execute();
        $brgyofficials=$brgystmt->fetchAll(PDO::FETCH_ASSOC); 
    
        foreach($brgyofficials as $officialname){
    
            $official[] = $officialname['official_name'];
    
        }
    
        //To fetch the logo from the databse
        $imgquery="SELECT `filename` FROM `certificate-img`";
        $imgstmt=$pdo->prepare($imgquery);
        $imgstmt->execute();
        $imglogo = $imgstmt->fetchAll(PDO::FETCH_ASSOC); 

        foreach($imglogo as $seallogo){
            $logo[] = $seallogo['filename']; // Collecting each filename
        }

        $brgydetailsquery = "SELECT * FROM brgy_details";
        $brgydetailstmt = $pdo->prepare($brgydetailsquery);
        $brgydetailstmt->execute();
        $brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC); 
    
        $callkagawadquery = "SELECT official_name FROM kagawad";
        $kagawadstmt=$pdo->prepare($callkagawadquery);
        $kagawadstmt->execute();
        $kagawad=$kagawadstmt->fetchAll(PDO::FETCH_ASSOC);
    
        // $docudetailsquery = "CALL determine_docu_type('Certificate_of_Residency')";
        // $docudetailstmt = $pdo->prepare($docudetailsquery);
        // $docudetailstmt->execute();
        // $docudetailstmt->closeCursor();
    
        // // Insert into tbl_cert_audit_trail
        // $auditTrailQuery = "INSERT INTO tbl_cert_audit_trail(issuing_dept_no, datetime_issued, expiration)
        //                     VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 3 MONTH))";
        // $auditTrailStmt = $pdo->prepare($auditTrailQuery);
        // $auditTrailStmt->execute([$issuingdeptno, $nowdate]);
    
        // // Insert into tbl_docu_request
        // $docuRequestQuery = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile)
        //                         VALUES (?, ?, ?, ?, ?)";
        // $docuRequestStmt = $pdo->prepare($docuRequestQuery);
        // $docuRequestStmt->execute([$residentno, $presentedid, $IDnumber, $purpose, $filename]);
    
        // Fetch the age and request_id
        $idquery = "SELECT request_id FROM tbl_docu_request WHERE request_id =(SELECT MAX(request_id) FROM tbl_docu_request)";
        $idstmt = $pdo->prepare($idquery);
        $idstmt->execute();
        $requestid=$idstmt->fetchColumn();

//         $pdo->commit();

//     }catch(Exception $errors){
//         $pdo->rollBack();
//         exit(json_encode(["error", $errors]));
//     }

//     $pdo=null;

// }else{
//     exit("Access Denied");
// }

class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {
        
    global $brgydetailsraw;

       foreach($brgydetailsraw as $brgydetails){
    
            $this->setXY(20,16);

            $title = '
            <style>
                .title{
                font-family: Rockwell;
                font-size: 18px;
                }
            </style>
            
            <strong class="title">'.strtoupper($brgydetails['brgy_name'].' '. $brgydetails['sona'].' '.$brgydetails['district']).'</strong>';

            $this->writeHTML($title, true, false, true, false, 'C');
       }
    }
    
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setCreator(PDF_CREATOR);
    $pdf->setTitle('Blotter Certificate');
    $pdf->setSubject('Blotter Certificate');
    $pdf->setKeywords('TCPDF, PDF, certificate, Blotters');

    // Set default header data
    $pdf->setHeaderData('','0','');
    
    // Set margins
    $pdf->setMargins(15, 40, 15);
    $pdf->setHeaderMargin(15);
    $pdf->setFooterMargin(20);

    // Set auto page breaks
    $pdf->setAutoPageBreak(TRUE, 15);

    // Add a page
    $pdf->AddPage();
    
    $pdf->setFont('Rockwell', 'B', 16);

    // Title
    $pdf->Cell(0, 10, 'Certificate of Blotter', 0, 1, 'C');
    $pdf->Ln(10);

    // Set font for the content
    $pdf->setFont('Rockwell', '', 12);

    // Body

    $pdf->MultiCell(0, 10, "This is the sample of the Blotterssdoigfjksdoigjsspdfokspodfsdfsdf. "
        ."opadkgposdkgopsdgksopdgksopdgkopsdposdkgopsdkgopksg.\n\n"
        ."Issued on: " . date('Y-m-d') . "\n"
        ."Authorized Signature: _______________________", 0, 'L', 0, 1, '', '', true);


        // Logo
        global $logo;

        if(isset($logo[0])){
            $this->Image("../img/logos/".$logo[0], 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[1])){
            $this->Image("../img/logos/".$logo[1], 35, 7, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[2])){
            $this->Image("../img/logos/".$logo[2], 34, 5, 158, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[3])){
            $this->Image("../img/logos/".$logo[3], 170, 7, 24, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $this->SetLineWidth(0);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        global $brgydetailsraw;
    foreach($brgydetailsraw as $brgydetails){
    
             // Set font
            $this->SetFont('Cambria', 'B', 8);
            
            // Add the address text
            $this->MultiCell(0, 10, $brgydetails['address']."\nTel. No. ".$brgydetails['tel_num']." / Mobile No. ".$brgydetails['cp_num']." E-mail: ".$brgydetails['email'], 0, 'C', 0, 1);
            
    
        }
        $this->SetLineWidth(0.5); 

         // Draw a line above the footer
         $this->Line(10, 280, 200, 280);
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Generate Certificate of Blotter');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(0, PDF_MARGIN_TOP, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------


// add a page
$pdf->AddPage();


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($fileName, 'I');

echo json_encode(["file" => $filename]);

?>