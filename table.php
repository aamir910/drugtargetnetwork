<?php

include("fetchdata.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if all array values are set
  if (
    // isset($_POST['Chembl_id1']) ||
    isset($_POST['MaxPhase1']) ||
    isset($_POST['oncotree_change1']) ||
    isset($_POST['DataPlatform']) ||
    isset($_POST['pic50']) ||
    isset($_POST['disease_class1'])


  ) {
    // Array to store conditions
    $conditions = array();


    $sql = "SELECT drugresponse.*, compounds_updated1.INCHI_KEY, drug_disease.Disease_class, 
    drug_disease.Disease_name , drug_disease.Phase FROM drugresponse";

    // Join with compounds_updated1 table
    $sql .= " LEFT JOIN compounds_updated1 ON drugresponse.COMPOUND_NAME = compounds_updated1.COMPOUND_NAME";

    // Join with drug_disease table
    $sql .= " LEFT JOIN drug_disease ON compounds_updated1.INCHI_KEY = drug_disease.INCHI_KEY";

    $sql .= " WHERE";


    // Check and add condition for ONCOTREE_PRIMARY_DISEASE
    if (isset($_POST['Chembl_id1']) && !empty($_POST['Chembl_id1'])) {
      $Chembl_id1 = $_POST['Chembl_id1'];
      $escaped_chembl_ids = array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
      }, $Chembl_id1);

      $Chembl_id_condition = implode("','", $escaped_chembl_ids);
      $conditions[] = "drugresponse.ONCOTREE_PRIMARY_DISEASE IN ('$Chembl_id_condition')";
    }

    // Check and add condition for MAX_PHASE
    if (isset($_POST['MaxPhase1']) && !empty($_POST['MaxPhase1'])) {
      $MaxPhase1 = $_POST['MaxPhase1'];
      $MaxPhase_condition = implode("','", $MaxPhase1);
      $conditions[] = "drugresponse.MAX_PHASE IN ('$MaxPhase_condition')";
    }

    // Check and add condition for pic50
    if (isset($_POST['pic50']) && !empty($_POST['pic50'])) {
      $pic50 = floatval($_POST['pic50']); // Convert pic50 to a float value
      $conditions[] = "VALUE >= $pic50";
    }

    // Check and add condition for ONCOTREE_LINEAGE
    if (isset($_POST['oncotree_change1']) && !empty($_POST['oncotree_change1'])) {
      $oncotree_change1 = $_POST['oncotree_change1'];
      $oncotree_change_condition = implode("','", $oncotree_change1);
      $conditions[] = "drugresponse.ONCOTREE_LINEAGE IN ('$oncotree_change_condition')";
    }

    if (isset($_POST['DataPlatform']) && !empty($_POST['DataPlatform'])) {
      $DataPlatform = $_POST['DataPlatform'];
      $DataPlatform_condition = implode("','", $DataPlatform);
      $conditions[] = "drugresponse.DATASET IN ('$DataPlatform_condition')";
    }
    // for the data of the drug_disease  

    if (isset($_POST['disease_class1']) && !empty($_POST['disease_class1'])) {
      $disease_class1 = $_POST['disease_class1'];
      $disease_class1_condition = implode("','", $disease_class1);
      $conditions[] = "drug_disease.Disease_class IN ('$disease_class1_condition')";
    }

    $count_increment = intval($_POST['count_increment']);
    $drugresponse_id  = intval($_POST['drugresponse_id']);
    if (!empty($conditions)) {

      // $sql = "SELECT * FROM drugresponse WHERE " . implode(" AND ", $conditions) ;
      $sql .= " " . implode(" AND ", $conditions) . "  AND drugresponse_id >" . $drugresponse_id;
      // if ($count_increment != 1) {

      //   $sql .= " " . implode(" AND ", $conditions) . "  AND drugresponse_id > 5000";
      // } else {
      //   $sql .= " " . implode(" AND ", $conditions) . "  AND drugresponse_id >";
      // }
    }

    // Limit the result to 400 rows0
    $limit = 500;

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

    // Echo the JSON-encoded data
    echo $json_result;
    exit(); // Stop further execution
  }
}
?>


