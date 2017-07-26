<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Group A Steered Research Project</title>

    <!-- Bootstrap Core CSS -->
    <link href="CSS/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="CSS/4-col-portfolio.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- Javascript for graphing -->
		<script src="https://d3js.org/d3.v3.js"></script>


</head>

<body>

  <body background="Images/geometry.png">
 <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Project Webserver</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="background.html">Background</a>
                    </li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Data<span class="caret"></span></a>
                         <ul class="dropdown-menu">
                              <li><a href="gene_search.php">Search Gene Data</a></li>
                              <li><a href="graph_data.html">Graph Gene Data</a></li>
                              <li><a href="search_ucsc.php">Visualise Mapped Data</a></li>
                              <li><a href="fastqc.html">View FASTQC Files</a></li>
                         </ul>
                    </li>
                    <li>
                        <a href="image_archive.html">Image Archive</a>
                    </li>
                      <li>
                        <a href="team.html">Team</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">


<?php
$db = parse_ini_file("../config-file.ini");
// add course server to mySQL and put database on there, then change these:
$host = $db['host'];
$user = $db['user'];
$pass = $db['pass'];
$name = $db['name'];
// Create connection
$conn = new mysqli($host, $user, $pass, $name);
// Check connection
if ($conn -> connect_error) {
	$message = $conn -> connect_error;
} 
else {
	$message = "Connection successful";
}
?>

<?php
$heading='';
	$sql = "SELECT * FROM FPKM WHERE gene_id LIKE \"%$heading%\" OR gene_short_name LIKE \"%$heading%\"";
	$result = $conn->query($sql);

	$row = $result -> fetch_assoc();

?>

<?php
$heading=$_GET["gene"];
?>

	<h1 class="page-header"><b><?php echo $heading; ?></b>
		<small>FPKM Values (Expression Level) Per Rat</small>
	</h1>

<article> 

<p><td><h3><a target="_blank" href="http://www.sigmaaldrich.com/catalog/genes/<?php echo strtoupper($heading); ?>?lang=en&region=GB">View Gene Information</a></h3></td></p>

<div id="myDiv"><!-- Plotly chart will be drawn inside this DIV --></div>

<div id="myDiv2"><!-- Plotly chart will be drawn inside this DIV --></div>


</article>







            </div>
        </div>
        <!-- /.row -->



        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Group A Steered Research Project - MSc Bioinformatics @ University of Leicester - 2017</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>






<?php
	$sql = "SELECT * FROM FPKM WHERE gene_id LIKE \"%$heading%\" OR gene_short_name LIKE \"%$heading%\"";
	$result = $conn->query($sql);

	$row = $result -> fetch_assoc();

?>






        <!-- Start insert grouped bar graph-->



<head>
  <!-- Plotly.js -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body>
  

  <script>
var trace1 = {
  x: ['Rat 7973', 'Rat 8050', 'Rat 8043', 'Rat 8033', 'Rat 8059'], 
  y: [<?php echo $row["rat_7973_low"]; ?>, <?php echo $row["rat_8050_low"]; ?>, <?php echo $row["rat_8043_low"]; ?>, <?php echo $row["rat_8033_low"]; ?>, <?php echo $row["rat_8059_low"]; ?>], 
  name: 'FPKM Low', 
  type: 'bar'
};

var trace2 = {
  x: ['Rat 7973', 'Rat 8050', 'Rat 8043', 'Rat 8033', 'Rat 8059'], 
  y: [<?php echo $row["rat_7973"]; ?>, <?php echo $row["rat_8050"]; ?>, <?php echo $row["rat_8043"]; ?>, <?php echo $row["rat_8033"]; ?>, <?php echo $row["rat_8059"]; ?>],
  name: 'FPKM', 
  type: 'bar'
};

var trace3 = {
  x: ['Rat 7973', 'Rat 8050', 'Rat 8043', 'Rat 8033', 'Rat 8059'], 
  y: [<?php echo $row["rat_7973_high"]; ?>, <?php echo $row["rat_8050_high"]; ?>, <?php echo $row["rat_8043_high"]; ?>, <?php echo $row["rat_8033_high"]; ?>, <?php echo $row["rat_8059_high"]; ?>],
  name: 'FPKM High', 
  type: 'bar'
};

var data = [trace1, trace2, trace3];
var layout = {title: 'Grouped Bar Chart', barmode: 'group'};

Plotly.newPlot('myDiv', data, layout);
  </script>
</body>



        <!-- End insert grouped bar graph-->


        <!-- Start insert heat map-->




<head>
  <!-- Plotly.js -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body>
  

  <script>
var xValues = ['<?php echo $row["gene_short_name"]; ?>'];

var yValues = ['rat_7973', 'rat_8050', 'rat_8043', 'rat_8033', 'rat_8059'];

var zValues = [
  [<?php echo $row["rat_7973"]; ?>],
  [<?php echo $row["rat_8050"]; ?>],
  [<?php echo $row["rat_8043"]; ?>],
  [<?php echo $row["rat_8033"]; ?>],  
  [<?php echo $row["rat_8059"]; ?>]
];

var colorscaleValue = [
  [0, '#3D9970'],
  [1, '#001f3f']
];

var data = [{
  x: xValues,
  y: yValues,
  z: zValues,
  type: 'heatmap',
  colorscale: colorscaleValue,
  showscale: false
}];

var layout = {
  title: 'Annotated Heatmap',
  annotations: [],
  xaxis: {
    ticks: '',
    side: 'top'
  },
  yaxis: {
    ticks: '',
    ticksuffix: ' ',
    width: 700,
    height: 700,
    autosize: false
  }
};

