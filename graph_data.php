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

    <!-- Bootstrap JS -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Data<span class="caret"></span></a>
                         <ul class="dropdown-menu">
                              <li><a href="gene_search.php">Search Gene Data</a></li>
                              <li><a href="graph_data.php">Graph Gene Data</a></li>
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
                <h1 class="page-header">Project Webserver
                    <small>A is for Awesome</small>
                </h1>

<?php
$db = parse_ini_file("config-file.ini");
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
	$find_genome_ids = 'SELECT DISTINCT(genome) FROM ucsc_search;';
	$result = $conn->query($find_genome_ids);
?>

<?php
	$find_trim_status = 'SELECT DISTINCT(trimmed_or_untrimmed) FROM ucsc_search;';
	$result_trim = $conn->query($find_trim_status);
?>



<?php
	$find_pipeline_id = 'SELECT DISTINCT(pipeline) FROM ucsc_search;';
	$result_pipeline = $conn->query($find_pipeline_id);
?>


  
<h1>UCSC Search</h1>
	<form action="<?php echo htmlspecialchars("graph_data.php")?>" method="post">
	<div class="input-group" style="width: 30%; float: left">
		<input type=text name="search" placeholder="Enter gene name or ID" class="form-control">

		<div class="input-group-btn">
			
		</div>
	</div>

       <select style="height: 2.4em; width: 10em;" name="genome_id">
          <?php while ($row = $result -> fetch_object()): ?>
          <option value='<?php echo $row->genome; ?>'><?php echo $row->genome; ?></option>
		  <?php endwhile; ?>

        </select>

       <select style="height: 2.4em; width: 15em;" name="trim_status_id">
          <?php while ($row = $result_trim -> fetch_object()): ?>
          <option value='<?php echo $row->trimmed_or_untrimmed; ?>'><?php echo $row->trimmed_or_untrimmed; ?></option>
		  <?php endwhile; ?>

        </select>

       <select style="height: 2.4em; width: 10em;" name="pipeline_id">
          <?php while ($row = $result_pipeline -> fetch_object()): ?>
          <option value='<?php echo $row->pipeline; ?>'><?php echo $row->pipeline; ?></option>
		  <?php endwhile; ?>

        </select>

		<select style="height: 2.4em; width: 10em;" name="rat_id">
			<option value='7973'>Rat 7973</option>
			<option value='8050'>Rat 8050</option>
			<option value='8043'>Rat 8043</option>
			<option value='8033'>Rat 8033</option>
			<option value='8059'>Rat 8059</option>
        </select>


			<button class="btn btn-default" type="submit">
				<i class="glyphicon glyphicon-search"></i>
			</button>



</form>


<?php
$input = "";
$len = "";
$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$input = htmlspecialchars($_POST["search"]);
	$genome_input = htmlspecialchars($_POST["genome_id"]);
	$trim_status_input = htmlspecialchars($_POST["trim_status_id"]);
	$pipeline_id_input = htmlspecialchars($_POST["pipeline_id"]);
	$rat_id_input = htmlspecialchars($_POST["rat_id"]);
}
$len = strlen($input);
if ($len >= 3) {
	$sql = "SELECT * FROM ucsc_search WHERE gene_id LIKE \"%$input%\" OR gene_short_name LIKE \"%$input%\"";
	$sql = $sql . " AND genome='$genome_input'";
	$sql = $sql . " AND trimmed_or_untrimmed='$trim_status_input'";
	$sql = $sql . " AND pipeline='$pipeline_id_input'";

	$result = $conn->query($sql);
	if (!$result) {
		printf("Error: %s\n", $conn->error);
	} 
	
else {
	function create_ucsc_link($row_assoc_array, $rat_id) {
		$row_genome = $row_assoc_array["genome"];
		$row_locus = $row_assoc_array["locus"];
		$big_data_url = $row_assoc_array["bam_file_rat_$rat_id"];
		
		return "http://genome.ucsc.edu/cgi-bin/hgTracks?db=$row_genome".
			"&position=$row_locus".
			"&hgct_customText=track".
			"%20type=bam".
			"%20name=myBigBedTrack".
			"%20description=%22a%20bigBed".
			"%20track%22%20visibility=full".
			"%20bigDataUrl=$big_data_url";
	
	}
	
	if ($input) {		
		if ($result->num_rows > 0) {
			$row = $result -> fetch_assoc();
			$link = create_ucsc_link($row, $rat_id_input);
			echo "<br><iframe src='$link' width='100%' height='500'></iframe>";
		}
	}
}
}
		
?>


<?php $conn->close();?>



<span class="col-sm-2"></span>




            </div>
        </div>
        <!-- /.row -->

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
