<?php

/* --- OVERLAYS ----------------------------------------------------------------------------------------------------- */

// -- Change payment status --

echo <<< DLGINVOICESTATUS
    <div id="dlgInvoiceStatus" title="Payé / Non payé">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment marquez la facture payé / non-payé?</p>
    </div>
DLGINVOICESTATUS;

// -- Delete invoice --

echo <<< DLGINVOICEDELETE
    <div id="dlgInvoiceDelete" title="Supprimer">
        <p>Voulez vous vraiment supprimer cet facture?</p>
    </div>
DLGINVOICEDELETE;

/* ------------------------------------------------------------------------------------------------------------------ */

echo <<< PAGE
    <div class="page-header">
        <h1>Factures <small>TECORESY Admin</small></h1>
    </div>

    <!--<button id="btnTest">TEST</button>-->

    <div id="tblOverview">
        <table id="dataInvoices" class="testtable" width="100%">
            <thead>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>

    <div id="factureOverview">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 id="fNoInvoice" class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <p id="fTimestamp"></p>
            </div>
        </div>

        <button id="btnReturn" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Retourner</button>
    </div>
PAGE;

echo <<< PAGE
    <script src="js/pages/invoices.js"></script>
PAGE;
