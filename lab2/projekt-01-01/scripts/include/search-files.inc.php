<?php


function search_files(
    $ADirName         = './',
    $AExt             = '/.*/',
    $ARecursive       = true
)
{

    if (substr($ADirName, strlen($ADirName) - 1, 1) != '/') {
        $ADirName .= '/';
    }
    
    if (($handle = opendir($ADirName)) !== false) {
        $files = array();
        while (false !== ($next = readdir($handle))) {
            if ($next != '.' && $next != '..') {
                $tmp = $ADirName . $next;
                if (is_dir($tmp)) {
                    $tmp  .= '/';
                    $next .= '/';
                    if ($ARecursive) {
                        $recfiles = search_files(
                            $tmp, $AExt,
                            $ARecursive
                        );
                        if ($recfiles) {
                            $files = array_merge($files, $recfiles);
                        };
                    };
                } else if (is_file($tmp) && preg_match($AExt, $next)) {
                       $files[] = $tmp;
                }
            };
        };
        closedir($handle);
        return $files;
    } else {
        return false;
    }
}


function unlinkRecursive($dir, $deleteRootToo = false)
{
    if (!$dh = @opendir($dir)) {
        return false;
    }
    while (false !== ($obj = readdir($dh)))
    {
        if ($obj == '.' || $obj == '..') {
            continue;
        }

        if (!@unlink($dir . '/' . $obj)) {
            unlinkRecursive($dir . '/' . $obj, true);
        }
    }

    closedir($dh);

    if ($deleteRootToo) {
        @rmdir($dir);
    }

    return;
}
