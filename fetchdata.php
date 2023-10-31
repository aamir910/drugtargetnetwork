<?php
try {
    $dropdown1Value = $_POST["dropdown1"];
    $dropdown2Value = $_POST["dropdown2"];
    $dropdown3Value = $_POST["dropdown3"];

    // Now you can use these variables in your PHP code.
    
    // For example, you can print the selected values:
    echo "Selected values: Dropdown 1 - $dropdown1Value, Dropdown 2 - $dropdown2Value, Dropdown 3 - $dropdown3Value";

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
