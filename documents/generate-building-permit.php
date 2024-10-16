<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
include_once('../includes/anti-SQLInject.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename

date_default_timezone_set('Asia/Manila');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $brgyquery="SELECT * FROM brgy_officials";
    $brgystmt=$pdo->prepare($brgyquery);
    $brgystmt->execute();
    $brgyofficials=$brgystmt->fetchAll(PDO::FETCH_ASSOC); 

    foreach($brgyofficials as $officialname){

        $official[] = $officialname['official_name'];

    }

    $nowdate= date("Y-m-d H:i:s"); //Get the date now
    $nowtime = time(); //Get the time now
    $directory = "building_permits/";
    $filePath = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."/generated_pdf_" . $nowtime . ".pdf";
    $filename = "generated_pdf_" . $nowtime . ".pdf";

    $username = null;
    $issuingdeptno = null;

    $ID = $_POST['id_to_record'];
    $isResident = ($_POST['res_sta']=="RESIDENT")? "RESIDENT" : "NON_RESIDENT" ; 

    $fname=sanitizeData(utf8_decode($_POST['first_name']));
    $mname=sanitizeData(utf8_decode($_POST['middle_name']));
    $lname=sanitizeData(utf8_decode($_POST['last_name']));
    $suffix = (isset($_POST['suffix']))? $suffix=$_POST['suffix']: null ;

    $fullname = $fname .' '. $mname .' '. $lname.' '. $suffix;
    $address = sanitizeData(utf8_decode($_POST['address']));


    $presentedid=sanitizeData($_POST['presented_id']);
    $IDnumber=sanitizeData($_POST['id_num']);

    $building_hnum= sanitizeData($_POST['house_num']);
    $building_street= sanitizeData($_POST['street']);
    $building_subd = sanitizeData($_POST['subd']);
    $buildingaddress = utf8_decode($building_hnum .' '. $building_street. ' '. $building_subd);
    $permit_type= sanitizeData($_POST['purpose']);
    $purpose = "Securing Building Permit "."(".$permit_type.")";

    try{

        $pdo->beginTransaction();

         $brgydetailsquery = "SELECT * FROM brgy_details";
        $brgydetailstmt = $pdo->prepare($brgydetailsquery);
        $brgydetailstmt->execute();
        $brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC); 
    
        $buildingquery = "INSERT INTO tbl_building_permits(blg_house_no, street, subd, permit_type) VALUES (?,?,?,?)";
        $buildingstmt = $pdo->prepare($buildingquery);
        $buildingstmt->execute([$building_hnum, $building_street, $building_subd, $permit_type]);

        $determinedocuquery = "CALL determine_docu_type('Building_Permits');";
        $determinedocustmt = $pdo->prepare($determinedocuquery);
        $determinedocustmt->execute();
        $determinedocustmt->closeCursor(); 

        $auditTrailquery= "
                INSERT INTO tbl_cert_audit_trail(issuing_dept_no, datetime_issued, expiration)
                VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 1 YEAR));
                ";
        $auditTrailstmt=$pdo->prepare($auditTrailquery);
        $auditTrailstmt->execute([$issuingdeptno, $nowdate]);

        if ($isResident =="RESIDENT"){

            $certDetailsquery = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile) 
                        VALUES (:residentno,:presentedid, :IDnumber, :purpose, :filenames);";
            $alldatatorequest = [
                ':residentno' => $ID,
                ':presentedid' => $presentedid,
                ':IDnumber' => $IDnumber,
                ':purpose' => "Securing Building Permit",
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
                ':purpose' => "Securing Building Permit",
                ':filenames' => $filename
            ];
            $certDetailsstmt = $pdo->prepare($certDetailsquery);
            $certDetailsstmt->execute($alldatatorequest);

            $getimagequery = "SELECT img_filename FROM non_resident where nresident_id = ?";
            $getimagestmt = $pdo->prepare($getimagequery);
            $getimagestmt->execute([$ID]);
            $image = $getimagestmt->fetchColumn();

            }    

            $requestquery = "SELECT get_max_request_id() AS request_id";
            $requeststmt = $pdo->prepare($requestquery);
            $requeststmt -> execute();        
            $requestid= $requeststmt->fetchColumn();

            $pdo->commit();

    }catch(Exception $errors){
        $pdo->rollBack();
        exit(json_encode(["error", $errors->getMessage()]));
    }

}else{
    exit("Access Denied");
}
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

        global $brgydetailsraw;
       foreach($brgydetailsraw as $brgydetails){
    
            $this->setXY(17,16);

            $title = '
            <style>
                .title{
                font-family: Rockwell;
                font-size: 20px;
                color: #393939;
                line-height: 0.6;
                letter-spacing: 2rem;
                font-color: rgb(28,28,28);

                }

                .body{
                line-height: 0.6;
                }

                .brgyname{
                font-family: Cambria;
                font-size: 12px;
                letter-spacing: 0.5rem;
                line-height: 0.6;
                }

                .contact{
                font-family: Cambria;
                font-size: 12px;
                letter-spacing: 0.5rem;
                line-height: 0.6;
                }
            </style>
            
            <p class="body"> 
            <strong class="title">'.strtoupper($brgydetails['brgy_name'].' '. $brgydetails['sona'].' '.$brgydetails['district']).'</strong>
            <p class="brgyname">'.strtoupper($brgydetails['address']).'</p>
            <p class="contact"> Tel No: '.$brgydetails['tel_num'].' Cell No: '.$brgydetails['cp_num'].' Email: '.$brgydetails['email'].'</p>
            </p>

            
            '
            ;
            $this->writeHTML($title, true, false, true, false, 'C');
    
        }

         $this->SetY(-15);


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
                $this->Image("../img/logos/" . $logo[1], 15, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Second image
            }

            if (isset($logo[5])) {
                $this->Image("../img/logos/" . $logo[5], 30, 5, 153, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Third image
            }

            if (isset($logo[3])) {
                $this->Image("../img/logos/" . $logo[3], 175, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Fourth image
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

        $this->SetXY(25, 276); 
        $this->Cell(5, 10, "Print Issued By", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        $this->SetXY(25, 279); 
        $this->Cell(5, 10, "Wenzel", 0, 0, 'C', false, '', 0, false, 'T', 'M');

        // global $year_quarter;

        // $this->SetXY(25, 282); 
        // $this->Cell(5, 10, $year_quarter, 0, 0, 'C', false, '', 0, false, 'T', 'M');

        // global $expirationdate;
        // $this->SetXY(25, 285); 
        // $this->Cell(5, 10, "May Bisa Hanggang ika-".$expirationdate, 0, 0, 'C', false, '', 0, false, 'T', 'M');

        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('Cambria', 'I', 8);
    
        $this->SetXY(160 ,271 );
        // Add bottom-right aligned text (default color)
        $this->MultiCell(0, 5, "NOT VALID WITHOUT \n DRY SEAL", 0, 'C', 0, 1, '', '', true);

        global $logo; 
        $this->Image("../img/logos/".$logo[3], 145, 277, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image("../img/logos/".$logo[0], 160, 277, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $this->Image("../img/logos/".$logo[1], 175, 277, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image("../img/logos/".$logo[4], 188, 275, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

   
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Generate Building Permit');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set margins
$pdf->SetMargins(20, 30, 20);
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
$pdf->Image('../img/logos/'.$logo[4], -15, 20, 280, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
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

// set some text to print
$html =
    '<div class="body">
        <br><br>
        <h1 class="certi"> TANGGAPAN NG PUNONG BARANGAY </h1>
        <h1 class="bpermit"> SECURING BUILDING PERMIT </h1>

        <br><br>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sa pamamagitan nito ay pinatutunayan na si <b class="bold">'.'  '.$fullname. '  '.'</b>
         na kasulukuyang naninirahan sa <b class="bold">'.' '.$address. ' '.'</b> na nasasakupan ng Barangay 177, Sona 15, Distrito 1, Lungsod ng Caloocan.
        </p>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ang pagpapatunay na ito ay ipinagkaloob sa kahilingan ni <b class="bold">'.'  '.$fullname. '  '.'</b> upang magamit sa kaniyang <b class="bold">'.' '.$purpose.' '.'</b>
         na matatagpuan sa <b class="bold">'.' '.$buildingaddress.' '.'</b> na nasasakupan ng Barangay 177, Sona 15, Distrito 1, Lungsod ng Caloocan.
         </p>

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
            font-size: 20px;
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
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 95, 210, 30, 30, $style, 'N');

$pdf->SetXY(108 , 240); 
$pdf->Cell(5, 10, $qrContent, 0, 0, 'C', false, '', 0, false, 'T', 'M');

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
  
$pdf->Image($imagepath, 170, 180, 30, 30, $imagetype, '', '', false, 300, '', false, false, 0); // X, Y, Width, Height


// Move 30 units above the bottom
$pdf->SetY(230); 
// Move 60 units from the right
$pdf->SetX(-60); 

$pdf->SetDrawColor(0, 0, 0); // Black color

$pdf->Rect(170, 180, 30, 30, 'D');

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
$pdf->Cell(5, 10, strtoupper($official[2]), 0, 0, 'C', false, '', 0, false, 'T', 'M');

$pdf->SetFont('cambria', 'B', 12);

$pdf->SetXY(180, 240); 
$pdf->Cell(5, 10, "KALIHIM BARANGAY", 0, 0, 'C', false, '', 0, false, 'T', 'M');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($filePath, 'F');
echo json_encode(["file" => $filename]);


?>