<?php

include("fetchdata.php");

    // Array to store conditions
    $conditions = array();

    $sql = "SELECT drugresponse.*, compounds_updated1.INCHI_KEY, drug_disease.Disease_class, drug_disease.Phase FROM drugresponse";
    
    // Join with compounds_updated1 table
    $sql .= " LEFT JOIN compounds_updated1 ON drugresponse.COMPOUND_NAME = compounds_updated1.COMPOUND_NAME";
    
    // Join with drug_disease table
    $sql .= " LEFT JOIN drug_disease ON compounds_updated1.INCHI_KEY = drug_disease.INCHI_KEY";
    
    $conditions[] = "drugresponse.MAX_PHASE IN ('Approved' ,'Unknown')";
    
    $conditions[] = "drugresponse.DATASET IN ('GDSC1' ,'gCSI')";
    
    
    // Check if there are conditions before adding WHERE
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $limit = 400;
    
    // Append the LIMIT clause to your SQL query
    $sql .= " LIMIT " . $limit;
    

    $result = $conn->query($sql);
   
    // Fetch the result into an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    // Convert the result to JSON format
    $json_result = json_encode($data);
    header('Content-Type: application/json');
    
    echo $json_result;

  

?>
