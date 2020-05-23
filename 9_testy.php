

<p>testy1 </p>

<div id="tester" style="width:90%;height:250px;"></div>

<script>
	TESTER = document.getElementById('tester');
	Plotly.newPlot( TESTER, [{
	x: [1, 2, 3, 4, 5],
	y: [1, 2, 4, 8, 16] }], {
	margin: { t: 0 } } );
</script>


<p>testy2 </p>

<div id="myDiv" style="width:90%;"></div>

<script>
Plotly.d3.csv("http://ogrod.awrosa.pl/data/temp_garden_raspi.csv", function(err, rows){

  function unpack(rows, key) {
  return rows.map(function(row) { return row[key]; });
}


var trace1 = {
  type: "scatter",
  mode: "lines",
  x: unpack(rows, 'Data'),
  y: unpack(rows, 'Value'),
  line: {color: '#17BECF'}

}

var todayDate = new Date(), weekDate = new Date();
weekDate.setTime(todayDate.getTime()-(4*24*3600000));

var data = [trace1];

var layout = {
  title: 'Temperatura Ogród',
  xaxis: {
    range: [weekDate, todayDate  ],
    type: 'date'
  },
  yaxis: {
    autorange: true,
    range: [-20, 40],
    type: 'linear'
  }
};
//document.write(unpack(rows, 'Data'));
Plotly.newPlot('myDiv', data, layout);
})
</script>



Resources
