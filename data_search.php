<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bootstrap test</title>
<!-- Bootstrap Core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="4-col-portfolio.css" rel="stylesheet">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" 
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js">
</script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
</script>
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
                        <a href="data_search.html">Data-Search</a>
                    </li>
                    <li>
                        <a href="image_archive.html">Full Image Archive</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>



<div class="container">

<br><br><br><br>

<?php

// add course server to mySQL and put database on there, then change these:
$servername = "127.0.0.1";
$username = "username";
$password = "password";
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn -> connect_error) {
	$message = $conn -> connect_error;
} 

else {
	$message = "Connection successful";
}
?>
    
<h1>Data Search</h1>
	<p>Search here:</p>
	<form action="<?php echo htmlspecialchars("data_search.php")?>" method="post">
	<div class="input-group">
		<input type=text name="search" placeholder="Enter gene name or ID" class="form-control">
		<div class="input-group-btn">
			<button class="btn btn-default" type="submit">
				<i class="glyphicon glyphicon-search"></i>
			 </button>
		</div>
	</div>
</form>


<?php
$input = "";
$len = "";
$result = "";
$table = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$input = htmlspecialchars($_POST["search"]);
}

$len = strlen($input);
if ($len >= 3) {
	$sql = "SELECT * FROM Search WHERE gene_id LIKE \"%$input%\" OR gene_short_name LIKE \"%$input%\"";
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
	print "Please enter at least 3 characters.";
}
		


?>


<?php $conn->close();?>



<div class="table-responsive">
	<table class="table"><?php echo $table;?></table>
</div>

<span class="col-sm-2"></span>





</div>

</body>
</html>
