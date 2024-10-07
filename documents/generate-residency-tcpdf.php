<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');


// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date

if($_SERVER['REQUEST_METHOD']== "POST"){

    $nowdate= date("Y-m-d H:i:s"); //Get the date now
    $nowtime = time(); //Get the time now
    $username = null;
    $issuingdeptno = null;

    // Define directory for saving the PDF
    $directory = "certificate_of_residency/";
    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."generated_pdf_" . $nowtime . ".pdf";
    $filename= "generated_pdf_" . $nowtime . ".pdf";

    $residentno = (isset($_POST['residentno']))? $_POST['residentno']:null;
    $rsince=(isset($_POST['r_since']))? sanitizeData($_POST['r_since']): null;
    $completeaddress=(isset($_POST['address']))? sanitizeData(utf8_decode($_POST['address'])) : null;
    $fname=sanitizeData(utf8_decode($_POST['first_name']));
    $mname=sanitizeData(utf8_decode($_POST['middle_name']));
    $lname=sanitizeData(utf8_decode($_POST['last_name']));
    $suffix = (isset($_POST['suffix']))? $suffix=$_POST['suffix']: null ;

    $fullname = $fname .' '. $mname .' '. $lname.' '. $suffix;

    $presentedid=sanitizeData($_POST['presented_id']);
    $IDnumber=sanitizeData($_POST['id_num']);
    $purpose = sanitizeData($_POST['purpose']);

    try{
        $pdo->beginTransaction();

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
    
        $callkagawadquery = "SELECT official_name FROM kagawad";
        $kagawadstmt=$pdo->prepare($callkagawadquery);
        $kagawadstmt->execute();
        $kagawad=$kagawadstmt->fetchAll(PDO::FETCH_ASSOC);
    
        $docudetailsquery = "CALL determine_docu_type('Certificate_of_Residency')";
        $docudetailstmt = $pdo->prepare($docudetailsquery);
        $docudetailstmt->execute();
        $docudetailstmt->closeCursor();
    
        // Insert into tbl_cert_audit_trail
        $auditTrailQuery = "INSERT INTO tbl_cert_audit_trail(issuing_dept_no, datetime_issued, expiration)
                            VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 3 MONTH))";
        $auditTrailStmt = $pdo->prepare($auditTrailQuery);
        $auditTrailStmt->execute([$issuingdeptno, $nowdate]);
    
        // Insert into tbl_docu_request
        $docuRequestQuery = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile)
                                VALUES (?, ?, ?, ?, ?)";
        $docuRequestStmt = $pdo->prepare($docuRequestQuery);
        $docuRequestStmt->execute([$residentno, $presentedid, $IDnumber, $purpose, $filename]);
    
        // Fetch the age and request_id
        $idquery = "SELECT request_id FROM tbl_docu_request WHERE request_id =(SELECT MAX(request_id) FROM tbl_docu_request)";
        $idstmt = $pdo->prepare($idquery);
        $idstmt->execute();
        $requestid=$idstmt->fetchColumn();

        $pdo->commit();

    }catch(Exception $errors){
        $pdo->rollBack();
        exit(json_encode(["error", $errors]));
    }

    $pdo=null;

}else{
    exit("Access Denied");
}

class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {
        
        // Logo
        global $imglogo;
        foreach($imglogo as $seallogo){
            $logo[] = $seallogo['filename']; // Collecting each filename
        }

        if(isset($logo[0])){
            $this->Image("images/".$logo[0], 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[1])){
            $this->Image("images/".$logo[1], 35, 7, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[2])){
            $this->Image("images/".$logo[2], 34, 5, 158, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[3])){
            $this->Image("images/".$logo[3], 170, 7, 24, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Generate Certificate of Residency');
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

// Add image watermark (with transparency)
$pdf->SetAlpha(0.3); // Set transparency
$pdf->Image('images/watermark.png', 0, 25, 220, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

//Set Line in between brgy officials
$pdf->Line( 61, 35, 61, 280);

$pdf->SetTopMargin(35);
// set some text to print
$html =
    '<table>
        <tr>
            <br>
            <td class="brgyofficials">';
            foreach ($brgyofficials as $official) {
                if ($official['official_position'] == 'Punong Barangay') {
                    $html .= '<div class="official">
                    <u>' . strtoupper($official['official_name']) . '</u>
                    <h5>PUNONG BARANGAY</h5>  
                    </div>';

                }
            }   

            $html .= '<div class="kagawad">
                        <br>
                        BARANGAY KAGAWAD
                        <br>
                      </div>';

             // Insert PHP `foreach` loop outside the string for dynamic content
            foreach ($kagawad as $kagawad1) {
                $html .= '
                            <u>' .'KGD. '. strtoupper(htmlspecialchars($kagawad1['official_name'])) . '</u><br><br>
                ';
            }

            foreach ($brgyofficials  as $official) {
                if ($official['official_position'] == 'SK Chairperson') {
                    $html .= '<div class="official">
                                <u>' . strtoupper($official['official_name']) . '</u>
                                <h5>SK-CHAIRPERSON</h5>
                              </div>';
                } elseif ($official['official_position'] == 'Barangay Secretary') {
                    $html .= '<div class="official">
                                <u>' . strtoupper($official['official_name']) . '</u>
                                <h5>BARANGAY SECRETARY</h5>
                              </div>';
                } elseif ($official['official_position'] == 'Barangay Treasurer') {
                    $html .= '<div class="official">
                                <u>' . strtoupper($official['official_name']) . '</u>
                                <h5>BARANGAY TREASURER</h5>
                              </div>';
                }
            }

            
    $html .=    '   </td>
            <td class="certbody">
                <h1 class="certi"><u>CERTIFICATION</u></h1>

                <h3>  To whom it may concern: </h3>

                <p class="parag">This is to certify that <b class="bold">'.'  '.$fullname. '  '.'</b>
                 is bonafide resident of this barangay located at<b class="bold">'.'  '.$completeaddress.' '.'</b> SINCE <b class="bold">'.' '.$rsince.' UP TO PRESENT</b>.
                This certification is being issued upon the request of the above-mentioned name for</p>

                <h1 class="certi"><U>PROOF OF RESIDENCY.</U></h1>

                <p>Given this <b>'.date("d").'th day of  '.date("F").', '.date('Y').'</b>, at Barangay 177, Cielito Homes Subdivision, Camarin, Caloocan City.</p>

            </td>
        </tr>
    </table>
    
    <style>

        .brgyofficials{
            color: #4F6228; 
            font-family: Bookman Old Style Bold;
            font-weight: bolder;
            text-align: center;
            width: 30%;

        }

        .certbody{
            text-align: left; 
            font-family: Cambria;
            width:70%;
            padding: 12px;
            position: relative;
        }

        .certi{
            text-align: center; 
            font-size: 30px;
            font-family: Cambria;
        }

        p{
            text-align: center;
            font-size: 15px;
            line-height: 30px;
        }

        .bold{
            font-weight: bolder;
            font-size: 22px;
        }

    </style>';

// print a block of text using Write()
$pdf->writeHTML($html, true, false, true, false, '');

$qrContent = $requestid; 

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

$pdf->SetXY(22, 266);
$pdf->Cell(0, 5, $qrContent, 0, 1, 'L', false, '', 0, false, 'T', 'M');


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
$pdf->MultiCell(0, 5, "VALID FOR (3 MONTHS)", 0, 'C', 0, 1, '160', '', true);

// Reset to default black color
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(0, 5, "FROM THE DATE ISSUED", 0, 'C', 0, 1, '160', '', true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($fileName, 'F');

echo json_encode(["file" => $filename]);

?>