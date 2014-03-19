//var oTable;

var weekday=new Array(7);

weekday[0]="Dimanche";
weekday[1]="Lundi";
weekday[2]="Mardi";
weekday[3]="Mercredi";
weekday[4]="Jeudi";
weekday[5]="Vendredi";
weekday[6]="Samedi";

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#terrains").addClass("linkact");

    // DEBUGGING!

    /*rsrv0 = new reservation(false, "Lundi", 10, 1);
    rsrv1 = new reservation(false, "Mercredi", 9, 2);
    rsrv2 = new reservation(false, "Lundi", 11, 1);
    rsrv3 = new reservation(false, "Mercredi", 10, 1);

    tov = new reservationoverview();

    tov.addReservation(rsrv0);
    tov.addReservation(rsrv1);
    tov.addReservation(rsrv2);
    tov.addReservation(rsrv3);

    for (var i = 0; i < tov.reservations.length; i++) {
        console.log("We're at reservation n" + i);
        console.log("DET>" + tov.reservations[i].blocked);
        console.log("DET>" + tov.reservations[i].weekday);
        console.log("DET>" + tov.reservations[i].hour);
        console.log("DET>" + tov.reservations[i].terrain);
    }*/

    t1 = new Terrain(1);
    t2 = new Terrain(2);
    t3 = new Terrain(3);
    t4 = new Terrain(4);
    t5 = new Terrain(5);
    t6 = new Terrain(6);
    t7 = new Terrain(7);

    // DEBUGGING!

    //weekoverview = new Reservationoverview();

    loadReservationsFromDB();

    console.log("PAGE LOADED!");
});

function Reservation(blocked, weekday, hour, terrain) {
    console.log("JS->INSTANCE OF RESERVATION CREATED.");
    this.blocked = blocked;
    this.weekday = weekday;
    this.hour = hour;
    this.terrain = terrain;
};

/*function Reservationoverview() {
    //console.log("JS->Reservation overview creating...");
    this.reservations = new Array();
};

Reservationoverview.prototype.addReservation = function(reservation) {
    //console.log("JS->Reservation added.");
    this.reservations.push(reservation);
};*/

function Terrain(tid) {
    this.tid = tid;
    this.reservations = new Array();
};

Terrain.prototype.addReservation = function(reservation) {
    this.reservations.push(reservation);
};

function loadReservationsFromDB() {
    $.ajax({
        type       : "POST",
        url        : "inc/action.inc.php?action=getReservations",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            //console.log("AJAX>" + data);
            result = JSON.parse(data);

            for (var i = 0; i < result.length; i++) {
                tmpres = new Reservation(false, result[i]["dtWeekDay"], result[i]["idHour"], result[i]["fiTerrain"]);

                switch (result[i]["fiTerrain"]) {
                    case "1":
                        //console.log("-->Sending to t1");
                        t1.addReservation(tmpres);

                        break;

                    case "2":
                        //console.log("-->Sending to t2");
                        t2.addReservation(tmpres);

                        break;

                    case "3":
                        //console.log("-->Sending to t3");
                        t3.addReservation(tmpres);

                        break;

                    case "4":
                        //console.log("-->Sending to t4");
                        t4.addReservation(tmpres);

                        break;

                    case "5":
                        //console.log("-->Sending to t5");
                        t5.addReservation(tmpres);

                        break;

                    case "6":
                        //console.log("-->Sending to t6");
                        t6.addReservation(tmpres);

                        break;

                    case "7":
                        //console.log("-->Sending to t7");
                        t7.addReservation(tmpres);

                        break;
                }

                //tmpres = new Reservation(false, result[i]["dtWeekDay"], result[i]["idHour"], result[i]["fiTerrain"]);

                //weekoverview.addReservation(tmpres);
            }

            buildTable();

            //console.log("Total of " + weekoverview.reservations.length + " possible reservations");
        }
    });
};

function buildTable() {
    var terrains = new Array();

    terrains.push(t1);
    terrains.push(t2);
    terrains.push(t3);
    terrains.push(t4);
    terrains.push(t5);
    terrains.push(t6);
    terrains.push(t7);

    // DEBUG

    for (var i = 0; i < terrains.length; i++) {
        console.log("Terrain " + terrains[i].tid + " has " + terrains[i].reservations.length + " possible reservations.");
    }

    // DEBUG

    var tHtml = "";

    //tHtml = "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>"

    //for (var i = 0; i < terrains[0].reservations.length; i++) {

    //}

    $.ajax({
        type       : "POST",
        url        : "inc/action.inc.php?action=getDateSpan",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            var result = JSON.parse(data);

            tHtml += "<tr><th width=\"50px\"></th>";

            for (var i = 0; i < result.length; i++) {
                var d = new Date(result[i]["idDate"]);

                tHtml += "<th>" + weekday[d.getDay()]; + "</th>";
                console.log("AREQ2>" + result[i]["idDate"]);
            }

            tHtml += "</tr>";

            $("#dataTerrains thead").html(tHtml);
        },
        async      : false
    });

    tHtml = "";

    var times = ["08-09", "09-10", "10-11", "11-12", "12-13", "13-14", "14-15", "15-16", "16-17", "17-18", "18-19", "19-20", "20-21", "21-22"];

    for (var i = 0; i < 14; i++) {
        tHtml += "<tr>";
        for (var j = 0; j < 8; j++) {
            if (j == 0) {
                tHtml += "<td>" + times[i] + "</td>";
            }
            else {
                tHtml += "<td>LL</td>";
            }
        }
        tHtml += "</tr>";
    }

    $("#dataTerrains tbody").html(tHtml);
};