<?php

// project
CFG::set("PRJ_TITLE",  "Free CMS");
CFG::set("EDITING",    "view");
CFG::set("ERR_SHOW",   1);

CFG::set("LAYOUT",     "default");
CFG::set("COLORS",     "default");
CFG::set("EDITOR",     "default");

CFG::set("LANGUAGES",  "en");
CFG::set("GEN_LANG",   "en");
CFG::set("DATE_FMT",   "Y/m/d");
CFG::set("TIMEZONE",   "Europe/Vienna");

CFG::set("ARCHIVE",    SRV_ROOT);

// security
CFG::set("WWW_USER",   "www-data");
CFG::set("SECRET",     "anystring");
CFG::set("TIMEOUT",    15);

// database
CFG::set("DB_MODE",    0);
CFG::set("DB_HOST",    "localhost");
CFG::set("DB_FILE",    "none");
CFG::set("DB_GRPS",    "www");
CFG::set("DB_USER",    "none");
CFG::set("DB_PASS",    "none");
CFG::set("DB_CON",     false);

CFG::set("DB_ADMIN",   0);
CFG::set("DB_LOGIN",   0);

// networking
CFG::set("MAILMODE",   "none");
CFG::set("MAILMASTER", "nobody@home");
CFG::set("MAILTESTER", "nobody@home");
CFG::set("NOREPLY",    "nobody@home");

CFG::set("FTP_MODE",   "none");

CFG::set("CSS_URL",    "x.css.php");
CFG::set("CMS_URL",    "/cms");
CFG::set("CK4_URL",    "https://cdn.ckeditor.com/4.16.0/standard");
CFG::set("CK5_URL",    "https://cdn.ckeditor.com/ckeditor5/24.0.0/classic");

?>
