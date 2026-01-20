<?php
$fileUrl = $_GET['url'];
$parsedUrl = parse_url($fileUrl);
parse_str($parsedUrl['query'], $queryParams);

$filename = isset($queryParams['filename']) ? $queryParams['filename'] : 'default_video.mp4';

$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

switch (strtolower($fileExtension)) {
    case 'mp4':
        $contentType = 'video/mp4';
        break;
    case 'mov':
        $contentType = 'video/quicktime';
        break;
    case 'avi':
        $contentType = 'video/x-msvideo';
        break;
    case 'mkv':
        $contentType = 'video/x-matroska';
        break;
}

$ch = curl_init($fileUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 1);
curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, 60);


header('Content-Type: ' . $contentType);
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
header('Cache-Control: no-cache');

// cURL verisini doğrudan istemciye iletmek için yazma fonksiyonu
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {
    echo $data;
    flush();
    return strlen($data);
});

curl_exec($ch);

curl_close($ch);
?>
