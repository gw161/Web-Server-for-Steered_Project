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
	<select id="Genome" name="Genome">                      
  	<option value="0">--Select genome--</option>
 	 <option value="rn4">rn4</option>
  	<option value="rn6">rn6</option>
	</select>

	<select id="Rat" name="Rat">
	<option value="0">--Select Rat--</option>
	<option value="7973">rat_7973</option>
	<option value="8033">rat_8033</option>
	<option value="8043">rat_8043</option>
	<option value="8050">rat_8050</option>
	<option value="8059">rat_8059</option>
	</select>

?>
</body>

</html>
