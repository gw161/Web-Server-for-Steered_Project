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
							<li><a href="gene_search.php">Search by Gene</a></li>
							<li><a href="search_ucsc.php">Genome Browser</a></li>
							<li><a href="fastqc.html">FASTQC</a></li>
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
	$sql = "SELECT * FROM Search WHERE gene_id LIKE \"%$heading%\" OR gene_short_name LIKE \"%$heading%\"";
	$result = $conn->query($sql);

	$row = $result -> fetch_assoc();

?>

<?php
$heading=$_GET["gene"];
?>

	<h1 class="page-header"><b><?php echo $heading; ?></b>
		<small>IDK</small>
	</h1>

<article> 

<p><td><h3><a target="_blank" href="http://www.sigmaaldrich.com/catalog/genes/<?php echo strtoupper($heading); ?>?lang=en&region=GB">View Gene Information</a></h3></td></p>
<p><h3>FPKM Values Per Rat:</h3></p>

<div id ="chartID"></div>


<p><h3>idk lol:</h3></p>

<div id="scatter-load"></div>
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



<style>
.axis {
    font: 13px sans-serif;
  }
.axis path, .axis line {
    fill: none;
    stroke: black;
    shape-rendering: crispEdges;
  }

.bar {
    fill: #8CD3DD;
  }
.bar:hover {
    fill: #F56C4E;
  }
svg text.label {
  fill:black;
  font: 15px;  
  font-weight: 400;
  text-anchor: middle;
}
#chartID {
	min-width: 531px;
}
	</style>


        <!-- Insert bar chart-->




<script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>







<script>





<?php
	$sql = "SELECT * FROM Search WHERE gene_id LIKE \"%$heading%\" OR gene_short_name LIKE \"%$heading%\"";
	$result = $conn->query($sql);

	$row = $result -> fetch_assoc();

?>



var data = [{"food":"rat_7973","quantity":<?php echo $row["rat_7973"]; ?>},{"food":"8050","quantity":<?php echo $row["rat_8050"]; ?>},{"food":"rat_8043","quantity":<?php echo $row["rat_8043"]; ?>},{"food":"rat_8033","quantity":<?php echo $row["rat_8033"]; ?>},{"food":"rat_8059","quantity":<?php echo $row["rat_8059"]; ?>}]



var margin = {top:10, right:10, bottom:90, left:10};

var width = 960 - margin.left - margin.right;

var height = 500 - margin.top - margin.bottom;

var xScale = d3.scale.ordinal().rangeRoundBands([0, width], .03)

var yScale = d3.scale.linear()
      .range([height, 0]);


var xAxis = d3.svg.axis()
		.scale(xScale)
		.orient("bottom");
      
      
var yAxis = d3.svg.axis()
		.scale(yScale)
		.orient("left");

var svgContainer = d3.select("#chartID").append("svg")
		.attr("width", width+margin.left + margin.right)
		.attr("height",height+margin.top + margin.bottom)
		.append("g").attr("class", "container")
		.attr("transform", "translate("+ margin.left +","+ margin.top +")");

xScale.domain(data.map(function(d) { return d.food; }));
yScale.domain([0, d3.max(data, function(d) { return d.quantity; })]);


//xAxis. To put on the top, swap "(height)" with "-5" in the translate() statement. Then you'll have to change the margins above and the x,y attributes in the svgContainer.select('.x.axis') statement inside resize() below.
var xAxis_g = svgContainer.append("g")
		.attr("class", "x axis")
		.attr("transform", "translate(0," + (height) + ")")
		.call(xAxis)
		.selectAll("text");
			
// Uncomment this block if you want the y axis
/*var yAxis_g = svgContainer.append("g")
		.attr("class", "y axis")
		.call(yAxis)
		.append("text")
		.attr("transform", "rotate(-90)")
		.attr("y", 6).attr("dy", ".71em")
		//.style("text-anchor", "end").text("Number of Applicatons"); 
*/


	svgContainer.selectAll(".bar")
  		.data(data)
  		.enter()
  		.append("rect")
  		.attr("class", "bar")
  		.attr("x", function(d) { return xScale(d.food); })
  		.attr("width", xScale.rangeBand())
  		.attr("y", function(d) { return yScale(d.quantity); })
  		.attr("height", function(d) { return height - yScale(d.quantity); });





// Controls the text labels at the top of each bar. Partially repeated in the resize() function below for responsiveness.
	svgContainer.selectAll(".text")  		
	  .data(data)
	  .enter()
	  .append("text")
	  .attr("class","label")
	  .attr("x", (function(d) { return xScale(d.food) + xScale.rangeBand() / 2 ; }  ))
	  .attr("y", function(d) { return yScale(d.quantity) + 1; })
	  .attr("dy", ".75em")
	  .text(function(d) { return d.quantity; });  



document.addEventListener("DOMContentLoaded", resize);
d3.select(window).on('resize', resize); 

function resize() {
	console.log('----resize function----');
  // update width
  width = parseInt(d3.select('#chartID').style('width'), 10);
  width = width - margin.left - margin.right;

  height = parseInt(d3.select("#chartID").style("height"));
  height = height - margin.top - margin.bottom;
	console.log('----resiz width----'+width);
	console.log('----resiz height----'+height);
  // resize the chart
  
    xScale.range([0, width]);
    xScale.rangeRoundBands([0, width], .03);
    yScale.range([height, 0]);

    yAxis.ticks(Math.max(height/50, 2));
    xAxis.ticks(Math.max(width/50, 2));

    d3.select(svgContainer.node().parentNode)
        .style('width', (width + margin.left + margin.right) + 'px');

    svgContainer.selectAll('.bar')
    	.attr("x", function(d) { return xScale(d.food); })
      .attr("width", xScale.rangeBand());
      
   svgContainer.selectAll("text")  		
	 // .attr("x", function(d) { return xScale(d.food); })
	 .attr("x", (function(d) { return xScale(d.food	) + xScale.rangeBand() / 2 ; }  ))
      .attr("y", function(d) { return yScale(d.quantity) + 1; })
      .attr("dy", ".75em");   	      

    svgContainer.select('.x.axis').call(xAxis.orient('bottom')).selectAll("text").attr("y",10).call(wrap, xScale.rangeBand());
    // Swap the version below for the one above to disable rotating the titles
    // svgContainer.select('.x.axis').call(xAxis.orient('top')).selectAll("text").attr("x",55).attr("y",-25);
    	
   
}


function wrap(text, width) {
  text.each(function() {
    var text = d3.select(this),
        words = text.text().split(/\s+/).reverse(),
        word,
        line = [],
        lineNumber = 0,
        lineHeight = 1.1, // ems
        y = text.attr("y"),
        dy = parseFloat(text.attr("dy")),
        tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
    while (word = words.pop()) {
      line.push(word);
      tspan.text(line.join(" "));
      if (tspan.node().getComputedTextLength() > width) {
        line.pop();
        tspan.text(line.join(" "));
        line = [word];
        tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
      }
    }
  });
}

</script>
        <!-- End insert bar chart-->























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
