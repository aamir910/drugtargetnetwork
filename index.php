<?php
include("fetchdata.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if all dropdown values are set
  if (isset($_POST['dropdown1']) && isset($_POST['dropdown2']) && isset($_POST['dropdown3'])  && isset($_POST['dropdown4'])) {
    $dropdown1 = $_POST['dropdown1'];
    $dropdown2 = $_POST['dropdown2'];
    $dropdown3 = $_POST['dropdown3'];
    $dropdown4 = $_POST['dropdown4'];
    

    // Query the database based on the selected dropdown values
//     $sql = "SELECT * FROM drugresponse WHERE ONCOTREE_LINEAGE = '$dropdown1' AND 
// ONCOTREE_PRIMARY_DISEASE = '$dropdown2' AND 
// METRIC = '$dropdown3' AND 
// CHEMBL_ID = '$dropdown4' ";


    // $sql = "SELECT * FROM drugresponse WHERE ONCOTREE_LINEAGE = '$dropdown1' ORDER BY RAND() LIMIT 500";

    $sql = "SELECT * FROM drugresponse WHERE";

    // Array to store conditions
    $conditions = array();
    
    // Check and add condition for ONCOTREE_LINEAGE
    if (!empty($dropdown1)) {
        $conditions[] = "ONCOTREE_LINEAGE = '$dropdown1'";
    }
    
    // Check and add condition for ONCOTREE_PRIMARY_DISEASE
    if (!empty($dropdown2)) {
        $conditions[] = "ONCOTREE_PRIMARY_DISEASE = '$dropdown2'";
    }
    
    // Check and add condition for METRIC
    if (!empty($dropdown3)) {
        $conditions[] = "METRIC = '$dropdown3'";
    }
    
    // Check and add condition for CHEMBL_ID
    if (!empty($dropdown4)) {
        $conditions[] = "CHEMBL_ID = '$dropdown4'";
    }
    
    // Combine conditions with "AND" and add to the SQL query
    if (!empty($conditions)) {
        $sql .= " " . implode(" AND ", $conditions);
    } 




    $result = $conn->query($sql);

    // Fetch the result into an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    // Convert the result to JSON format
    $json_result = json_encode($data);
    header('Content-Type: application/json');

    // Echo the JSON-encoded data
    echo $json_result;
    exit(); // Stop further execution
  }
}
?>

<?php

// Check if drugName is set in the POST request
if (isset($_POST['drugName'])) {

  include 'fetchdata.php';
  $drugName = $_POST['drugName'];

  // Use prepared statement to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM compounds WHERE COMPOUND_NAME = ?");
  $stmt->bind_param("s", $drugName);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Fetch data as an associative array
  $data = $result->fetch_all(MYSQLI_ASSOC);

  // Close the statement
  $stmt->close();

  // Return the data as JSON
  echo json_encode($data);
  $conn->close();
  exit();
}

// Close the database connection
?>
<?php
// Check if drugName is set in the POST request
if (isset($_POST['drugName2'])) {

  include 'fetchdata.php';
  $drugName2 = $_POST['drugName2'];

  // Use prepared statement to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM cellline WHERE CELL_LINE_NAME = ?");
  $stmt->bind_param("s", $drugName2);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Fetch data as an associative array
  $data = $result->fetch_all(MYSQLI_ASSOC);

  // Close the statement
  $stmt->close();

  // Return the data as JSON
  echo json_encode($data);
  // echo $drugName2;
  $conn->close();
  exit();
}

