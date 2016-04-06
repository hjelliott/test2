<html>
<head>


</head>
<body>

<?php
/**
 * Return an array of timezones
 * Updated 2016/Apr/06
 * @return array
 */
function timezoneList()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));
 
    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);
 
        $tempTimezones[] = array(
            'offset' => (int)$currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier
        );
    }
 
    // Sort the array by offset,identifier ascending
    usort($tempTimezones, function($a, $b) {
		return ($a['offset'] == $b['offset'])
			? strcmp($a['identifier'], $b['identifier'])
			: $a['offset'] - $b['offset'];
    });
 
	$timezoneList = array();
    foreach ($tempTimezones as $tz) {
		$sign = ($tz['offset'] > 0) ? '+' : '-';
		$offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
			$tz['identifier'];
    }
 
    return $timezoneList;
}

function calctzoffset($tz) {
	
	$tzServer = new DateTimeZone(date_default_timezone_get());
	$dtServer = new DateTime("now",$tzServer);
	$tzEvent = new DateTimeZone($tz);
	$dtEvent = new DateTime("now",$tzEvent);
	$offset = ($tzEvent->getOffset($dtEvent) - $tzServer->getOffset($dtServer) )/3600;
	return $offset;

}



	echo '<p>Current timezone : ' . date_default_timezone_get() . 'Offset to Thailand : ' . calctzoffset('Asia/Bangkok') .  '</p>';
	
	$timezoneList = timezoneList();
	$first = array('Not Set' => 'Not yet set');
	$timezoneList = $first +$timezoneList ;
	echo '<select name="timezone">';
	foreach ($timezoneList as $value => $label) {
		echo '<option value="' . $value . '">' . $label . '</option>';
	}
	echo '</select> <br />';
	
	
	echo print_r($timezoneList);
?>

</body>


</html>