<?php

// Check if drugName is set in the POST request
if (isset($_POST['drugName2'])) {

  include 'fetchdata.php';
  $drugName = $_POST['drugName2'];

  // Use prepared statement to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM compounds_updated1 WHERE COMPOUND_NAME = ?");
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
if (isset($_POST['drugName'])) {

  include 'fetchdata.php';
  $drugName2 = $_POST['drugName'];

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
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="styles.css">
  <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- ajax  -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<title>DrugTargetNetwork</title>



</head>

<style>
  .container {
    /* margin-left: 20px; */
    /* Adjust the left margin as needed */
    /* margin-right: 20px; */
    /* width: 140%; */
    /* Adjust the right margin as needed */
  }

  #example {
    /* width: 100%; Set the width to 100% or adjust it as needed */
  }

  .container,
  .container-lg,
  .container-md,
  .container-sm,
  .container-xl,
  .container-xxl {
    max-width: 1792px;
  }

  /* loader started  */

  .loader {
    position: absolute;
    display: none;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #28a5fb;
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

  /* .dataTables_scroll {
    width: 180%;
  } */

  /* .row{
  width: 180%;
} */
  /* loader ended  */


  .selection_box {
    display: flex;
    justify-content: space-between;
    /* align-items: center; */
    background-color: rgb(231 226 226 / 50%);
    padding: 0.5rem;
  }


  .btn_left {
    position: absolute;
    margin-right: 10px;
    /* display: flex;
  justify-content: flex-end;
  align-items: end; */
    right: 0;
  }


  .btn1 {
    background-color: #28a5fb;
    /* Background color */
    color: white;
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
    font-size: 0.888rem;
    /* Font size */
    margin: 4px 2px;
    /* Add margin to the button */
    cursor: pointer;
    /* Add a pointer cursor on hover */
    border-radius: 4px;
    /* Rounded corners */
  }

  .dataTables_filter {
    position: absolute;
    top: 10px;
    left: 10px;
  }

  .dataTables_filter {
    float: right;
    /* You can adjust this property */
    margin-right: 10px;
    /* You can adjust this property */
  }

  /* here is the css of the table */

  .parent_description {
    /* width: 90%;
    height: 60%; */
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

    z-index: 999;

    height: 100vh;
    backdrop-filter: blur(10px);
    position: absolute;


    z-index: 999;
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

  .table-container table {
    border-collapse: collapse;
    width: 90%;
    margin-top: 20px;
    max-height: 500px;
    overflow: auto;
  }

  .table-container th,
  td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    height: 10px !important;

    overflow: auto;
  }

  .table-container th {
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

  .table-container td {
    white-space: pre-line;
    /* Preserve newline characters */
  }

  b {
    font-weight: bold;
  }

  .wrapper {
    width: 22%;
  }

  .forcenetwork {
    width: 78%;
    background-color: white;
  }

  .slider2size {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    /* width: 21rem; */
    margin-bottom: 2rem;
  }

  .form-select {
    width: 100%;
  }

  .dropdown {
    display: inline-block;
    position: relative;
  }

  #complete_table th {
    background-color: #051d33;
    color: white;
    font-weight: 500;
    letter-spacing: 1.5px;
  }
  @media (min-width: 768px) {
    .col-md-6 {
        /* flex: 0 0 auto; */
        width: 100%;
        right: 0;
        z-index: 9999;
        margin-bottom: 3rem;
        margin-top: -44px;
    }
}


  /* here is the css of the table ended */
</style>

<body>

  <!-- here will add the navbar -->
  <div id="loader_id">
    <div class="loader" id="loader"></div>
  </div>

  <nav class="selection_box">
    <div style="display: flex; ">
      <img src="images/drugtargetprofiler.png"  width="auto" height="50px" alt="noimg">
      <h5 style="padding: 0.5rem;">Drug Target Network</h5>

    </div>
    <div class="btn_left">
      <button id="fetch_more_data" class="btn1" onclick="fetchdata()">fetch_more_data</button>

    </div>
    <div id="search-container"></div>
  </nav>





  <!-- <div class="container m-5"  ><h2>Drug Target Network</h2></div> -->

  <div class="container mt-5 mb-5" id='complete_table'>
    <table id="example" class="table table-striped" style="width:100%">

      <thead>
        <tr>
          <th style="background-color: 051d33;">indexs</th>
          <th>drugresponse_id</th>
          <th>COMPOUND_NAME</th>
          <th>CELL_LINE_NAME</th>
          <th>VALUE</th>
          <th>METRIC</th>
          <th>DATASET</th>
          <th>Pubmed_ID</th>
          <th>PUBCHEM_ID</th>
          <th>CHEMBL_ID</th>
          <th>MAX_PHASE</th>
          <th>RRID</th>
          <th>ONCOTREE_LINEAGE</th>
          <th>ONCOTREE_PRIMARY_DISEASE</th>
          <th>Disease_class</th>
          <th>Disease_name</th>
          <th>Phase</th>

        </tr>

      </thead>
      <tbody id="tableBody">

      </tbody>
      <tfoot>
        <!-- Add footer content if needed -->
      </tfoot>
    </table>
  </div>




  <div class="blur_the_background">


    <div class="parent_description ">
      <!-- heading  -->
      <p id="drugname">name</p>
      <div class="container">

        <form class="toggle">

          <!-- <input type="radio" id="choice2" name="choice" value="productive" checked>
          <label for="choice2">Biologics Structure </label>
          <input type="radio" id="choice1" name="choice" value="creative">
          <label for="choice1">Properties</label> -->

        </form>
      </div>
      <div class="table-container">
        <table>
          <tbody id="compoundTableBody">
            <!-- Data will be dynamically inserted here using JavaScript -->
          </tbody>
          <!-- <img src="image_not_available.png" alt="Structure Image" class="structure-image"> -->
        </table>
      </div>
      <button style="background:none " id='parent_des_close'><img height="20px" width="20px" src="images/icons8-close-60.png" alt=""></button>

    </div>



    <script>
      // Function to parse query parameters from the URL
      function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split('&');

        for (var i = 0; i < vars.length; i++) {
          var pair = vars[i].split('=');
          if (decodeURIComponent(pair[0]) === variable) {
            return decodeURIComponent(pair[1]);
          }
        }

        console.log('Query variable %s not found', variable);
        return null;
      }

      // Retrieve arrays and single value from query parameters
      let count_increment = 1;
      var oncotree_change1 = JSON.parse(getQueryVariable('arr1'));
      var MaxPhase1 = JSON.parse(getQueryVariable('arr2'));
      var DataPlatform = JSON.parse(getQueryVariable('arr3'));
      var disease_class1 = JSON.parse(getQueryVariable('arr4'));
      var pic50 = parseInt(getQueryVariable('singleValue'));

      // Now you can use the retrieved arrays and single value in your index2.html
      console.log('Array 1:', oncotree_change1);
      console.log('Array 2:', MaxPhase1);
      console.log('Array 3:', DataPlatform);
      console.log('Single Value:', pic50);

      function fetchdata() {

        count_increment += 1;

        var table = $('#example').DataTable(); // Initialize DataTable
              table.destroy();
              flag = true ; 
        ajax();


      }




      let drugresponse_id = 0;
      let maxDrugResponseId = 0;
      var tableBody = $('#tableBody');
      let dataTable;
      console.log(tableBody, "data in the table ");
      let flag = true;
      let count_row = 1;
      let previousdata = [];

      function ajax() {
        let bodyElement = document.body;
        let y_graph = 350;
        let x_graph = bodyElement.clientWidth / 2;


        // Assuming 'loader' is the ID of your loader element
        let loaderElement = document.getElementById('loader');

        // Set the position of the loader
        loaderElement.style.display = 'block';
        loaderElement.style.top = y_graph + 'px';
        loaderElement.style.left = x_graph + 'px';

        document.getElementById('complete_table').style.display = 'none';


        var response2 = [{
            "drugresponse_id": 1,
            "COMPOUND_NAME": "Compound1",
            "CELL_LINE_NAME": "CellLine1",
            "VALUE": "Value1",
            "METRIC": "Metric1",
            "DATASET": "Dataset1",
            "Pubmed_ID": "PubmedID1",
            "PUBCHEM_ID": "PubchemID1",
            "CHEMBL_ID": "ChEMBLID1",
            "MAX_PHASE": "MaxPhase1",
            "RRID": "RRID1",
            "ONCOTREE_LINEAGE": "OncotreeLineage1",
            "ONCOTREE_PRIMARY_DISEASE": "OncotreePrimaryDisease1",
            "Disease_class": "DiseaseClass1",
            "Disease_name": "DiseaseName1",
            "Phase": "Phase1"
          },
          // Add more dummy data as needed
        ];


        $.ajax({
          type: "POST",
          url: "", // Leave it empty to target the current page
          data: {
            count_increment: count_increment,
            // Chembl_id1: Chembl_id1,
            MaxPhase1: MaxPhase1,
            oncotree_change1: oncotree_change1,
            DataPlatform: DataPlatform,
            disease_class1: disease_class1,
            pic50: pic50,
            drugresponse_id: maxDrugResponseId
          },
          success: function(response) {

            jsondata2 = response;
            console.log("newData", jsondata2);

          
            tableBody.empty();

            $.each(response, function(index, row) {
              // console.log(row ,"here is row ")
              if(flag){
                if(previousdata){
                  previousdata.forEach((data)=> tableBody.append(data))
                }
                flag = false ; 
              }

              var newRow = '<tr>';
             
              newRow += '<td>' + count_row + '</td>';
              newRow += '<td>' + row.drugresponse_id + '</td>';
              newRow += `<td> <a href="#" onclick="fetchData3('${row.COMPOUND_NAME}')">${row.COMPOUND_NAME}</a></td>`;
              newRow += `<td> <a href="#" onclick="fetchData2('${row.CELL_LINE_NAME}')">${row.CELL_LINE_NAME}</a></td>`;
              newRow += '<td>' + row.VALUE + '</td>';
              newRow += '<td>' + row.METRIC + '</td>';
              newRow += '<td>' + row.DATASET + '</td>';
              newRow += '<td>' + row.Pubmed_ID + '</td>';
              newRow += '<td>' + row.PUBCHEM_ID + '</td>';
              newRow += '<td>' + row.CHEMBL_ID + '</td>';
              newRow += '<td>' + row.MAX_PHASE + '</td>';
              newRow += '<td>' + row.RRID + '</td>';
              newRow += '<td>' + row.ONCOTREE_LINEAGE + '</td>';
              newRow += '<td>' + row.ONCOTREE_PRIMARY_DISEASE + '</td>';
              newRow += '<td>' + row.Disease_class + '</td>';
              newRow += '<td>' + row.Disease_name + '</td>';
              newRow += '<td>' + row.Phase + '</td>';
              newRow += '</tr>';;
              previousdata.push(newRow); 
              tableBody.append(newRow);

              count_row++;
              drugresponse_id = row.drugresponse_id;
              if (row.drugresponse_id > maxDrugResponseId) {
                maxDrugResponseId = row.drugresponse_id;
              }
            });


            console.log(drugresponse_id, "drugresponse_id", maxDrugResponseId)

              $(document).ready(function() {
                // Initialize DataTable only once
                dataTable = $('#example').DataTable({
                  "scrollX": true,
                  "paging": true,
                  "searching": true,
                  "lengthMenu": [1000, 2000, 3000, 5000],
                });
              });

            document.getElementById('loader').style.display = 'none';
            document.getElementById('complete_table').style.display = 'block';
          },
          error: function(xhr, status, error) {

            document.getElementById('loader').style.display = 'none';
            alert("data not fetch")
            console.error("AJAX Error: " + status + " - close-btn" + error);
          }
        });
      }

      ajax();




      // here are the functions to add the click on the lnk of tables 



      let drug_des_parent;
      let clickedData;
      let name_of_drug;

      var closeButton = document.getElementById('parent_des_close');
      closeButton.addEventListener('click', function() {

        // document.getElementById('choice2').checked = true;
        // document.getElementById('choice1').checked = false;

        // const structureImage = document.querySelector('.structure-image');
        // structureImage.style.display = 'block'; // Show the image
        var div = document.querySelector('.parent_description');
        div.classList.remove('show');
        var div = document.querySelector('.blur_the_background');
        div.classList.remove('show');
      });



      function generate_table(drugName1) {

        var div = document.querySelector('.parent_description');
        div.classList.toggle('show');
        var div = document.querySelector('.blur_the_background');
        div.classList.toggle('show');

        var name = document.querySelector('#drugname');
        name.innerHTML = drugName1;

        let dataobject = drug_des_parent['0'];

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
              var formattedData = formatData(text_change);
              // Use innerHTML instead of textContent to render HTML tags
              valueCell.innerHTML = formattedData;

            } else if (keyCell.innerText === 'COMMENTS') {
              let text_change = valueCell.innerHTML;
              var formattedData = formatData2(text_change);
              // Use innerHTML instead of textContent to render HTML tags
              valueCell.innerHTML = formattedData;

            } else
            if (keyCell.innerText === 'REFERENCE_ID') {
              let text_change = valueCell.innerHTML;
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

          for (var i = 0; i < lines.length - 1; i++) {
            var parts = lines[i].split(';');
            var formattedText = '<b>' + parts[0] + '</b>' + '<a href="https://cancer.sanger.ac.uk/cosmic" target="_blank">' + parts[1] + '</a>';
            formattedLines.push(formattedText);
          }


          return formattedLines.join('<br>');
        }

        function formatData2(data) {
          var lines = data.split('|');
          var formattedLines = [];


          for (var i = 0; i < lines.length - 1; i++) {
            var parts = lines[i].split(':');
            var formattedText = '<b>' + parts[0] + '</b>' + ':' + parts[1];
            formattedLines.push(formattedText);
          }



          return formattedLines.join('<br>');
        }

        function formatData3(data) {

          var lines = data.split('|');
          var formattedLines = [];

          for (var i = 0; i < lines.length - 1; i++) {
            var parts = lines[i].split('=');
            var formattedText = '<b>' + parts[0] + '</b>' + '=' + parts[1];
            formattedLines.push(formattedText);
          }



          return formattedLines.join('<br>');
        }
        // Call the function to populate the table
        populateTable();
        // const toggleForm = document.querySelector('.toggle');
        const compoundTable = document.querySelector('table');
      }


      function fetchData2(drugName) {
        // Make AJAX request to PHP script
        $.ajax({
          type: "POST",
          url: "",
          data: {
            drugName: drugName
          },
          success: function(data) {
            drug_des_parent = JSON.parse(data);

            generate_table(drugName);
            // You can do further processing here
          },
          error: function(xhr, status, error) {
            console.error("Error: " + error);
          }
        });
      }


      function fetchData3(drugName2) {
        console.log(drugName2, "here is the data ");
        // Make AJAX request to PHP script
        $.ajax({
          type: "POST",
          url: "",
          data: {
            drugName2: drugName2
          },
          success: function(data) {
            // Handle the returned data

            drug_des_parent = JSON.parse(data);

            console.log(data, "here is the data ", drug_des_parent);

            generate_table(drugName2);
            // You can do further processing here
          },
          error: function(xhr, status, error) {
            console.error("Error: " + error);
          }
        });
      }
    </script>
</body>

</html>