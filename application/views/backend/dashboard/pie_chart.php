<?php
$transactioncat = '';
$transactionamount = '';
foreach ($transections as $key => $value) {
    $transactioncat .= '"'.$value->transection_category.'", ';
    $transactionamount .= $value->transections.', ';
}
$transactioncat = rtrim($transactioncat, ", "); 
$transactionamount = rtrim($transactionamount, ", "); 

?>
<?php if ($transections) { ?>
$(document).ready(function () {    
    "use strict"; // Start of use strict
        if(window.myChart4 != undefined)
            window.myChart4.destroy();

    //pie chart
    var ctx = document.getElementById("pieChart");
    window.myChart4 = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                    data: [<?php echo @$transactionamount ?>],
                    backgroundColor: [
                        "rgba(55,160,0,0.9)",
                        "rgba(255,0,0,0.9)"
                    ],
                    hoverBackgroundColor: [
                        "rgba(55,160,0,0.8)",
                        "rgba(255,0,0,0.8)"
                    ]

                }],
            labels: [<?php echo @$transactioncat ?>]
        },
        options: {
            responsive: true
        }
    });
});

<?php } else { ?>
$(document).ready(function () {
    "use strict"; // Start of use strict
        if(window.myChart4 != undefined)
            window.myChart4.destroy();
    //pie chart
    var ctx = document.getElementById("pieChart");
    window.myChart4 = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                    data: [<?php echo @$transactionamount ?>],
                    backgroundColor: [
                        "rgba(55,160,0,0.9)",
                        "rgba(255,0,0,0.9)"
                    ],
                    hoverBackgroundColor: [
                        "rgba(55,160,0,0.8)",
                        "rgba(255,0,0,0.8)"
                    ]

                }],
            labels: [
                <?php echo @$transactioncat ?>
            ]
        },
        options: {
            responsive: true
        }
    });
});
<?php } ?>