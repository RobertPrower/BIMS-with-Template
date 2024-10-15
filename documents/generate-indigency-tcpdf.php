<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
include_once('includes/tagalogmonth.php');
include_once('../includes/anti-SQLInject.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename
// Define directory for saving the PDF
$directory = "certificate_of_indigency/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/certificate_of_indigency/generated_pdf_" . $nowtime . ".pdf";
$filename="generated_pdf_" . $nowtime . ".pdf";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $nowdate= date("Y-m-d H:i:s"); //Get the date now
    $nowtime = time(); //Get the time now
    $username = null;
    $issuingdeptno = null;
    $residentno = (isset($_POST['residentno']))? $_POST['residentno']:null;
    $completeaddress=(isset($_POST['address']))? sanitizeData(utf8_decode($_POST['address'])) : null;
    $fname=sanitizeData(utf8_decode($_POST['first_name']));
    $mname=sanitizeData(utf8_decode($_POST['middle_name']));
    $lname=sanitizeData(utf8_decode($_POST['last_name']));
    $suffix = (isset($_POST['suffix']))? $suffix=$_POST['suffix']: null ;

    $fullname = $fname .' '. $mname .' '. $lname.' '. $suffix;

    $presentedid=sanitizeData($_POST['presented_id']);
    $IDnumber=sanitizeData($_POST['id_num']);
    $purpose = sanitizeData($_POST['purpose']);
    $agency=sanitizeData($_POST['agency']);

    try{

        $pdo->beginTransaction();

         //Fetch the Brgy Officials
        $brgyquery="SELECT * FROM brgy_officials";
        $brgystmt=$pdo->prepare($brgyquery);
        $brgystmt->execute();
        $brgyofficials=$brgystmt->fetchAll(PDO::FETCH_ASSOC); 

        foreach($brgyofficials as $officialname){

            $official[] = $officialname['official_name'];

        }

        //Fetch the govenment Seals
        $imgquery="SELECT `filename` FROM `certificate-img`";
        $imgstmt=$pdo->prepare($imgquery);
        $imgstmt->execute();
        $imglogo = $imgstmt->fetchAll(PDO::FETCH_ASSOC); 

        $brgydetailsquery = "SELECT * FROM brgy_details";
        $brgydetailstmt = $pdo->prepare($brgydetailsquery);
        $brgydetailstmt->execute();
        $brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC); 

        //Fetch the kagawad
        $callkagawadquery = "SELECT official_name FROM kagawad";
        $kagawadstmt=$pdo->prepare($callkagawadquery);
        $kagawadstmt->execute();
        $kagawad=$kagawadstmt->fetchAll(PDO::FETCH_ASSOC);

        $indigentquery = "INSERT INTO tbl_indigency(agency) VALUES (?)";
        $indigentstmt = $pdo->prepare($indigentquery);
        $indigentstmt->execute([$agency]);

        $docudetailsquery = "CALL determine_docu_type('Certificate_of_Indigency')";
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


        // Fetch and request_id
        $idquery = "SELECT get_max_request_id()";
        $idstmt = $pdo->prepare($idquery);
        $idstmt->execute();
        $request_id=$idstmt->fetchColumn();

        $pdo->commit();

    } catch(Exception $error){

        $pdo->rollBack();
        exit(json_encode(["error", "message" => $error]));

    }

}else{
    exit("Access denied");
}

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
        
        // Logo
        global $imglogo;
        foreach($imglogo as $seallogo){
            $logo[] = $seallogo['filename']; // Collecting each filename
        }

        if(isset($logo[0])){
            $this->Image("../img/".$logo[0], 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[1])){
            $this->Image("../img/".$logo[1], 35, 7, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[2])){
            $this->Image("../img/".$logo[2], 34, 5, 158, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[3])){
            $this->Image("../img/".$logo[3], 170, 8, 24, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $this->SetLineWidth(0); 

         // Draw a line below the header
         $this->Line(0, 35, 220, 35); 
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-16);
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
$pdf->Image('../img/'.$logo[4], -6, 25, 220, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

$pdf->SetTopMargin(35);

$pdf->Line( 61, 35, 61, 280);
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

            
      $html .='</td>
            <td class="certbody">
                <div style="text-align:center; font-family:\'Cambria\',serif;">
                    <h2 style="font-size:22px;">PAGPAPATUNAY NA MAHIRAP</h2>
                    <p style="font-size:16px;">Sa pamamagitan nito ay pinatutunayan ng tanggapang ito na si <br><b class="bold">'.strtoupper($fullname).'</b>, nakatira sa <strong class="bold">'.$completeaddress.'</strong> ay nabibilang sa mahihirap na mamamayan dito sa aming nasasakupan.</p>
                    <p style="font-size:16px;">Ang pagpapatunay na ito ay ipinagkaloob upang magamit na basehan upang siya ay makahingi ng tulong na <strong class="bold"><u>'.$purpose.'</u></strong> mula sa tanggapan ng <strong class="bold"><u>'.$agency.'</u></strong>.</p>
                    <p style="font-size:16px;">Ipinagkaloob ngayong <b class="bold">ika-'.date("j").' ng '.$month.', '.date('Y').'</b> sa tanggapan ng <strong class="bold2">Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod ng Caloocan.</strong></p>
                </div>
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

         .bold2{
            font-weight: bolder;
            font-size: 18px;
        }

    </style>';

// print a block of text using Write()
$pdf->writeHTML($html, true, false, true, false, '');

$qrContent = $request_id; // Change this to whatever you want the QR code to link to

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

$pdf->SetXY(21, 266);
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