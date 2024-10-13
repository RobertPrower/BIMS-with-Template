<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); //Get the time now


if($_SERVER['REQUEST_METHOD']== "POST"){

    $directory = "first_time_job_seeker/";
    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."generated_pdf_" . $nowtime . ".pdf";
    $filename = "generated_pdf_" . time() . ".pdf";

    $username = null;
    $issuingdeptno = null;
    
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
    $purpose = "Employment";

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

        $brgydetailsquery = "SELECT * FROM brgy_details";
        $brgydetailstmt = $pdo->prepare($brgydetailsquery);
        $brgydetailstmt->execute();
        $brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC); 
    
        $docudetailsquery = "CALL determine_docu_type('FTJS')";
        $docudetailstmt = $pdo->prepare($docudetailsquery);
        $docudetailstmt->execute();
        $docudetailstmt->closeCursor();
    
        // Insert into tbl_cert_audit_trail
        $auditTrailQuery = "INSERT INTO tbl_cert_audit_trail(issuing_dept_no, datetime_issued, expiration)
                            VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 1 YEAR))";
        $auditTrailStmt = $pdo->prepare($auditTrailQuery);
        $auditTrailStmt->execute([$issuingdeptno, $nowdate]);
    
        // Insert into tbl_docu_request
        $docuRequestQuery = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile)
                                VALUES (?, ?, ?, ?, ?)";
        $docuRequestStmt = $pdo->prepare($docuRequestQuery);
        $docuRequestStmt->execute([$residentno, $presentedid, $IDnumber, $purpose, $fileName]);
    
        $nonofyearsquery = "SELECT resident_since FROM resident WHERE resident_id =?";
        $nonofyearsstmt = $pdo->prepare($nonofyearsquery);
        $nonofyearsstmt->execute([$residentno]);
        $sinceyear = $nonofyearsstmt->fetchColumn();
        $numofyears = date('Y') - $sinceyear;

         // Fetch the age and request_id
        $idquery = "SELECT request_id, age FROM tbl_docu_request WHERE request_id =(SELECT MAX(request_id) FROM tbl_docu_request)";
        $idstmt = $pdo->prepare($idquery);
        $idstmt->execute();
        $resultridage=$idstmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($resultridage as $idage){
                $request_Id[] = $idage['request_id'];
                $age[] = $idage['age'];

            }

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
        
       global $brgydetailsraw;
       foreach($brgydetailsraw as $brgydetails){
    
            $this->setXY(30,16);

            $title = '
            <style>
                .title{
                font-family: Rockwell;
                font-size: 16px;
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
            $this->Image("images/".$logo[0], 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[1])){
            $this->Image("images/".$logo[1], 35, 7, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[2])){
            $this->Image("images/".$logo[2], 20, 3, 180, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "A4", true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Barangay 177');
$pdf->SetTitle('First Time Jobseeker Certification');
$pdf->SetSubject('First Time Jobseeker Assistance Act-RA 11261');

// Set margins
$pdf->SetMargins(20, 40, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Add a page
$pdf->AddPage();

// Add image watermark (with transparency)
$pdf->SetAlpha(0.3); // Set transparency
$pdf->Image('images/watermark.png', -7, 25, 225, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

// Set some HTML content
$html = '
<br><br>
<h3 style="text-align: center; text-decoration: underline; font-family:Cambria Math;">OATH OF UNDERTAKING</h3>

<p style="text-align: justify;">
    I, <strong>'.$fullname.', '.$age[0].' years</strong> of age, a resident of <b>'.$completeaddress.', 
    since '.$rsince.',</b> availing the benefits of Republic Act 11261, otherwise known as the First Time Jobseeker Act of 2019, 
    do hereby declare, agree, and undertake to abide and be bound by the following:
</p>

<ol style="text-align: justify;">
    <li>That this is the first time that I will actively look for a job, and therefore requesting that a Barangay Certification be issued in my favor to avail the benefits of the law;</li>
    <li>That I am aware that the benefit and privilege/s under the said law shall be valid only for one (1) year from the date that the Barangay Certification is issued;</li>
    <li>That I can avail the benefits of the law only once.</li>
    <li>That I understand that my personal information shall be included in the Roster/List of the First Time Jobseeker and will not be used for any unlawful purpose;</li>
    <li>That I will inform and/or report to the Barangay personally through text or other means, or through my family/relatives once I get employed;</li>
    <li>That I am not a beneficiary of the Job Start Program R.A. No. 10889 and other laws that give me similar exemptions for the documents or transactions exempted under R.A. No. 11261;</li>
    <li>That if issued the requested Certification, I will not use the same in any fraud, neither falsify nor help and/or assist in the fabrication of the said certification;</li>
    <li>That this undertaking is made solely for the purpose of obtaining a Barangay Certification consistent with the objective of R.A. No. 11261 and not for any other purposes;</li>
    <li>That I consent to the use of my personal information pursuant to the Data Privacy Act and other applicable laws, rules, and regulations.</li>
</ol>

<p style="text-align: justify;">
    Signed this <strong style="font-weight: bold;">'.date("d").'th</strong> day of <strong style="font-weight: bold;">'.date("F").' '.date('Y').', at Barangay 177, Cielito Homes Subd., Camarin, Caloocan City.
</p>
';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Set font for the right-aligned text (Name)
$pdf->SetFont('helvetica', 'B', 12);

// Define the right margin and text block width
$right_margin = 20;  // Distance from the right edge of the paper
$text_block_width = 60; // Width for the text block

// Move the cursor near the bottom of the page (Y-coordinate)
$pdf->SetY($pdf->getPageHeight() -82); // Adjust the Y position (40mm from the bottom)

// Calculate the X position for right-aligned text relative to the A4 width
$pdf->SetX($pdf->getPageWidth() - $right_margin - $text_block_width);

// Right-align the name
$pdf->Cell($text_block_width, 10, $fullname, 0, 1, 'C');

// Set font for the centered text (Jobseeker label)
$pdf->SetFont('helvetica', '', 10);

// Add a small line break
$pdf->Ln(-3);

// Position the cursor for the centered text (aligned with the right-aligned name)
$pdf->SetX($pdf->getPageWidth() - $right_margin - $text_block_width);

// Center the text relative to the right-aligned name
$pdf->Cell($text_block_width, 10, 'First Time Jobseeker', 0, 1, 'C');

//For the Punong Barangay
$pdf->SetFont('helvetica', 'B', 12);

// Move the cursor near the bottom of the page (Y-coordinate)
$pdf->SetY($pdf->getPageHeight() - 65); // Adjust the Y position (40mm from the bottom)

// Define the text block width
$text_block_width = 70; // Width for the text block


// Left-align the name
$pdf->Cell($text_block_width, 10, 'Hon. '.strtoupper($official[0]) , 0, 1, 'C'); // Align to the left

// Set font for the centered text (Jobseeker label)
$pdf->SetFont('helvetica', '', 10);

$pdf->Ln(-3); 

// Center the text relative to the left-aligned name
$pdf->Cell($text_block_width, 10, 'BARANGAY CHAIRPERSON', 0, 1, 'C'); // Align to the left

$qrContent = $request_Id[0]; // Change this to whatever you want the QR code to link to

// Set the QR code style
$style = array(
    'position' => '', // Position (default)
    'align' => 'C', // Center align
    'size' => 50, // Size of the QR code (in mm)
    'border' => 2, // Border thickness
    'bgcolor' => array(255, 255, 255), // Background color
    'text' => true, // Do not display the text
);

// Generate the QR code
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 150, 235, 30, 30, $style, 'N');

// Optional: Add text below the QR code (if desired)
$pdf->SetXY(153, 265); 
$pdf->Cell(0, 10,$qrContent, 0, 1, 'L'); // Centered text
//2nd Page
$pdf ->AddPage();

// Add image watermark (with transparency)
$pdf->SetAlpha(0.3); // Set transparency
$pdf->Image('images/watermark.png', -7, 25, 225, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
$pdf->SetAlpha(1); // Reset transparenc

$expirationday = date('d', strtotime('+1 year'));
$expirationyear = date('Y', strtotime('+1 year'));
$expirationdate =$expirationday.'th day of '. date('F', strtotime('+1 year')) .' '. $expirationyear;

$html = '

<br><br>

<h1 style="text-align: center; font-size: 28px">CERTIFICATION <br> <small style="text-align: center; font-size: 12px">(First Time Jobseekers Assistance Act-RA 11261)</small></h1>


<p style="text-align: justify; font-family:helvetica; font-size: 12px;">
This is to certify that <b style="font-weight: bold;">Mr./Ms. '.$fullname.',</b> a resident of <b style="font-weight: bold;">'.$completeaddress.'</b>, for <b style="font-weight: bold;">'.$numofyears.' years </b>, is a qualified availee of RA 11261 or the First Time Job Seekers Assistance Act of 2019.
</p>

<p style="text-align: justify; font-family:helvetica; font-size: 12px;">
I further certify that the holder/bearer was informed of his/her rights, including the duties and responsibilities accorded
by RA 11261 through the Oath of Undertaking he/she has signed and executed in the presence of Barangay Official/s. 
</p>

<p style="text-align: justify; font-family:helvetica; font-size: 12px;">
Sign this <strong style="font-weight: bold;">'.date("d").'th</strong> day of <strong style="font-weight: bold;">'.date("F").' '.date('Y').'</strong>, at Barangay 177, Cielito Homes Subdivision, Camarin, Caloocan City.
</p>

<p style="text-align: justify; font-family:helvetica; font-size: 12px;">
This Certification is valid only until <b style="font-weight: bold;">'.$expirationdate.'</b>, one year from the issuance.
</p>
';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Set font for the right-aligned text (Name)
$pdf->SetFont('helvetica', 'B', 12);

// Define the right margin and text block width
$right_margin = 20;  // Distance from the right edge of the paper
$text_block_width = 60; // Width for the text block

// Move the cursor near the bottom of the page (Y-coordinate)
$pdf->SetY($pdf->getPageHeight() -90); // Adjust the Y position (40mm from the bottom)

// Calculate the X position for right-aligned text relative to the A4 width
$pdf->SetX($pdf->getPageWidth() - $right_margin - $text_block_width);

// Right-align the name
$pdf->Cell($text_block_width, 10, 'HON. '.strtoupper($official[0]) , 0, 1, 'R');

// Set font for the centered text (Jobseeker label)
$pdf->SetFont('helvetica', '', 10);

// Add a small line break
$pdf->Ln(-3);

// Position the cursor for the centered text (aligned with the right-aligned name)
$pdf->SetX($pdf->getPageWidth() - $right_margin - $text_block_width);

// Center the text relative to the right-aligned name
$pdf->Cell($text_block_width, 10, 'BARANGAY CHAIRPERSON', 0, 1, 'C');

// Set the QR code style
$style = array(
    'position' => '', // Position (default)
    'align' => 'C', // Center align
    'size' => 50, // Size of the QR code (in mm)
    'border' => 2, // Border thickness
    'bgcolor' => array(255, 255, 255), // Background color
    'text' => true, // Do not display the text
);

// Generate the QR code
$pdf->write2DBarcode($qrContent, 'QRCODE,H', 35, 195, 30, 30, $style, 'N');

// Optional: Add text below the QR code (if desired)
$pdf->SetXY(39, 223); 
$pdf->Cell(0, 10,$qrContent, 0, 1, 'L'); // Centered text
// Close and output PDF document
$pdf->Output($fileName, 'F');

echo json_encode(["file" => $filename]);

?>