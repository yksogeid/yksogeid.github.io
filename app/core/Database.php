<?php

class Database
{
    private $url;
    private $key;

    public function __construct()
    {
        $this->url = "https://mbzyihwtrqzkbtsidhhx.supabase.co";
        $this->key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im1ienlpaHd0cnF6a2J0c2lkaGh4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjU1MDc3NzgsImV4cCI6MjA4MTA4Mzc3OH0.rSt-Haksx4mRgy3sAnuPI-2YES6VEf1orvPgjuqnZnw";
    }

    public function request($table, $method = "GET", $data = null, $params = "")
    {
        if ($params === "") {
            $params = "?select=*";
        }

        $url = $this->url . "/rest/v1/" . $table . $params;

        $headers = [
            "Content-Type: application/json",
            "apikey: " . $this->key,
            "Authorization: Bearer " . $this->key
        ];

        // Add proper header for Upsert if on_conflict is present
        if (strpos($params, 'on_conflict') !== false) {
            $headers[] = "Prefer: resolution=merge-duplicates";
        }

        $opts = [
            "http" => [
                "method" => $method,
                "header" => implode("\r\n", $headers),
                "ignore_errors" => true
            ]
        ];

        if ($data !== null) {
            $opts["http"]["content"] = json_encode($data);
        }

        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);

        $response_headers = $http_response_header ?? [];

        if ($response === false || empty($response_headers)) {
            throw new Exception("Request failed: Unable to connect to Supabase.");
        }

        $status_line = $response_headers[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = isset($match[1]) ? (int) $match[1] : 0;

        if ($status < 200 || $status >= 300) {
            throw new Exception("HTTP $status: " . $response);
        }

        return json_decode($response, true);
    }
}
