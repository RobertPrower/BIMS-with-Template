<?php
  require('./BIMS-with-Template/create-documents.php');

  $pdf = new FPDF('P', 'mm', "A4");

  $pdf->AddPage();

  $pdf->SetFont('Arial', 'B', 10);

  $pdf->Cell(71 ,10,'',0,0);
  $pdf->Cell(59 ,5,'Invoice',0,0);
  $pdf->Cell(59 ,10,'',0,1);

  $pdf->Output();
?>