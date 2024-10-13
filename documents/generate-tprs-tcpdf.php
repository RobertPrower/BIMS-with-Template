<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');


// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date

$directory = "tprs/";
    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."generated_pdf_" . $nowdate. ".pdf";
    $filename= "generated_pdf_" . $nowdate . ".pdf";

if($_SERVER['REQUEST_METHOD']== "POST"){

    $nowdate= date("Y-m-d H:i:s"); //Get the date now
    $nowtime = time(); //Get the time now
    $username = null;
    $issuingdeptno = null;

    // Define directory for saving the PDF
    $directory = "tprs/";
    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."generated_pdf_" . $nowtime . ".pdf";
    $filename= "generated_pdf_" . $nowtime . ".pdf";

    $ID = (isset($_POST['id_to_record']))? $_POST['id_to_record']:null;
    $isResident = ($_POST['res_sta']=="RESIDENT")? "RESIDENT" : "NON_RESIDENT" ; 

    $completeaddress=(isset($_POST['address']))? sanitizeData(utf8_decode($_POST['address'])) : null;
    $fname=sanitizeData(utf8_decode($_POST['first_name']));
    $mname=sanitizeData(utf8_decode($_POST['middle_name']));
    $lname=sanitizeData(utf8_decode($_POST['last_name']));
    $suffix = (isset($_POST['suffix']))? $suffix=$_POST['suffix']: null ;

    $fullname = $fname .' '. $mname .' '. $lname.' '. $suffix;

    $presentedid=sanitizeData($_POST['presented_id']);
    $IDnumber=sanitizeData($_POST['id_num']);
    $purpose = "Securing TPRS Certificate";

    $toda = sanitizeData($_POST['toda']);
    $route = sanitizeData($_POST['route']);
    $tprstype= "Motorcycle";

    $maker=sanitizeData($_POST['maker']);
    $chassisno=sanitizeData($_POST['chasis_no']);
    $plateno=sanitizeData($_POST['plate_no']);
    $engineno=sanitizeData($_POST['engine_no']);

    try{
        $pdo->beginTransaction();

        $brgydetailsquery = "SELECT * FROM brgy_details";
        $brgydetailstmt = $pdo->prepare($brgydetailsquery);
        $brgydetailstmt->execute();
        $brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC);

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
    
        $callkagawadquery = "SELECT official_name FROM kagawad";
        $kagawadstmt=$pdo->prepare($callkagawadquery);
        $kagawadstmt->execute();
        $kagawad=$kagawadstmt->fetchAll(PDO::FETCH_ASSOC);

        $tprs = "INSERT INTO tbl_tprs(toda, `route`, platenum, chasisnum, makertype, enginenum) VALUES (?,?,?,?,?,?)";
        $tprstmt = $pdo->prepare($tprs);
        $tprstmt->execute([$toda, $route, $plateno,$chassisno, $maker, $engineno ]);

        $docudetailsquery = "CALL determine_docu_type('TPRS')";
        $docudetailstmt = $pdo->prepare($docudetailsquery);
        $docudetailstmt->execute();
        $docudetailstmt->closeCursor();
    
        // Insert into tbl_cert_audit_trail
        $auditTrailQuery = "INSERT INTO tbl_cert_audit_trail(issuing_dept_no, datetime_issued, expiration)
                            VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 1 MONTH))";
        $auditTrailStmt = $pdo->prepare($auditTrailQuery);
        $auditTrailStmt->execute([$issuingdeptno, $nowdate]);
    
        if ($isResident =="RESIDENT"){

            $certDetailsquery = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile) 
                        VALUES (:residentno,:presentedid, :IDnumber, :purpose, :filenames);";
            $alldatatorequest = [
                ':residentno' => $ID,
                ':presentedid' => $presentedid,
                ':IDnumber' => $IDnumber,
                ':purpose' => "Securing TPRS Permit",
                ':filenames' => $filename
            ];
            $certDetailsstmt = $pdo->prepare($certDetailsquery);
            $certDetailsstmt->execute($alldatatorequest);

            $getimagequery = "SELECT img_filename FROM resident where resident_id = ?";
            $getimagestmt = $pdo->prepare($getimagequery);
            $getimagestmt->execute([$ID]);
            $image = $getimagestmt->fetchColumn();

        }else{

            $certDetailsquery = "INSERT INTO tbl_docu_request (nresident_no ,presented_id, ID_number, purpose, pdffile) 
                        VALUES (:residentno,:presentedid, :IDnumber, :purpose, :filenames);";
            $alldatatorequest = [
                ':residentno' => $ID,
                ':presentedid' => $presentedid,
                ':IDnumber' => $IDnumber,
                ':purpose' => "Securing TPRS Permit",
                ':filenames' => $filename
            ];
            $certDetailsstmt = $pdo->prepare($certDetailsquery);
            $certDetailsstmt->execute($alldatatorequest);

            $getimagequery = "SELECT img_filename FROM non_resident where nresident_id = ?";
            $getimagestmt = $pdo->prepare($getimagequery);
            $getimagestmt->execute([$ID]);
            $image = $getimagestmt->fetchColumn();

            }    
    
        // Fetch the age and request_id
        $idquery = "SELECT request_id FROM tbl_docu_request WHERE request_id =(SELECT MAX(request_id) FROM tbl_docu_request)";
        $idstmt = $pdo->prepare($idquery);
        $idstmt->execute();
        $requestid=$idstmt->fetchColumn();

        $pdo->commit();

    }catch(Exception $e){
        $pdo->rollBack();
        exit(json_encode(["error", $e]));
    }

    $pdo=null;

}else{
    exit("Access Denied");
}

