<?php

include_once "config/fallback.php";
include_once "core/include/load.min.php";

incCls("server/curl.php");

// ***********************************************************
#print_r($_FILES);

$crl = new curl();

// ***********************************************************
$arr = $_FILES;
$cnt = 0;

foreach ($arr as $dir => $inf) {
	extract($inf);

	switch ($name) {
		case "curl.mkd": return $crl->bulk_job($tmp_name, "force");
		case "curl.rmd": return $crl->bulk_job($tmp_name, "rmDir");
		case "curl.dpf": return $crl->bulk_job($tmp_name, "kill");

		case "curl.ren": return $crl->bulk_ren($tmp_name);
		case "curl.cpf": return $crl->bulk_cpy($tmp_name);
		default:
			$cnt+= $crl->copy($tmp_name, $dir, $name);
	}
}
echo "total: $cnt";

?>
