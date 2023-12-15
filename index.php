<?php

include("fetchdata.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if all array values are set
  if (
    isset($_POST['Chembl_id1']) ||
    isset($_POST['MaxPhase1']) ||
    isset($_POST['oncotree_change1'])
  ) {
    // Array to store conditions
    $conditions = array();

    $sql = "SELECT * FROM drugresponse WHERE";
    // Check and add condition for CHEMBL_ID
    if (isset($_POST['Chembl_id1']) && !empty($_POST['Chembl_id1'])) {
      $Chembl_id1 = $_POST['Chembl_id1'];
      $Chembl_id_condition = implode("','", $Chembl_id1);
      $conditions[] = "CHEMBL_ID IN ('$Chembl_id_condition')";
    }

    // Check and add condition for MAX_PHASE
    if (isset($_POST['MaxPhase1']) && !empty($_POST['MaxPhase1'])) {
      $MaxPhase1 = $_POST['MaxPhase1'];
      $MaxPhase_condition = implode("','", $MaxPhase1);
      $conditions[] = "MAX_PHASE IN ('$MaxPhase_condition')";
    }

    // Check and add condition for ONCOTREE_LINEAGE
    if (isset($_POST['oncotree_change1']) && !empty($_POST['oncotree_change1'])) {
      $oncotree_change1 = $_POST['oncotree_change1'];
      $oncotree_change_condition = implode("','", $oncotree_change1);
      $conditions[] = "ONCOTREE_LINEAGE IN ('$oncotree_change_condition')";
    }


    if (!empty($conditions)) {

      // $sql = "SELECT * FROM drugresponse WHERE " . implode(" AND ", $conditions);
      $sql .= " " . implode(" AND ", $conditions);
    }

    $count_increment = intval($_POST['count_increment']);
    // Limit the result to 400 rows
    $limit = 400 * $count_increment;

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
  <link rel="stylesheet" type="text/css" href="./css/styles.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <style>
    .dropdown {
      display: inline-block;
      position: relative;
    }

    /* Style for the dropdown button */
    .dropdown label {
      padding: 10px;
      font-size: 16px;
      /* border: 1px solid #ccc; */
      cursor: pointer;
      background-color: #fff;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      width: 200px;
      /* Adjust the width as needed */
      position: relative;
    }

    /* Style for the arrow icon */
    .dropdown button::after {
      content: '\25BC';
      /* Unicode character for downward arrow */
      font-size: 12px;
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
    }

    /* Style for the dropdown content */
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
      z-index: 1;
      max-height: 550px;
      /* Adjust the max-height as needed */
      overflow-y: auto;
    }

    /* Style for the checkboxes inside the dropdown */
    .dropdown-content label {
      display: block;
      padding: 8px;
      cursor: pointer;
    }

    .dropdown-content input {
      margin-right: 8px;
    }

    /* Define styles for tooltip2 */
    .tooltip2 {
      position: absolute;
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      font-size: 12px;
      pointer-events: none;
    }

    .tooltip2 strong {
      font-weight: bold;
    }

    .in_de_Crement {
      display: flex;
      visibility: hidden;
    }

    #dialog-container {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid #ccc;
      padding: 20px;
      background-color: #fff;
      z-index: 1000;
      cursor: move;
      overflow: hidden;
      border-radius: 8px;
    }

    #dialog-header {
      cursor: move;
      padding-bottom: 10px;
      border-bottom: 1px solid #ccc;
    }

    #search-bar {
      margin-bottom: 10px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 100%;
    }

    #name-list {
      max-height: 200px;
      overflow-y: auto;
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    #name-list li {
      margin-bottom: 5px;
    }

    #no-matches {
      display: none;
      color: #888;
    }

    /* fitler button  */
    .fitlerbtn {
      background-color: green;
    }
  </style>


</head>

