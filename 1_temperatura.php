   
<div alingn="center" >

Dzisiaj

<div id="myDiv1" style="width:98%;"></div>

<script>

var plikDanych="http://ogrod.awrosa.pl/data/temp_garden_raspi.csv";

Plotly.d3.csv(plikDanych, function(err, rows){

  function unpack(rows, key) {
  return rows.map(function(row) { return row[key]; });
}


var trace1 = {
  type: "scatter",
  mode: "lines",
  x: unpack(rows, 'Data'),
  y: unpack(rows, 'Value'),
  line: {color: '#FF0000'}

}

var todayDate = new Date(), weekDate = new Date();
weekDate.setTime(todayDate.getTime()-(1*24*3600000));

var data = [trace1];

var layout = {
  title: 'Temperatura Ogród (ostatnie 24h)',
  xaxis: {
    range: [weekDate, todayDate  ],
    type: 'date'
  },
  yaxis: {
    autorange: true,
    type: 'linear'
  }
};
//document.write(unpack(rows, 'Data'));
Plotly.newPlot('myDiv1', data, layout);
})
</script>
</div> 

<div alingn="center" >

Ostatni tydzień 

<div id="myDiv2" style="width:98%;"></div>

<script>

var plikDanych="http://ogrod.awrosa.pl/data/temp_garden_raspi.csv";

Plotly.d3.csv(plikDanych, function(err, rows){

  function unpack(rows, key) {
  return rows.map(function(row) { return row[key]; });
}


var trace1 = {
  type: "scatter",
  mode: "lines",
  x: unpack(rows, 'Data'),
  y: unpack(rows, 'Value'),
  line: {color: '#FF0000'}

}

var todayDate = new Date(), weekDate = new Date();
weekDate.setTime(todayDate.getTime()-(7*24*3600000));

var data = [trace1];

var layout = {
  title: 'Temperatura Ogród (ostatni tydzień)',
  xaxis: {
    range: [weekDate, todayDate  ],
    type: 'date'
  },
  yaxis: {
    autorange: true,
    type: 'linear'
  }
};
//document.write(unpack(rows, 'Data'));
Plotly.newPlot('myDiv2', data, layout);
})
</script>
</div> 
   
<div alingn="center" >

All Data



<div id="myDiv3" style="width:98%;"></div>

<script>

var plikDanych="http://ogrod.awrosa.pl/data/temp_garden_raspi.csv";

Plotly.d3.csv(plikDanych, function(err, rows){

  function unpack(rows, key) {
  return rows.map(function(row) { return row[key]; });
}


var trace1 = {
  type: "scatter",
  mode: "lines",
  x: unpack(rows, 'Data'),
  y: unpack(rows, 'Value'),
  line: {color: '#FF0000'}

}

var todayDate = new Date();


var data = [trace1];

var layout = {
  title: 'Temperatura Ogród (ostatni tydzień)',
  xaxis: {
    range: ['2020-05-18', todayDate.toString()  ],
    rangeselector: {buttons: [
        {
          count: 1,
          label: '1w',
          step: 'week',
          stepmode: 'backward'
        },
        {
          count: 1,
          label: '1m',
          step: 'month',
          stepmode: 'backward'
        },
        {
          count: 6,
          label: '6m',
          step: 'month',
          stepmode: 'backward'
        },
        {step: 'all'}
      ]},
    rangeslider: {range: ['2020-05-15', todayDate.toString() ]},
    type: 'date'
  },
  yaxis: {
    autorange: true,
    type: 'linear'
  }
};
//document.write(unpack(rows, 'Data'));
Plotly.newPlot('myDiv3', data, layout);
})
</script>
</div>    
   
<!--  
   <h2>temperatury w ogrodzie</h2>
   <p> zapisane w <a href="https://thingspeak.com/channels/1051650"> thingspeak.com </a> </p>
  
  
  <h3> ostatnie 60 pomiarów (co 10 minut)</h3>
    <iframe width="100%" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1051650/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=120&type=line"></iframe>
 <h4> ostatnie 6 dni </h4>	 
   <iframe width="100%" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1051650/charts/1?bgcolor=%23ffffff&color=%23d62020&days=5&dynamic=true&timescale=10&type=line"></iframe>

 -->