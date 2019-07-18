<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 12/07/2018
 * Time: 15:23
 */

require 'utility.php';

if (!file_exists($file = __DIR__ . '/vendor/autoload.php')) {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
require_once __DIR__ . '/vendor/autoload.php';

$videos = '';
$channels = '';
$playlists = '';

// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
if (isset($_GET['q']) && isset($_GET['maxResults'])) {
    /*
     * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
     * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
    $DEVELOPER_KEY = 'AIzaSyBMjHOBf00-B9wpKJdmp0Hri63IBchOL8s'; //key access

    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);

    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);
    $searchResponse = "";
    try {

        // Call the search.list method to retrieve results matching the specified
        // query term.
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'q' => $_GET['q'],
            'maxResults' => $_GET['maxResults'],
        ));


          // Add each result to the appropriate list, and then display the lists of
          // matching videos, channels, and playlists.
          foreach ($searchResponse['items'] as $searchResult) {
            switch ($searchResult['id']['kind']) {
              case 'youtube#video':
                $videos .= sprintf('<li>%s (%s)</li>',
                    $searchResult['snippet']['title'], $searchResult['id']['videoId']);
                break;
              case 'youtube#channel':
                $channels .= sprintf('<li>%s (%s)</li>',
                    $searchResult['snippet']['title'], $searchResult['id']['channelId']);
                break;
              case 'youtube#playlist':
                $playlists .= sprintf('<li>%s (%s)</li>',
                    $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
                break;
            }
          }
        } catch (Google_Service_Exception $e) {
          $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
        } catch (Google_Exception $e) {
          $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
        }

    prepareXMLresponse($searchResponse);
}

function prepareXMLresponse($searchResponse){
    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
    echo "<trailers>";
    $url_yt = "https://www.youtube.com/watch?v=";
    foreach ($searchResponse['items'] as $i){
          echo "<trailer>";
            echo "<title>".control_Character($i['snippet']['title'])."</title>";
            echo "<videoId>".$url_yt.$i['id']['videoId']."</videoId>";
          echo "</trailer>";
      }
    echo "</trailers>";
}
