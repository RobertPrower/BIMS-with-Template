<?php

require_once('tcpdf/tcpdf.php');
include_once('../includes/connecttodb.php');
require_once('../includes/anti-SQLInject.php');
require_once('includes/tagalogmonth.php');

// Get the current date and time
$nowdate = date("Y-m-d_H-i-s");
$directory = "monthly_status_report/";
$fileName = $_SERVER['DOCUMENT_ROOT'] . "/BIMS-with-Template/documents/" . $directory . "generated_pdf_" . $nowdate . ".pdf";
$filename = "generated_pdf_" . $nowdate . ".pdf";

// Fetch required data for images and header information
$imgquery = "SELECT `filename` FROM `certificate-img`";
$imgstmt = $pdo->prepare($imgquery);
$imgstmt->execute();
$logo = array_column($imgstmt->fetchAll(PDO::FETCH_ASSOC), 'filename');

$brgydetailsquery = "SELECT * FROM brgy_details";
$brgydetailstmt = $pdo->prepare($brgydetailsquery);
$brgydetailstmt->execute();
$brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC);

// Define start and end dates for the report
$start_from = '2024-10-01';
$end_date = date('Y-m-d H:i:s');  // Current timestamp

// SQL query similar to the one provided
$sqlquery = "
   CALL `SearchDocuForSpecificDates`(:start_from ,:end_date)
";

$stmt = $pdo->prepare($sqlquery);
$stmt->bindParam(':start_from', $start_from);
$stmt->bindParam(':end_date', $end_date);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

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

    // Define the DrawGradient method here
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
        $this->DrawGradient(0, 0, $this->getPageWidth(), 40, [4, 238, 9], [255, 255, 255]);
        foreach ($this->brgydetailsraw as $brgydetails) {
            $this->setXY(8, 17);
            $title = '<p><strong>' . mb_strtoupper($brgydetails['brgy_name'] . ' ' . $brgydetails['sona'] . ' ' . $brgydetails['district']) . '</strong></p>';
            $title .= '<p>' . mb_strtoupper($brgydetails['address']) . '</p>';
            // $title .= '<p>Tel No: ' . $brgydetails['tel_num'] . ' Cell No: ' . $brgydetails['cp_num'] . ' Email: ' . $brgydetails['email'] . '</p>';
            $this->writeHTML($title, true, false, true, false, 'C');
        }

        if (!empty($this->logo)) {
            if (isset($this->logo[1])) $this->Image("../img/logos/" . $this->logo[1], 57, 8, 23);
            if (isset($this->logo[5])) $this->Image("../img/logos/" . $this->logo[5], 74, 5, 153);
            if (isset($this->logo[3])) $this->Image("../img/logos/" . $this->logo[3], 223, 8, 23);
        }
        $this->Line(0, 35, 300, 35);
    }

    public function Footer()
    {
        $this->SetY(-11);
        foreach ($this->brgydetailsraw as $brgydetails) {
            $this->SetFont('Cambria', 'B', 9);
            $this->MultiCell(0, 10, $brgydetails['address'] . "\nTel. No. " . $brgydetails['tel_num'] . " / Mobile No. " . $brgydetails['cp_num'] . " E-mail: " . $brgydetails['email'], 0, 'C', 0, 1);
        }
        $this->Line(10, 250, 200, 280);
    }
}

$pdf = new MYPDF($brgydetailsraw, $logo);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Generate Certicates Report of the Month');
$pdf->SetMargins(15, 40, 15);
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage("L");

// Generate table content from records
$html = '
    <div style="text-align: center; font-size: 23px; font-weight: bold; padding: 15px; background-color: #4CAF50; color: black; margin-bottom: 20px;">

        Certificates Report - Month of ' . date("F Y") . '
    </div>';

// Certificates Table
$html .= '
    <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; font-size: 11px; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Date Issued</th>
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Certificates</th>
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Permits</th>
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Purpose</th>
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Released By</th>
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Total</th>
                <th style="padding: 8px; font-size: 12px; font-weight: bold; text-align: center;">Remarks</th>
            </tr>
        </thead>';

foreach ($records as $row) {
    $html .= '<tr><td>' . $row['date_issued'] . '</td> <td>' . $row['document_desc'] . ' </td>';
    $html .= '<td style="padding: 15%; text-align: center;">' . $row['document_desc'] . ' </td> <td style="padding: 14%; text-align: center;">' . $row['purpose'] . '</td>';
    $html .= '<td style="padding: 15%; text-align: center;">' . $row['username'] . ' </td> <td style="padding: 13%; text-align: center;">' .$row['status'] . '</td>';
    $html .= '<td style="padding: 13%; text-align: center;">' . $row['status'] . '</td></tr>';
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($fileName, 'I');

echo json_encode(["file" => $filename]);
?>