<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');

// Get the current date and time

$nowdate = date("Y-m-d H:i:s");
$nowtime = time(); // Get the time now

// Define directory for saving the PDF
$directory = "clearances_report/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/" . $directory . "generated_pdf_" . $nowtime . ".pdf";
$filename = "generated_pdf_" . $nowtime . ".pdf";

// Sample data for testing
$fname = "Robert";
$mname = "Lumauig";
$lname = "Salas";
$suffix = isset($_POST['suffix']) ? $_POST['suffix'] : null;
$fullname = $fname . ' ' . $mname . ' ' . $lname . ' ' . $suffix;

// Fetch required data
$brgyquery = "SELECT * FROM brgy_officials";
$brgystmt = $pdo->prepare($brgyquery);
$brgystmt->execute();
$brgyofficials = $brgystmt->fetchAll(PDO::FETCH_ASSOC);

$official = array_map(function ($officialname) {
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

class MYPDF extends TCPDF
{

    protected $brgydetailsraw;
    protected $logo;

    public function __construct($brgydetailsraw, $logo)
    {
        parent::__construct();
        $this->brgydetailsraw = $brgydetailsraw;
        $this->logo = $logo;
    }

    public function DrawGradient($x, $y, $w, $h, $color1, $color2)
    {
        $steps = 100;
        for ($i = 0; $i <= $steps; $i++) {
            $r = $color1[0] + ($color2[0] - $color1[0]) * ($i / $steps);
            $g = $color1[1] + ($color2[1] - $color1[1]) * ($i / $steps);
            $b = $color1[2] + ($color2[2] - $color1[2]) * ($i / $steps);
            $this->SetFillColor($r, $g, $b);
            $this->Rect($x, $y + ($h / $steps) * $i, $w, $h / $steps, 'F');
        }
    }

    public function Header()
    {

        $headerY = $this->GetY();

        // Draw a linear gradient in the header area
        $this->DrawGradient(0, 0, $this->getPageWidth(), ($headerY + 40) * 0.75, [4, 238, 9], [255, 255, 255]);

        global $brgydetailsraw;
        foreach ($brgydetailsraw as $brgydetails) {

            $this->setXY(17, 16);

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
            <strong class="title">' . mb_strtoupper($brgydetails['brgy_name'] . ' ' . $brgydetails['sona'] . ' ' . $brgydetails['district']) . '</strong>
            <p class="brgyname">' . mb_strtoupper($brgydetails['address']) . '</p>
            <p class="contact"> Tel No: ' . $brgydetails['tel_num'] . ' Cell No: ' . $brgydetails['cp_num'] . ' Email: ' . $brgydetails['email'] . '</p>
            </p>

            
            '
            ;
            $this->writeHTML($title, true, false, true, false, 'C');

        }

        $this->SetY(-15);


        global $pdo;
        require_once('../includes/connecttodb.php');

        $imgquery = "SELECT `filename` FROM `certificate-img`";
        $imgstmt = $pdo->prepare($imgquery);
        $imgstmt->execute();
        $imglogo = $imgstmt->fetchAll(PDO::FETCH_ASSOC);

        // If images exist, handle them properly
        if (!empty($imglogo)) {
            // Collect filenames in an array (or process them directly)
            global $logo;
            $logo = [];
            foreach ($imglogo as $seallogo) {
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

    public function Footer()
    {
        $this->SetY(-15);
        foreach ($this->brgydetailsraw as $brgydetails) {
            $this->SetFont('Cambria', 'B', 8);
            $this->MultiCell(0, 10, $brgydetails['address'] . "\nTel. No. " . $brgydetails['tel_num'] . " / Mobile No. " . $brgydetails['cp_num'] . " E-mail: " . $brgydetails['email'], 0, 'C', 0, 1);
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

<style>

    .body { font-size: 11px; }
    .title { text-align: center; font-size: 20px; font-weight: bold; }
    table { border-collapse: collapse; width: 90%; height: 150%; margin: 0% auto;  } 
    th, td { border: 1px solid #000; text-align: center; padding: 10px; width: 30%; }
    thead { background-color: #f2f2f2; }

</style>

<div class = "body">
    <h1 class= "title"> STATUS REPORT FOR THIS MONTH </h1>

    <br>
        <table>
            <thead>
                <tr>
                    <th> Date </th>
                    <th> May 20,2024 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Car Loan </th>
                    <th> 2 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Loan </th>
                    <th> 6 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Local Employment </th>
                    <th> 14 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Meralco </th>
                    <th> 4 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Philhealth Requirements </th>
                    <th> 1 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Police Clearance </th>
                    <th> 1 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> School Requirements </th>
                    <th> 2 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> SSS Requirements </th>
                    <th> 1 </th>
                </tr>
            </thead>
        </table>

        <table>
            <thead>
                <tr class = "totals">
                    <td> Total </td>
                    <td> 42 </td>
                </tr>
            </thead>
        </table>

        <br><br>

        <table>
            <thead>
                <tr>
                    <th> Business Clearance </th>
                    <th> 3 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> First Time Job Seeker </th>
                    <th> 14 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> Securing Business </th>
                    <th> 1 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> TPRS </th>
                    <th> 2 </th>
                </tr>
            </thead>
        </table>

        <table>
            <thead>
                <tr class = "totals">
                    <td> Total </td>
                    <td> 62 </td>
                </tr>
            </thead>
        </table>

        <br><br>

        <table>
            <thead>
                <tr>
                    <th> MALE </th>
                    <th> 32 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> FEMALE </th>
                    <th> 32 </th>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th> UNGENDER </th>
                    <th> 0 </th>
                </tr>
            </thead>
        </table>

        <table>
            <thead>
                <tr class = "totals">
                    <td> Total </td>
                    <td> 62 </td>
                </tr>
            </thead>
        </table>

</style>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($fileName, 'I');

echo json_encode(["file" => $filename]);
?>