<body>
  <div class=" searchBar">
    <form class="selection_box flex" id="searchForm">
      <div class="in_de_Crement">
        <h4 style="width: 12rem;text-align:center;display: flex;justify-content: center;align-items: center;">More data </h4>
        <button class="btn1" id="increment">400+</button>
        <button class="btn1" id="decrement">400-</button>

      </div>
      <div class="form-row rowData">
        <!-- First Dropdown -->

        <div class="dropdown" onclick="toggleDropdown(event)">

          <label id="dropdownBtn">Select ONCOTREE_LINEAGE</label>
          <div id="dropdownContent" class="dropdown-content">
            <label><input type="checkbox" value="Bone">Bone</label>
            <label><input type="checkbox" value="Skin">Skin</label>
            <label><input type="checkbox" value="Central Nervous System">Central Nervous System</label>
            <label><input type="checkbox" value="Lung">Lung</label>
            <label><input type="checkbox" value="Peripheral Nervous System">Peripheral Nervous System</label>
            <label><input type="checkbox" value="Soft Tissue">Soft Tissue</label>
            <label><input type="checkbox" value="Esophagus">Esophagus</label>
            <label><input type="checkbox" value="Breast">Breast</label>
            <label><input type="checkbox" value="Head and Neck">Head and Neck</label>
            <label><input type="checkbox" value="Haematopoietic and Lymphoid">Haematopoietic and Lymphoid</label>
            <label><input type="checkbox" value="Bladder">Bladder</label>
            <label><input type="checkbox" value="Kidney">Kidney</label>
            <label><input type="checkbox" value="Pancreas">Pancreas</label>
            <label><input type="checkbox" value="Large Intestine">Large Intestine</label>
            <label><input type="checkbox" value="Ovary">Ovary</label>
            <label><input type="checkbox" value="Stomach">Stomach</label>
            <label><input type="checkbox" value="Biliary Tract">Biliary Tract</label>
            <label><input type="checkbox" value="Small Intestine">Small Intestine</label>
            <label><input type="checkbox" value="Placenta">Placenta</label>
            <label><input type="checkbox" value="Prostate">Prostate</label>
            <label><input type="checkbox" value="Testis">Testis</label>
            <label><input type="checkbox" value="Uterus">Uterus</label>
            <label><input type="checkbox" value="Vulva">Vulva</label>
            <label><input type="checkbox" value="Thyroid">Thyroid</label>
            <!-- Add more options as needed -->
          </div>
        </div>
        <!-- here is second 
       -->

        <div class="dropdown" onclick="toggleDropdown2(event)">

          <label id="dropdownBtn2">Select Max Phase</label>
          <div id="dropdownContent2" class="dropdown-content">
            <label><input type="checkbox" value="Approved">Approved</label>
            <label><input type="checkbox" value="Preclinical">Preclinical</label>
            <label><input type="checkbox" value="PHASE 2">PHASE 2</label>
            <label><input type="checkbox" value="PHASE 3">PHASE 3</label>
            <label><input type="checkbox" value="PHASE 1">PHASE 1</label>
            <label><input type="checkbox" value="Unknown">Unknown</label>
            <!-- Add more options as needed -->
          </div>


        </div>
        <!-- third Dropdown -->
        <div class="dropdown" onclick="toggleDropdown3(event)">
          <label id="dropdownBtn3">Select CHEMBL_ID</label>
          <div id="dropdownContent3" class="dropdown-content">
            <label><input type="checkbox" value="CHEMBL553">CHEMBL553</label>
            <label><input type="checkbox" value="CHEMBL413">CHEMBL413</label>
            <label><input type="checkbox" value="CHEMBL535">CHEMBL535</label>
            <label><input type="checkbox" value="CHEMBL4872316">CHEMBL4872316</label>
            <label><input type="checkbox" value="CHEMBL4851750">CHEMBL4851750</label>
            <label><input type="checkbox" value="CHEMBL428647">CHEMBL428647</label>
            <label><input type="checkbox" value="CHEMBL254129">CHEMBL254129</label>
            <label><input type="checkbox" value="CHEMBL2144069">CHEMBL2144069</label>
            <label><input type="checkbox" value="CHEMBL1336">CHEMBL1336</label>
            <label><input type="checkbox" value="CHEMBL572878">CHEMBL572878</label>
            <label><input type="checkbox" value="CHEMBL941">CHEMBL941</label>
            <label><input type="checkbox" value="CHEMBL4873176">CHEMBL4873176</label>
            <label><input type="checkbox" value="CHEMBL601719">CHEMBL601719</label>
            <label><input type="checkbox" value="CHEMBL217092">CHEMBL217092</label>
            <label><input type="checkbox" value="CHEMBL392695">CHEMBL392695</label>
            <label><input type="checkbox" value="CHEMBL159822">CHEMBL159822</label>
            <label><input type="checkbox" value="CHEMBL1421">CHEMBL1421</label>
            <label><input type="checkbox" value="CHEMBL483847">CHEMBL483847</label>
            <label><input type="checkbox" value="CHEMBL4860897">CHEMBL4860897</label>
            <label><input type="checkbox" value="CHEMBL1242367">CHEMBL1242367</label>
            <label><input type="checkbox" value="CHEMBL197603">CHEMBL197603</label>
            <label><input type="checkbox" value="CHEMBL213100">CHEMBL213100</label>
            <label><input type="checkbox" value="CHEMBL1643959">CHEMBL1643959</label>
            <label><input type="checkbox" value="CHEMBL513909">CHEMBL513909</label>
            <label><input type="checkbox" value="CHEMBL209148">CHEMBL209148</label>
            <!-- Add more options as needed -->
          </div>


        </div>



        <!-- button  -->
      </div>
      <button class="btn btn-success" id="submitButton" type='submit'>
        <i class="bi bi-search"></i> Search
      </button>
    </form>
    <!-- end of the navbar -->
    <main class="graph_div  flex  col-12 col-sm-12  " id="div2">


      <svg id="forcenetwork" width="100%" style="
               
               display: flex;
               justify-content: center;
               align-items: center;
               height:100%;
             " class=" forcenetwork  ">
        <!-- Loader embedded inside SVG -->
      </svg>
      <foreignObject width="100%" height="100%">
        <div class="loader" id="loader"></div>
      </foreignObject>


      <div class="wrapper  " id='wrapper'>
        <header style="display:flex;
  justify-content: space-between;" |>
          <h2>links value</h2>
          <button class="fitlerbtn" onclick="toggleDialog()" title="Click to perform a single node filter">Single Node Filter</button>


          <div id="dialog-container">
            <div id="dialog-header">
              <button onclick="toggleDialog()" class="close-btn-search" style="background:none   ;  position: absolute;
                top: 10px;right: 10px;cursor: pointer;max-height: 100px;overflow: auto;
