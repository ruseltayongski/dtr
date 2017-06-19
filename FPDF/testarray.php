

<?php

    $logs = array();
    $logs[] = '23:00:00';
    $logs[] = '13:00:00';
    $logs[] = '';
    $logs[] = '14:50:00';
    $logs[] = '08:34:00';
    $logs[] = '07:34:00';

    sort($logs);

    print_r($logs);
?>