<?php

$monthsi = array();
$monthsr = array();


$investmonth = '';
$investamount = '';
foreach ($investment as $key => $value) {
    $investmonth .= '"'.$value->month.'", ';
    $investamount .= $value->investment.', ';

    array_push($monthsi,$value->month);
}
$investmonth     = rtrim($investmonth, ", "); 
$investamount   = rtrim($investamount, ", ");



$roimonth = '';
$roiamount = '';
foreach ($roi as $key => $value) {
    $roimonth .= '"'.$value->month.'", ';
    $roiamount .= $value->roi.', ';

    array_push($monthsr,$value->month);
}
$roimonth     = rtrim($roimonth, ", "); 
$roiamount   = rtrim($roiamount, ", ");


    

$month = array_merge($monthsi, $monthsr);
$months = '';
foreach (array_unique($month) as $key => $value) {
    $months .= '"'.$value.'", ';
}
$months = rtrim($months, ", "); 

?>
<?php if ($investment && $roi) { ?>

$(document).ready(function () {
    "use strict"; // Start of use strict

     if(window.myChart3 != undefined)
       window.myChart3.destroy();

    //line chart
    var ctx = document.getElementById("lineChart");
    window.myChart3 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php echo $months; ?>],
            datasets: [
                {
                    label: "Investment",
                    borderColor: "rgba(0,0,0,.09)",
                    borderWidth: "1",
                    backgroundColor: "rgba(0,0,0,.07)",
                    data: [<?php echo @$investamount;  ?>]
                },
                {
                    label: "ROI+Refferal Bonus",
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "1",
                    backgroundColor: "rgba(55, 160, 0, 0.5)",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php echo @$roiamount;  ?>]
                }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    });
});
<?php } else{ ?>
$(document).ready(function () {

    "use strict"; // Start of use strict
    if(window.myChart3 != undefined)
       window.myChart3.destroy();

    //line chart
    var ctx = document.getElementById("lineChart");
    window.myChart3 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php echo @$months ?>],
            datasets: [
                {
                    label: "Investment",
                    borderColor: "rgba(0,0,0,.09)",
                    borderWidth: "1",
                    backgroundColor: "rgba(0,0,0,.07)",
                    data: [<?php echo @$investamount;  ?>]
                },
                {
                    label: "ROI+Refferal Bonus",
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "1",
                    backgroundColor: "rgba(55, 160, 0, 0.5)",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php echo @$roiamount;  ?>]
                }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    });
});

<?php } ?>