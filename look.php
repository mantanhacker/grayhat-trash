<?php
/**
 * PHP Vulnerability Surface Checker
 * Features: No-index for SEO, Styled UI
 * by Mantan Hacker, Umbra Groups, Manadoghost, L4663r666h05t, neoKecoak
 */

header('X-Robots-Tag: noindex, nofollow, noarchive');

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<html><head>
    <title>Vulnerability Surface Scanner</title>
    <meta name='robots' content='noindex, nofollow, noarchive, nosnippet'>
    <meta name='googlebot' content='noindex, nofollow'>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f0f0f; color: #d1d1d1; padding: 30px; }
        .container { max-width: 900px; margin: auto; }
        h2 { color: #fff; border-bottom: 2px solid #333; padding-bottom: 10px; }
        table { border-collapse: collapse; width: 100%; background: #1a1a1a; box-shadow: 0 4px 10px rgba(0,0,0,0.5); }
        th, td { border: 1px solid #333; padding: 12px 15px; text-align: left; }
        th { background: #252525; color: #00ff41; text-transform: uppercase; font-size: 13px; }
        .status-vulnerable { color: #ff4757; font-weight: bold; background: rgba(255, 71, 87, 0.1); padding: 2px 6px; border-radius: 4px; }
        .status-secure { color: #2ed573; background: rgba(46, 213, 115, 0.1); padding: 2px 6px; border-radius: 4px; }
        .highlight-red { color: #ff4757; font-weight: bold; }
        small { color: #888; word-break: break-all; }
    </style>
</head><body>
<div class='container'>";

echo "<h2>[+] SECURITY SURFACE CHECKER [+]</h2>";
echo "<table>";
echo "<tr><th>Component / Vector</th><th>Status / Findings</th></tr>";

// Helper function for status display
function checkStatus($condition, $vulnerableIfTrue = true) {
    if ($vulnerableIfTrue) {
        return $condition ? "<span class='status-vulnerable'>ENABLED / VULNERABLE</span>" : "<span class='status-secure'>DISABLED / SECURE</span>";
    } else {
        return $condition ? "<span class='status-secure'>PROTECTED</span>" : "<span class='status-vulnerable'>EXPOSED / NO LIMIT</span>";
    }
}

// FFI Check
echo "<tr><td>FFI (Function Injection)</td><td>" . checkStatus(class_exists('FFI')) . "</td></tr>";

// Imagick Check
echo "<tr><td>Imagick Extension</td><td>" . checkStatus(extension_loaded('imagick')) . "</td></tr>";

// PCRE JIT
echo "<tr><td>PCRE JIT (Memory Spraying)</td><td>" . checkStatus(ini_get('pcre.jit') == 1) . "</td></tr>";

// Stream Wrappers
$wrappers = stream_get_wrappers();
$risk_wrappers = ['gopher', 'expect', 'phar', 'dict', 'ftp'];
$output_wrappers = [];
foreach($wrappers as $w) {
    $output_wrappers[] = in_array($w, $risk_wrappers) ? "<span class='highlight-red'>$w</span>" : $w;
}
echo "<tr><td>Stream Wrappers</td><td>" . implode(', ', $output_wrappers) . "</td></tr>";

// Native Mail Function
echo "<tr><td>Native mail() (Exfiltration/LD_PRELOAD)</td><td>" . checkStatus(function_exists('mail')) . "</td></tr>";

// Open Basedir
$obd = ini_get('open_basedir');
echo "<tr><td>open_basedir Restriction</td><td>" . ($obd ? "<span class='status-secure'>Path: $obd</span>" : "<span class='status-vulnerable'>DISABLED (FULL FS ACCESS)</span>") . "</td></tr>";

// Disabled Functions
$df = ini_get('disable_functions');
echo "<tr><td>Disabled Functions</td><td><small>" . ($df ? $df : "NONE (ALL FUNCTIONS ALLOWED)") . "</small></td></tr>";

// Server Software Info
echo "<tr><td>Server Environment</td><td>" . htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</td></tr>";

echo "</table>";
echo "<p style='margin-top: 20px; color: #555;'>Scan completed. No logs were generated.</p>";
echo "</div></body></html>";
?>
