let flag3 = true

function ajax() {
  // Prevent the default form submission
  event.preventDefault();

  let bodyElement = document.body;
  let y_graph = bodyElement.clientHeight / 2 - 90;
  let x_graph = bodyElement.clientWidth / 2 - 85;

  // Assuming 'loader' is the ID of your loader element
  let loaderElement = document.getElementById('loader');

  // Set the position of the loader
  loaderElement.style.display = 'block';
  loaderElement.style.top = y_graph + 'px';
  loaderElement.style.left = x_graph + 'px';


  clearGraph();

  document.getElementById('wrapper').style.display = 'none';

  document.getElementById('legend1').style.display = 'none';

  document.getElementById('buttonbar').style.display = 'none';

  if (flag3) {


    flag3 = false;

    fetch('jsonfile.json')
      .then(response => {
        // Check if the response is successful
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        // Parse the JSON response
        return response.json();
      })
      .then(data => {


        console.log(data);
        processData(data);

        document.getElementById('wrapper').style.display = 'block';


        document.getElementById('legend1').style.display = 'block';

        document.getElementById('buttonbar').style.display = 'block';

        document.getElementById('loader').style.display = 'none';

        force_network_grapgh();

        range_of_links(minValue, maxValue, slider_range);

        pax_phasecliked.on("click", onclickmax_phase);

        datasettext_click.on("click", onclick_dataSet);

        matric_click.on("click", onclick_dataSet);

        phase_click.on("click", onclick_dataSet);

        child_clicked.on("click", onclick_childnodes);

        disease_clicked.on("click", onclick_childnodes);

      })
      .catch(error => {
        // Handle any errors that occur during the fetch operation
        console.error('There was a problem with the fetch operation:', error);
      });

  } else {
    $.ajax({
      type: "POST",
      url: "", // Leave it empty to target the current page
      data: {
        count_increment: count_increment,
        Chembl_id1: Chembl_id1,
        MaxPhase1: MaxPhase1,
        oncotree_change1: oncotree_change1,
        DataPlatform: DataPlatform,
        disease_class1: disease_class1,
        pic50: pic50
      },
      success: function(response) {

        jsondata2 = response;
        console.log("newData", jsondata2);

        fetchData(jsondata2);

        document.getElementById('wrapper').style.display = 'block';


        document.getElementById('legend1').style.display = 'block';

        document.getElementById('buttonbar').style.display = 'block';

        document.getElementById('loader').style.display = 'none';

        force_network_grapgh();

        range_of_links(minValue, maxValue, slider_range);

        pax_phasecliked.on("click", onclickmax_phase);

        datasettext_click.on("click", onclick_dataSet);

        matric_click.on("click", onclick_dataSet);

        phase_click.on("click", onclick_dataSet);

        child_clicked.on("click", onclick_childnodes);

        disease_clicked.on("click", onclick_childnodes);

        // processData(jsondata2);
        // You can parse the JSON and use the data as needed
      },
      error: function(xhr, status, error) {
        console.error("AJAX Error: " + status + " - close-btn" + error);
      }
    });
  }
  // Make an AJAX request to the current PHP script
  MaxPhase1 = [];
}