// Close the database connection

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- Include Bootstrap 5 CSS and JavaScript -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<style>
  .selection_box {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgb(231 226 226 / 50%);
    ;
    padding: 1rem;
  }

  .btn-green {
    background-color: red;
    border-color: #4caf50;
  }

  .btn {
    margin-right: 0.5rem;
    margin-left: 0.5rem;

    background-color: green;
    /* border-color: #4caf50; */

  }

  .btn-green:hover {
    background-color: #45a049;
    border-color: #45a049;
  }

  .rowData {
    display: flex;
    flex-direction: row;
    gap: 10px;
    width: 100%;
    justify-content: center;
  }

  .searchBar {
    /* padding-top: 1rem;
    padding-bottom: 1rem;

    background-color: #ffca28; */
  }

  .graph_div {
    display: flex;
    flex-direction: row;
    margin-top: 15px;
    /* border: 2px solid black; */
    border-radius: 1rem;
    width: 100%;
    /* height: 550px; */
    height: 100vph;
  }

  .error-border {
    border: 2px solid red;
  }


  .alert2 {
    display: none;
  }

  /* slider css  */

  input[type="range"] {
    width: 100%;
  }

  /* csss slider    */


  .wrapper {
    /* width: 400px; */
    width: 250px ; 
    background: #fff;
    border-radius: 10px;
    padding: 20px 25px 40px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    display: none;
  }

  header h2 {
    font-size: 24px;
    font-weight: 600;
  }

  header p {
    margin-top: 5px;
    font-size: 16px;
  }

  .price-input {
    width: 100%;
    display: flex;
    margin: 10px 0 10px;
  }

  .price-input .field {
    display: flex;
    width: 100%;
    height: 45px;
    align-items: center;
  }

  .field input {
    width: 100%;
    height: 100%;
    outline: none;
    font-size: 19px;
    margin-left: 12px;
    border-radius: 5px;
    text-align: center;
    border: 1px solid #999;
    -moz-appearance: textfield;
  }

  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
  }

  .price-input .separator {
    width: 130px;
    display: flex;
    font-size: 19px;
    align-items: center;
    justify-content: center;
  }

  .slider {
    height: 5px;
    position: relative;
    background: #ddd;
    border-radius: 5px;
  }

  .slider .progress {
    height: 100%;
    left: 0%;
    right: 0%;
    position: absolute;
    border-radius: 5px;
    background: #ddd;
  }

  .range-input {
    position: relative;
  }

  .range-input input {
    position: absolute;
    width: 100%;
    height: 5px;
    top: -5px;
    background: none;
    pointer-events: none;
    -webkit-appearance: none;
    -moz-appearance: none;
  }

  input[type="range"]::-webkit-slider-thumb {
    height: 17px;
    width: 17px;
    border-radius: 50%;
    background: green;
    pointer-events: auto;
    -webkit-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
  }

  input[type="range"]::-moz-range-thumb {
    height: 17px;
    width: 17px;
    border: none;
    border-radius: 50%;
    background: #ddd;
    pointer-events: auto;
    -moz-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
  }

  /* slider css ended here */

  /* LEGEND CSS STARTED HERE  */
  .legend {
    border: 2px solid black;
    margin: 1rem;
    border-radius: 1rem;
    background-color: white;

  }

  .legenddata {
    font-size: 20px;
    padding-left: 1rem;
  }

  .marked {
    text-decoration: line-through;

    text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.5);
  }

  .rect {
    display: inline-block;
    width: 20px;
    height: 10px;
    border-radius: 2rem;
    margin-right: 5px;
  }

  .line {
    display: inline-block;
    width: 30px;
    height: 5px;
    border-radius: 0.5rem;
    margin-right: 5px;
  }

  .circle {
    display: inline-block;
    width: 14px;
    height: 14px;
    border-radius: 2rem;
    margin-right: 5px;
  }

  ul {
    list-style-type: none;
  }


  /* LEGEND CSS ENDED HERE  */
  /* here is the styling of the color picker */

  .card {
    background-color: #fff;
    border-radius: 1rem;
    padding: 5px;
    box-shadow: 0 30px 30px -15px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 55%;
    left: 20%;
  }

  .cl-picker {
    text-transform: uppercase;
    /* letter-spacing: 1px; */
    font-weight: bold;
    margin: 1px;
  }

  .card ul {
    list-style: none;
    /* padding: 24px; */
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-gap: 10px;
    padding-left: 0;
    margin: 1px;
  }

  .card ul li {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.3s;
  }

  .card ul li:hover {
    transform: scale(1.1);
  }

  #red {
    background-color: #ef5350;
  }

  #green {
    background-color: #66bb6a;
  }

  #amber {
    background-color: #ffca28;
  }

  #blue {
    background-color: #42a5f5;
  }

  #gray {
    background-color: #bdbdbd;
  }

  /* here is the styling of the color picker ended  */

  /* svg loader  */
  .loader {

    position: absolute;
    margin: 15% -38%;
    display: none;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid green;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
    0% {
      -webkit-transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
    }
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  /* loader css ended  */

  /* slider2  */

  .sliderpart2 {
    display: flex;
    flex-direction: row;

    position: absolute;
    top: 92%;
    left: 25%;
    /* transform: translate(-50%, -50%); */
    width: 650px;
    /* height: 124px; */
    /* padding: 10px; */
    /* padding-left: 40px; */
    background: #fffefe;
    /* border-radius: 20px; */
    display: flex;
    align-items: center;
    /* box-shadow: 0px 5px 20px #7e6d5766; */
  }

  .sliderpart2 p {
    font-size: 20px;
    font-weight: 600;
    font-family: Open Sans;
    padding-left: 30px;
    color: black;
  }

  /* .sliderpart2 input[type="range"] {
    -webkit-appearance: none !important;
    width: 420px;
    height: 2px;
    background: black;
    border: none;
    outline: none;
  } */
  .sliderpart2 input[type="range"] {
    -webkit-appearance: none !important;
    width: 420px;
    height: 2px;
    background: green;
    border: none;
    outline: none;
    /* height: 17px;
    width: 17px; */
    border: none;
    /* border-radius: 50%; */
    background: #ddd;
    pointer-events: auto;
    /* -moz-appearance: none; */
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
  }

  .fieldset {
    background: white;
    border-radius: 2rem;
  }

  .sliderpart2 input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none !important;
    width: 20px;
    height: 20px;
    background: green;
    border: 2px solid green;
    border-radius: 50%;
    cursor: pointer;
  }

  .sliderpart2 input[type="range"]::-webkit-slider-thumb:hover {
    background: black;
  }



  .btn1 {
    background-color: rgb(190, 190, 190);
    /* Background color */
    color: black;
    /* Text color */
    border: none;
    /* Remove the border */
    padding: 10px 20px;
    /* Add padding to the button */
    text-align: center;
    /* Center the text horizontally */
    text-decoration: none;
    /* Remove underlines from links */
    display: inline-block;
    /* Make it an inline block element */
    font-size: 16px;
    /* Font size */
    margin: 4px 2px;
    /* Add margin to the button */
    cursor: pointer;
    /* Add a pointer cursor on hover */
    border-radius: 4px;
    /* Rounded corners */
  }

  /* Change the button background color on hover */
  .btn1:hover {
    background-color: #45a049;
  }

  /* overlay css  */
  section {
    position: fixed;
    height: 100%;
    width: 100%;
    background: #e3f2fd;
  }

  button {
    /* font-size: 18px; */
    /* font-weight: 400; */
    color: #fff;
    /* padding: 14px 22px; */
    border: none;
    background: #4070f4;
    border-radius: 6px;
    cursor: pointer;
  }



  button.show-modal,
  .modal-box {
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  }

  section.active .show-modal {
    display: none;
  }

  .overlay {

    position: fixed;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.3);
    opacity: 0;
    pointer-events: none;
  }

  section.active .overlay {
    opacity: 1;
    pointer-events: auto;
  }

  .modal-box {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    backdrop-filter: blur(10px);
    opacity: 0;
    pointer-events: none;

  }

  .model_box_inner {

    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    max-width: 380px;
    width: 100%;

    padding: 30px 20px;
    border-radius: 24px;
    background-color: #fff;
    opacity: 1;
    /* pointer-events: none; */
    transition: all 0.3s ease;
    transform: translate(-05%, -05%);
  }

  section.active .modal-box {
    opacity: 1;
    pointer-events: auto;
  }

  .modal-box h2 {
    margin-top: 20px;
    font-size: 25px;
    font-weight: 500;
    color: #333;
  }

  .modal-box h3 {
    font-size: 16px;
    font-weight: 400;
    color: #333;
    text-align: center;
  }

  .modal-box .buttons {
    margin-top: 25px;
  }

  .modal-box button {
    font-size: 14px;
    padding: 6px 12px;
    margin: 0 10px;

    background-color: green;

  }

  .exportbtn {
    display: flex;
    flex-direction: column;
    padding: 1rem;
    gap: 20px;

  }

  #buttonbar {
    display: none;
  }

  .alignitems {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    /* margin: 20px; */
    gap: 20px;
  }

  .sliderbtn {
    padding: 5px 1px;
    background: green;
    /* margin: 5px; */
    /* height: 72px; */
    width: 190px;

  }

  /* drugdata description  */

  body {
    margin: 0;
    overflow: hidden;
    height: auto;
    /* Prevent body overflow when the modal is open */
  }


  .parent_description {
    width: 90%;
    height: 60%;
    display: none;
    position: absolute;

    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 8px;

  }

  .blur_the_background {

    display: none;
    width: 100%;
    top: 0%;

    height: 900px;
    backdrop-filter: blur(10px);
    position: absolute;
  }

  .blur_the_background.show {
    display: block;
  }

  .parent_description.show {
    display: block;
  }

  .toggle {
    list-style: none;
    /* Remove default list styles */
    padding: 0;
  }

  .toggle input[type="radio"] {
    display: none;
    /* Hide the default radio buttons */
  }

  .toggle label {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    background-color: #e0e0e0;
    cursor: pointer;
  }

  .toggle input[type="radio"]:checked+label {
    background-color: #3498db;
    /* Change background color for the selected option */
    color: #ffffff;
    /* Change text color for the selected option */
  }

  #parent_des_close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    max-height: 100px;
    overflow: auto;

  }



  /* table css  */

  table {
    border-collapse: collapse;
    width: 90%;
    margin-top: 20px;
    max-height: 500px;
    overflow: auto;
  }

  th,
  td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    height: 10px !important;

    overflow: auto;
  }

  th {
    background-color: #f2f2f2;
  }

  /* Apply bolder style to the left-side (key) cells */
  td:first-child {
    font-weight: bold;
  }

  .table-container {
    max-height: 400px;
    /* Set the maximum height for the container */
    overflow-y: auto;
    /* Enable vertical scrollbar when content overflows */
  }

  td {
    white-space: pre-line;
    /* Preserve newline characters */
  }

  b {
    font-weight: bold;
  }
</style>

