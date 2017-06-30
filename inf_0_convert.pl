#!/usr/bin/perl
use strict;
use warnings;
my @columns;
my $string = "dog";
open (FILE1, "genes.csv") or die("Could not open\n");
open (OUTPUT, ">genes2.csv");

if ($string =~ s/dog/cat/) {
	print $string;
}

while (<FILE1>) {
	@columns = split ("\t", $_);
	foreach my $val (@columns) {
		if ($val =~ s/-Inf/0/) {
			print $val;
		}
	}
			
}
close (FILE1);
