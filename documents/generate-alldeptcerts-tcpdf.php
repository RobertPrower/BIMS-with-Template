<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s");
$nowtime = time(); // Get the time now

// Define directory for saving the PDF
$directory = "certificate_of_blotter/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/".$directory."generated_pdf_" . $nowtime . ".pdf";
$filename = "generated_pdf_" . $nowtime . ".pdf";

// Sample data for testing
$fname = "Robert";
$mname = "Lumauig";
$lname = "Salas";
$suffix = isset($_POST['suffix']) ? $_POST['suffix'] : null;
$fullname = $fname .' '. $mname .' '. $lname.' '. $suffix;

// Fetch required data
$brgyquery = "SELECT * FROM brgy_officials";
$brgystmt = $pdo->prepare($brgyquery);
$brgystmt->execute();
$brgyofficials = $brgystmt->fetchAll(PDO::FETCH_ASSOC);

$official = array_map(function($officialname) {
    return $officialname['official_name'];
}, $brgyofficials);

$imgquery = "SELECT `filename` FROM `certificate-img`";
$imgstmt = $pdo->prepare($imgquery);
$imgstmt->execute();
$logo = array_column($imgstmt->fetchAll(PDO::FETCH_ASSOC), 'filename');

$brgydetailsquery = "SELECT * FROM brgy_details";
$brgydetailstmt = $pdo->prepare($brgydetailsquery);
$brgydetailstmt->execute();
$brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC);

class MYPDF extends TCPDF {

    protected $brgydetailsraw;
    protected $logo;

    public function __construct($brgydetailsraw, $logo) {
        parent::__construct();
        $this->brgydetailsraw = $brgydetailsraw;
        $this->logo = $logo;
    }

    public function DrawGradient($x, $y, $w, $h, $color1, $color2) {
        $steps = 100;
        for ($i = 0; $i <= $steps; $i++) {
            $r = $color1[0] + ($color2[0] - $color1[0]) * ($i / $steps);
            $g = $color1[1] + ($color2[1] - $color1[1]) * ($i / $steps);
            $b = $color1[2] + ($color2[2] - $color1[2]) * ($i / $steps);
            $this->SetFillColor($r, $g, $b);
            $this->Rect($x, $y + ($h / $steps) * $i, $w, $h / $steps, 'F');
        }
    }

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
                font-size: 16px;
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
                font-size: 10px;
                letter-spacing: 0.5rem;
                line-height: 0.6;
                }

                .contact{
                font-family: Cambria;
                font-size: 10px;
                letter-spacing: 0.5rem;
                line-height: 0.6;
                }
            </style>
            
            <p class="body"> 
            <strong class="title">'.mb_strtoupper($brgydetails['brgy_name'].' '. $brgydetails['sona'].' '.$brgydetails['district']).'</strong>
            <p class="brgyname">'.mb_strtoupper($brgydetails['address']).'</p>
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
                $this->Image("../img/logos/" . $logo[5], 75, 5, 153, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Third image
            }

            if (isset($logo[3])) {
                $this->Image("../img/logos/" . $logo[3], 255, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Fourth image
            }
        } else {
            // Handle the case when no images are returned by the query
            // echo "No logos found in the database.";
        }

        
        $this->SetLineWidth(0); 

         // Draw a line below the header
         $this->Line(0, 35, 290, 35); 
    }

    public function Footer() {
        $this->SetY(-15);
        foreach($this->brgydetailsraw as $brgydetails) {
            $this->SetFont('Cambria', 'B', 8);
            $this->MultiCell(0, 10, $brgydetails['address']."\nTel. No. ".$brgydetails['tel_num']." / Mobile No. ".$brgydetails['cp_num']." E-mail: ".$brgydetails['email'], 0, 'C', 0, 1);
        }
        $this->Line(10, 280, 200, 280);
    }
}

$pdf = new MYPDF($brgydetailsraw, $logo);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Generate Status Report of the month');
$pdf->SetMargins(15, 40, 15);
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage('L');

$html = '

<div class="body">

    <h1 class="title"> STATUS REPORT FOR THIS MONTH </h1>

    <table style="border-collapse: collapse; width: 100%;" border="1" cellpadding="4">

        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #000; text-align: center;">Date</th>
                <th style="border: 1px solid #000; text-align: center;">Name</th>
                <th style="border: 1px solid #000; text-align: center;">Address</th>
                <th style="border: 1px solid #000; text-align: center;">Age</th>
                <th style="border: 1px solid #000; text-align: center;">Contact</th>
                <th style="border: 1px solid #000; text-align: center;">Gender</th>
                <th style="border: 1px solid #000; text-align: center;">Types</th>
                <th style="border: 1px solid #000; text-align: center;">Purpose</th>
                <th style="border: 1px solid #000; text-align: center;">Released By</th>
                <th style="border: 1px solid #000; text-align: center;">Remarks</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="border: 1px solid #000; text-align: center;">June 1, 2000 <br> Monday</td>
                <td style="border: 1px solid #000; text-align: center;">John Doe</td>
                <td style="border: 1px solid #000; text-align: center;">123 Main St</td>
                <td style="border: 1px solid #000; text-align: center;">25</td>
                <td style="border: 1px solid #000; text-align: center;">(123) 456-7890</td>
                <td style="border: 1px solid #000; text-align: center;">Male</td>
                <td style="border: 1px solid #000; text-align: center;">Type A</td>
                <td style="border: 1px solid #000; text-align: center;">Verification</td>
                <td style="border: 1px solid #000; text-align: center;">Admin</td>
                <td style="border: 1px solid #000; text-align: center;">Approved</td>
            </tr>
            <!-- Repeat <tr>...</tr> as needed for more rows -->

        </tbody>
    </table>
</div>

<style>
    .body { font-size: 8px; }
    .title {text-align: center}
</style>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($fileName, 'I');

echo json_encode(["file" => $filename]);
?>