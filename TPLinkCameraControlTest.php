#!/usr/bin/php
<?

# usage
# php TPLinkCameraControlTest.php admin password url data
# php TPLinkCameraControlTest.php admin password http://192.168.2.89:80 '{"method":"do","preset":{"goto_preset": {"id": "1"}}}'
#
# data example:
# PTZ to preset position      {"method":"do","preset":{"goto_preset": {"id": "1"}}}
# PTZ by coord                {"method":"do","motor":{"move":{"x_coord":"10","y_coord":"0"}}}
# PTZ horizontal by step      {"method":"do","motor":{"movestep":{"direction":"0"}}}
# PTZ vertical by step        {"method":"do","motor":{"movestep":{"direction":"90"}}}
# stop PTZ                    {"method":"do","motor":{"stop":"null"}}
# add PTZ preset position     {"method":"do","preset":{"set_preset":{"name":"name","save_ptz":"1"}}}
# lens mask                   {"method":"set","lens_mask":{"lens_mask_info":{"enabled":"on"}}}
#
# https://github.com/likaci/mercury-ipc-control

# ref https://github.com/likaci/mercury-ipc-control
include('TPLinkCameraControler.php');

$username = ($argv[1]);
$password = ($argv[2]);
$base_url = ($argv[3]);
$data = ($argv[4]);
echo("username: " . $username . "\n");
echo("password: " . $password . "\n");
echo("base_url: " . $base_url . "\n");
echo("data: " . $data . "\n");

$TPLinkCameraControler = new TPLinkCameraControler($username, $password, $base_url);
$TPLinkCameraControler->doRequest($data);
?>