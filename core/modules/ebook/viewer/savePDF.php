<?php

// ***********************************************************
// create new PDF document
// ***********************************************************
incCls("xsite/tcpdf.php");

$pdf = new mypdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);
$pdf->makePDF($htm);

?>