class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {

       global $brgydetailsraw;
        foreach($brgydetailsraw as $brgydetails){
    
            $this->setXY(5,16);

            $title = '
            <style>
                .title{
                font-family: Rockwell;
                font-size: 18px;
                line-height: 0.6;

                }

                .body{
                line-height: 0.6;
                }

                .brgyname{
                font-family: Cambria;
                font-size: 16px;
                line-height: 0.6;
                }

                .brgyname2{
                font-family: Cambria
                font-size: 12px
                line-height: 0.6;

                }
            </style>
            
            <p class="body"> 
            <strong class="title">'.strtoupper($brgydetails['brgy_name'].' '. $brgydetails['sona'].' '.$brgydetails['district']).'</strong>
            <p class="brgyname">'.strtoupper($brgydetails['address']).'</p>
            <p class="brgyname2"> Tel No: '.$brgydetails['tel_num'].' Cell No: '.$brgydetails['cp_num'].' Email: '.$brgydetails['email'].'</p>
            </p>

            
            '
            ;
            $this->writeHTML($title, true, false, true, false, 'C');
    
        }
        
        // Logo
        global $logo;

        if(isset($logo[0])){
            $this->Image("images/".$logo[0], 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[2])){
            $this->Image("images/".$logo[5], 30, 5, 158, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[3])){
            $this->Image("images/".$logo[1], 178, 7, 24, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $this->SetLineWidth(0); 

         // Draw a line below the header
         $this->Line(0, 35, 220, 35); 
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-25);
        // Set font
        $this->SetFont('Cambria', 'I', 8);
    
        $this->SetXY(25, 280); 
        $this->Cell(5, 10, "Print Issued By", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        $this->SetXY(25, 285); 
        $this->Cell(5, 10, "Wenzel", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        $this->SetTextColor(255,0,0);        
        $this->SetXY(160 ,285 );
        // Add bottom-right aligned text (default color)
        $this->MultiCell(0, 5, "NOT VALID WITHOUT \n DRY SEAL", 0, 'C', 0, 1, '', '', true);

    
        $this->SetLineWidth(0.5); 

         // Draw a line above the footer
         $this->Line(10, 280, 200, 280);
    }

    public function VerticalGradient($x, $y, $w, $h, $colorStart, $colorEnd) {
        $steps = 100; // Number of steps for the gradient

        for ($i = 0; $i <= $steps; $i++) {
            // Calculate the intermediate color
            $r = $colorStart[0] + ($colorEnd[0] - $colorStart[0]) * ($i / $steps);
            $g = $colorStart[1] + ($colorEnd[1] - $colorStart[1]) * ($i / $steps);
            $b = $colorStart[2] + ($colorEnd[2] - $colorStart[2]) * ($i / $steps);
            
            // Set the fill color for the current step
            $this->SetFillColor($r, $g, $b);
            
            // Draw a horizontal rectangle for this gradient step
            $this->Rect($x, $y + ($h / $steps) * $i, $w, $h / $steps, 'F');
        }
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
$pdf->SetMargins(6, PDF_MARGIN_TOP, 5);
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

$pdf->LinearGradient(0, 36, 63, 243, [255, 255, 255],[210, 254, 211] );

$pdf->VerticalGradient(63,95,146,183,[255,255,255],[253,204,128]);

// Add image watermark (with transparency)
$pdf->SetAlpha(0.2); // Set transparency
$pdf->Image('images/'.$logo[4], 35, 45, 200, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

//Set Line in between brgy officials
$pdf->Line( 64, 37, 64, 280);

$pdf->SetTopMargin(35);
// set some text to print
$html ='
 <style>

        .official{
        }

        .brgyofficials{
            color: #4F6228; 
            font-size: 10px
            font-family: Bookman Old Style Bold;
            font-weight: bold;
            text-align: left;
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

        .bold{
            font-weigh: bold;
            font-size: 18px;
            font-family: Cambria;
        }

    </style>
<table>
        <tr>
            <br>
            <td class="brgyofficials">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/brgy177.png" width="120" height="120">
            ';
                
                foreach ($brgyofficials as $official) {
                    if ($official['official_position'] == 'Punong Barangay') {
                        $html .= '<div class="official" style="text-align: center;">
                        <h3><u>' . 'KGD. '.strtoupper($official['official_name']) . '</u></h3>
                        <h4 style="text-align: center;">PUNONG BARANGAY</h4>  
                        </div>';

                    }
                }   

                $html .= '<div style="text-align: center;">
                            <br>
                            <h3><u>BARANGAY KAGAWAD</u></h3>
                            
                    </div>
                    <div class="kagawad" style="line-height: 6px">';

                foreach ($kagawad as $kagawad1) {
                    $html .= '
                                <p>' .'KGD. '. strtoupper(htmlspecialchars($kagawad1['official_name'])) . '</p><br><br>
                    ';
                }

                $html .= '</div>
                        <div style="text-align: center">';

                foreach ($brgyofficials  as $official) {
                    if ($official['official_position'] == 'SK Chairperson') {
                        $html .= '<div class="official">
                                    <u>' . strtoupper($official['official_name']) . '</u>
                                    <h5>SK-CHAIRPERSON</h5>
                                    <br><br>
                                  </div>';
                    } elseif ($official['official_position'] == 'Barangay Secretary') {
                        $html .= '<div class="official">
                                    <u>' . strtoupper($official['official_name']) . '</u>
                                    <h5>BARANGAY SECRETARY</h5>
                                    <br><br>
                                  </div>';
                    } elseif ($official['official_position'] == 'Barangay Treasurer') {
                        $html .= '<div class="official">
                                    <u>' . strtoupper($official['official_name']) . '</u>
                                    <h5>BARANGAY TREASURER</h5>
                                  </div>';
                    }
                }

$html .='</div>  
         </td>
            <td class="certbody">
                <h1 class="certi"> PAGPAPATUNAY </h1>

                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sa pamamagitan nito ay pinatutunayan na si <b class="bold">'.' '.$fullname.' '.'</b>
                  ay miyembro ng <b class="bold">'.' '.$toda.' '.'</b> na may rutang <b class="bold">'.' '.$route.' '.'</b>
                  na nasasakupan ng Barangay 177, Sona 15, Distrito 1, Lungsod ng Caloocan.
                </p>

                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ang pagpapatunay ay ipinagkaloob sa kahiligan ni '.$fullname.' upang magamit para sa <b class="bold">TPRS-'.$tprstype.'.</b></p>
                <table style="width: 90%; height: 10%;">
                    <tr>
                        <td>
                            <h2> Maker: ['.$maker.']</h2>
                        </td>
                        <td>
                            <h2> Plate No: ['.$plateno.'] </h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h2> Chasis No: ['.$chassisno.'] </h2>
                        </td>
                        <td>
                            <h2> Engine No: ['.$engineno.'] </h2>
                        </td>
                    </tr>
                </table>
                <br>

                <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ipinagkaloob ngayong <b>
                ika-'.date("j").' ng '.$month.', '.date('Y').'</b>
                sa tanggapan ng Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod ng Caloocan.
                </p>

            </td>
        </tr>
    </table>';

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

$extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

if ($extension == "png") {
    $imagetype = "PNG";
} elseif ($extension == "jpg") {
    $imagetype = "JPG";
} elseif ($extension == "jpeg") {
    $imagetype = "JPEG";
} else {
    $imagetype = "Unknown";
}

if($isResident == "RESIDENT"){
    $imagepath = "../includes/img/resident_img/".$image;
}else{
    $imagepath = "../includes/img/non_resident_img/".$image;
}
  
$pdf->Image($imagepath, 70, 180, 20, 20, $imagetype, '', '', false, 300, '', false, false, 0); // X, Y, Width, Height

// Move 30 units above the bottom
$pdf->SetY(230); 
// Move 60 units from the right
$pdf->SetX(-60); 

$pdf->SetDrawColor(0, 0, 0); // Black color

$pdf->Rect(70, 180, 20, 20, 'D');

$pdf->Rect(155, 180, 20, 20, 'D');

$pdf->Rect(180, 180, 20, 20, 'D');

$pdf->Rect(105, 190, 35, 5, 'D');

$pdf->SetFont('calibri', '', 10);

$pdf->SetTextColor(0, 0, 0); 

$pdf->SetXY(162, 198); // Position for the tex
$pdf->Cell(5, 10, "LEFT", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(162, 201); // Position for the tex
$pdf->Cell(5, 10, "THUMBMARK", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(187, 198); // Position for the tex
$pdf->Cell(5, 10, "RIGHT", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(187  , 201); // Position for the tex
$pdf->Cell(5, 10, "THUMBMARK", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetXY(120, 198); // Position for the tex
$pdf->Cell(5, 10, "LAGDA", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 10);

$pdf->SetTextColor(0, 0, 0); 

$pdf->SetXY(160, 220); // Position for the tex
$pdf->Cell(5, 10, "Pinatunayan ni:", 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'BU', 10);

foreach ($brgyofficials as $official) {
    if ($official['official_position'] == 'Punong Barangay') {
        
        $pdf->SetXY(173, 235); 
        $pdf->Cell(5, 10, "KGG. ".strtoupper($official['official_name']), 0, 0, 'C', false, '', 0, false, 'T', 'M');

    }
}   

// $pdf->SetXY(180, 235); 
// $pdf->Cell(5, 10, "KGG. ".strtoupper($official[1]), 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 10);

$pdf->SetXY(175, 240); 
$pdf->Cell(5, 10, "PUNONG BARANGAY", 0, 0, 'C', false, '', 0, false, 'T', 'M');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($fileName, 'F');

echo json_encode(["file" => $filename]);

?>