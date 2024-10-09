<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');

date_default_timezone_set('Asia/Manila');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s"); // Current date
$nowtime = time(); // Timestamp to generate a unique filename

// Define directory for saving the PDF
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/certificate_of_tprs/generated_pdf_" . $nowtime . ".pdf";

class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {
        
        // Logo
        $this->Image("images/BagongPinas.png", 10, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $this->Image("images/Brgy177(2).png", 30, 5, 155, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image("images/CaloocanCityLogo.png", 180, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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

$pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, '', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Generate Certificate of TPRS');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
$pdf->Image('images/watermark.png', 35, 35, 200, 0, 'PNG', '', '', false, 300, '', false, false, 0); // X, Y, Width, Height
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
$toda = "ZACATODA";
$route = "Zabarte - Camarin Vice Versa";
$tprs="TPRS - Motorcycle";

$make="[KAWASAKI]";
$chassisno="[BC175GB12656]";
$plateno="[130404]";
$engineno="[BC175AEL13294]";

// set some text to print
$html =
    '<table>
        <tr>
            <br>
            <td class="brgyofficials">
                <u>DONNA DE GANA - JARITO</u>
                <br>
                PUNONG BARANGAY
                <br><br><br>

                BARANGAY KAGAWAD: 
                <br><br><br>

                <u> KGD. DARWIN L. DELA CRUZ </u>
                <br><br>

                <u> KGD.ELOISA MARIE T. ENCARNACION </u>
                <br><br>

                <u>KGD. GINA T. ORTIZ</u>
                <br><br>

                <u>KGD. FRANCIS S. ACOSTA</u>
                <br><br>

                <u>KGD. RENATO C. BUSANTE.</u>
                <br><br>

                <u>KGD. CHRISTY JOY V. CALILUNG</u>
                <br><br>

                <u>KGD. LORETO D. DERRADA</u>
                <br><br><br><br>

                <u>VINCE B. SALVANI</u>
                <h5>SK-CHAIRPERSON</h5>

                <br><br>

                <u>LOIDA M. FRANCISCO</u>
                
                <h5>BARANGAY SECRETARY</h5>
                <br><br><br><br>

                <u>DAVE A. RAMIREZ</u>
                <h5>BARANGAY TREASURER</h5>
                <br>

            
            </td>
            <td class="certbody">
                <h1 class="certi"> PAGPAPATUNAY </h1>

                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sa pamamagitan nito ay pinatutunayan na si <b class="bold">'.' '.$name.' '.'</b>
                  ay miyembro ng <b class="bold">'.' '.$toda.' '.'</b> na may rutang <b class="bold">'.' '.$route.' '.'</b>
                  na nasasakupan ng Barangay 177, Sona 15, Distrito 1, Lungsod ng Caloocan.
                </p>

                <span class="span"> <b class="bold"> Make: '.' '.$make. ' '.'</b> <b class="bold"> Plate No: '.' '.$plateno. ' '.'</b>
                <br>
                <b class="bold"> Chassis No: '.' '.$chassisno. ' '.'</b> <b class="bold"> Engine No: '.' '.$engineno. ' '.'</b>
                </span>

                <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ipinagkaloob ngayong <b>
                ika-'.date("j").' ng '.$month.', '.date('Y').'</b>
                sa tanggapan ng Barangay 177, Cielito Homes Subdivision, Camarin, Lungsod ng Caloocan.
                </p>

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
            border-right-width: 2px;
            border-right: 50px soild;

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
            text-align: center;
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
$pdf->MultiCell(0, 5, "VALID FOR (3 MONTHS)", 0, 'R', 0, 1, '', '', true);

// Reset to default black color
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(0, 5, "FROM THE DATE ISSUED", 0, 'R', 0, 1, '', '', true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

?>