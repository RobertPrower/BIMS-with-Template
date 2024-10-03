<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename

date_default_timezone_set('Asia/Manila');

$nowdate= date("Y-m-d H:i:s"); //Get the date now
$nowtime = time(); //Get the time now
$username = null;
$issuingdeptno = null;
// $residentsince=$_POST['r_since'];
// $completeaddress=utf8_decode($_POST['address']);
// $fname=utf8_decode($_POST['firstname']);
// $mname=utf8_decode($_POST['middlename']);
// $lname=utf8_decode($_POST['lastname']);

// $presentedid=$_POST['presented_id'];
// $purpose=$_POST['purpose'];
// $residentno=($_POST['resident_no']);
// $IDnumber=$_POST['IDnum'];

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

//Fetch the kagawad
$callkagawadquery = "SELECT official_name FROM kagawad";
$kagawadstmt=$pdo->prepare($callkagawadquery);
$kagawadstmt->execute();
$kagawad=$kagawadstmt->fetchAll(PDO::FETCH_ASSOC);

// Define directory for saving the PDF
$directory = "certificate_of_residency/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/certificate_of_indigency/generated_pdf_" . $nowtime . ".pdf";

class MYPDF extends TCPDF {
    
    //Page header public function Header() {
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
            $this->Image("images/".$logo[1], 35, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[2])){
            $this->Image("images/".$logo[2], 30, 5, 155, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if(isset($logo[3])){
            $this->Image("images/".$logo[3], 160, 8, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$pdf->SetAlpha(0.3); // Set transparency
$pdf->Image('images/watermark.png', 0, 25, 220, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
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
                    <p style="font-size:16px;">Sa pamamagitan nito ay pinatutunayan ng tanggapang ito na si <b class="bold">ROSADEL T. SANTOME</b>, nakatira sa <strong class="bold">4779 Genesis St., Cielito Homes, Camarin, Caloocan City</strong> ay nabibilang sa mahihirap na mamamayan dito sa aming nasasakupan.</p>
                    <p style="font-size:16px;">Ang pagpapatunay na ito ay ipinagkaloob upang magamit na basehan upang siya ay makahingi ng tulong na <strong class="bold"><u>MEDICAL ASSISTANCE</u></strong> mula sa tanggapan ng <strong class="bold"><u>MALASAKIT CENTER</u></strong>.</p>
                    <p style="font-size:16px;">Ipinagkaloob ngayong <strong class="bold">ika-29 ng Pebrero, 2024</strong> sa tanggapan ng <strong class="bold2">Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod ng Caloocan.</strong></p>
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
$pdf->MultiCell(0, 5, "VALID FOR (3 MONTHS)", 0, 'C', 0, 1, '160', '', true);

// Reset to default black color
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(0, 5, "FROM THE DATE ISSUED", 0, 'C', 0, 1, '160', '', true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

?>