<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename

date_default_timezone_set('Asia/Manila');

$brgyquery="SELECT * FROM brgy_officials";
$brgystmt=$pdo->prepare($brgyquery);
$brgystmt->execute();
$brgyofficials=$brgystmt->fetchAll(PDO::FETCH_ASSOC); 

foreach($brgyofficials as $officialname){

    $official[] = $officialname['official_name'];

}

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

    public function DrawGradient($x, $y, $w, $h, $color1, $color2) {
        $steps = 100; // Number of steps for the gradient
        for ($i = 0; $i <= $steps; $i++) {
            // Calculate the intermediate color
            $r = $color1[0] + ($color2[0] - $color1[0]) * ($i / $steps);
            $g = $color1[1] + ($color2[1] - $color1[1]) * ($i / $steps);
            $b = $color1[2] + ($color2[2] - $color1[2]) * ($i / $steps);
            // Set the fill color
            $this->SetFillColor($r, $g, $b);
            // Draw the rectangle for this step
            $this->Rect($x, $y + ($h / $steps) * $i, $w, $h / $steps, 'F');
        }
    }
    
    //Page header
    public function Header() {

        $headerY = $this->GetY();
        
        // Draw a linear gradient in the header area
        $this->DrawGradient(0, 0, $this->getPageWidth(), ($headerY + 40) * 0.75, [4, 238, 9], [255, 255, 255]);
        

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
        
            
            if (isset($logo[1])) {
                $this->Image("images/" . $logo[1], 15, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Second image
            }

            if (isset($logo[5])) {
                $this->Image("images/" . $logo[5], 30, 5, 153, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Third image
            }

            if (isset($logo[3])) {
                $this->Image("images/" . $logo[3], 175, 8, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Fourth image
            }
        } else {
            // Handle the case when no images are returned by the query
            // echo "No logos found in the database.";
        }

        
        $this->SetLineWidth(0); 

         // Draw a line below the header
         $this->Line(0, 35, 220, 35); 
    }

    // Page footer
    public function Footer() {

          // Get the width and height of the page
        $pageWidth = $this->getPageWidth();
        $pageHeight = $this->getPageHeight();

        // Set the starting point for the footer (15mm from the bottom)
        $footerHeight = 20; // Height of the footer
        $footerY = $pageHeight - $footerHeight;

        // Define the points of the polygon (rectangle with an uphill angle on the right side)
        // Bottom-left, top-left (flat), top-right (slanted upwards), bottom-right
        $points = array(
            0, $footerY + $footerHeight,        // Bottom-left corner
            0, $footerY,                        // Top-left corner (flat)
            $pageWidth, $footerY - 8,         // Top-right corner (slanted downwards by 10 units)
            $pageWidth, $footerY + $footerHeight // Bottom-right corner
        );

        // Set the fill color (light gray) for the rectangle
        $this->SetFillColor(4, 238, 9); 

        // Draw the polygon (angled rectangle)
        $this->Polygon($points, 'F'); 

        $this->SetFont('cambria', 'B', 7);

        $this->SetXY(25, 260); 
        $this->Cell(5, 10, "Print Issued By", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        $this->SetXY(25, 263); 
        $this->Cell(5, 10, "Wenzel", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        $this->SetXY(25, 266); 
        $this->Cell(5, 10, "Q1-Q2", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        $this->SetXY(25, 269); 
        $this->Cell(5, 10, "May Bisa Hanggang ika-Hunyo 2024", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('Cambria', 'I', 8);
    
        // Add bottom-right aligned text (default color)
        $this->MultiCell(0, 5, "NOT VALID WITHOUT \n DRY SEAL", 0, 'C', 0, 1, '', '', true);

        $this->Image("images/Brgy177.png", 145, 258, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image("images/BagongPinas.png", 160, 258, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $this->Image("images/CaloocanCityLogo.png", 175, 258, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        $this->Image("images/watermark.png", 188, 256, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

   

        $this->SetLineWidth(0.5); 

         // Draw a line above the footer
         $this->Line(10, 280, 200, 280);
    }


}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

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
$pdf->SetMargins(20, 20, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 20); 

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
$pdf->Image('images/'.$logo[4], -10, 20, 280, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

$pdf->SetTopMargin(35);

if (date('m') == "01") {
    $month = "Inero";
} elseif (date('m') == "02") {
    $month = "Pebrero";
} elseif (date('m') == "03") {
    $month = "Marso";
} elseif (date('m') == "04") {
    $month = "Abril";
} elseif (date('m') == "05") {
    $month = "Mayo";
} elseif (date('m') == "06") {
    $month = "Hunyo";
} elseif (date('m') == "07") {
    $month = "Hulyo";
} elseif (date('m') == "08") {
    $month = "Agosto";
} elseif (date('m') == "09") {
    $month = "Setyembre";
} elseif (date('m') == "10") {
    $month = "Oktubre";
} elseif (date('m') == "11") {
    $month = "Nobyembre";
} elseif (date('m') == "12") {
    $month = "Disyembre";
} else {
    $month = "Invalid month";
}

$name = "Roberto Lumauig Salas Sr";
$address="Blk 8 Lot 4 Jeremiah st Cielito Homes Camarin Caloocan City";
$bpermit="Business Permit (Hardware Supplies)";
$storetype = "Sari-Sari Store";
$businessname="WENZEL HARDWARE";

// set some text to print
$html =
    '<div class="body">
        <br><br>
        <h1 class="certi"> TANGGAPAN NG PUNONG BARANGAY </h1>
        <h1 class="bpermit"> SECURING BUSINESS PERMIT </h1>

        <br><br>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ito ay nagpapatunay na ang  <b class="bold">'.'  '.$businessname. '  '.'</b> na pag-aari ni <b class="bold">'.'  '.$name. '  '.'</b> na matatagpuan sa 
        Blk 8 Lot 4 Jeremiah st Cielito Homes Camarin Caloocan City na sasakopan ng Barangay na ito ay pinahihintulutan namagbukas/magpatuloy ng 
        kanilang negosyong  <b class="bold">'.'  '.$storetype. '  '.'</b> at pagkilos nangangailangan ng pahintulot.</p>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ang pagpapatunay na ito ay ipinagkaloob sa kahilingan ni <b class="bold">'.'  '.$name. '  '.'</b> upang magamit sa kanilang inilahad na negosyo/hanapbuhay,
         ayon sa itinadhana ng seksyon Bilang 17 ng Bagong Kodigo ng Pamahalaang Lokal.</p>

         <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mapapawalang bisa ito sa oras na mapatunayang lumabag sa panuntunan ng Revenue Code, gayundin ang hindi pagcomplay/pagtugon sa hinihinging requirements ng Tanggapan ng Baranagy</p>
         
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ipinagkaloob ngayong <b>ika-'.date("j").' ng '.$month.', '.date('Y').'</b> sa tanggapan ng Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod ng Caloocan.</p>
        
    </div>
    
    <style>

        .body{
        text-align: justify !important;
        font-size: 12;
        }

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
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 95, 210, 30, 30, $style, 'N');

$pdf->SetXY(108 , 240); 
$pdf->Cell(5, 10, $qrContent, 0, 0, 'C', false, '', 0, false, 'T', 'M');


// Move 30 units above the bottom
$pdf->SetY(230); 
// Move 60 units from the right
$pdf->SetX(-60); 

$pdf->SetDrawColor(0, 0, 0); // Black color

$pdf->Rect(170, 180, 20, 20, 'D');

$pdf->Rect(20, 180, 20, 20, 'D');

$pdf->Rect(45, 180, 20, 20, 'D');

$pdf->Rect(90, 190, 55, 10, 'D');

$pdf->SetFont('calibri', '', 10);

$pdf->SetTextColor(0, 0, 0); 


$pdf->SetXY(28, 198); // Position for the tex
$pdf->Cell(5, 10, "LEFT", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(28, 201); // Position for the tex
$pdf->Cell(5, 10, "THUMBMARK", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(52, 198); // Position for the tex
$pdf->Cell(5, 10, "RIGHT", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(52  , 201); // Position for the tex
$pdf->Cell(5, 10, "THUMBMARK", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(115, 198); // Position for the tex
$pdf->Cell(5, 10, "LAGDA", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 14);

$pdf->SetTextColor(0, 0, 0); 

$pdf->SetXY(30, 220); // Position for the tex
$pdf->Cell(5, 10, "Pinagtibay ni:", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'BU', 12);

$pdf->SetXY(35, 235); 
$pdf->Cell(5, 10, "KGG. ".strtoupper($official[0]), 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 12);

$pdf->SetXY(35, 240); 
$pdf->Cell(5, 10, "PUNONG BARANGAY", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 14);

$pdf->SetTextColor(0, 0, 0); 

$pdf->SetXY(180, 220); // Position for the tex
$pdf->Cell(5, 10, "Pinatunayan ni:", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'BU', 12);

$pdf->SetXY(180, 235); 
$pdf->Cell(5, 10, "KGG. ".strtoupper($official[2]), 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 12);

$pdf->SetXY(180, 240); 
$pdf->Cell(5, 10, "KALIHIM BARANGAY", 0, 0, 'C', false, '', 0, false, 'T', 'M');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

?>