<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename

date_default_timezone_set('Asia/Manila');

$sqlquery="SELECT * FROM brgy_officials";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();
$results=$stmt->fetchAll(PDO::FETCH_ASSOC); 

$nowdate= date("Y-m-d H:i:s"); //Get the date now
$nowtime = time(); //Get the time now
$fileName = "certificate_of_businesspermit/"."generated_pdf_" . time() . ".pdf";
$username = null;
$issuingdeptno = null;
// $residentsince=$_POST['r_since'];
// $completeaddress=utf8_decode($_POST['address']);
// $fname=utf8_decode($_POST['firstname']);
// $mname=utf8_decode($_POST['middlename']);
// $lname=utf8_decode($_POST['lastname']);

// $suffix = (isset($_POST['suffix']))? $suffix=$_POST['suffix']: null ;

// $presentedid=$_POST['presented_id'];
// $purpose=$_POST['purpose'];
// $residentno=($_POST['resident_no']);
// $IDnumber=$_POST['IDnum'];

// $auditTrailquery= "CALL determine_docu_type('Certificate_of_Residency'); 
//             INSERT INTO tbl_cert_audit_trail(issuing_dept_no, date_issued, expiration, time_issued)
//             VALUES (?,?,DATE_ADD(CURDATE(), INTERVAL 3 MONTH), CURTIME())";
// $auditTrailstmt=$pdo->prepare($auditTrailquery);
// $auditTrailstmt->execute([$issuingdeptno, $nowdate]);
// // Close the cursor of the previous statement
// $auditTrailstmt->closeCursor();

// $certDetailsquery4 = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile) 
//             VALUES (:residentno,:presentedid, :IDnumber, :purpose, :filenames);";
// $alldatatorequest = [
//     ':residentno' => $residentno,
//     ':presentedid' => $presentedid,
//     ':IDnumber' => $IDnumber,
//     ':purpose' => $purpose,
//     ':filenames' => $fileName
// ];
// $certDetailsstmt = $pdo->prepare($certDetailsquery);
// $certDetailsstmt->execute($alldatatorequest);


// $request_id = $pdo->lastInsertId();

// $sqlquery5="SELECT age FROM tbl_docu_request WHERE request_id = ?";
// $stmt5=$pdo->prepare($sqlquery5);
// $stmt5->execute([$request_id]);
// $AgeResult= $stmt5->fetchAll();
// $Age=$AgeResult;

// Define directory for saving the PDF
$directory = "certificate_of_businesspermit/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/certificate_of_businesspermit/generated_pdf_" . $nowtime . ".pdf";

// function connecttodb(){
//     global $pdo;
//     require_once('../includes/connecttodb.php');
//     return $pdo;
// }
class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {

        global $pdo; 
        require_once('../includes/connecttodb.php');

        $imgquery="SELECT `filename` FROM `certificate-img`";
        $imgstmt=$pdo->prepare($imgquery);
        $imgstmt->execute();
        $imglogo = $imgstmt->fetchAll(PDO::FETCH_ASSOC); 

