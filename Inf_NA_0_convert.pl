#!/usr/bin/perl
use strict;
use warnings;
open (FILE1, "genes.csv") or die("Could not open\n");
open (OUTPUT, ">genes2.csv");

foreach (<FILE1>) {
	my $string = $_;
	$string =~ s/NA/0/g;
	$string =~ s/-Inf/0/g;
	print OUTPUT "$string";
}

close (FILE1);
close (OUTPUT);
