<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : pdfInvoice.inc.php
 * Description :
 *   This file is used to create a pdf for an invoice. The ID of the invoice is passed via GET in order to fetch the
 *   details of a reservation.
 */

include "dbconfig.inc.php";
include "classes/PDF.class.php";
include "classes/InvoiceMgr.class.php";

$invoiceMgr = new InvoiceMgr();

// Retrieve all details for an invoice by the given ID.
$facture = $invoiceMgr->getInvoice(filter_input(INPUT_GET, "iid"));

// Create a new PDF file
$pdf = new PDF();

// Set the layout of the PDF and add the address of the tennis club.
$pdf = new PDF( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->addSociete( utf8_decode("TC Résidence Walfer"), "59, rue de Bridel\nL-7217 Bereldange\nLuxembourg");

// Add the ID of the invoice to the PDF.
$pdf->fact_dev( "Facture ", $facture[0]["idFacture"] );

$date = substr($facture[0]["dtCreateTS"], 0, 10);

// Add general information of the invoice to the PDF.
$pdf->addDate($date);
$pdf->addClient("No. " . $facture[0]["fiUser"]);
$pdf->addPageNumber("1");
$pdf->addClientAdresse($facture[0]["dtLastname"] . " " . $facture[0]["dtFirstname"] . "\n" . $facture[0]["dtStreet"] . "\n" . $facture[0]["dtPostalCode"] . " " . $facture[0]["dtLocation"] . "\n" . $facture[0]["dtCountry"]);

$pdf->addReference("Devis ... du ....");

// Add the reservations and prices to the PDF.
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

// Show the generated PDF.
$pdf->Output();