    // If images exist, handle them properly
    if (!empty($imglogo)) {
        // Collect filenames in an array (or process them directly)
        global $logo;
        $logo = [];
        foreach($imglogo as $seallogo){
            $logo[] = $seallogo['filename']; // Collecting each filename
        }

        // Check if the required images are set in the $logo array before using them
        if (isset($logo[0])) {
            $this->Image("images/" . $logo[0], 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // First image
        }
        
        if (isset($logo[1])) {
            $this->Image("images/" . $logo[1], 35, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Second image
        }

        if (isset($logo[2])) {
            $this->Image("images/" . $logo[2], 30, 5, 155, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Third image
        }

        if (isset($logo[3])) {
            $this->Image("images/" . $logo[3], 160, 8, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Fourth image
        }
    } else {
        // Handle the case when no images are returned by the query
        echo "No logos found in the database.";
    }

        $this->SetLineWidth(0); 

         // Draw a line below the header
         $this->Line(0, 35, 220, 35); 
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('Cambria', 'I', 8);
    
        $this->MultiCell(0, 10, "Cielito Homes Subd., Camarin, Lungsod ng Caloocan, M.M.\nTel. No. 8364-7073 / Mobile No. 0999-403-1692 E-mail: 177Barangay@gmail.com", 0, 'C', 0, 1);

        $this->SetLineWidth(0.5); 

         // Draw a line above the footer
         $this->Line(10, 280, 200, 280);
    }


}

// function fetchwatermark(){
//     include_once('../includes/connecttodb.php');

//     $imgquery="SELECT * FROM `certificate-img` WHERE purpose='watermark'";
//     $imgstmt=$pdo->prepare($imgquery);
//     $imgstmt->execute();

//     return $imgstmt->fetchColumn(); 

// }

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'Letter', true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Generate Business Permit');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
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

// Add image watermark (with transparency)
$pdf->SetAlpha(0.3); // Set transparency
$pdf->Image('images/'.$logo[4], -18, 20, 280, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

$pdf->SetTopMargin(35);
$name = "Roberto Lumauig Salas Sr";
$address="Blk 8 Lot 4 Jeremiah st Cielito Homes Camarin Caloocan City";
$bpermit="Business Permit (Hardware Supplies)";
$businessname="WENZEL HARDWARE";

// set some text to print
$html =
    '<div>
        <h3 class="certi"> TANGGAPAN NG PUNONG BARANGAY </h3>
        <h1 class="bpermit"> SECURING BUSINESS PERMIT </h1>

        <br><br>

        <p> Ang pagpapatunay na ito ipinagkaloob sa kahilingan ni <b class="bold">'.'  '.$name. '  '.'</b></p>
        <p> upang magamit para sa kaniyang<b class="bold">'.'  '.$bpermit.' '.'</b> na may pangalang <b class="bold">'.' '.$businessname.'</b></p>
        <p> na kasalukuyang matatagpuan sa <b class="bold">'.' '.$address.' '.'</b> na nasasakupan ng Barangay 177, Sona 15, Distrito 1, Lungsod ng Caloocan.</p>  
        
        <p class="p1">Ipinagkaloob ngayong '.date("d").'th day of '.date('F Y').' sa tanggapan ng </p>
        <p class="p2"> Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod ng Caloocan. </p>
    </div>
    
    <style>

        .certbody{
            text-align: center; 
            font-family: Cambria;
            width:70%;
            padding: 12px;
            position: relative;
        }

        .certi{
            text-align: center; 
            font-size: 18px;
            font-family: Cambria;
        }

        .bpermit {
            text-align: center;
            font-weight: bolder;
            font-size: 32px;
        }

        .p1{
            font-size: 15px;
        }

        .p2{
            text-align: left;
            font-size: 15px;
        }

    </style>';

// print a block of text using Write()
$pdf->writeHTML($html, true, false, true, false, '');

$qrContent = 'https://example.com'; // Change this to whatever you want the QR code to link to

// Set the QR code style
$style = array(
    'position' => '', // Position (default)
    'align' => 'C', // Center align
    'size' => 50, // Size of the QR code (in mm)
    'border' => 2, // Border thickness
    'bgcolor' => array(255, 255, 255), // Background color
    'text' => false, // Do not display the text
);

// Generate the QR code
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 20, 235, 30, 30, $style, 'N');

// Move 30 units above the bottom
$pdf->SetY(230); 
// Move 60 units from the right
$pdf->SetX(-60); 

// Set the font
$pdf->SetFont('calibri', '', 10);

// Set color to default for other text
$pdf->SetTextColor(0, 0, 0); 

// Add bottom-right aligned text (default color)
$pdf->MultiCell(0, 5, "NOT VALID WITHOUT DRY SEAL", 0, 'R', 0, 1, '', '', true);

// Set color to red for specific text
$pdf->SetTextColor(200, 0, 0); 
$pdf->MultiCell(0, 5, "VALID FOR (3 MONTHS)", 0, 'R', 0, 1, '', '', true);

// Reset to default black color
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(0, 5, "FROM THE DATE ISSUED", 0, 'R', 0, 1, '', '', true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

?>