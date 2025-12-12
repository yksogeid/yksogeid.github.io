<?php
require_once "config.php";

echo "<h2>Checking Supabase Tables</h2>";

// Check ninos table
echo "<h3>Testing 'ninos' table:</h3>";
try {
    $ninos = supabase_request("ninos");
    echo "✅ 'ninos' table exists and is accessible<br>";
    echo "Records found: " . count($ninos) . "<br>";
    if (count($ninos) > 0) {
        echo "Sample record: <pre>" . print_r($ninos[0], true) . "</pre>";
    }
} catch (Exception $e) {
    echo "❌ Error accessing 'ninos': " . $e->getMessage() . "<br>";
}

echo "<hr>";

// Check asistencia table
echo "<h3>Testing 'asistencia' table:</h3>";
try {
    $asistencia = supabase_request("asistencia");
    echo "✅ 'asistencia' table exists and is accessible<br>";
    echo "Records found: " . count($asistencia) . "<br>";
    if (count($asistencia) > 0) {
        echo "Sample record: <pre>" . print_r($asistencia[0], true) . "</pre>";
    } else {
        echo "Table is empty (no records yet)<br>";
    }
} catch (Exception $e) {
    echo "❌ Error accessing 'asistencia': " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><strong>Next steps:</strong></p>";
echo "<ul>";
echo "<li>If 'asistencia' table doesn't exist, you need to create it in Supabase</li>";
echo "<li>If it exists but has wrong columns, you need to add the 'nino_id' column</li>";
echo "<li>Make sure RLS policies are configured correctly</li>";
echo "</ul>";
?>