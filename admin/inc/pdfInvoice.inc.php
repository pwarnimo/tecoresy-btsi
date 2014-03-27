<?php

include "dbconfig.inc.php";
include "classes/PDF.class.php";
include "classes/InvoiceMgr.class.php";

$invoiceMgr = new InvoiceMgr();

$facture = $invoiceMgr->getInvoice(filter_input(INPUT_GET, "iid"));


$pdf = new PDF();

$pdf = new PDF( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete( utf8_decode("TC Résidence Walfer"), "59, rue de Bridel\nL-7217 Bereldange\nLuxembourg");

$pdf->fact_dev( "Facture ", $facture[0]["idFacture"] );

$date = substr($facture[0]["dtCreateTS"], 0, 10);

$pdf->addDate($date);
$pdf->addClient("No. " . $facture[0]["fiUser"]);
$pdf->addPageNumber("1");
$pdf->addClientAdresse($facture[0]["dtLastname"] . " " . $facture[0]["dtFirstname"] . "\n" . $facture[0]["dtStreet"] . "\n" . $facture[0]["dtPostalCode"] . " " . $facture[0]["dtLocation"] . "\n" . $facture[0]["dtCountry"]);

$pdf->addReference("Devis ... du ....");

$cols=array( "REFERENCE"    => 23,
    "DESIGNATION"  => 120,
    //"QUANTITE"     => 22,
    //"P.U. HT"      => 26,
    "MONTANT" => 30);
    //"TVA"          => 11 );
$pdf->addCols( $cols);

$cols=array( "REFERENCE"    => "L",
    "DESIGNATION"  => "L",
    //"QUANTITE"     => "C",
    //"P.U. HT"      => "R",
    "MONTANT" => "R");
    //"TVA"          => "C" );
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

$y    = 109;
$line = array( "REFERENCE"    => "REF1",
    "DESIGNATION"  => "Reservation du terrain " . $facture[0]["fiTerrain"] . " de " . $facture[0]["fiDate"] . " a " . $facture[0]["fiHour"] . " heures.",
    //"QUANTITE"     => "1",
    //"P.U. HT"      => "600.00",
    "MONTANT" => $facture[0]["dtPrix"] . " Eur");
    //"TVA"          => "1" );

$size = $pdf->addLine( $y, $line );

$pdf->Output();
