<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename

//Get the Brgy Officials from the database
$kagawadsquery="SELECT * FROM kagawad";
$offstmt=$pdo->prepare($kagawadsquery);
$offstmt->execute();
$kagawad = $offstmt->fetchAll(PDO::FETCH_ASSOC);

//Get the Brgy Officials from the database
$offcialsquery="SELECT official_name, official_position FROM brgy_officials";
$offstmt=$pdo->prepare($offcialsquery);
$offstmt->execute();
$brgyofficial=$offstmt->fetchAll(PDO::FETCH_ASSOC);

$nowdate= date("Y-m-d H:i:s"); //Get the date now
$nowtime = time(); //Get the time now
$fileName = "certificate_of_residency/"."generated_pdf_" . time() . ".pdf";
$username = null;
$issuingdeptno = null;
// $residentsince=$_POST['r_since'];
// $completeaddress=utf8_decode($_POST['address']);
// $fname=utf8_decode($_POST['firstname']);
// $mname=utf8_decode($_POST['middlename']);
// $lname=utf8_decode($_POST['lastname']);

// if(isset($_POST['suffix'])){
//     $suffix=$_POST['suffix'];
// }else{
//     $suffix="";
// }
// $presentedid=$_POST['presented_id'];
// $purpose=$_POST['purpose'];
// $residentno=($_POST['resident_no']);
// $IDnumber=$_POST['IDnum'];

// $sqlquery2 = "CALL determine_docu_type('Certificate_of_Residency'); 
//             INSERT INTO tbl_cert_audit_trail(issuing_dept_no, date_issued, expiration, time_issued)
//             VALUES (?,?,DATE_ADD(CURDATE(), INTERVAL 3 MONTH), CURTIME())";
// $stmt2=$pdo->prepare($sqlquery2);
// $stmt2->execute([$issuingdeptno, $nowdate]);
// // Close the cursor of the previous statement
// $stmt2->closeCursor();

// $sqlquery3="SELECT * FROM `certificate-img`";
// $stmt3=$pdo->prepare($sqlquery3);
// $stmt3->execute();
// $results3=$stmt3->fetchAll(PDO::FETCH_ASSOC); 

// $sqlquery4 = "INSERT INTO tbl_docu_request (resident_no ,presented_id, ID_number, purpose, pdffile) 
//             VALUES (:residentno,:presentedid, :IDnumber, :purpose, :filenames);";
// $alldatatorequest = [
//     ':residentno' => $residentno,
//     ':presentedid' => $presentedid,
//     ':IDnumber' => $IDnumber,
//     ':purpose' => $purpose,
//     ':filenames' => $fileName
// ];
// $stmt3 = $pdo->prepare($sqlquery4);
// $stmt3->execute($alldatatorequest);


// $request_id = $pdo->lastInsertId();

// $sqlquery5="SELECT age FROM tbl_docu_request WHERE request_id = ?";
// $stmt5=$pdo->prepare($sqlquery5);
// $stmt5->execute([$request_id]);
// $AgeResult= $stmt5->fetchAll();
// $Age=$AgeResult;

// $logo=[];

// foreach($results3 as $filename){
//     $logo[]=$filename['filename'];
// }

// Define directory for saving the PDF
$directory = "certificate_of_residency/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/certificate_of_residency/generated_pdf_" . $nowtime . ".pdf";

class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {
        
        // Logo
        $this->Image("images/BagongPinas.png", 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $this->Image("images/CaloocanCityLogo.png", 35, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image("images/Brgy177Logo.png", 30, 5, 155, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image("images/Brgy177.png", 160, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'Letter', true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'letter' , true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Generate Certificate of Residency');
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
$pdf->SetAlpha(0.2); // Set transparency
$pdf->Image('images/watermark.png', 10, 45, 400, '', '', '', '', false, 300, '', false, false, 0, false, false, true);
$pdf->SetAlpha(1); // Reset transparenc

$pdf->SetTopMargin(35);

$pdf->SetLineWidth(0.5); 
$pdf->Line(62, 35, 62, 280); // X1 = X2 = 50, varying Y1 = 30 and Y2 = 150

$name = "Roberto Lumauig Salas Sr";
$address="Blk 8 Lot 4 Jeremiah st Cielito Homes Camarin Caloocan City";
$rsince="2002";
// set some text to print
$html =
    '    <table>
            <tr>
                <td class="brgyofficials"> 
                    ';
                    foreach ($brgyofficial as $official) {
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

                    foreach ($brgyofficial as $official) {
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
$html .=    '  </td>
            <td class="certbody">
                <h1 class="certi"><u>CERTIFICATION</u></h1>

                <h3>  To whom it may concern: </h3>

                <p class="parag">This is to certify that <b class="bold">'.'  '.$name. '  '.'</b>
                 is bonafide resident of this barangay located at<b class="bold">'.'  '.$address.' '.'</b> SINCE <b class="bold">'.' '.$rsince.'</b>. UP TO PRESENT.
                This certification is being issued upon the request of the above-mentioned name for</p>

                <h1 class="certi"><U>PROOF OF RESIDENCY.</U></h1>

                <p>Given this '.date("d").'th day of '.date('F Y').', at Barangay 177, Cielito Homes Subdivision, Camarin, Caloocan City.</p>

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

         .official, .kagawad {
            margin-bottom: 10px; /* Add space between each official */
        }

        .kagawad-title {
            margin-bottom: 20px; /* Add space between the title and the list of Kagawads */
        }

    </style>';

// print a block of text using Write()
$pdf->writeHTML($html, true, false, true, false, '');

$qrContent = '2004-0000001'; // Change this to whatever you want the QR code to link to

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
