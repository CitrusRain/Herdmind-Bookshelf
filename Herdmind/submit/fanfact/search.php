<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
?>
<?php
$query = $_GET['query'].'%'; // add % for LIKE query later

// do query
$stmt = $dbh->prepare('SELECT Title FROM PageTitles WHERE Title LIKE = :query');
$stmt->bindParam(':query', $query, PDO::PARAM_STR);
$stmt->execute();

// populate results
$results = array();
foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $row) {
    $results[] = $row;
}

// and return to typeahead
return json_encode($results);
?>