<body>

  <div class=" searchBar">
    <form class="selection_box flex" id="searchForm">
      <div class="form-row rowData">
        <!-- First Dropdown -->
        <div class="form-group col-md-2">
          <select class="form-select" id="dropdown1">
            <option value="">Select ONCOTREE_LINEAGE</option>
            <option value="Bone">Bone</option>
            <option value="Skin">Skin</option>
            <option value="Central Nervous System">Central Nervous System</option>
            <option value="Lung">Lung</option>
            <option value="Peripheral Nervous System">Peripheral Nervous System</option>
            <option value="Soft Tissue">Soft Tissue</option>
            <option value="Esophagus">Esophagus</option>
            <option value="Breast">Breast</option>
            <option value="Head and Neck">Head and Neck</option>
            <option value="Haematopoietic and Lymphoid">Haematopoietic and Lymphoid</option>
            <option value="Bladder">Bladder</option>
            <option value="Kidney">Kidney</option>
            <option value="Pancreas">Pancreas</option>
            <option value="Large Intestine">Large Intestine</option>
            <option value="Ovary">Ovary</option>
            <option value="Stomach">Stomach</option>
            <option value="Biliary Tract">Biliary Tract</option>
            <option value="Small Intestine">Small Intestine</option>
            <option value="Placenta">Placenta</option>
            <option value="Prostate">Prostate</option>
            <option value="Testis">Testis</option>
            <option value="Uterus">Uterus</option>
            <option value="Vulva">Vulva</option>
            <option value="Thyroid">Thyroid</option>
          </select>

          <!-- Alert message for the first dropdown -->
          <div class="alert-message alert2" style="position: absolute; top: 110px; ">
            <span class="alert alert-danger">Please select an option</span>
          </div>
        </div>

        <!-- Second Dropdown -->
        <div class="form-group col-md-2" style = "display : none ; "> 
        <select class="form-select" id="dropdown2">
    <option value="">Select ONCOTREE_PRIMARY_DISEASE	</option>
    <option value="Ewing's Sarcoma">Ewing's Sarcoma</option>
    <option value="Melanoma">Melanoma</option>
    <option value="Glioblastoma">Glioblastoma</option>
    <option value="Lung Carcinoid Tumor">Lung Carcinoid Tumor</option>
    <option value="Lung Adenocarcinoma">Lung Adenocarcinoma</option>
    <option value="Bronchiolo-Alveolar Lung Carcinoma">Bronchiolo-Alveolar Lung Carcinoma</option>
    <option value="Non-Small Cell Lung Carcinoma">Non-Small Cell Lung Carcinoma</option>
    <option value="Small Cell Lung Carcinoma">Small Cell Lung Carcinoma</option>
    <option value="Neuroblastoma">Neuroblastoma</option>
    <option value="Epithelioid Sarcoma">Epithelioid Sarcoma</option>
    <option value="Giant Cell Lung Carcinoma">Giant Cell Lung Carcinoma</option>
    <option value="Esophageal Squamous Cell Carcinoma">Esophageal Squamous Cell Carcinoma</option>
    <option value="Ductal Breast Carcinoma">Ductal Breast Carcinoma</option>
    <option value="Head and Neck Squamous Cell Carcinoma">Head and Neck Squamous Cell Carcinoma</option>
    <option value="Adult T Acute Lymphoblastic Leukemia">Adult T Acute Lymphoblastic Leukemia</option>
    <option value="Bladder Carcinoma">Bladder Carcinoma</option>
    <option value="Renal Cell Carcinoma">Renal Cell Carcinoma</option>
    <option value="Non-Cancerous">Non-Cancerous</option>
    <option value="Chronic Myelogenous Leukemia">Chronic Myelogenous Leukemia</option>
    <option value="Pancreatic Ductal Adenocarcinoma">Pancreatic Ductal Adenocarcinoma</option>
    <option value="Plasma Cell Myeloma">Plasma Cell Myeloma</option>
    <option value="Adult Acute Myeloid Leukemia">Adult Acute Myeloid Leukemia</option>
    <option value="Pleural Epithelioid Mesothelioma">Pleural Epithelioid Mesothelioma</option>
    <option value="Childhood T Acute Lymphoblastic Leukemia">Childhood T Acute Lymphoblastic Leukemia</option>
</select>

          <!-- Alert message for the second dropdown -->
          <div class="alert-message alert2 " style="position: absolute; top: 110px; ">
            <span class="alert alert-danger">Please select an option</span>
          </div>
        </div>


 
        <!-- third Dropdown -->
        <div class="form-group col-md-2">
        <select class="form-select" id="dropdown3">
    <option value="">Select matric </option>
    <option value="pIC50">pIC50</option>
    <option value="pEC50">pEC50</option>
    <option value="pGI50">pGI50</option>
</select>
          <!-- Alert message for the second dropdown -->
          <div class="alert-message alert2 " style="position: absolute; top: 110px; ">
            <span class="alert alert-danger">Please select an option</span>
          </div>
        </div>

        <!-- forth Dropdown -->
        <div class="form-group col-md-2">
        <select class="form-select" id="dropdown4">
    <option value="">Select CHEMBL_ID</option>
    <option value="CHEMBL553">CHEMBL553</option>
    <option value="CHEMBL413">CHEMBL413</option>
    <option value="CHEMBL535">CHEMBL535</option>
    <option value="CHEMBL4872316">CHEMBL4872316</option>
    <option value="CHEMBL4851750">CHEMBL4851750</option>
    <option value="CHEMBL428647">CHEMBL428647</option>
    <option value="CHEMBL254129">CHEMBL254129</option>
    <option value="CHEMBL2144069">CHEMBL2144069</option>
    <option value="CHEMBL1336">CHEMBL1336</option>
    <option value="CHEMBL572878">CHEMBL572878</option>
    <option value="CHEMBL941">CHEMBL941</option>
    <option value="CHEMBL4873176">CHEMBL4873176</option>
    <option value="CHEMBL601719">CHEMBL601719</option>
    <option value="CHEMBL217092">CHEMBL217092</option>
    <option value="CHEMBL392695">CHEMBL392695</option>
    <option value="CHEMBL159822">CHEMBL159822</option>
    <option value="CHEMBL1421">CHEMBL1421</option>
    <option value="CHEMBL483847">CHEMBL483847</option>
    <option value="CHEMBL4860897">CHEMBL4860897</option>
    <option value="CHEMBL1242367">CHEMBL1242367</option>
    <option value="CHEMBL197603">CHEMBL197603</option>
    <option value="CHEMBL213100">CHEMBL213100</option>
    <option value="CHEMBL1643959">CHEMBL1643959</option>
    <option value="CHEMBL513909">CHEMBL513909</option>
    <option value="CHEMBL209148">CHEMBL209148</option>
</select>

          <!-- Alert message for the third dropdown -->
          <div class="alert-message alert2 " style="position: absolute; top: 110px; ">
            <span class="alert alert-danger">Please select an option</span>
          </div>


        </div>
        <!-- button  -->
        <button class="btn btn-success" id="submitButton" type='submit'>
          <i class="bi bi-search"></i> Search
        </button>
      </div>
    </form>

    <div class="graph_div  flex col-12 " id="div2">

      <div class="wrapper col-2" id='wrapper'>
        <header>
          <h2>links value</h2>
        </header>
        <div class="price-input">
          <div class="field">
            <span>Min</span>
            <input type="number" class="input-min" value="4.0" step="0.1">
          </div>
          <div class="separator">-</div>
          <div class="field">
            <span>Max</span>
            <input type="number" class="input-max" value="9.0" step="0.1">
          </div>
        </div>
        <div class="slider">
          <div class="progress"></div>
        </div>
        <div class="range-input">
          <input id="min_slider" type="range" class="range-min" min="4.0" max="9.0" step="0.1" value="4.0">
          <input id="max_slider" type="range" class="range-max" min="4.0" max="9.0" step="0.1" value="9.0">
        </div>


        <div class="legend">
          <fieldset class="fieldset">
            <legend class="legenddata">max_phase</legend>
            <ul id="myList"></ul>
            <legend class="legenddata">data_set</legend>
            <ul id="dataset"></ul>
            <!-- <legend class="legenddata">child nodes</legend>
            <ul id="child_node"></ul> -->

          </fieldset>
        </div>

      </div>



      <svg id="forcenetwork" width="100%" style="
                  background-color: white;
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  height:700px;
                " class="col-10">
        <!-- Loader embedded inside SVG -->
      </svg>
      <foreignObject width="100%" height="100%">
        <div class="loader" id="loader"></div>
      </foreignObject>
    </div>


    <!-- second slider and btns  -->

    <div class="sliderpart2" id='buttonbar'>

      <div class='alignitems'>
        <button class="sliderbtn " id="zoom-in-button">zoom-in</button>
        <button class="sliderbtn " id="zoom-out-button">zoom out</button>
        <div style="display: flex; justify-content: center; align-items:center; width: 200px; ">
          <input id="nodeCountSlider2" type="range" min="0" max="100" value="50" />
          <p id="rangeValue">50</p>

        </div>
        <!-- btntag -->
        <button class="sliderbtn" id="redraw">redraw</button>
        <button class="sliderbtn " id="export">Export</button>

      </div>
    </div>





    <div class="card" id="cardid" style="display: none;">
      <p class="cl-picker">change color</p>
      <ul class="ul_of_color_picker" id="colorList">

      </ul>
    </div>


  </div>
  </div>

  <!-- overlay  -->
  <section>
    <span class="overlay"></span>
    <div class="modal-box">
      <div class="model_box_inner">
        <h2>Export Chart as</h2>

        <div class="buttons exportbtn">

          <button class="png" id='png'> Download PNG </button>
          <button class="jpeg" id="jpeg"> Download JPEG </button>
          <button class="csv" id="csv"> Download XLS </button>
          <!-- <button class="close-btn"> Close</button> -->

          <button class="close-btn" style="background:none   ;  position: absolute;
