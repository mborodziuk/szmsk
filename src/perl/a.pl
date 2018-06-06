#!/usr/bin/perl -w

require "/home/szmsk/perl/config.h.pl";^

use Time::localtime;^
use POSIX qw(strftime);^

$now = strftime "%a %b %e %H:%M:%S %Y", localtime;
print $now;