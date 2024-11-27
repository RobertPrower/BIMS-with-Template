<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');

// Get the current date and time
$nowdate = date("Y-m-d H:i:s");
$nowtime = time(); // Get the time now

// Define directory for saving the PDF
$directory = "monthly_status_report/";
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

}

$pdf = new MYPDF($brgydetailsraw, $logo); // Pass required data
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Status Report of the Year and Month');
$pdf->SetMargins(15, 20, 15);
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage("P");

// Draw a linear gradient in the header area
$pdf->DrawGradient(0, 0, $pdf->getPageWidth(), 43, [4, 238, 9], [255, 255, 255]);

global $brgydetailsraw;
foreach ($brgydetailsraw as $brgydetails) {

  $pdf->setXY(13, 18);

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
  $pdf->writeHTML($title, true, false, true, false, 'C');

}

$pdf->SetY(-15);


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
    $pdf->Image("../img/logos/" . $logo[1], 10, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Second image
  }

  if (isset($logo[5])) {
    $pdf->Image("../img/logos/" . $logo[5], 30, 5, 153, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Third image
  }

  if (isset($logo[3])) {
    $pdf->Image("../img/logos/" . $logo[3], 177, 8, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Fourth image
  }
} else {
  // Handle the case when no images are returned by the query
  // echo "No logos found in the database.";
}


$pdf->SetLineWidth(0);

// Draw a line below the header
// $pdf->Line(x1: 0, y1: 35, 220, 35);

$fname1 = 'Robert';

$html = ' <style> 
            .body { font-size: 11px; }
            .title { text-align: center; font-size: 20px; font-weight: bold; }
            table { border-collapse: collapse; width: 70%; height: 120%; margin: 0 auto; }
            th, td { border: 1px solid #000; text-align: center; padding: 10px; width: 21%; }
            thead { background-color: #f2f2f2; }
            .section-title { font-weight: bold; text-align: center; }
            .totals { font-weight: bold; }
          </style>
          
<div class="body"> 
  <h1 class="title">MONTHLY REPORT</h1>
     <table> 
        <thead> 
              <tr> 
                <td colspan="2" class="section-title">Requirements Summary</td>
                <th>July <br> 01-31</th> 
                <th>August <br> 01-31</th> 
                <th>September 01-30</th>
                <th>October 01-31</th> 
                <th>November 01-30</th>
                <th>TOTAL</th>
              </tr>
          </thead> 
        <tbody>
              <tr> 
                <td></td>
                <td>2024</td> 
                <td>2024</td> 
                <td>2024</td> 
                <td>2024</td> 
                <td>2024</td>
                <td></td>
              </tr> 
            </tbody> 
          </table> 

          <table>
              <tr> 
                  <td>CLEARANCES</td>
                  <td>343</td>
                  <td>331</td>
                  <td>223</td>
                  <td>223</td>
                  <td>223</td>
                  <td>2553</td> <!--- TOTAL --->
                </tr> 
              <tr> 
                  <td>BARANGAY BUSINESS PERMIT</td> 
                  <td>223</td>
                  <td>223</td>
                  <td>223</td>
                  <td>223</td>
                  <td>223</td>
                  <td>2425</td> <!--- TOTAL --->
                </tr> 
              <tr> 
                  <td>SECURING BUSINESS PERMIT</td> 
                  <td>634</td>
                  <td>634</td> 
                  <td>634</td> 
                  <td>634</td> 
                  <td>634</td> 
                  <td>3343</td> <!--- TOTAL --->
              </tr> 
                <tr> 
                  <td>634</td>
                  <td>634</td> 
                  <td>634</td> 
                  <td>634</td> 
                  <td>634</td>
                  <td>634</td>
                  <td>3343</td> <!--- TOTAL --->
                </tr> 
              <tr> 
                    <td>SECURING FENCING PERMIT</td> 
                    <td>634</td>
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td>
                    <td>3343</td> <!--- TOTAL ---> 
                  </tr> 
              <tr> 
                    <td>SECURING EXCAVATION PERMIT</td> 
                    <td>432</td>
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td>
                    <td>634</td>
                    <td>3343</td> <!--- TOTAL --->
                  </tr> 
              <tr> 
                    <td>SECURING CABLE & WIRE INSTALLATION PERMIT</td>
                    <td>432</td>
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td>
                    <td>634</td>
                    <td>3343</td> <!--- TOTAL --->
                  </tr> 
              <tr> 
                    <td>BAIL BOND</td>
                    <td>432</td>
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td>
                    <td>634</td>
                    <td>3343</td> <!--- TOTAL --->
                </tr> 
              <tr> 
                    <td>SURETY BOND</td> 
                    <td>432</td>
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td>
                    <td>634</td>
                    <td>3343</td> <!--- TOTAL --->
                </tr> 
              <tr> 
                    <td>TPRS(SUPER VISION)</td>
                    <td>432</td>
                    <td>634</td> 
                    <td>634</td> 
                    <td>634</td>
                    <td>634</td>
                    <td>3343</td> <!--- TOTAL ---> 
                </tr> 
              
              <tr class="totals"> 
                    <td>Total</td> 
                    <td>1252</td> 
                    <td>1252</td>
                    <td>1252</td>
                    <td>1252</td>
                    <td>1252</td>
                    <td>1252</td>
                  </tr> 
              </table>
              
            <table> 
              
                <tr> 
                      <td colspan="2" class="section-title">Clearance Summary</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                </tr> 
                
                <tr> 
                      <td>Business Clearance</td> 
                      <td>3233</td>
                      <td>323</td>
                      <td>424</td>
                      <td>242</td>
                      <td>323</td>
                      <td>422</td>
                      <td>2132</td>
                </tr> 
                <tr> 
                      <td>Securing Business</td> 
                      <td>123</td>
                      <td>4223</td>
                      <td>232</td>
                      <td>324</td>
                      <td>2323</td>
                      <td>1231</td>
                </tr> 
                <tr>
                      <td>TPPB</td> 
                      <td>24</td>
                      <td>232</td>
                      <td>244</td>
                      <td>524</td>
                      <td>2423</td>
                      <td>1231</td>
                  </tr> 
                <tr> 
                      <td>First Time Job Seeker</td>
                      <td>143</td>
                      <td>424</td>
                      <td>324</td>
                      <td>232</td>
                      <td>234</td>
                      <td>1231</td>
                  </tr> 

                <tr class="totals">  <!----- TOTAL ------>
                  <td>Total</td> 
                  <td>62</td>
                  <td>1231</td>
                  <td>1231</td>
                  <td>1231</td>
                  <td>1231</td>
                  <td>1231</td>
                </tr> 
              </table>
              
              <table> 
              
                <tr> 
                    <td colspan="2" class="section-title">Gender Summary</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> 
                <tr> 
                    <td>MALE</td> <td>32</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                </tr> 
                <tr> 
                    <td>FEMALE</td> 
                    <td>30</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td> 
                  </tr> 
                  <tr> 
                    <td>UNGENDER</td> 
                    <td>0</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                  </tr> 
                  <tr class="totals"> 
                    <td>Total</td> 
                    <td>62</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                    <td>1231</td>
                  </tr> 
              </table>
  </div>';

// Dynamically calculate Y position for vertical centering
$pageHeight = $pdf->getPageHeight();
$contentHeight = 80;
$yPosition = 30;

$pdf->SetY($yPosition); // Set the vertical position
$pdf->writeHTML($html, true, false, true, false, 'C');

$pdf->Output($fileName, 'I');

echo json_encode(["file" => $filename]);
?>