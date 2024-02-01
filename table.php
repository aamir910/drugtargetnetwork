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

    if (!empty($conditions)) {
      // $sql = "SELECT * FROM drugresponse WHERE " . implode(" AND ", $conditions) ;

      if ($count_increment != 1) {

        $sql .= " " . implode(" AND ", $conditions);
      } else {
        $sql .= " " . implode(" AND ", $conditions) . " AND drugresponse.MAX_PHASE NOT IN ('Preclinical', 'Unknown')";
      }
    }

    // Limit the result to 400 rows
    $limit = 5000 * $count_increment;

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

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
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
<body>

<!-- here will add the navbar -->

        <div class="container m-5" ><h2>Drug Target Network</h2></div>

        <div class="container">
          <table id="example" class="table table-striped" style="width:100%">
            <thead>
              <tr>
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
              </tr>
              
            </thead>
            <tbody>
              <tr>
                <td>Erlotinib</td>
                <td>ES5</td>
                <td>4.28</td>
                <td>pIC50</td>
                <td>GDSC1</td>
                <td>22460902 | 23180760</td>
                <td>-1.0</td>
                <td>CHEMBL553</td>
                <td>Approved</td>
                <td>CVCL_1201</td>
                <td>Bone</td>
                <td>Ewing's Sarcoma</td>
              </tr>
              <!-- Add more rows with your data as needed -->
              <tr>
                <td>Erlotinib</td>
                <td>EW-11</td>
                <td>4.92</td>
                <td>pIC50</td>
                <td>GDSC1</td>
                <td>22460902 | 23180760</td>
                <td>-1.0</td>
                <td>CHEMBL553</td>
                <td>Approved</td>
                <td>CVCL_1209</td>
                <td>Bone</td>
                <td>Ewing's Sarcoma</td>
              </tr>
              <tr>
                <td>Erlotinib</td>
                <td>EW-11</td>
                <td>4.92</td>
                <td>pIC50</td>
                <td>GDSC1</td>
                <td>22460902 | 23180760</td>
                <td>-1.0</td>
                <td>CHEMBL553</td>
                <td>Approved</td>
                <td>CVCL_1209</td>
                <td>Bone</td>
                <td>Ewing's Sarcoma</td>
              </tr>
              <tr>
                <td>Erlotinib</td>
                <td>EW-11</td>
                <td>4.92</td>
                <td>pIC50</td>
                <td>GDSC1</td>
                <td>22460902 | 23180760</td>
                <td>-1.0</td>
                <td>CHEMBL553</td>
                <td>Approved</td>
                <td>CVCL_1209</td>
                <td>Bone</td>
                <td>Ewing's Sarcoma</td>
              </tr>
              <tr>
                <td>Erlotinib</td>
                <td>EW-11</td>
                <td>4.92</td>
                <td>pIC50</td>
                <td>GDSC1</td>
                <td>22460902 | 23180760</td>
                <td>-1.0</td>
                <td>CHEMBL553</td>
                <td>Approved</td>
                <td>CVCL_1209</td>
                <td>Bone</td>
                <td>Ewing's Sarcoma</td>
              </tr>
              <tr>
                <td>Erlotinib</td>
                <td>EW-11</td>
                <td>4.92</td>
                <td>pIC50</td>
                <td>GDSC1</td>
                <td>22460902 | 23180760</td>
                <td>-1.0</td>
                <td>CHEMBL553</td>
                <td>Approved</td>
                <td>CVCL_1209</td>
                <td>Bone</td>
                <td>Ewing's Sarcoma</td>
              </tr>
            </tbody>
            <tfoot>
              <!-- Add footer content if needed -->
            </tfoot>
          </table>
      </div>
  
  <!-- <footer class="footer text-lg-start text-muted ">

    <section class="">
      <div class="container text-center text-md-start  p-4">

        <div class="row mt-3">

          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto  ">

            <h6 class=" mb-4">
              CONTACT US
            </h6>
            <p class="para">
              <i class="bi bi-geo-alt-fill" style="color: #04DBFD;"></i> Hammurabi insurance
            </p>
            <p class="para">
              Services,Inc san Francisco
            </p>
            <p class="para">
              CA,94118 United State
            </p>
            <div>
              <p class="para">
                info@askhammurabi.com
              </p>
            </div>
          </div>

          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto ">

            <h6 class=" fw-bold mb-4">
              USEFUL LINKS
            </h6>
            <p class="para">
              <a href="#!" class="text-reset">Terms of Services</a>
            </p>
            <p class="para">
              <a href="#!" class="text-reset">Privacy Policy</a>
            </p>
            <p class="para">
              <a href="#!" class="text-reset">Legal</a>
            </p>
            <p class="para">
              <a href="#!" class="text-reset">Marketing Partners</a>
            </p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto ">

            <h6 class="fw-bold mb-4">OUR SERVICES</h6>
            <p class="para">
              <a href="#!" class="text-reset">Employers</a>
            </p>
            <p class="para">
              <a href="#!" class="text-reset">Producers</a>
            </p>
            <p class="para">
              <a href="#!" class="text-reset">Carier</a>
            </p>
            <p class="para">
              <a href="#!" class="text-reset">Marketing Partners</a>
            </p>
          </div>

        </div>

      </div>
    </section>
    <hr>
    </hr>


    <div class="text-center ">
      <span class="spanf"> © Copyright Hammurabi. All Rights Reserverd</span>

    </div>
    <hr>
    </hr>
  </footer> -->

  <script>
    
    $(document).ready(function () {
      $('#example').dataTable({
        "scrollX": true, 
        "paging": false 
      });
    });
    //new DataTable('#example');

  </script>
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
  let count_increment = 1 ; 
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


    function ajax() {
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
          pic50: pic50

        },
        success: function(response) {

          jsondata2 = response;
          console.log("newData", jsondata2);

        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: " + status + " - close-btn" + error);
        }
      });
    }

    ajax();
  </script>



</body>



</html>