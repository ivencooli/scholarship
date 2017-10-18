<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A web interface for Home Assistant with WebSocket">
    <title>Home Assistant with WebSocket</title>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>
<script type="text/javascript">
function switch2_on()
{
    $(document).ready(function() {
        function msg(str) {
            $('#msg').prepend('<p>' + str + '</p>');
        };
        ws = new WebSocket('ws://192.168.123.110:8123/api/websocket');
        ws.addEventListener('open', function (event) {
            ws.send('{  "id": 1,  "type": "call_service", "domain": "switch", "service": "turn_on", "service_data": { "entity_id": "switch.switch1" } }\n\n');
        });
        ws.onmessage = function(event) {
            msg(event.data);
        };
        ws.onclose = function() {msg('Socket closed');};
        ws.onopen = function() {msg('Connected...');};
    });
}
</script>

<?php
$json = file_get_contents('php://input');
// $json = '{"device_id": "device_id",
// "tag_uid": "0852dfdb",
// "counter": 3,
// "hash": "a229163b1736c5e69ae1c8347b1a78b6355555ca"}';
$array = json_decode($json, true);
$tag_uid = $array['tag_uid'];
if ($tag_uid = '51846e8b')
{
 echo "<script type='text/javascript'>switch2_on();</script>";
 $myfile = fopen("1.txt", "w") or die("Unable to open file!");
 fwrite($myfile, $json);
 fclose($myfile);
}

 ?>
