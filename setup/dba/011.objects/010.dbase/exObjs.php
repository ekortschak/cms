<?php

// ***********************************************************
HTW::xtag("dbo.check objects", "h5");
// ***********************************************************
incCls("dbase/dbAlter.php");

$ddl = new dbAlter($dbs, $tbl);
$ddl->askMe(false);
$ddl->tellMe(false);

// ***********************************************************
$ddl->t_add("dbusr");
// ***********************************************************
$ddl->f_add("dbusr", "uname",	"var",  25);
$ddl->f_add("dbusr", "pwd",		"var",  32);
$ddl->f_add("dbusr", "email",	"var", 150);
$ddl->f_add("dbusr", "country",	"var",   5);
$ddl->f_add("dbusr", "tstamp",	"cur");
$ddl->f_add("dbusr", "status",   "var",  15);
$ddl->f_add("dbusr", "acticode", "dat");

// ***********************************************************
$ddl->t_add("dbobjs");
// ***********************************************************
$ddl->f_add("dbobjs", "cat", 	"var",   5);
$ddl->f_add("dbobjs", "spec",	"var",  25);
$ddl->f_add("dbobjs", "prop",	"var",  25);
$ddl->f_add("dbobjs", "value",	"var",  25);
$ddl->f_add("dbobjs", "input",	"var", 150);
$ddl->f_add("dbobjs", "mask", 	"var",  50);

// ***********************************************************
$ddl->t_add("dbxs");
// ***********************************************************
$ddl->f_add("dbxs", "cat", 	 "var",  5);
$ddl->f_add("dbxs", "spec",	 "var", 25);
$ddl->f_add("dbxs", "www",	 "var",  5, "x", "NULL");
$ddl->f_add("dbxs", "user",	 "var",  5, "r", "NULL");
$ddl->f_add("dbxs", "admin", "var",  5, "w", "NULL");

// ***********************************************************
$ddl->t_add("copyright");
// ***********************************************************
$ddl->f_add("copyright", "md5",	   "var", 32);
$ddl->f_add("copyright", "tstamp", "var", 15);
$ddl->f_add("copyright", "owner",  "var", 25);
$ddl->f_add("copyright", "holder", "var", 75);
$ddl->f_add("copyright", "perms",  "var",  5);
$ddl->f_add("copyright", "memo",   "mem");

// ***********************************************************
$ddl->t_add("feedback");
// ***********************************************************
$ddl->f_add("feedback", "owner",  "var", 50);
$ddl->f_add("feedback", "tstamp", "var", 15);
$ddl->f_add("feedback", "topic",  "var", 25);
$ddl->f_add("feedback", "rating", "int");
$ddl->f_add("feedback", "memo",	  "txt");

// ***********************************************************
echo "Done";
// ***********************************************************

?>
