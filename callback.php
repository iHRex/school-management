<?php
require_once SMS_PLUGIN_DIR. '/lib/vendor/autoload.php'; 
$client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
$CLIENT_ID = get_option('smgt_virtual_classroom_client_id');
$CLIENT_SECRET = get_option('smgt_virtual_classroom_client_secret_id');
$REDIRECT_URI = site_url().'?page=callback';

if(empty(get_option('smgt_virtual_classroom_access_token')) OR get_option('smgt_virtual_classroom_access_token'))
{
    $response = $client->request('POST', '/oauth/token', [
    "headers" => [
        "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)
    ],
        'form_params' => [
            "grant_type" => "authorization_code",
            "code" => $_GET['code'],
            "redirect_uri" => $REDIRECT_URI
        ],
    ]);
    $token = $response->getBody()->getContents();
    update_option( 'smgt_virtual_classroom_access_token', $token );
    $site_url=site_url().'/wp-admin/admin.php?page=smgt_virtual_classroom&tab=meeting_list&message=4';
    // $site_url= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header('Location:'.$site_url);
    // wp_redirect($site_url);
    // exit();
}
else
{
    $get_token = get_option('smgt_virtual_classroom_access_token');
    $token_decode = json_decode($get_token);
    $refresh_token = $token_decode->refresh_token;
    
    $response = $client->request('POST', '/oauth/token', [
        "headers" => [
            "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)
        ],
        "query" => [
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token
        ],
    ]);
    $token = $response->getBody()->getContents();
    update_option( 'smgt_virtual_classroom_access_token', $token );
}
// $redirect_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// if (!headers_sent())
// {
// header('Location: '.$redirect_url);
// }
// else
// {
// echo '<script type="text/javascript">';
// echo 'window.location.href="'.$redirect_url.'";';
// echo '</script>';
// }
// $url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// apply_filters( 'wp_redirect', $url );
// wp_redirect ($url);
// die();

?>