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
    SELECT
        `tbl_docu_request`.`request_id` AS `request_id`,
        `tbl_cert_audit_trail`.`datetime_issued` AS `date_issued`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN '1' ELSE '0' END) AS `is_resident`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`resident_id` ELSE `non_resident`.`nresident_id` END) AS `resident/nonres_id`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`last_name` ELSE CONVERT(`non_resident`.`last_name` USING utf8mb4) END) AS `last_name`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`first_name` ELSE CONVERT(`non_resident`.`first_name` USING utf8mb4) END) AS `first_name`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`middle_name` ELSE CONVERT(`non_resident`.`middle_name` USING utf8mb4) END) AS `middle_name`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`suffix` ELSE CONVERT(`non_resident`.`suffix` USING utf8mb4) END) AS `suffix`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`house_num` ELSE CONVERT(`non_resident`.`house_num` USING utf8mb4) END) AS `house_num`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`street` ELSE CONVERT(`non_resident`.`street` USING utf8mb4) END) AS `street`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`subdivision` ELSE CONVERT(`non_resident`.`subdivision` USING utf8mb4) END) AS `subdivision`,
        (CASE WHEN `tbl_docu_request`.`nresident_no` IS NOT NULL THEN `non_resident`.`city` ELSE 'Caloocan City' END) AS `city`,
        (CASE 
            WHEN `tbl_documents`.`Barangay_Clearance` IS NOT NULL THEN 'Barangay Clearance'
            WHEN `tbl_documents`.`Certificate_of_Residency` IS NOT NULL THEN 'Certificate of Residency'
            WHEN `tbl_documents`.`Certificate_of_Indigency` IS NOT NULL THEN 'Certificate of Indigency'
            WHEN `tbl_documents`.`Certificate_of_Good_Moral` IS NOT NULL THEN 'Certificate of Good Moral'
            WHEN `tbl_documents`.`Business_Permits` IS NOT NULL THEN 'Business Permits'
            WHEN `tbl_documents`.`Building_Permits` IS NOT NULL THEN 'Building Permits'
            WHEN `tbl_documents`.`Excavation_Permits` IS NOT NULL THEN 'Excavation Permits'
            WHEN `tbl_documents`.`Fencing_Permits` IS NOT NULL THEN 'Fencing Permits'
            WHEN `tbl_documents`.`FTJS` IS NOT NULL THEN 'First Time Job Seekers'
            WHEN `tbl_documents`.`Oath_of_Undertaking` IS NOT NULL THEN 'Oath of Undertaking'
            WHEN `tbl_documents`.`TPRS` IS NOT NULL THEN 'Tricycle Pedicab Regulatory Services'
            ELSE 'Unknown Document Type'
        END) AS `document_desc`,
        `tbl_docu_request`.`age` AS `age`,
        (CASE WHEN `tbl_docu_request`.`resident_no` IS NOT NULL THEN `resident`.`sex` ELSE CONVERT(`non_resident`.`sex` USING utf8mb4) END) AS `sex`,
        `tbl_docu_request`.`presented_id` AS `presented_id`,
        `tbl_docu_request`.`ID_number` AS `ID_number`,
        `tbl_docu_request`.`purpose` AS `purpose`,
        `tbl_docu_request`.`status` AS `status`,
        `tbl_docu_request`.`is_deleted` AS `is_deleted`,
        `tbl_username`.`username`
    FROM `tbl_docu_request`
    LEFT JOIN `resident` ON `tbl_docu_request`.`resident_no` = `resident`.`resident_id`
    LEFT JOIN `non_resident` ON `tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`
    JOIN `tbl_documents` ON `tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`
    JOIN `tbl_cert_audit_trail` ON `tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`
    LEFT JOIN `tbl_username` ON `tbl_username`.`username_id` = `tbl_cert_audit_trail`.`issued_by_no`
    WHERE `tbl_docu_request`.`is_deleted` = 0  
      AND `tbl_cert_audit_trail`.`datetime_issued` BETWEEN :start_from AND :end_date
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
            $this->setXY(17, 16);
            $title = '<p><strong>' . mb_strtoupper($brgydetails['brgy_name'] . ' ' . $brgydetails['sona'] . ' ' . $brgydetails['district']) . '</strong></p>';
            $title .= '<p>' . mb_strtoupper($brgydetails['address']) . '</p>';
            $title .= '<p>Tel No: ' . $brgydetails['tel_num'] . ' Cell No: ' . $brgydetails['cp_num'] . ' Email: ' . $brgydetails['email'] . '</p>';
            $this->writeHTML($title, true, false, true, false, 'C');
        }

        if (!empty($this->logo)) {
            if (isset($this->logo[1])) $this->Image("../img/logos/" . $this->logo[1], 15, 8, 23);
            if (isset($this->logo[5])) $this->Image("../img/logos/" . $this->logo[5], 75, 5, 153);
            if (isset($this->logo[3])) $this->Image("../img/logos/" . $this->logo[3], 260, 8, 23);
        }
        $this->Line(0, 35, 300, 35);
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
$pdf->AddPage("L");

// Generate table content from records
$html = '<h1>STATUS REPORT FOR THIS MONTH</h1><table border="1" cellpadding="4"><thead><tr>';
$html .= '<th>Date Issued</th>  <th>Name</th>  <th>Address</th> <th style="width: 5%;">Age</th>  <th>Contact</th><th>Gender</th><th>Type</th><th>Purpose</th><th>Released By</th><th>Remarks</th></tr></thead><tbody>';

foreach ($records as $row) {
    $html .= '<tr><td>' . $row['date_issued'] . '</td><td>' . $row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['suffix'] . '</td>';
    $html .= '<td>' . $row['house_num'] . ' ' . $row['street'] . '</td><td style="width: 5%;">' . $row['age'] . '</td>';
    $html .= '<td>' . $row['presented_id'] . '</td><td>' . $row['sex'] . '</td>';
    $html .= '<td>' . $row['document_desc'] . '</td><td>' . $row['purpose'] . '</td>';
    $html .= '<td>' . $row['username'] . '</td><td>' . $row['status'] . '</td></tr>';
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($fileName, 'I');

echo json_encode(["file" => $filename]);
?>