"><img height="20px" width="20px" src="icons8-close-60.png" alt=""></button>
              <label for="search-bar">Search:</label>
              <input type="text" id="search-bar" oninput="filterNames()" onclick="focusSearch()">
            </div>
            <ul id="name-list">
            </ul>
            <button style=" margin: 12px 38px 0px ; ; " class="sliderbtn" onclick="saveNames()">Filter</button>
          </div>

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
          <div style="width : 40%">
            <legend class="legenddata">Max clinical phase</legend>
            <ul id="myList" class="legend_inner"></ul>
            <legend class="legenddata">Data platform’</legend>
            <ul id="dataset" class="legend_inner"></ul>
            <legend class="legenddata">Matric</legend>
            <ul id="matric_set" class="legend_inner"></ul>
          </div>
          <div style="width : 60%">
            <legend class="legenddata">child nodes</legend>
            <ul id="child_node" class="legend_inner"></ul>
          </div>
        </div>
      </div>
    </main>
    <!-- second slider and btns  -->

    <footer class="sliderpart2" id='buttonbar'>

      <div class='alignitems'>
        <button class="sliderbtn " id="zoom-in-button">zoom-in</button>
        <button class="sliderbtn " id="zoom-out-button">zoom out</button>
        <div class="slider2size">
          <input id="nodeCountSlider2" type="range" min="0" max="100" value="50" />
          <p id="rangeValue">50</p>

        </div>
        <!-- btntag -->
        <button class="sliderbtn" id="redraw">redraw</button>
        <button class="sliderbtn " id="export">Export</button>

      </div>
    </footer>





    <div class="card" id="cardid" style="display: none;">
      <p class="cl-picker">change color</p>
      <ul class="ul_of_color_picker" id="colorList">

      </ul>
    </div>


  </div>
  </div>

  <!-- overlay  -->
  <section style="background-color : white">
    <span class='overlay'></span>
    <div class="modal-box">
      <div class="model_box_inner">
        <h2>Export Chart as</h2>

        <div class="buttons exportbtn">

          <button class="png" id='png'> Download PNG </button>
          <button class="jpeg" id="jpeg"> Download JPEG </button>
          <button class="csv" id="csv"> Download XLS </button>
          <!-- <button class="close-btn"> Close</button> -->

          <button class="close-btn" style="background:none   ;  position: absolute;
                top: 10px;right: 10px;cursor: pointer;max-height: 100px;overflow: auto;
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

  <!-- Dragable div  -->


  <script>
    let oncotree_change1 = [];


    // Function to toggle the display of the dropdown content
    function toggleDropdown(event) {

      // event.preventDefault();

      var dropdownContent = document.getElementById("dropdownContent");
      var dropdownBtn = document.getElementById("dropdownBtn");

      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";

      } else {
        dropdownContent.style.display = "block";
        event.stopPropagation();
      }
    }

    // Function to handle checkbox changes and update the button text
    function handleCheckboxChange() {
      oncotree_change1 = [];

      // Get all checkboxes within the dropdown
      var checkboxes = document.querySelectorAll('#dropdownContent input[type="checkbox"]:checked');
      // Update the array with the selected values
      checkboxes.forEach(function(checkbox) {
        oncotree_change1.push(checkbox.value);
      });

      // Update the button text with selected values
      var dropdownBtn = document.getElementById("dropdownBtn");
      dropdownBtn.textContent = oncotree_change1.length > 0 ? oncotree_change1.join(', ') : "Select Options";



      console.log(oncotree_change1, "oncotraight");
      // Close the dropdown
      var dropdownContent = document.getElementById("dropdownContent");
      dropdownContent.style.display = "none";
    }

    // Add event listeners to the checkboxes
    var checkboxList = document.querySelectorAll('#dropdownContent input[type="checkbox"]');
    checkboxList.forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {

        handleCheckboxChange();
      });
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      // Check if the clicked element is a dropdown button or its content
      if (
        !event.target.matches('.dropdown') &&
        !event.target.matches('.dropdown-content') &&
        !event.target.closest('.dropdown-content')
      ) {
        // Close all dropdowns
        var dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(function(dropdown) {
          dropdown.style.display = 'none';
        });
      }
    };


    let MaxPhase1 = [];

    function toggleDropdown2(event) {
      var dropdownContent = document.getElementById("dropdownContent2");
      var dropdownBtn = document.getElementById("dropdownBtn2");

      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
        event.stopPropagation();
      }
    }


    function handleCheckboxChange2() {
      MaxPhase1 = [];

      // Get all checkboxes within the dropdown
      var checkboxes = document.querySelectorAll('#dropdownContent2 input[type="checkbox"]:checked');
      // Update the array with the selected values
      checkboxes.forEach(function(checkbox) {
        MaxPhase1.push(checkbox.value);
      });

      // Update the button text with selected values
      var dropdownBtn = document.getElementById("dropdownBtn2");
      dropdownBtn.textContent = MaxPhase1.length > 0 ? MaxPhase1.join(', ') : "Select Options";



      console.log(MaxPhase1, 'MaxPhase1');
      // Close the dropdown
      var dropdownContent = document.getElementById("dropdownContent2");
      dropdownContent.style.display = "none";
    }

    var checkboxList2 = document.querySelectorAll('#dropdownContent2 input[type="checkbox"]');
    checkboxList2.forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        handleCheckboxChange2();
      });
    });

    // Add script for the third dropdown
    let Chembl_id1 = [];

    function toggleDropdown3(event) {
      var dropdownContent = document.getElementById("dropdownContent3");
      var dropdownBtn = document.getElementById("dropdownBtn3");

      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
        event.stopPropagation();
      }
    }

    function handleCheckboxChange3() {
      Chembl_id1 = [];
      // Get all checkboxes within the dropdown
      var checkboxes = document.querySelectorAll('#dropdownContent3 input[type="checkbox"]:checked');
      // Update the array with the selected values
      checkboxes.forEach(function(checkbox) {
        Chembl_id1.push(checkbox.value);
      });
      // Update the button text with selected values
      var dropdownBtn = document.getElementById("dropdownBtn3");
      dropdownBtn.textContent = Chembl_id1.length > 0 ? Chembl_id1.join(', ') : "Select Options";

      console.log(Chembl_id1, "Chembl_id1");
      // Close the dropdown
      var dropdownContent = document.getElementById("dropdownContent3");
      dropdownContent.style.display = "none";
    }

    var checkboxList3 = document.querySelectorAll('#dropdownContent3 input[type="checkbox"]');
    checkboxList3.forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        handleCheckboxChange3();
      });
    });
  </script>


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
    let child_categories_border;
    //  onclick matric 
    let matric_link = [];

    let minValue;
    let maxValue;
    let slider_range = 100;
    const slider2 = document.getElementById("nodeCountSlider2");
    // onclick dataset   

    let list_hidden_links = [];

    let jsondata2;

    let csvfile = [];
    let response;

    let visible_node = [];


    let simulation;

    let drug_des_parent;
    let clickedData;
    let name_of_drug;
    // fetching the json file  
    let curentnodes = 400;




    // legend entry 
    let colors;

    let child_colors;


    // max_phses 
    let phases = [];
    let max_phase_categories;


    // dataset entry 
    let dataset_legend = [];
    let data_Set;

    // matric entry

    let matric_legend = [];
    let matric_categories;

    //  child_node entry 
    let ONCOTREE_LINEAGE_legend = [];
    let legendChild;


    let count_increment = 1;

    document.getElementById("increment").addEventListener("click", function(event) {
      event.preventDefault();
      count_increment += 1;
      ajax();
    });


    document.getElementById("decrement").addEventListener("click", function(event) {
      event.preventDefault();
      if (count_increment > 1) {
        count_increment -= 1;
        ajax();
      } else {
        alert("mininum data fetched")
      }

    });

    async function fetchData(data) {
      try {
        response = data;

        console.log('data coming from the', response);

        processData(response);
      } catch (error) {
        console.error("Error loading the JSON file:", error);

      }
    }
    // fetching the data ended here 
    let i = 0;

    function processData(data) {

      const uniqueProteins = new Set();
      data.forEach((item) => {
        if (!uniqueProteins.has(item.COMPOUND_NAME)) {
          uniqueProteins.add(item.COMPOUND_NAME);


          nodes.push({
            id: item.COMPOUND_NAME,
            type: "parentnode",
            MAX_PHASE: item.MAX_PHASE,
            flag: true
          });


        }
      if(!ONCOTREE_LINEAGE_legend.includes(item.ONCOTREE_LINEAGE)){

        ONCOTREE_LINEAGE_legend.push(item.ONCOTREE_LINEAGE)

      }

        if (!phases.includes(item.MAX_PHASE)) {
          phases.push(item.MAX_PHASE);

        }
        if (!dataset_legend.includes(item.DATASET)) {

          dataset_legend.push(item.DATASET);

        }
        if (!matric_legend.includes(item.METRIC)) {

          matric_legend.push(item.METRIC);
        }
      })
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
        dataset: item.DATASET,
        link_matric: item.METRIC
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
          // console.log(data, "data to show ");
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

      // console.log(dataobject, "check2");
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
            // console.log(text_change)
            var formattedData = formatData(text_change);
            // Use innerHTML instead of textContent to render HTML tags
            valueCell.innerHTML = formattedData;

          } else if (keyCell.innerText === 'COMMENTS') {
            let text_change = valueCell.innerHTML;
            // console.log(text_change)
            var formattedData = formatData2(text_change);
            // Use innerHTML instead of textContent to render HTML tags
            valueCell.innerHTML = formattedData;

          } else
          if (keyCell.innerText === 'REFERENCE_ID') {
            let text_change = valueCell.innerHTML;
            // console.log(text_change)
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
          var formattedText = '<b>' + parts[0] + '</b>' + ':' + parts[1];
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

    // console.log("width", svgWidth, "height", svgHeight);

    function force_network_grapgh() {



      const g = svg.append("g");
      // simulationtag
      simulation = d3
        .forceSimulation(nodes)
        .force(
          "link",
          d3.forceLink(links)
          .id((d) => d.id)
          .distance((link, index) => (index % 2 === 0 ? 200 : 350))
        )
        // tag
        .force("charge", d3.forceManyBody().strength(-100))
        .force("x", d3.forceX(500))
        .force("y", d3.forceY(270));


      legendinfo();
      // Manually set colors based on the dataset value
      link = g
        .selectAll(".link ")
        .data(links)
        .enter().append("line")
        .style("stroke", function(d) {
          switch (d.dataset) {
            case "GDSC1":
              return "#4372c4";
            case "GDSC2":
              return "#fe0000";
            case "CCLE_NP24":
              return "#9B35C8";
            case "NCI-60":
              return "#0bc00f";
            case "gCSI":
              return "#fe8f01";
            case "FIMM":
              return "#f99cc8";
            default:
              // Default color if the dataset doesn't match any specific case
              return "black";
          }
        })
        .attr("stroke-width", function(d) {

          if (d.value < 5) {
            return 0.5;
          } else {
            return d.value - 4.5;
          }
        })
        .style("stroke-dasharray", function(d) {
          if (d.link_matric === 'pIC50') {
            return "2,2";
          } else if (d.link_matric === 'pEC50') {
            return "5,5";
          } else if (d.link_matric === 'pGI50') {
            return "0";
          }
        })
        .attr("x1", function(d) {
          return d.source.x;
        })
        .attr("y1", function(d) {
          return d.source.y;
        })
        .attr("x2", function(d) {
          return d.target.x;
        })
        .attr("y2", function(d) {
          return d.target.y;
        }).on("mouseover", function(d) {


          let r = event.target.__data__;

          console.log("Hovered Link Data:", r);
          console.log(d)
          console.log("hover")
          tooltip2.transition()
            .style("opacity", 0.9);
          tooltip2.html("<strong>Link Value:</strong> " + r.value)
            .style("left", d.pageX + "px")
            .style("top", d.pageY + "px");
        })
        .on("mouseout", function(d) {
          tooltip2.transition()
            .duration(500)
            .style("opacity", 0);
        });

      ;

      // Define a tooltip div with class "tooltip2"
      var tooltip2 = d3.select("body").append("div")
        .attr("class", "tooltip2")
        .style("opacity", 0);



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
        // call the function 



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


      //  create childnode here

      node.filter((d) => d.type === "childnode")
        .append("circle")
        .attr("r", function(d) {
          const degree = links.filter(
            (link) => link.source.id === d.id || link.target.id === d.id
          ).length;
          if (degree < 8) {
            return 5;
          } else {
            return degree / 2;
          }
        })
        .attr("fill", (d) => {
          let category = d.oncotree_change;
          let color;
          if (category === 'Bone') {
            color = child_colors[0];
          } else if (category === 'Skin') {
            color = child_colors[1];
          } else if (category === 'Central Nervous System') {
            color = child_colors[2];
          } else if (category === 'Lung') {
            color = child_colors[3];
          } else if (category === 'Peripheral Nervous System') {
            color = child_colors[4];
          } else if (category === 'Soft Tissue') {
            color = child_colors[5];
          } else if (category === 'Esophagus') {
            color = child_colors[6];
          } else if (category === 'Breast') {
            color = child_colors[7];
          } else if (category === 'Head and Neck') {
            color = child_colors[8];
          } else if (category === 'Haematopoietic and Lymphoid') {
            color = child_colors[9];
          } else if (category === 'Bladder') {
            color = child_colors[10];
          } else if (category === 'Kidney') {
            color = child_colors[11];
          } else if (category === 'Pancreas') {
            color = child_colors[0]; // Repeat the color for category 11
          } else if (category === 'Large Intestine') {
            color = child_colors[1];
          } else if (category === 'Ovary') {
            color = child_colors[2];
          } else if (category === 'Stomach') {
            color = child_colors[3];
          } else if (category === 'Biliary Tract') {
            color = child_colors[4];
          } else if (category === 'Small Intestine') {
            color = child_colors[5];
          } else if (category === 'Placenta') {
            color = child_colors[6];
          } else if (category === 'Prostate') {
            color = child_colors[7];
          } else if (category === 'Testis') {
            color = child_colors[8];
          } else if (category === 'Uterus') {
            color = child_colors[9];
          } else if (category === 'Vulva') {
            color = child_colors[10];
          } else if (category === 'Thyroid') {
            color = child_colors[11];
          }
          return color;
        })
        .attr("stroke",
          (d) => {
            if (child_categories_border.includes(d.oncotree_change)) {
              return "black";
            }
          })
        .attr("stroke-width", 3)


      node.filter((d) => d.type === "parentnode")
        .append("rect")
        .attr("width", 30) // Set the width of the rectangle
        .attr("height", 12) // Set the height of the rectangle
        .attr("fill", function(node) {
          if (node.MAX_PHASE === "Approved") {
            return "#0bc00f"; // Updated color for "Approved"
          } else if (node.MAX_PHASE === "PHASE 1") {
            return "#4372c4"; // Updated color for "PHASE 1"
          } else if (node.MAX_PHASE === "PHASE 2") {
            return "#fe0000"; // Updated color for "PHASE 2"
          } else if (node.MAX_PHASE === "PHASE 3") {
            return "#9B35C8"; // Updated color for "PHASE 3"
          } else if (node.MAX_PHASE === "") {
            return "#fe8f01"; // Updated color for empty string
          } else if (node.MAX_PHASE === "Unknown") {
            return "#fe8f01"; // Updated color for "Unknown"
          } else if (node.MAX_PHASE === "Preclinical") {
            return "#f99cc8"; // Updated color for "Preclinical"
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






    // here is the function to start the limitations 
    function range_of_links(min_range, max_range, valueofslider) {

      link.style("display", null);
      node.style("display", null);
      //  fitleration of the threshold value sidler 

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

      node.each(function(d) {
        // Check if the node's MAX_PHASE is in the list_hidden
        if (list_hidden.includes(d.MAX_PHASE) && d.type === "parentnode") {
          // Node is in list_hidden, set display to "none"
          d3.select(this).style("display", "none");
        }
        if (checkbox_names.includes(d.id)) {

          d3.select(this).style("display", "none");
        }

      });
      const matchinglink = link.filter(function(link) {
        if (list_hidden.includes(link.source.MAX_PHASE) || (checkbox_names.includes(link.source.id))) {
          return link;
        }
      });
      matchinglink.style("display", "none");
      let connectedNodes;
      let allconnedtednodes = [];
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
        if (list_hidden_childnode.includes(childNode.oncotree_change) || checkbox_names.includes(childNode.id)) {
          return childNode;
        }
      });
      childnodefilteration.style("display", "none");
      let source_node = [];
      let matchinglinkpart = link.filter(function(link) {
        if (list_hidden_childnode.includes(link.target.oncotree_change) || checkbox_names.includes(link.target.id)) {
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
        if (list_hidden_dataset.includes(templink.dataset) || list_hidden_dataset.includes(templink.link_matric)) {

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
      // export csv 
      csvfile = [];
      visible_node = []
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

          if (visibility === "inline") {
            visible_node.push(node.id);

          }



          // If true, push the node into the csvfile array
        }
      });

      generateNameList();
    }
    // legenddata
    function legendinfo() {
      colors = ["#4372c4", "#fe0000", "#9B35C8", "#0bc00f", "#fe8f01", "#f99cc8"];

      function createMaxPhaseCategories() {
        const maxPhaseCategories = phases.map((category, index) => {
          let color;
          if (category === "Approved") {
            color = colors[3];
          } else if (category === "PHASE 1") {
            color = colors[0];
          } else if (category === "PHASE 2") {
            color = colors[1];
          } else if (category === "PHASE 3") {
            color = colors[2];
          } else if (category === "Preclinical") {
            color = colors[5]; // Fixed index for "Preclinical"
          } else if (category === "Unknown" || category === "") {
            color = colors[4];
          }

          return {
            category,
            color
          };
        });

        return maxPhaseCategories;
      }

      function generateDataSet() {
        const dataSet_legend_color = dataset_legend.map((category, index) => {
          let color;

          if (category === "GDSC1") {
            color = colors[0];
          } else if (category === "GDSC2") {
            color = colors[1];
          } else if (category === "CCLE_NP24") {
            color = colors[2];
          } else if (category === "NCI-60") {
            color = colors[3];
          } else if (category === "gCSI") {
            color = colors[4];
          } else if (category === "FIMM") {
            color = colors[5];
          }

          return {
            category,
            color
          };

        });
        return dataSet_legend_color;
      }

      function generateMatricCategories() {
        return matric_legend.map((category) => ({
          category
        }));
      }
      // const ONCOTREE_LINEAGE = [
      //   'Bone',
      //   'Skin',
      //   'Central Nervous System',
      //   'Lung',
      //   'Peripheral Nervous System',
      //   'Soft Tissue',
      //   'Esophagus',
      //   'Breast',
      //   'Head and Neck',
      //   'Haematopoietic and Lymphoid',
      //   'Bladder',
      //   'Kidney',
      //   'Pancreas',
      //   'Large Intestine',
      //   'Ovary',
      //   'Stomach',
      //   'Biliary Tract',
      //   'Small Intestine',
      //   'Placenta',
      //   'Prostate',
      //   'Testis',
      //   'Uterus',
      //   'Vulva',
      //   'Thyroid'
      // ];

      child_colors = [

        '#1f77b4', // blue
        '#ff7f0e', // orange
        '#2ca02c', // green
        '#d62728', // red
        '#9467bd', // purple
        '#8c564b', // brown
        '#e377c2', // pink
        '#7f7f7f', // gray
        '#17becf', // cyan
        '#1f77b4', // light blue (replacing yellow-green)
        '#ff9896', // light red
        '#98df8a' // light green


      ];
      const child_categories = ONCOTREE_LINEAGE_legend.map((category, index) => {
        let color;

        if (category === 'Bone') {
          color = child_colors[0];
        } else if (category === 'Skin') {
          color = child_colors[1];
        } else if (category === 'Central Nervous System') {
          color = child_colors[2];
        } else if (category === 'Lung') {
          color = child_colors[3];
        } else if (category === 'Peripheral Nervous System') {
          color = child_colors[4];
        } else if (category === 'Soft Tissue') {
          color = child_colors[5];
        } else if (category === 'Esophagus') {
          color = child_colors[6];
        } else if (category === 'Breast') {
          color = child_colors[7];
        } else if (category === 'Head and Neck') {
          color = child_colors[8];
        } else if (category === 'Haematopoietic and Lymphoid') {
          color = child_colors[9];
        } else if (category === 'Bladder') {
          color = child_colors[10];
        } else if (category === 'Kidney') {
          color = child_colors[11];
        } else if (category === 'Pancreas') {
          color = child_colors[0]; // Repeat the color for category 11
        } else if (category === 'Large Intestine') {
          color = child_colors[1];
        } else if (category === 'Ovary') {
          color = child_colors[2];
        } else if (category === 'Stomach') {
          color = child_colors[3];
        } else if (category === 'Biliary Tract') {
          color = child_colors[4];
        } else if (category === 'Small Intestine') {
          color = child_colors[5];
        } else if (category === 'Placenta') {
          color = child_colors[6];
        } else if (category === 'Prostate') {
          color = child_colors[7];
        } else if (category === 'Testis') {
          color = child_colors[8];
        } else if (category === 'Uterus') {
          color = child_colors[9];
        } else if (category === 'Vulva') {
          color = child_colors[10];
        } else if (category === 'Thyroid') {
          color = child_colors[11];
        }
        return {
          category,
          color
        };
        return child_categories;
      });

      //  gererating the dynamic nodes 
      data_Set = generateDataSet();
      max_phase_categories = createMaxPhaseCategories();
      matric_categories = generateMatricCategories();

      //  appenging the maxphses

      const ul = d3.select("#myList");

      ul.selectAll("li").remove();

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
        }).on("click", color_click_onchange);


      pax_phasecliked = listItems
        .append("span")
        .text((d) => (d.category === "" ? "Unknown" : d.category))


      // appending the data of the dataset

      const ul2 = d3.select("#dataset");

      ul2.selectAll("li").remove();

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


      //appending the data of the child nodes
      const ul4 = d3.select('#child_node');

      ul4.selectAll("li").remove();
      dataSet_child = ul4
        .selectAll("li")
        .data(child_categories)
        .enter()
        .append("li");

      child_categories_border = [
        'Pancreas',
        'Large Intestine',
        'Ovary',
        'Stomach',
        'Biliary Tract',
        'Small Intestine',
        'Placenta',
        'Prostate',
        'Testis',
        'Uterus',
        'Vulva',
        'Thyroid'
      ];


      child_color = dataSet_child
        .append("div")
        .attr("class", "circle")
        .style("background-color", (d) => {
          for (const categoryObj of child_categories) {
            if (d.category === categoryObj.category) {
              return categoryObj.color;
            }
          }
          return "#6a329f";
        }).style("border", (d) => {
          for (const categoryObj of child_categories) {
            if (d.category === categoryObj.category) {
              let borderColor;
              if (child_categories_border.includes(d.category)) {
                borderColor = '3px solid black';
                return borderColor;
              }

            }
          }
          return "#6a329f";
        })
      // .style("border" , "2px solid RED") ;


      child_clicked = dataSet_child.append("span").text((d) => d.category);



      // appending the data of the matric 
      const ul3 = d3.select('#matric_set');

      ul3.selectAll("li").remove();

      matric_link = ul3
        .selectAll("li")
        .data(matric_categories)
        .enter()
        .append("li");

      matric_color = matric_link
        .append("div")
        .attr("class", "line")
        .style("background", "repeating-radial-gradient(circle, #000000 0, #000000 1px, transparent 1px, transparent 2px)")
        .style("height", "2px");

      matric_click = matric_link.append("span").text((d) => d.category);






      // color picker
      for (const categoryObj of max_phase_categories) {
        addColor(categoryObj.color);
      }

      phases = [];
      dataset_legend = [];
      max_phase_categories = []
      console.log(max_phase_categories, "max empty ");
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

      //error 
      node.each(function(node) {
        if (node.MAX_PHASE === selected_maxphase && node.type === "parentnode") {
          d3.select(this).select("rect").attr("fill", colorpick);

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

      matric_click.on("click", onclick_dataSet);

      child_clicked.on("click", onclick_childnodes);

      range_of_links(minValue, maxValue, slider_range);

    }
    // Add onchange event listeners to both sliders
    minSlider.addEventListener("change", logSliderValues);
    maxSlider.addEventListener("change", logSliderValues);
    slider2.addEventListener("change", logSliderValues);

    // slider value ended here 


    document.getElementById("submitButton").addEventListener("click", function(event) {


      // Reset error messages
      document.querySelector(".in_de_Crement").style.visibility = "visible";

      document.querySelectorAll(".alert2").forEach(function(alert) {
        alert.style.display = "none";
      });
      document.querySelectorAll(".error-border").forEach(function(element) {
        element.classList.remove("error-border");
      });

      if (false) {
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
      }



      // document.getElementById("dropdown1").addEventListener("change", function() {
      //   removeError(this);
      // });

      // document.getElementById("dropdown2").addEventListener("change", function() {
      //   removeError(this);
      // });

      // document.getElementById("dropdown3").addEventListener("change", function() {
      //   removeError(this);
      // });
      // document.getElementById("dropdown4").addEventListener("change", function() {
      //   removeError(this);
      // });

      // function removeError(dropdown) {
      //   // Remove error message and border when a selection is made
      //   dropdown.nextElementSibling.style.display = "none";
      //   dropdown.classList.remove("error-border");
      // }


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
      document.getElementById('loader').style.display = 'block';
      clearGraph();

      document.getElementById('wrapper').style.display = 'none';

      document.getElementById('buttonbar').style.dispajaxfetchdatalay = 'none';

      // Make an AJAX request to the current PHP script
      $.ajax({
        type: "POST",
        url: "", // Leave it empty to target the current page
        data: {
          count_increment: count_increment,
          Chembl_id1: Chembl_id1,
          MaxPhase1: MaxPhase1,
          oncotree_change1: oncotree_change1,
        },
        success: function(response) {

          jsondata2 = response;
          // console.log(jsondata2);

          fetchData(jsondata2);


          document.getElementById('wrapper').style.display = 'block';


          document.getElementById('buttonbar').style.display = 'block';



          document.getElementById('loader').style.display = 'none';

          force_network_grapgh();

          pax_phasecliked.on("click", onclickmax_phase);

          datasettext_click.on("click", onclick_dataSet);

          matric_click.on("click", onclick_dataSet);

          child_clicked.on("click", onclick_childnodes);
          range_of_links(minValue, maxValue, slider_range);



          // processData(jsondata2);
          // You can parse the JSON and use the data as needed
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: " + status + " - close-btn" + error);
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
      dropdown3



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

  <script>
    let checkbox_names = [];

    // Make the dialog draggable
    dragElement(document.getElementById("dialog-container"));
    var nameList = document.getElementById("name-list");
    nameList.innerHTML = ''; // Clear existing list

    function generateNameList() {
      console.log(visible_node, "here is visible node");
      for (var i = 0; i < visible_node.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem = document.createElement('li');
        let name1 = visible_node[i];
        listItem.innerHTML = `<input type="checkbox" id="${name1}" > <label for="${name1}">${name1}</label>`;
        nameList.appendChild(listItem);
      }
    }

    function toggleCLoseFilterSearch() {

    }
    // Initial generation of the name list
    function toggleDialog() {

      var dialog = document.getElementById("dialog-container");
      dialog.style.display = (dialog.style.display === "block") ? "none" : "block";

    }

    function dragElement(elmnt) {
      var pos1 = 0,
        pos2 = 0,
        pos3 = 0,
        pos4 = 0;
      var header = document.getElementById("dialog-header");
      header.onmousedown = dragMouseDown;

      function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
      }

      function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      }

      function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
      }
    }

    function focusSearch() {
      document.getElementById("search-bar").focus();
    }
    // Function to filter names based on the search bar input
    function filterNames() {
      var input, filter, checkboxes, names, i;
      input = document.getElementById("search-bar");
      filter = input.value.toLowerCase();
      checkboxes = document.getElementById("name-list").getElementsByTagName("input");
      var noMatches = document.getElementById("no-matches");
      var matchesFound = false;

      for (i = 0; i < checkboxes.length; i++) {
        names = checkboxes[i].id;
        var label = document.querySelector('label[for=' + names + ']');
        if (names.toLowerCase().indexOf(filter) > -1 || label.innerText.toLowerCase().indexOf(filter) > -1) {
          checkboxes[i].style.display = "";
          label.style.display = "";
          matchesFound = true;
        } else {
          checkboxes[i].style.display = "none";
          label.style.display = "none";
        }
      }

      // Show or hide the entire list based on matches
      var nameList = document.getElementById("name-list");
      nameList.style.display = matchesFound ? "block" : "none";

      // Show or hide "No matches" message
      noMatches.style.display = matchesFound ? "none" : "block";
    }
    // Function to save selected names in an array
    function saveNames() {
      var checkboxes = document.getElementById("name-list").getElementsByTagName("input");
      checkbox_names = [];

      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
          checkbox_names.push(checkboxes[i].id);
        }
      }
      range_of_links(minValue, maxValue, slider_range);
    }
  </script>






</body>

</html>