top: 10px;
right: 10px;
cursor: pointer;
max-height: 100px;
overflow: auto;
"><img height="20px" width="20px" src="icons8-close-60.png" alt=""></button>

        </div>
      </div>

    </div>
  </section>

  <div class="blur_the_background">
    <div class="parent_description ">
      <h4 id="drugname">name</h4>
      <div class="container">

        <form class="toggle">

          <input type="radio" id="choice2" name="choice" value="productive" checked>
          <label for="choice2">Biologics Structure </label>

          <input type="radio" id="choice1" name="choice" value="creative">
          <label for="choice1">Properties</label>


        </form>

      </div>
      <div class="table-container">
        <table>
          <tbody id="compoundTableBody">
            <!-- Data will be dynamically inserted here using JavaScript -->
          </tbody>

          <img src="image_not_available.png" alt="Structure Image" class="structure-image" style="margin : 0% 20%;">
        </table>

      </div>



      <button style="background:none " id='parent_des_close'><img height="20px" width="20px" src="icons8-close-60.png" alt=""></button>

    </div>
  </div>


  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="https://d3js.org/d3-force.v3.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>




  <script>
    let nodes = []; // unique nodes   
    let links = []; // links  from the json files
    let node = []; // DOM element    
    let link = []; // DOM ELEMENT 

    let filteredLinks = [];
    let filterNodes = [];
    let listItems = []; // onclick on the legend 
    let max_phase_cliked = [];


    let clicked;
    let list_hidden = [];
    let remove_maxPhase = [];

    //  onclick data set 

    let dataSet_link = []
    let clicked2;
    let list_hidden_dataset = [];
    //  onclick child nodes 

    let dataSet_child = []
    let clicked3;
    let list_hidden_childnode = [];


    let minValue;
    let maxValue;
    let slider_range = 100;
    const slider2 = document.getElementById("nodeCountSlider2");
    // onclick dataset   

    let list_hidden_links = [];

    let jsondata2;

    let csvfile = [];
    let response;

    let simulation;

    let drug_des_parent;
    let clickedData;
    let name_of_drug;
    // fetching the json file  
    async function fetchData(data) {
      try {
        response = data; // Replace with the correct JSON file path
        // const jsonData = await response.json();

        console.log('data coming from the', response);
        processData(response);
      } catch (error) {
        console.error("Error loading the JSON file:", error);
      }
    }


    // fetching the data ended here 

    function processData(data) {

      const uniqueProteins = new Set();

      data.forEach((item) => {
        if (!uniqueProteins.has(item.COMPOUND_NAME)) {
          uniqueProteins.add(item.COMPOUND_NAME);

          let calsoleimage;

          if (item.MAX_PHASE === "Approved") {
            calsoleimage = "grey.png"
          } else if (item.MAX_PHASE === "PHASE 1") {
            calsoleimage = "blue.png"
          } else if (item.MAX_PHASE === "PHASE 2") {
            calsoleimage = "yellow.png"
          } else if (item.MAX_PHASE === "PHASE 3") {
            calsoleimage = "lightblue.png"
          } else if (item.MAX_PHASE === "") {
            calsoleimage = "unknown.png"
          } else if (item.MAX_PHASE === "Unknown") {
            calsoleimage = "unknown.png"
          } else if (item.MAX_PHASE === "Preclinical") {
            calsoleimage = "purple.png"

          } else {
            // calsoleimage = "black.png"

          }


          nodes.push({
            id: item.COMPOUND_NAME,
            type: "parentnode",
            image: calsoleimage,
            MAX_PHASE: item.MAX_PHASE,
            flag: true
          });
        }
      });
      data.forEach((item) => {
        if (!uniqueProteins.has(item.CELL_LINE_NAME)) {
          uniqueProteins.add(item.CELL_LINE_NAME);
          nodes.push({
            id: item.CELL_LINE_NAME,
            type: "childnode",
            MAX_PHASE: item.MAX_PHASE,
            oncotree_change: item.ONCOTREE_LINEAGE
          });
        }
      });

      //  creating the links  

      links = data.map((item) => ({
        source: item.COMPOUND_NAME,
        target: item.CELL_LINE_NAME,
        value: item.VALUE,
        max_range_link: item.MAX_PHASE,
        dataset: item.DATASET
      }));

      console.log("nodes", nodes)

      console.log("links", links);


      let tempdata = [];


      data.filter(data => {
        if (!tempdata.includes(data.ONCOTREE_LINEAGE))
          tempdata.push(data.ONCOTREE_LINEAGE)
      })


    }




    // custom drag function

    function customDrag(simulation) {
      function dragstarted(event, d) {
        // if (d !== selectedNode) return; // Allow dragging only for the selected node
        if (!event.active) simulation.alphaTarget(0.3).restart();
      }

      function dragged(event, d) {
        // if (d !== selectedNode) return; // Allow dragging only for the selected node
        d.fx = event.x;
        d.fy = event.y;
      }

      function dragended(event, d) {
        // if (d !== selectedNode) return; // Allow dragging only for the selected node
        if (!event.active) simulation.alphaTarget(0);
      }

      return d3
        .drag()
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended);
    }


    // custom drag function ended



    // here the function to fetch the data from the databse for the biologics description 

    function fetchData2(drugName) {
      // Make AJAX request to PHP script
      $.ajax({
        type: "POST",
        url: "",
        data: {
          drugName: drugName
        },
        success: function(data) {
          // Handle the returned data
          console.log(data, "data to show ");
          drug_des_parent = JSON.parse(data);

          generate_table();
          // You can do further processing here
        },
        error: function(xhr, status, error) {
          console.error("Error: " + error);
        }
      });
    }

    function fetchData3(drugName2) {
      // Make AJAX request to PHP script
      $.ajax({
        type: "POST",
        url: "",
        data: {
          drugName2: drugName2
        },
        success: function(data) {
          // Handle the returned data
          console.log(data, "data to show ");
          drug_des_parent = JSON.parse(data);

          generate_table();
          // You can do further processing here
        },
        error: function(xhr, status, error) {
          console.error("Error: " + error);
        }
      });
    }



    function generate_table() {


      var div = document.querySelector('.parent_description');
      div.classList.toggle('show');
      var div = document.querySelector('.blur_the_background');
      div.classList.toggle('show');

      var name = document.querySelector('#drugname');
      name.innerHTML = clickedData.id;

      let dataobject = drug_des_parent['0'];

      console.log(dataobject, "check2");
      // Function to populate the table
      function populateTable() {
        const tableBody = document.getElementById('compoundTableBody');
        tableBody.innerHTML = '';

        Object.entries(dataobject).forEach(([key, value]) => {
          const row = document.createElement('tr');

          const keyCell = document.createElement('td');
          keyCell.textContent = key;
          row.appendChild(keyCell);

          const valueCell = document.createElement('td');
          row.appendChild(valueCell);
          valueCell.textContent = value;

          if (keyCell.innerText === 'CROSS_REFERENCES_CELL_LINES') {
            let text_change = valueCell.innerHTML;
            console.log(text_change)
            var formattedData = formatData(text_change);
            // Use innerHTML instead of textContent to render HTML tags
            valueCell.innerHTML = formattedData;

          } else if (keyCell.innerText === 'COMMENTS') {
            let text_change = valueCell.innerHTML;
            console.log(text_change)
            var formattedData = formatData2(text_change);
            // Use innerHTML instead of textContent to render HTML tags
            valueCell.innerHTML = formattedData;

          } else
          if (keyCell.innerText === 'REFERENCE_ID') {
            let text_change = valueCell.innerHTML;
            console.log(text_change)
            var formattedData = formatData3(text_change);
            // Use innerHTML instead of textContent to render HTML tags
            valueCell.innerHTML = formattedData;
          }

          tableBody.appendChild(row);
        });
      }

      function formatData(data) {
        var lines = data.split('|');
        var formattedLines = [];

        for (var i = 0; i < lines.length-1; i++) {
          var parts = lines[i].split(';');
          var formattedText = '<b>' + parts[0] + '</b>' + ':' + parts[1];
          formattedLines.push(formattedText);
        }



        return formattedLines.join('<br>');
      }

      function formatData2(data) {
        var lines = data.split('|');
        var formattedLines = [];


        for (var i = 0; i < lines.length-1; i++) {
          var parts = lines[i].split(':');
          var formattedText = '<b>' + parts[0] + '</b>' + ':' + parts[1];
          formattedLines.push(formattedText);
        }



        return formattedLines.join('<br>');
      }

      function formatData3(data) {

        var lines = data.split('|');
        var formattedLines = [];

        for (var i = 0; i < lines.length-1; i++) {
          var parts = lines[i].split('=');
          var formattedText = '<b>' + parts[0] + '</b>' + '=' + parts[1];
          formattedLines.push(formattedText);
        }



        return formattedLines.join('<br>');
      }
      // Call the function to populate the table
      populateTable();
      const toggleForm = document.querySelector('.toggle');
      const compoundTable = document.querySelector('table');
      const structureImage = document.querySelector('.structure-image');
      // structureImage.style.display = 'none';
      compoundTable.style.display = 'none';

      toggleForm.addEventListener('change', function() {

        if (document.getElementById('choice1').checked) {
          compoundTable.style.display = 'table'; // Show the table
          structureImage.style.display = 'none'; // Hide the image
          populateTable(); // Call the function to populate the table
        } else if (document.getElementById('choice2').checked) {
          compoundTable.style.display = 'none'; // Hide the table
          structureImage.style.display = 'block'; // Show the image
        }
      });
    }

    //  initialize the graph for the first time  


    const svg = d3.select("#forcenetwork");
    const svgWidth = +svg.node().getBoundingClientRect().width;
