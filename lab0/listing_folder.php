<?php
$dir = ".";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {

    $files[] = $filename;
}

foreach ($files as $file) {
    if (is_dir($file))
    {
	continue;
    }

    echo "<p><a href=\"http://dev.uznam.org/ai/$file\">$file</a></p>\n";
}

closedir($dh);
?>