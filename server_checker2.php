<?php
error_reporting(0);
ini_set("display_errors", 0);

function check($host) {
    $fp = @fsockopen($host, 1670, $errno, $errstr, 10);
    if (!$fp) {
        echo "$errstr ($errno)\n";
        return false;
    } else {
        fclose($fp);
        return true;
    }
}

$results = array(
    '0' => array(
        'id' => 1,
        'server_name' => 'Test',
        'ip_address' => '209.40.98.14'
    ),
    '1' => array(
        'id' => 1,
        'server_name' => 'Device',
        'ip_address' => '103.31.155.138'
    )
);

foreach($results as $result) {
    $id = $result['id'];
    $server_name = $result['server_name'];
    $host = $result['ip_address'];
    if (!check($host)) {
        echo $server_name. ' ('.$host.')' .' Down'."\n";
    } else {
        echo $server_name. '('.$host.')' .' Up'."\n"; //
    }
}
?>