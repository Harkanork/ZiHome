<?
$liste1 = "";
$query0 = "SELECT date, max(lum) AS max, min(lum) as min FROM `luminosite_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['min'] ."," . $value0['max'] ."],";
}
?>
<script type="text/javascript">
$(function () {

        $('#year-<? echo $periph['id']; ?>').highcharts({
            chart: {
                type: 'columnrange',
                //inverted: true
            },

            title: {
                text: 'Variation de luminosité sur 1 an'
            },

            xAxis: [{
                type: 'datetime'
            }],

            yAxis: {
                title: {
                    text: 'Luminosité'
                },
		style: {
			color: '<? echo $couleurgraph1; ?>'
		}
            },

            tooltip: {
                valueSuffix: ''
            },

            plotOptions: {
                columnrange: {
                        dataLabels: {
                                enabled: true,
                                formatter: function () {
                                        return this.y + '';
                                }
                        }
                }
            },

            legend: {
                enabled: false
            },

            series: [{
                name: 'Luminosités',
		color: '<? echo $couleurgraph1; ?>',
                data: [<?php echo $liste1; ?>]
            }]

        });

});
                </script>
<div id="year-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
