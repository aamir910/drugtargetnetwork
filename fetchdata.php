<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=drugtargetnetwork", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM drugresponsefile LIMIT 500";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $results = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $results[] = $row;
    }

    echo json_encode($results);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