const svgHeight = +svg.node().getBoundingClientRect().height;

console.log("width", svgWidth, "height", svgHeight);

    function force_network_grapgh() {


      const g = svg.append("g");
      // simulationtag
      simulation = d3
        .forceSimulation(nodes)
        .force(
          "link",
          d3
          .forceLink(links)
          .id((d) => d.id)
          .distance(70)
        )
        .force("charge", d3.forceManyBody().strength(-15))
        .force("x", d3.forceX(500))
        .force("y", d3.forceY(270)) ;

      link = g
        .selectAll(".link ")
        .data(links)
        .enter()
        .append("line")
        .attr("class", "link")
        .style("stroke", function(d) {
          // Manually set colors based on the dataset value
          switch (d.dataset) {
            case "GDSC1":
              return "#000080";
            case "GDSC2":
              return "yellow";
            case "CCLE_NP24":
              return "blue";
            case "NCI-60":
              return "grey";
            case "gCSI":
              return "#ce7e00";
            case "FIMM":
              return "#6a329f";
            default:
              // Default color if the dataset doesn't match any specific case
              return "black";
          }
        })
        .attr("stroke-width", function(d) {

          if (d.value < 5) {
            return 1
          } else {

            return d.value - 2;
          }
        });

      node = g
        .selectAll(".node")
        .data(nodes)
        .enter()
        .append("g")
        .attr("class", "node").call(customDrag(simulation));
      node.on("click", handleClick);



      function handleClick(event) {

        clickedData = event.target.__data__;
        // alert(clickedData.id);
        name_of_drug = clickedData.id;


        let compoundData = {
          "COMPOUND_NAME": "Compound1",
          "PREFERRED_COMPOUND_NAME": "Preferred1",
          "PUBCHEM_ID": 1,
          "CHEMBL_ID": "ChEMBL1",
          "MAX_PHASE": 2,
          "Source_DB_DR_ID": 101
        };
        console.log("comppundata ", compoundData);
        // call the function 
        // workplace


        if (clickedData.type === "parentnode") {


          fetchData2(name_of_drug);

        } else if (clickedData.type === "childnode") {

          fetchData3(name_of_drug);

        }

        var closeButton = document.getElementById('parent_des_close');
        closeButton.addEventListener('click', function() {
          
      document.getElementById('choice2').checked = true;
      document.getElementById('choice1').checked = false;
      
      const structureImage = document.querySelector('.structure-image');
      structureImage.style.display = 'block'; // Show the image
          var div = document.querySelector('.parent_description');
          div.classList.remove('show');
          var div = document.querySelector('.blur_the_background');
          div.classList.remove('show');
        });
      }
      // Add tooltips
      const tooltip = node
        .append("text")
        .text((d) => d.id)
        .attr("dx", 6)
        .attr("dy", "1.5em")
        .attr("font-size", "10px")
        .attr("text-anchor", "middle")
        .style("fill", "black")
        .style("opacity", (d) => ((d.type === "parentnode" && (d.MAX_PHASE === "" || d.MAX_PHASE === "Unknown")) ? 0 : 1)); // hide initially for specific nodes

      node.on("mouseover", handleMouseOver).on("mouseout", handleMouseOut);




      function handleMouseOver(d) {
        // Show tooltip only for the hovered node
        d3.select(this).select("text").style("opacity", 1);

        // You might want to adjust the tooltip position based on your visualization
        // tooltip.attr("x", d.x).attr("y", d.y);
      }


      function handleMouseOut(d) {
        // Hide tooltip when the mouse is out  
        d3.select(this).select("text").style("opacity", (d) => (d.MAX_PHASE === "" || d.MAX_PHASE === "Unknown") && d.type === "parentnode" ? 0 : 1);

      }



      node
        .filter((d) => d.type === "childnode")
        .append("circle")
        .attr("r", 8)
        .attr("fill", "green")
        .attr("stroke", "#fff")
        .attr("stroke-width", 1.5)


      node.filter((d) => d.type === "parentnode")
        .append("rect")
        .attr("width", 30) // Set the width of the rectangle
        .attr("height", 12) // Set the height of the rectangle
        .attr("fill", function(node) {
          if (node.MAX_PHASE === "Approved") {
            return "grey";
          } else if (node.MAX_PHASE === "PHASE 1") {
            return "#000080";
          } else if (node.MAX_PHASE === "PHASE 2") {
            return "yellow";
          } else if (node.MAX_PHASE === "PHASE 3") {
            return "blue";
          } else if (node.MAX_PHASE === "") {
            return "#ce7e00";
          } else if (node.MAX_PHASE === "Unknown") {
            return "#ce7e00";
          } else if (node.MAX_PHASE === "Preclinical") {
            return "#6a329f";

          }
        })
        .attr("x", -12)
        .attr("y", -8)
        .attr("rx", 5) // Set the x-axis border radius
        .attr("ry", 5) // Set the y-axis border radius
        .attr("stroke", "#fff")
        .attr("stroke-width", 1.5);


      simulation.on("tick", () => {
        link
    .attr("x1", (d) => Math.max(0, Math.min(svgWidth, d.source.x)))
    .attr("y1", (d) => Math.max(0, Math.min(svgHeight, d.source.y)))
    .attr("x2", (d) => Math.max(0, Math.min(svgWidth, d.target.x)))
    .attr("y2", (d) => Math.max(0, Math.min(svgHeight, d.target.y)));

  node.attr("transform", (d) => `translate(${Math.max(0, Math.min(svgWidth, d.x))},${Math.max(0, Math.min(svgHeight, d.y))})`);
});




      var zoom = d3.zoom()
        .scaleExtent([0.1, 10]) // Set the zoom scale extent as needed
        .on("zoom", zoomed);


      g.call(zoom);

      function zoomed() {
        if (g) {
          // console.log(d3.event.transform)
          // g.attr("transform", d3.event.transform);

          var transform = d3.zoomTransform(this);
          // Access the current zoom state using d3.zoomTransform
          // It returns an object with properties: k (scale), x (translateX), and y (translateY)

          // Apply the zoom transformation directly to the SVG elements
          g.attr("transform", "translate(" + transform.x + "," + transform.y + ") scale(" + transform.k + ")");

        }
      }
      var zoomInButton = document.getElementById("zoom-in-button");
      var zoomOutButton = document.getElementById("zoom-out-button");

      zoomInButton.addEventListener("click", function() {
        svg.transition().call(zoom.scaleBy, 1.2);
      });

      zoomOutButton.addEventListener("click", function() {
        svg.transition().call(zoom.scaleBy, 0.8);
      });


    }

    function range_of_links(min_range, max_range, valueofslider) {


      link.style("display", null);
      node.style("display", null);

      //  fitleration of the threshold value sidler 
      // sildertag
      let parentnodes = node.filter(function(node) {
        if (node.type === "parentnode") {
          return node;
        }
      })

      slider2.max = parentnodes.size();
      let filternodes3 = parentnodes.each(function(drugNode, i) {
        if (i < valueofslider) {
          d3.select(this).style("display", null);
        } else {
          d3.select(this).style("display", "none");
          link.filter(function(linktemp) {
            if (linktemp.source === drugNode) {
              d3.select(this).style("display", "none")
            }
          })

        }

      });



      filteredLinks = link.filter(link => {
        // Filter links with a value greater than 5
        return link.value < min_range || link.value > max_range
      });



      filterNodes = node.filter(node => {

        return filteredLinks.data().some(link => (link.target === node || link.source === node));
      });



      // Hide the filtered links

      filteredLinks.style("display", "none");



      var filterlinks2 = link.filter(function(templink) {
        // Filter links with a value greater than 5
        let visible = d3.select(this).style("display");
        if (visible === "inline") {

          return templink;
        }
      });


      // Hide the associated target nodes
      filterNodes.style("display", "none");

      let filterNodes2 = filterNodes.filter(node => {
        // Check if there's at least one link connected to the node that is not in filteredLinks
        const isLinkedToHiddenLink = link.data().some(link => {
          return (link.target === node || link.source === node) && !filteredLinks.data().includes(link);
        });

        return isLinkedToHiddenLink;
      });

      // Reset the display style for the filtered nodes
      filterNodes2.style("display", null);

      //

      node.each(function(d) {


        // Check if the node's MAX_PHASE is in the list_hidden
        if (list_hidden.includes(d.MAX_PHASE) && d.type === "parentnode") {
          // Node is in list_hidden, set display to "none"

          d3.select(this).style("display", "none");

        }
      });

      const matchinglink = link.filter(function(link) {
        if (list_hidden.includes(link.source.MAX_PHASE)) {
          return link;
        }
      });

      matchinglink.style("display", "none");

      let connectedNodes;
      let allconnedtednodes = [];


      // here is the removing and show of the max_phase child nodes 

      let childNode2 = node.filter(node => {
        if (node.type === "childnode") {
          return node;
        }
      })
      childNode2.style("display", "none");

      let visiblenode = [];
      node.filter(function(node) {
        if (node.type === "parentnode") {
          let maxnode = d3.select(this).style("display");
          if (maxnode === "inline") {
            filterlinks2.filter(link => {
              if (link.source === node) {
                visiblenode.push(link.target.id);
              }
            })
          }
        }
      })

      node.filter(function(node) {
        if (visiblenode.includes(node.id)) {
          d3.select(this).style("display", null);
        }
      })

      // ended    

      //    child nodes will be filter here 


      let childnodefilteration = node.filter(function(childNode) {
        if (list_hidden_childnode.includes(childNode.oncotree_change)) {
          return childNode;
        }
      });

      childnodefilteration.style("display", "none");

      let source_node = [];

      let matchinglinkpart = link.filter(function(link) {
        if (list_hidden_childnode.includes(link.target.oncotree_change)) {


          source_node.push(link.source.id)

          return (
            link
          );
        }
      });

      matchinglinkpart.style("display", "none");



      node.each(function(d) {
        // d3.select(this).style("display", "none");   
        if (source_node.includes(d.id)) {


          const connectedLinks = link.filter(
            (link) => link.source.id === d.id
          );


          const data = connectedLinks.data().map((link) => link.target.oncotree_change);


          const flag2 = data.every((item) => list_hidden_childnode.includes(item));

          if (flag2) {

            d3.select(this).style("display", "none");

            var displayStyle = d3.select(this).style("display");
          }
          // else{

          //   d3.select(this).style("display", null);
          // }

        }
      });

      node.each(function(d) {
        if (d.type === "parentnode") {
          var nodestyle = d3.select(this).style("display");

          const connectedLinks = link.filter(link => link.source.id === d.id);

          // Array to store styles of connected links
          var linkStyles = [];

          connectedLinks.each(function(link) {
            var linkStyle = d3.select(this).style("display");

            linkStyles.push(linkStyle);
          });
          // Check if every style in the array is "none"
          var allLinksNone = linkStyles.every(style => style === "none");

          if (allLinksNone) {
            // Set node style to "display: none"
            d3.select(this).style("display", "none");
          }
        }
      });
      // link filter nodes here 
      link.filter(function(templink) {
        if (list_hidden_dataset.includes(templink.dataset)) {
          d3.select(this).style("display", "none");

          node.filter(function(tempnode) {
            if (tempnode === templink.target || tempnode === templink.source) {
              var nodestyle = d3.select(this).style("display");

              const connectedLinks = link.filter(link => link.source.id === tempnode.id || link.target.id === tempnode.id);

              // Array to store styles of connected links
              var linkStyles = [];

              connectedLinks.each(function(link) {
                var linkStyle = d3.select(this).style("display");

                linkStyles.push(linkStyle);
              });
              // Check if every style in the array is "none"
              var allLinksNone = linkStyles.every(style => style === "none");

              if (allLinksNone) {
                // Set node style to "display: none"
                d3.select(this).style("display", "none");
              }

            }
          })
        }
      })

      //  link filter nodes ended here 

      // 

      // export csv 
      csvfile = [];
      node.filter(function(node) {
        // Select the current node using D3 and get its "display" property
        let visibility = d3.select(this).style("display");

        // Check if the display property is "inline"
        if (visibility === "inline") {
          response.filter(function(maindata) {

            if (maindata.COMPOUND_NAME === node.id) {
              //  if(!csvfile.includes(maindata))
              csvfile.push(maindata);
            }
          })
          // If true, push the node into the csvfile array
        }
      });

      // Log the contents of csvfile to the console
      console.log("csvfile", csvfile);

    }


    // legenddata
    function legendinfo() {
      const max_phase_categories = [{
          category: "PHASE 1",
          color: "#000080"
        },
        {
          category: "PHASE 2",
          color: "yellow"
        },
        {
          category: "PHASE 3",
          color: "blue"
        },
        {
          category: "Approved",
          color: "grey"
        },
        {
          category: "",
          color: "#ce7e00"
        },
        {
          category: "Preclinical",
          color: "#6a329f"
        }
      ];



      const data_Set = [{
          category: "GDSC1",
          color: "#000080"
        },
        {
          category: "GDSC2",
          color: "yellow"
        },
        {
          category: "CCLE_NP24",
          color: "blue"
        },
        {
          category: "NCI-60",
          color: "grey"
        },
        {
          category: "gCSI",
          color: "#ce7e00"
        },
        {
          category: "FIMM",
          color: "#6a329f"
        }
      ];

      const ul = d3.select("#myList");
      listItems = ul
        .selectAll("li")
        .data(max_phase_categories)
        .enter()
        .append("li");

      max_phase_color = listItems
        .append("div")
        .attr("class", "rect")
        .style("background-color", (d) => {
          for (const categoryObj of max_phase_categories) {
            if (d.category === categoryObj.category) {
              return categoryObj.color;
            }
          }
          return "#6a329f";
        }).on("click", color_click_onchange);;


      pax_phasecliked = listItems
        .append("span")
        .text((d) => (d.category === "" ? "Unknown" : d.category))


      const ul2 = d3.select("#dataset");
      dataSet_link = ul2
        .selectAll("li")
        .data(data_Set)
        .enter()
        .append("li");


      data_set_color = dataSet_link
        .append("div")
        .attr("class", "line")
        .style("background-color", (d) => {
          for (const categoryObj of data_Set) {
            if (d.category === categoryObj.category) {
              return categoryObj.color;
            }
          }
          return "#6a329f";
        }).on("click", color_click_onchange);;


      datasettext_click = dataSet_link.append("span").text((d) => d.category);

      // color picker
      for (const categoryObj of max_phase_categories) {
        addColor(categoryObj.color);
      }
    }

    //colorpicker 

    var colorpick;
    let li;
    let ul_color;
    let count = 0;
    let count1 = 0;
    let cardshow;
    let clickedDiv = '';
    ul_color = document.getElementById('colorList');
    let selected_maxphase;


    function addColor(color) {
      li = document.createElement('li');
      li.className = 'color-item';
      li.id = color;
      li.style.backgroundColor = color; // Set background color
      ul_color.appendChild(li);

    }

    function color_click_onchange(event, d) {
      selected_maxphase = d.category;
      clickedDiv = d3.select(this);

      var clickX = event.clientX;
      var clickY = event.clientY;

      cardshow = document.getElementById("cardid");
      cardshow.style.display = "block";

      // Set the position of cardshow based on the click coordinates
      cardshow.style.left = clickX + "px";
      cardshow.style.top = clickY + "px";

      count = 0;

    }



    ul_color.addEventListener("click", function(event) {

      let clickedLi = "";

      clickedLi = event.target;

      if (clickedLi.tagName === 'LI') {
        colorpick = clickedLi.style.backgroundColor;

        clickedDiv.style("background-color", colorpick || "#6a329f");
        cardshow.style.display = "none";

      }
      node.each(function(node) {
        if (node.MAX_PHASE === selected_maxphase && node.type === "parentnode") {
          if (colorpick === "yellow") {
            d3.select(this).select("rect") // Assuming the shape is a rectangle, adjust as needed
              .attr("fill", "yellow");

          } else if (colorpick === "grey") {
            d3.select(this).select("rect")
              .attr("fill", "grey");

          } else if (colorpick === "rgb(206, 126, 0)") {
            d3.select(this).select("rect")
              .attr("fill", "rgb(206, 126, 0)");

          } else if (colorpick === "rgb(0, 0, 128)") {
            d3.select(this).select("rect")
              .attr("fill", "rgb(0, 0, 128)");
          } else if (colorpick === "blue") {
            d3.select(this).select("rect")
              .attr("fill", "blue");
          } else {
            d3.select(this).select("rect")
              .attr("fill", "purple.png");
          }
        }
      });


      link.filter(function(templink) {
        if (templink.dataset === selected_maxphase) {
          d3.select(this).style("stroke", colorpick);

        }

      });





      node.filter((d) => d.type === 'parentnode')
        .select('image')
        .attr('xlink:href', (d) => d.image);

    });



    legendinfo();

    function onclickmax_phase(event) {

      d3.select(this)
        .classed("marked", function() {
          return !d3.select(this).classed("marked");
        });

      clicked = event.target.textContent;

      const index = list_hidden.indexOf(clicked);

      if (clicked === "Unknown") {
        // If 'clicked' is "unknown", check if an empty string ("") is in 'list_hidden'
        const emptyStringIndex = list_hidden.indexOf("");
        if (emptyStringIndex === -1) {
          // If an empty string is not in the array, push it
          list_hidden.push("");
          list_hidden.push("Unknown")
        } else {
          // If an empty string is already in the array, splice it (remove)
          list_hidden.splice(emptyStringIndex, 2);
        }
      } else if (index === -1) {
        // If 'clicked' is not in 'list_hidden', push it
        list_hidden.push(clicked);
      } else {
        // If 'clicked' is already in 'list_hidden', splice it
        list_hidden.splice(index, 1);

      }


      range_of_links(minValue, maxValue, slider_range);


    }


    function onclick_dataSet(event) {
      d3.select(this)
        .classed("marked", function() {
          return !d3.select(this).classed("marked");
        });

      clicked2 = event.target.textContent;

      const index = list_hidden_dataset.indexOf(clicked2);


      if (index === -1) {
        list_hidden_dataset.push(clicked2);
      } else {
        list_hidden_dataset.splice(index, 1);
      }

      range_of_links(minValue, maxValue, slider_range);
    }

    function onclick_childnodes(event) {

      d3.select(this)
        .classed("marked", function() {
          return !d3.select(this).classed("marked");
        });

      clicked3 = event.target.textContent;

      const index = list_hidden_childnode.indexOf(clicked3);


      if (index === -1) {
        list_hidden_childnode.push(clicked3);
      } else {
        list_hidden_childnode.splice(index, 1);
      }



      range_of_links(minValue, maxValue, slider_range);


    }

    function clearGraph() {
      const svg = d3.select("#forcenetwork");
      svg.selectAll("*").remove();
      nodes = [];
      links = [];
      slider_range = 100;
      slider2.max = 100;

      rangeValue.textContent = 100;
    }



    /// here is the code of applying the logic of theslider_rangeclear maxphase 

    // setting the sidler valus 
    const minSlider = document.getElementById("min_slider");
    const maxSlider = document.getElementById("max_slider");
    const rangetext = document.getElementById("rangeValue");
    // Function to log the values of both sliders
    function logSliderValues() {

      // tag2
      rangeValue.textContent = slider2.value;
      minValue = parseFloat(minSlider.value);
      maxValue = parseFloat(maxSlider.value);

      slider_range = parseFloat(slider2.value);

      pax_phasecliked.on("click", onclickmax_phase);

      datasettext_click.on("click", onclick_dataSet);

      // child_clicked.on("click", onclick_childnodes);

      range_of_links(minValue, maxValue, slider_range);

    }



    // Add onchange event listeners to both sliders
    minSlider.addEventListener("change", logSliderValues);
    maxSlider.addEventListener("change", logSliderValues);

    slider2.addEventListener("change", logSliderValues);



    // slider value ended here 


    document.getElementById("submitButton").addEventListener("click", function(event) {


      // Reset error messages
      document.querySelectorAll(".alert2").forEach(function(alert) {
        alert.style.display = "none";
      });
      document.querySelectorAll(".error-border").forEach(function(element) {
        element.classList.remove("error-border");
      });

      if (
        document.getElementById("dropdown1").value === "" &&
        document.getElementById("dropdown2").value === "" &&
        document.getElementById("dropdown3").value === "" &&
        document.getElementById("dropdown4").value === "" 

      ) {
        // Show error messages for the empty dropdowns

        if (document.getElementById("dropdown1").value === "") {
          document.querySelector("#dropdown1 + .alert2").style.display = "block";
          document.getElementById("dropdown1").classList.add("error-border");
        }

        if (document.getElementById("dropdown2").value === "") {
          document.querySelector("#dropdown2 + .alert2").style.display = "block";
          document.getElementById("dropdown2").classList.add("error-border");
        }
        if (document.getElementById("dropdown3").value === "") {
          document.querySelector("#dropdown3 + .alert2").style.display = "block";
          document.getElementById("dropdown3").classList.add("error-border");
        }
        if (document.getElementById("dropdown4").value === "") {
          document.querySelector("#dropdown4 + .alert2").style.display = "block";
          document.getElementById("dropdown4").classList.add("error-border");
        }

        // Prevent form submission
        event.preventDefault();

      } else {

        event.preventDefault();


        ajax();

        // document.getElementById("dropdown1").value = "";
        // document.getElementById("dropdown2").value = "";
        // document.getElementById("dropdown3").value = "";



      }



      document.getElementById("dropdown1").addEventListener("change", function() {
        removeError(this);
      });

      document.getElementById("dropdown2").addEventListener("change", function() {
        removeError(this);
      });

      document.getElementById("dropdown3").addEventListener("change", function() {
        removeError(this);
      });
      document.getElementById("dropdown4").addEventListener("change", function() {
        removeError(this);
      });

      function removeError(dropdown) {
        // Remove error message and border when a selection is made
        dropdown.nextElementSibling.style.display = "none";
        dropdown.classList.remove("error-border");
      }


    });

    // slider code 

    const rangeInput = document.querySelectorAll(".range-input input");
    const priceInput = document.querySelectorAll(".price-input input");
    const range = document.querySelector(".slider .progress");
    let priceGap = 0.1; // Change the step to 0.1

    priceInput.forEach(input => {
      input.addEventListener("input", (e) => {
        let minPrice = parseFloat(priceInput[0].value);
        let maxPrice = parseFloat(priceInput[1].value);

        if (maxPrice - minPrice >= priceGap && maxPrice <= parseFloat(rangeInput[1].max)) {
          if (e.target.className === "input-min") {
            rangeInput[0].value = minPrice;
            range.style.left = ((minPrice / parseFloat(rangeInput[0].max)) * 100) + "%";
          } else {
            rangeInput[1].value = maxPrice;
            range.style.right = 100 - (maxPrice / parseFloat(rangeInput[1].max)) * 100 + "%";
          }
        }
      });
    });

    rangeInput.forEach(input => {
      input.addEventListener("input", (e) => {
        let minVal = parseFloat(rangeInput[0].value);
        let maxVal = parseFloat(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
          if (e.target.className === "range-min") {
            rangeInput[0].value = maxVal - priceGap;
          } else {
            rangeInput[1].value = minVal + priceGap;
          }
        } else {
          priceInput[0].value = minVal;
          priceInput[1].value = maxVal;
          range.style.left = ((minVal / parseFloat(rangeInput[0].max)) * 100) + "%";
          range.style.right = 100 - (maxVal / parseFloat(rangeInput[1].max)) * 100 + "%";
        }
      });
    });
  </script>

  <!---Script to fetch data  from php script --->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- JavaScript for handling form submission and AJAX -->
  <script>
    function ajax() {

      // Prevent the default form submission
      event.preventDefault();
      // Get the selected values from the dropdowns
      var dropdown1Value = $("#dropdown1").val();
      var dropdown2Value = $("#dropdown2").val();
      var dropdown3Value = $("#dropdown3").val();
      var dropdown4Value = $("#dropdown4").val();



      document.getElementById('loader').style.display = 'block';
      clearGraph();

      document.getElementById('wrapper').style.display = 'none';

      document.getElementById('buttonbar').style.dispajaxfetchdatalay = 'none';

      // Make an AJAX request to the current PHP script
      $.ajax({
        type: "POST",
        url: "", // Leave it empty to target the current page
        data: {
          dropdown1: dropdown1Value,
          dropdown2: dropdown2Value,
          dropdown3: dropdown3Value,
          dropdown4: dropdown4Value,
          
        },
        success: function(response) {

          jsondata2 = response;

          fetchData(jsondata2);


          document.getElementById('wrapper').style.display = 'block';


          document.getElementById('buttonbar').style.display = 'block';



          document.getElementById('loader').style.display = 'none';

          force_network_grapgh();

          pax_phasecliked.on("click", onclickmax_phase);

          datasettext_click.on("click", onclick_dataSet);

          range_of_links(minValue, maxValue, slider_range);



          // processData(jsondata2);
          // You can parse the JSON and use the data as needed
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: " + status + " - " + error);
        }
      });

    }
  </script>

  <!-- overlayascript?  -->
  <script>
    const section = document.querySelector("section"),
      overlay = document.querySelector(".overlay"),
      showBtn = document.querySelector("#export"),
      closeBtn = document.querySelector(".close-btn");
    // tag1
    showBtn.addEventListener("click", () => section.classList.add("active"));
    overlay.addEventListener("click", () =>
      section.classList.remove("active")
    );
    closeBtn.addEventListener("click", () =>
      section.classList.remove("active")
    );

    const redraw = () => {
      // Restart the simulation



      if (simulation.alpha() < 0.01) {
        // Manually restart the simulation
        simulation.alpha(1).restart();

        nodes.forEach(function(d) {
          d.fx = null;
          d.fy = null;
        });
      } else {
        simulation.alpha(1).restart();

        nodes.forEach(function(d) {
          d.fx = null;
          d.fy = null;
        });
      }
     


    };

    // Event listener for the redraw button
    d3.select("#redraw").on("click", redraw);
  </script>
  <!-- // capture picture  -->
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

  <script>
    // downlaodPNG
    document.getElementById('png').addEventListener('click', function() {

      document.getElementById('buttonbar').style.display = 'none';
      section.classList.remove("active")


      downlaodPNG("png");
      document.getElementById('buttonbar').style.display = 'block';


    });
    // downlaodJPEG
    document.getElementById('jpeg').addEventListener('click', function() {

      document.getElementById('buttonbar').style.display = 'none';
      section.classList.remove("active")
      downlaodPNG("jpeg");

      document.getElementById('buttonbar').style.display = 'block';
    });

    //  downloadCSV 
    document.getElementById('csv').addEventListener('click', function() {
      section.classList.remove("active")

      // downloadCSV(csvfile);  
      cenvertxlsx(csvfile);
    });

    function downlaodPNG(typeochart) {
      html2canvas(document.body, {
        allowTaint: true,
        useCors: true,
        windowWidth: window.innerWidth,
        windowHeight: window.innerHeight,
        scrollX: window.scrollX,
        scrollY: window.scrollY
      }).then(function(canvas) {
        var link = document.createElement('a');
        link.href = canvas.toDataURL();
        link.download = `chart.${typeochart}`;

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      });
    }
    //downloadxlxs
    function cenvertxlsx(dataArray) {
      const ws = XLSX.utils.json_to_sheet(dataArray);

      // Create a workbook
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');

      // Save the workbook to an XLSX file
      XLSX.writeFile(wb, 'output.xlsx');

      alert('XLSX file created successfully');

    }
  </script>

</body>

</html>