<?
$liste1 = "";
$liste2 = "";
$query0 = "SELECT date, max(temp) AS max, min(temp) as min, max(hygro) as maxh, min(hygro) as minh, SUBSTRING(`date`,1,7) AS mdate FROM `temperature_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($value0['mdate']) * 1000 . "," . $value0['min'] ."," . $value0['max'] ."],";
if(!($value0['maxh'] == 0)) {
$liste2 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['minh'] ."," . $value0['maxh'] ."],";
}
}
?>
<script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#year-<? echo $periph['id']; ?>').highcharts({
            chart: {
                type: 'columnrange',
                //inverted: true
            },

            title: {
                text: 'Variation de température sur 1 an'
            },

            xAxis: [{
                type: 'datetime',
		dateTimeLabelFormats: {
			//day: '%b \'%y',
			//week: '%b \'%y',
			month: '%b \'%y',
			year: '%b %y'
		}
            }],

            yAxis: [{
                labels: {
                    formatter: function() {
                        return this.value +'°C';
                    },
                    style: {
                    }
                },
                                title: {
                    text: 'Température ( °C )',
                                        style: {
                        color: '<? echo $couleurgraph1; ?>'
                    }
                },
<? if(!($liste2 == "")) { ?>
            }, {
                title: {
                    text: 'Hygrométrie',
                    style: {
                        color: '<? echo $couleurgraph2; ?>'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +' %';
                    },
                    style: {
                    }
                },
				<? } ?>
            }],

            plotOptions: {
                columnrange: {
		}
            },

            legend: {
                enabled: false
            },

            series: [{
<? if(!($liste2 == "")) { ?>
                name: 'Hygrométrie',
                color: '<? echo $couleurgraph2; ?>',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
                tooltip: {
                    valueSuffix: ' %'
                }
            }, {
<? } ?>
                name: 'Température',
                color: '<? echo $couleurgraph1; ?>',
                data: [<?php echo $liste1; ?>],
                tooltip: {
                    valueSuffix: ' °C'
                }
            }]

        });

});
                </script>
<div id="year-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
