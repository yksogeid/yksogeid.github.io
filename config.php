<?php

define("SUPABASE_URL", "https://mbzyihwtrqzkbtsidhhx.supabase.co");
define("SUPABASE_KEY", "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im1ienlpaHd0cnF6a2J0c2lkaGh4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjU1MDc3NzgsImV4cCI6MjA4MTA4Mzc3OH0.rSt-Haksx4mRgy3sAnuPI-2YES6VEf1orvPgjuqnZnw");

function supabase_request($table, $method = "GET", $data = null, $params = "")
{
    if ($params === "") {
        $params = "?select=*";
    }

    $url = SUPABASE_URL . "/rest/v1/" . $table . $params;

    $headers = [
        "Content-Type: application/json",
        "apikey: " . SUPABASE_KEY,
        "Authorization: Bearer " . SUPABASE_KEY
    ];

    $opts = [
        "http" => [
            "method" => $method,
            "header" => implode("\r\n", $headers),
            "ignore_errors" => true  // This allows us to get the response even on error
        ]
    ];

    if ($data !== null) {
        $opts["http"]["content"] = json_encode($data);
    }

    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    // $http_response_header is a magic variable populated by file_get_contents
    $response_headers = $http_response_header ?? [];

    // Check for HTTP errors
    if ($response === false || empty($response_headers)) {
        throw new Exception("Request failed: Unable to connect to Supabase. Check your URL and network connection. (URL: $url)");
    }

    // Get HTTP response code
    $status_line = $response_headers[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = isset($match[1]) ? (int) $match[1] : 0;

    // If not a 2xx status code, throw an error with details
    if ($status < 200 || $status >= 300) {
        $error_details = json_decode($response, true);
        $error_message = "HTTP $status: ";

        if ($status === 404) {
            $error_message .= "Table '$table' not found. Please check:\n";
            $error_message .= "1. The table exists in your Supabase database\n";
            $error_message .= "2. Row Level Security (RLS) policies allow access\n";
            $error_message .= "3. Your API key has the correct permissions";
        } elseif (isset($error_details['message'])) {
            $error_message .= $error_details['message'];
        } else {
            $error_message .= $response;
        }

        throw new Exception($error_message . "\n(URL: $url)");
    }

    return json_decode($response, true);
}
