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
                    <h1 class="page-header">Search Gene Expression Level Data
                    </h1>

			    	<?php
			    	// Insert connection details from config-file.ini
				    $db = parse_ini_file("../config-file.ini");
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
			    		$find_genome_ids = 'SELECT DISTINCT(genome) FROM FPKM_and_counts;';
			    		$result = $conn->query($find_genome_ids);
			    	?>

			    	<?php
			    		$find_trim_status = 'SELECT DISTINCT(trim_status) FROM FPKM_and_counts;';
			    		$result_trim = $conn->query($find_trim_status);
		    		?>

			    	<?php
			    		$find_pipeline_id = 'SELECT DISTINCT(pipeline) FROM FPKM_and_counts;';
			    		$result_pipeline = $conn->query($find_pipeline_id);
			    	?>
					
					<!-- HTML form created using variable data from MySQL table -->
			    	<form action="<?php echo htmlspecialchars("gene_search.php")?>" method="post">
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
					  <option value='All'>Trimmed And Untrimmed</option>
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
						$sql = "SELECT * FROM FPKM_and_counts WHERE gene_short_name LIKE \"%$input%\"";
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
							if ($input) {
				
								if ($result->num_rows > 0) {
									// PHP generated table to hold MySQL data
									$table = "<thead><tr> <th>Select</th> <th>Gene Name</th> <th>Genome</th> <th>Trim Status</th> <th>Pipeline</th> <th>Rat 7973 FPKM/Counts</th><th>Rat 8050 FPKM/Counts</th><th>Rat 8043 FPKM/Counts</th><th>Rat 8033 FPKM/Counts</th><th>Rat 8059 FPKM/Counts</th> </tr></thead>";
									while ($row = $result -> fetch_assoc()) {
										$table .= "<tbody><tr><td>".$row["click"]."<a target='_blank' href='http://www.sigmaaldrich.com/catalog/genes/".$row["gene_short_name"]."?lang=en&region=GB'><button type='button' class='btn btn-default btn-xs'>Gene Information</button></a><br><a target='_blank' href='gene_view.php?gene=".$row["gene_short_name"]."&genome=".$row["genome"]."&pipeline=".$row["pipeline"]."'><button type='button' class='btn btn-default btn-xs'>Plotly Bar Chart</button></a></td><td>".$row["gene_short_name"]."</a></td><td>".$row["genome"]."</td><td>".$row["trim_status"]."</td><td>".$row["pipeline"]."</td><td>".$row["rat_7973"]."</td><td>".$row["rat_8050"]."</td><td>".$row["rat_8043"]."</td><td>".$row["rat_8033"]."</td><td>".$row["rat_8059"]."</td></tr>";  
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
