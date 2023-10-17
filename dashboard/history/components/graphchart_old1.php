<div id="layoutSidenav_content">

<style>
    .bargraph {
      width: 1500px;
      height: 450px;
      margin: 20px; 
      padding: 10px; 
   
    }
  </style>

<div id='myDiv'><!-- Plotly chart will be drawn inside this DIV --></div>

<script type="text/javascript">

d3.csv("https://raw.githubusercontent.com/plotly/datasets/master/finance-charts-apple.csv", function(err, rows){
  function unpack(rows, key) {
  return rows.map(function(row) { return row[key]; });
}

  var x = unpack(rows, 'Date')
  var y = unpack(rows, 'AAPL.Volume')

  var trace = {
    type: "scatter",
    mode: "lines",
    name: 'AAPL Volume',
    x: x,
    y: y,
    line: {color: 'blue'},
    line: {color: 'orange'}
  }

  var data = [trace];

var layout = {
  title: 'Stocks Data',
  xaxis: {
    title: 'Quantity',
    titlefont: {
      family: 'Arial, sans-serif',
      size: 18,
      color: 'black'
    },
    showticklabels: true,
    tickangle: 'auto',
    tickfont: {
      family: 'Old Standard TT, serif',
      size: 14,
      color: 'green'
    },
    exponentformat: 'e',
    showexponent: 'all'
  },
  yaxis: {
    title: 'Month and Year',
    titlefont: {
      family: 'Arial, sans-serif',
      size: 18,
      color: 'black'
    },
    showticklabels: true,
    tickangle: 45,
    tickfont: {
      family: 'Old Standard TT, serif',
      size: 14,
      color: 'green'
    },
    exponentformat: 'e',
    showexponent: 'all'
  }
};

Plotly.newPlot('myDiv', data, layout);
})



</script>

</div>