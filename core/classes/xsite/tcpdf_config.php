<?php

// IMPORTANT:
// If you define the constant K_TCPDF_EXTERNAL_CONFIG, all the following settings will be ignored.
// If you use the tcpdf_autoconfig.php, then you can overwrite some values here.

define("MYFONT", "FreeSans");

define ('K_PATH_MAIN', TCPDF);
//define ('K_PATH_URL', '');

// Doc Info
define ('K_BLANK_IMAGE', '_blank.png');
define ('PDF_PAGE_FORMAT', 'A4');
define ('PDF_PAGE_ORIENTATION', 'P');
define ('PDF_CREATOR', 'TCPDF');
define ('PDF_AUTHOR', 'TCPDF');
define ('PDF_HEADER_TITLE', PRJ_TITLE);
define ('PDF_HEADER_STRING', "by glaubeistmehr.at");
define ('PDF_UNIT', 'mm');

// margins
define ('PDF_MARGIN_HEADER', 5);
define ('PDF_MARGIN_FOOTER', 10);
define ('PDF_MARGIN_TOP', 27);
define ('PDF_MARGIN_BOTTOM', 25);
define ('PDF_MARGIN_LEFT', 15);
define ('PDF_MARGIN_RIGHT', 15);

// fonts
$dir = FSO::join(TCPDF, "fonts/");
define ('K_PATH_FONTS', $dir);

define ('PDF_FONT_NAME_MAIN', 'helvetica');
define ('PDF_FONT_NAME_DATA', 'helvetica');
define ('PDF_FONT_MONOSPACED', 'mono');

define ('PDF_FONT_SIZE_MAIN', 10);
define ('PDF_FONT_SIZE_DATA', 8);

// Ratio used to adjust the conversion of pixels to user units.
define ('PDF_IMAGE_SCALE_RATIO', 1);
define('HEAD_MAGNIFICATION', 1);
define('K_CELL_HEIGHT_RATIO', 1);
define('K_TITLE_MAGNIFICATION', 1);
define('K_SMALL_RATIO', 2/3);

// If true and PHP version is greater than 5, then the Error() method throw new exception instead of terminating the execution.
define('K_TCPDF_THROW_EXCEPTION_ERROR', true);

// Default timezone for datetime functions
define('K_TIMEZONE', 'UTC');

?>
