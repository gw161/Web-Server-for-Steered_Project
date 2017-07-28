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
                        <a href="background.html">Analysis Summary</a>
                    </li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Data<span class="caret"></span></a>
                         <ul class="dropdown-menu">
                              <li><a href="gene_search.php">Expression Levels</a></li>
                              <li><a href="diff_exp.php">Differential Expression</a></li>
                              <li><a href="graph_data.html">Volcano Plot with R Shiny</a></li>
                              <li><a href="search_ucsc.php">Visualise Mapped Data</a></li>
                              <li><a href="fastqc.html">View FastQC Files</a></li>
                         </ul>
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
                <h1 class="page-header">Visualise Mapped Data on the UCSC Genome Browser
                </h1>

		<?php
		$db = parse_ini_file("../config-file.ini");
		// Insert connection details from config-file.ini
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
			$find_genome_ids = 'SELECT DISTINCT(genome) FROM UCSC_search;';
			$result = $conn->query($find_genome_ids);
		?>

		<?php
			$find_trim_status = 'SELECT DISTINCT(trim_status) FROM UCSC_search;';
			$result_trim = $conn->query($find_trim_status);
		?>

		<?php
			$find_pipeline_id = 'SELECT DISTINCT(pipeline) FROM UCSC_search;';
			$result_pipeline = $conn->query($find_pipeline_id);
		?>


	 	<!-- HTML form created using variable data from MySQL table -->
		<form action="<?php echo htmlspecialchars("search_ucsc.php")?>" method="post">
		<div class="input-group" style="width: 40%; float: left">
			<input type=text name="search" placeholder="Enter gene name to search" class="form-control">

			<div class="input-group-btn">
			
		    </div>
		</div>

	        <select style="height: 2.4em; width: 10em;" name="genome_id">
		  <option value='All'>All Genomes</option>
		  <?php while ($row = $result -> fetch_object()): ?>
		  <option value='<?php echo $row->genome; ?>'><?php echo $row->genome; ?></option>
			  <?php endwhile; ?>

	        </select>

	        <select style="height: 2.4em; width: 15em;" name="trim_status_id">
		  <option value='All'>Trim Status</option>
		  <?php while ($row = $result_trim -> fetch_object()): ?>
		  <option value='<?php echo $row->trim_status; ?>'><?php echo $row->trim_status; ?></option>
			  <?php endwhile; ?>

	        </select>

	        <select style="height: 2.4em; width: 10em;" name="pipeline_id">
		  <option value='All'>All Pipelines</option>
		  <?php while ($row = $result_pipeline -> fetch_object()): ?>
		  <option value='<?php echo $row->pipeline; ?>'><?php echo $row->pipeline; ?></option>
			  <?php endwhile; ?>

		</select>

		<button type="submit" class="btn btn-default">Submit</button>

		</form>

	<?php
	$input = "";
	$len = "";
	$result = "";
	$table = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$input = htmlspecialchars($_POST["search"]);
		$genome_input = htmlspecialchars($_POST["genome_id"]);
		$trim_input = htmlspecialchars($_POST["trim_status_id"]);
		$pipeline_input = htmlspecialchars($_POST["pipeline_id"]);
	}
	$len = strlen($input);
	if ($len >= 3) {
		// When user types in a query and selects dropdown options, data from the MySQL table populates a PHP generated table 
		$sql = "SELECT * FROM UCSC_search WHERE gene_short_name LIKE \"%$input%\"";
		if ($genome_input != 'All') { 
			$sql = $sql . " AND genome='$genome_input'";
		}
	
		if ($trim_input != 'All') {
			$sql = $sql . " AND trim_status='$trim_input'";
		}
	
		if ($pipeline_input != 'All') {
			$sql = $sql . " AND pipeline='$pipeline_input'";
		}

		$result = $conn->query($sql);
		if (!$result) {
	printf("Error: %s\n", $conn->error);
		$table = "<strong>No results</strong>";
		} 
	
		else {
			$table = "";
			function create_ucsc_link($row_assoc_array, $rat_id) {
				$row_genome = $row_assoc_array["genome"];
				$big_data_url = $row_assoc_array["bam_file_rat_$rat_id"];
				$gene_input = $row_assoc_array["gene_short_name"];
				$row_pipeline = $row_assoc_array["pipeline"];
				$row_trim_status = $row_assoc_array["trim_status"];
		
				return "http://genome.ucsc.edu/cgi-bin/hgTracks?db=$row_genome".
					"&position=$gene_input".
					"&hgct_customText=track".
					"%20type=bam".
					"%20name=myBigBedTrack".
					"%20description=%22$gene_input%20$row_genome".
					"%20pipeline $row_pipeline $row_trim_status%22%20visibility=full".
					"%20bigDataUrl=$big_data_url";
	
			}
	
			if ($input) {
				
				if ($result->num_rows > 0) {
						// PHP generated table to hold MySQL data
						$table = "<thead><tr> <th>Gene Name</th> <th>Genome</th> <th>Trim Status</th> <th>Pipeline</th> <th>Rat 7973</th><th>Rat 8050</th><th>Rat 8043</th><th>Rat 8033</th><th>Rat 8059</th> </tr></thead>";
					while ($row = $result -> fetch_assoc()) {
						$table .= "<tbody><tr><td>".$row["gene_short_name"]."</td><td>".$row["genome"]."</td><td>".$row["trim_status"]."</td><td>".$row["pipeline"]."</td><td>".$row["rat_7973"]."<a target='_blank' href='". create_ucsc_link($row, "7973") ."'><button type='button' class='btn btn-default btn-xs'>View in UCSC</button></a></td><td>".$row["rat_8050"]."<a target='_blank' href='".create_ucsc_link($row, "8050")."'><button type='button' class='btn btn-default btn-xs'>View in UCSC</button></a>
		</td><td>".$row["rat_8043"]."<a target='_blank' href='".create_ucsc_link($row, "8043")."'><button type='button' class='btn btn-default btn-xs'>View in UCSC</button></a></td><td>".$row["rat_8033"]."<a target='_blank' href='".create_ucsc_link($row, "8033")."'><button type='button' class='btn btn-default btn-xs'>View in UCSC</button></a></td><td>".$row["rat_8059"]."<a target='_blank' href='".create_ucsc_link($row, "8059")."'><button type='button' class='btn btn-default btn-xs'>View in UCSC</button></a></td></tr>";  
					}
				$table .= "</tbody>";
				} 
				else { 
					$table = "<strong>No results</strong>"; 
				}
			}
		}
	}
	else {
		print "<p style='clear: both;'>Please enter at least 3 characters.</p>";
	}
		
	?>

	<?php $conn->close();?>

	<div class="table-responsive">
		<table class="table"><?php echo $table;?></table>
	</div>

	<span class="col-sm-2"></span>

            </div>
        </div>
        <!-- /.row -->

	<br><br><br><br><br><br><br><br><br><br><br><br>

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
