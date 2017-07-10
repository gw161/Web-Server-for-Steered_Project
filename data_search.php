<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>4 Col Portfolio - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="4-col-portfolio.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

  <body background="geometry.png">
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
                    <li>
                        <a href="data_search.php">Data-Search</a>
                    </li>
                    <li>
                        <a href="image_archive.html">Full Image Archive</a>
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
	$find_genome_ids = 'SELECT DISTINCT(genome) FROM Search;';
	$result = $conn->query($find_genome_ids);
?>

  
<h1>Data Search</h1>
	<p>Search here:</p>
	<form action="<?php echo htmlspecialchars("data_search.php")?>" method="post">
	<div class="input-group" style="width: 50%; float: left">
		<input type=text name="search" placeholder="Enter gene name or ID" class="form-control">

		<div class="input-group-btn">
			
		</div>
	</div>

       <select style="height: 2.4em; width: 10em;" name="genome_id">
          <option value='All'>All</option>
          <?php while ($row = $result -> fetch_object()): ?>
          <option value='<?php echo $row->genome; ?>'><?php echo $row->genome; ?></option>
		  <?php endwhile; ?>

        </select>

			<button class="btn btn-default" type="submit">
				<i class="glyphicon glyphicon-search"></i>
			 </button>



</form>


<?php
$input = "";
$len = "";
$result = "";
$table = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$input = htmlspecialchars($_POST["search"]);
	$genome_input = htmlspecialchars($_POST["genome_id"]);

}
$len = strlen($input);
if ($len >= 3) {
	$sql = "SELECT * FROM Search WHERE gene_id LIKE \"%$input%\" OR gene_short_name LIKE \"%$input%\"";
	if ($genome_input != 'All') { 
		$sql = $sql . " AND genome='$genome_input'";
	}

	$result = $conn->query($sql);

	if (!$result) {
printf("Error: %s\n", $conn->error);
	$table = "<strong>No results</strong>";
} 
	
else {
	echo $sql . "<br>";
	$table = "";
	if ($input) {
				
		if ($result->num_rows > 0) {
				$table = "<thead><tr> <th>Gene ID</th><th>Gene Short Name</th> <th>7973</th><th>8050</th><th>8043</th><th>8033</th><th>8059</th> </tr></thead>";
			while ($row = $result -> fetch_assoc()) {
				$table .= "<tbody><tr><td>".$row["gene_id"]."</td><td>".$row["gene_short_name"]."</td><td>".$row["7973"]."</td><td>".$row["8050"]."</td><td>".$row["8043"]."</td><td>".$row["8033"]."</td><td>".$row["8059"]."</td></tr>";  
						//echo "gene: " .  $row["gene_id"] . " " . "gene_short_name: " . $row["gene_short_name"].""7973: " . $row["7973"].""8050: " . $row["8050"].""8043: " . $row["8043"].""8033: " . $row["8033"].""8059: " . $row["8059"]."<br>";
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



        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
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
