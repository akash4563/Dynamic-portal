<?php
function getPortalData() {
    $kv_url = getenv('KV_REST_API_URL');
    $kv_token = getenv('KV_REST_API_TOKEN');

    if ($kv_url && $kv_token) {
        // Fetch from Vercel KV
        $ch = curl_init($kv_url . '/get/portal_data');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $kv_token
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        if ($data && isset($data['result']) && $data['result'] !== null) {
            // Vercel KV rest returns the value as a string inside 'result' if it's stored as a string
            $parsed = json_decode($data['result'], true);
            if ($parsed !== null) {
               return json_encode($parsed, JSON_PRETTY_PRINT);
            }
        }
    }

    // Fallback to local file if KV is not configured or data not found
    $dataFile = 'data.json';
    if (file_exists($dataFile)) {
        return file_get_contents($dataFile);
    }

    return '{"categories":[]}';
}

function savePortalData($jsonData) {
    $kv_url = getenv('KV_REST_API_URL');
    $kv_token = getenv('KV_REST_API_TOKEN');

    if ($kv_url && $kv_token) {
        // Save to Vercel KV
        $ch = curl_init($kv_url . '/set/portal_data');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        // We send the JSON data stringified as the payload value
        $payload = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $kv_token,
            'Content-Type: text/plain'
        ]);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode >= 200 && $httpcode < 300) {
            return true;
        }
        return false;
    }

    // Fallback to local file
    $dataFile = 'data.json';
    return file_put_contents($dataFile, $jsonData) !== false;
}
?>