for ( var i = 0; i < yValues.length; i++ ) {
  for ( var j = 0; j < xValues.length; j++ ) {
    var currentValue = zValues[i][j];
    if (currentValue != 0.0) {
      var textColor = 'white';
    }else{
      var textColor = 'black';
    }
    var result = {
      xref: 'x1',
      yref: 'y1',
      x: xValues[j],
      y: yValues[i],
      text: zValues[i][j],
      font: {
        family: 'Arial',
        size: 12,
        color: 'rgb(50, 171, 96)'
      },
      showarrow: false,
      font: {
        color: textColor
      }
    };
    layout.annotations.push(result);
  }
}

Plotly.newPlot('myDiv2', data, layout);
  </script>
</body>




        <!-- End insert heat map-->
















		<script>







var mousedata = [{

	"name": "rat_7973",
	"x": 1,
	"expression": <?php echo $row["rat_7973"]; ?>
},

{
	"name": "rat_8050",
	"x": 2,
	"expression": <?php echo $row["rat_8050"]; ?>


},

{
	"name": "rat_8043",
	"x": 3,
	"expression": <?php echo $row["rat_8043"]; ?>


},

{
	"name": "rat_8033",
	"x": 4,
	"expression": <?php echo $row["rat_8033"]; ?>


},

{
	"name": "rat_8059",
	"x": 5,
	"expression": <?php echo $row["rat_8059"]; ?>

}];

// call the method below
showScatterPlot(mousedata);


function showScatterPlot(data) {
    // just to have some space around items. 
    var margins = {
        "left": 40,
            "right": 30,
            "top": 30,
            "bottom": 30
    };
    
    var width = 500;
    var height = 500;
    
    // this will be our colour scale. An Ordinal scale.
    var colors = d3.scale.category10();

    // we add the SVG component to the scatter-load div
    var svg = d3.select("#scatter-load").append("svg").attr("width", width).attr("height", height).append("g")
        .attr("transform", "translate(" + margins.left + "," + margins.top + ")");

    // this sets the scale that we're using for the X axis. 
    // the domain define the min and max variables to show. In this case, it's the min and max prices of items.
    // this is made a compact piece of code due to d3.extent which gives back the max and min of the price variable within the dataset
    var x = d3.scale.linear()
        .domain(d3.extent(data, function (d) {
        return d.x;
    }))
    // the range maps the domain to values from 0 to the width minus the left and right margins (used to space out the visualization)
        .range([0, width - margins.left - margins.right]);

    // this does the same as for the y axis but maps from the rating variable to the height to 0. 
    var y = d3.scale.linear()
        .domain(d3.extent(data, function (d) {
        return d.expression;
    }))
    // Note that height goes first due to the weird SVG coordinate system
    .range([height - margins.top - margins.bottom, 0]);

    // we add the axes SVG component. At this point, this is just a placeholder. The actual axis will be added in a bit
    svg.append("g").attr("class", "x axis").attr("transform", "translate(0," + y.range()[0] + ")");
    svg.append("g").attr("class", "y axis");

    // this is our X axis label. Nothing too special to see here.
    svg.append("text")
        .attr("fill", "#414241")
        .attr("text-anchor", "end")
        .attr("x", width / 2)
        .attr("y", height - 35)
        .text("Ratty");


    // this is the actual definition of our x and y axes. The orientation refers to where the labels appear - for the x axis, below or above the line, and for the y axis, left or right of the line. Tick padding refers to how much space between the tick and the label. There are other parameters too - see https://github.com/mbostock/d3/wiki/SVG-Axes for more information
    var xAxis = d3.svg.axis().scale(x).orient("bottom").tickPadding(2);
    var yAxis = d3.svg.axis().scale(y).orient("left").tickPadding(2);

    // this is where we select the axis we created a few lines earlier. See how we select the axis item. in our svg we appended a g element with a x/y and axis class. To pull that back up, we do this svg select, then 'call' the appropriate axis object for rendering.    
    svg.selectAll("g.y.axis").call(yAxis);
    svg.selectAll("g.x.axis").call(xAxis);

    // now, we can get down to the data part, and drawing stuff. We are telling D3 that all nodes (g elements with class node) will have data attached to them. The 'key' we use (to let D3 know the uniqueness of items) will be the name. Not usually a great key, but fine for this example.
    var chocolate = svg.selectAll("g.node").data(data, function (d) {
        return d.name;
    });

    // we 'enter' the data, making the SVG group (to contain a circle and text) with a class node. This corresponds with what we told the data it should be above.
    
    var chocolateGroup = chocolate.enter().append("g").attr("class", "node")
    // this is how we set the position of the items. Translate is an incredibly useful function for rotating and positioning items 
    .attr('transform', function (d) {
        return "translate(" + x(d.x) + "," + y(d.expression) + ")";
    });

    // we add our first graphics element! A circle! 
    chocolateGroup.append("circle")
        .attr("r", 5)
        .attr("class", "dot")
        .style("fill", function (d) {
            // remember the ordinal scales? We use the colors scale to get a colour for our manufacturer. Now each node will be coloured
            // by who makes the chocolate. 
            return colors(d.manufacturer);
    });

    // now we add some text, so we can see what each item is.
    chocolateGroup.append("text")
        .style("text-anchor", "middle")
        .attr("dy", -10)
        .text(function (d) {
            // this shouldn't be a surprising statement.
            return d.name;
    });
}
		</script>

</html>
