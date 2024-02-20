function legendinfo() {
    colors = ["#4372c4", "#fe0000", "#9B35C8", "#0bc00f", "#fe8f01", "#f99cc8"];

    function createMaxPhaseCategories() {
      phases.push(...list_hidden);
      const maxPhaseCategories = phases.map((category, index) => {
        let color;
        if (category === "Approved") {
          color = colors[3];
        } else if (category === "Phase I") {
          color = colors[0];
        } else if (category === "Phase II") {
          color = colors[1]
        } else if (category === "Phase III") {
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

      // dataset_legend.push(...list_hidden_dataset);
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
    function GenerateDisease_class() {
      const categoryColorMap = {
        'Behavior mechanisms': 'steelblue',
        'Cardiovascular': 'red',
        'Chemically-Induced disorders': 'orange',
        'Congenital and neonatal': 'yellow',
        'Digestive system': 'green',
        'Endocrine system': 'blue',
        'Eye': 'indigo',
        'Female urogenital': 'violet',
        'Genetic inborn': 'brown',
        'Hemic and lymphatic': 'pink',
        'Immune system': 'cyan',
        'Infections': 'purple',
        'Male urogenital': 'teal',
        'Mental disorders': 'gray',
        'Musculoskeletal': 'lime',
        'Neoplasm': 'maroon',
        'Nervous system': 'navy',
        'Nutritional and Metabolic': 'olive',
        'Occupational diseases': 'pink',
        'Otorhinolaryngologic': 'salmon',
        'Pathological conditions': 'turquoise',
        'Respiratory tract': 'sienna',
        'Skin and connective tissue': 'gold',
        'Stomatognathic': 'plum',
        'Wounds and injuries': 'coral',
      };

      return disease_Class_legend.map((category) => ({
        category,
        color: categoryColorMap[category] || "black",
      }));
    }
    function generateChildCategories() {
      const categoryColorMap = {
        'Bone': child_colors[0],
        'Skin': child_colors[1],
        'Central Nervous System': child_colors[2],
        'Lung': child_colors[3],
        'Peripheral Nervous System': child_colors[4],
        'Soft Tissue': child_colors[5],
        'Esophagus': child_colors[6],
        'Breast': child_colors[7],
        'Head and Neck': child_colors[8],
        'Haematopoietic and Lymphoid': child_colors[9],
        'Bladder': child_colors[10],
        'Kidney': child_colors[11],
        'Endometrium': child_colors[12],
        'Lymphoid': child_colors[13],
        'Adrenal Gland': child_colors[14],
        'Bowel': child_colors[15],
        'Pancreas': child_colors[0], // Repeat the color for category 11
        'Large Intestine': child_colors[1],
        'Ovary': child_colors[2],
        'Stomach': child_colors[3],
        'Biliary Tract': child_colors[4],
        'Small Intestine': child_colors[5],
        'Placenta': child_colors[6],
        'Prostate': child_colors[7],
        'Testis': child_colors[8],
        'Uterus': child_colors[9],
        'Vulva': child_colors[10],
        'Thyroid': child_colors[11],
        'Cervix': child_colors[12],
        'Liver': child_colors[13],
      };

      return ONCOTREE_LINEAGE_legend.map((category) => ({
        category,
        color: categoryColorMap[category] || "black",
      }));
    }
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
      '#E75480', // light blue (replacing yellow-green)
      '#ff9896', // light red
      '#98df8a', // light green
      '#aec7e8', // light purple
      '#ffbb78', // light orange
      '#FFD700', // gold
      '#00CED1' // dark turquoise
    ];
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
      'Thyroid',
      'Cervix',
      'Liver'
    ];
    const disease_classColors = [
      'red',
      'orange',
      'yellow', 'green',
      'blue', 'indigo',
      'violet', 'brown',
      'pink', 'cyan',
      'purple', 'teal',
      'gray',
      'lime',
      'maroon',
      'navy',
      'olive',
      'pink',
      'salmon',
      'turquoise',
      'sienna',
      'gold',
      'plum',
      'coral'
    ];
    healthCategoriesWithColors = [{

        category: 'Behavior mechanisms',
        color: 'steelblue'
      },
      {
        category: 'Cardiovascular',
        color: 'red'
      },
      {
        category: 'Chemically-Induced disorders',
        color: 'orange'
      },
      {
        category: 'Congenital and neonatal',
        color: 'yellow'
      },
      {
        category: 'Digestive system',
        color: 'green'
      },
      {
        category: 'Endocrine system',
        color: 'blue'
      },
      {
        category: 'Eye',
        color: 'indigo'
      },
      {
        category: 'Female urogenital',
        color: 'violet'
      },
      {
        category: 'Genetic inborn',
        color: 'brown'
      },
      {
        category: 'Hemic and lymphatic',
        color: 'pink'
      },
      {
        category: 'Immune system',
        color: 'cyan'
      },
      {
        category: 'Infections',
        color: 'purple'
      },
      {
        category: 'Male urogenital',
        color: 'teal'
      },
      {
        category: 'Mental disorders',
        color: 'gray'
      },
      {
        category: 'Musculoskeletal',
        color: 'lime'
      },
      {
        category: 'Neoplasm',
        color: 'maroon'
      },
      {
        category: 'Nervous system',
        color: 'navy'
      },
      {
        category: 'Nutritional and Metabolic',
        color: 'olive'
      },
      {
        category: 'Occupational diseases',
        color: 'pink'
      },
      {
        category: 'Otorhinolaryngologic',
        color: 'salmon'
      },
      {
        category: 'Pathological conditions',
        color: 'turquoise'
      },
      {
        category: 'Respiratory tract',
        color: 'sienna'
      },
      {
        category: 'Skin and connective tissue',
        color: 'gold'
      },
      {
        category: 'Stomatognathic',
        color: 'plum'
      },
      {
        category: 'Wounds and injuries',
        color: 'coral'
      }
    ];

    //  gererating the dynamic nodes 
    data_Set = generateDataSet();
    max_phase_categories = createMaxPhaseCategories();
    matric_categories = generateMatricCategories();
    child_categories = generateChildCategories();
    disease_categories = GenerateDisease_class();
    //  appenging the maxphses

    const ul = d3.select("#myList");

    ul.selectAll("li").remove();

    listItems = ul
      .selectAll("li")
      .data(max_phase_categories)
      .enter()
      .append("li");

    let check2 = true;

    max_phase_color = listItems
      .append("div")
      .attr("class", "rect")
      .style("background-color", (d) => {
        // Check if the category is "Unknown" or an empty string
        if (d.category === "Unknown" || d.category === "") {

          // Set the background color for "Unknown" or an empty string
          if (check2) {
            check2 = false;
            return "#fe8f01"

          }
        } else {
          // Iterate through 'max_phase_categories' to find a matching category
          for (const categoryObj of max_phase_categories) {
            if (d.category === categoryObj.category) {
              return categoryObj.color; // Use the color from 'max_phase_categories'
            }
          }

        }
      })
      .on("click", color_click_onchange);


    let unknownDisplayed = false;


    pax_phasecliked = listItems
      .append("span")
      .text((d) => {
        if (d.category === "" || d.category === "Unknown") {
          if (!unknownDisplayed) {
            unknownDisplayed = true;
            return "Unknown";
          }
        } else {
          return d.category;
        }
      })
      .style("font-size", "14.208px")
      .style("font-family", "Arial")
      .classed("marked", (d) => {

        return list_hidden.includes(d.category);
      });




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
      }).on("click", color_click_onchange);


    datasettext_click = dataSet_link.append("span")
      .text((d) => d.category)
      .style("font-size", "14.208px")
      .style("font-family", "Arial")
      .classed("marked", (d) => {

        return list_hidden_dataset.includes(d.category);
      });



    //appending the data of the child nodes
    const ul4 = d3.select("#child_node");
    // added the disease to the disease phase 

    const ul5 = d3.select("#disease_Class");

    ul5.selectAll("li").remove();
    ul4.selectAll("li").remove();
    dataSet_child = ul4
      .selectAll("li")
      .data(child_categories)
      .enter()
      .append("li");

    // Append elements to ul5 (disease class)
    const dataSet_disease = ul5
      .selectAll("li")
      .data(child_categories)
      .enter()
      .append("li")
      .style('display', 'flex');;


    //aamir
    child_color = dataSet_child;
    dataSet_child.filter((d) => ONCOTREE_LINEAGE_Data.includes(d.category))
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

    dataSet_disease.filter((d) => disease_Class_Data.includes(d.category))
      .append("div")
      .attr("class", "triangle")
      .style("position", "relative")
      .style("width", "0")
      .style("height", "0")
      .style("border-left", "10px solid transparent")
      .style("border-right", "10px solid transparent")
      .style("border-bottom", function(d) {
        var color = healthCategoriesWithColors.find(category => category.category === d.category)?.color || "black";
        return "17px solid " + color
      })
      .style("border-radius", "0")
    // append the disease class 
    child_clicked = dataSet_child
      .filter((d) => ONCOTREE_LINEAGE_Data.includes(d.category))
      .append("span")
      .text((d) => d.category)
      .style("font-size", "14.208px").style("font-family", "Arial")
      .classed("marked", (d) => {
        return list_hidden_childnode.includes(d.category);
      });

    disease_clicked = dataSet_disease.filter((d) => disease_Class_Data.includes(d.category))
      .append("span")
      .text((d) => d.category)
      .style("font-size", "14.208px").style("font-family", "Arial")
      .classed("marked", (d) => {

        return list_hidden_childnode.includes(d.category);
      });;


    //appending the data of the disease nodes



    // appending the data of the matric 
    const ul3 = d3.select('#matric_set');

    const ul3part2 = d3.select('#phases_disease');

    ul3.selectAll("li").remove();
    ul3part2.selectAll("li").remove();

    matric_link = ul3
      .selectAll("li")
      .data(matric_categories)
      .enter()
      .append("li");

    phase_link = ul3part2
      .selectAll("li")
      .data(matric_categories)
      .enter()
      .append("li");


    matric_color = matric_link
      .filter((d) => !phase_legend_data.includes(d.category))
      .append("div")
      .attr("class", "line")
      .style("background", function(d) {
        if (d.category === 'pIC50') {
          return "tranparent";
        } else if (d.category === 'pEC50') {
          return "tranparent";
        } else if (d.category === 'pGI50') {
          return "black";
        }
      })
      .style("height", "2px");



    matric_color
      .append("h6")
      // .text(".......");
      .text(function(d) {
        if (d.category === 'pIC50') {
          return ".......";
        } else if (d.category === 'pEC50') {
          return "-----";
        } else if (d.category === 'pGI50') {
          return " ";
        }
      });
    matric_click = matric_link
      .filter((d) => !phase_legend_data.includes(d.category))
      .append("span").text((d) => d.category)
      .style("font-size", "14.208px").style("font-family", "Arial").classed("marked", (d) => {
        return list_hidden_dataset.includes(d.category);
      });

    // appending the phases 


    phase_link
      .filter((d) => phase_legend_data.includes(d.category))
      .append("div")
      .attr("class", "line")
      .style("background", "black")
      .style("height", "2px");


    phase_click = phase_link
      .filter((d) => phase_legend_data.includes(d.category))
      .append("span").text((d) => d.category)
      .style("font-size", "14.208px").style("font-family", "Arial").classed("marked", (d) => {
        return list_hidden_dataset.includes(d.category);
      });

    // color picker

    let check3_color = true;
    for (const categoryObj of max_phase_categories) {
      if (categoryObj.category === "Unknown" || categoryObj.category === "") {
        if (check3_color) {
          addColor(categoryObj.color);
          check3_color = false;
        }
      } else {
        addColor(categoryObj.color);
      }
    }

    phases = [];
    dataset_legend = [];
    max_phase_categories = []
    ONCOTREE_LINEAGE_legend = [];
    matric_legend = [];
    disease_Class_legend = [];
    disease_phase_legend = [];

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
    // Check if an element with the same id already exists
    var existingLi = document.getElementById(color);

    // If it exists, remove it
    if (existingLi) {
      existingLi.remove();
    }

    // Create a new li element
    var li = document.createElement('li');
    li.className = 'color-item';
    li.id = color;
    li.style.backgroundColor = color; // Set background color

    // Append the new li element to the ul
    ul_color.appendChild(li);
  }
  function color_click_onchange(event, d) {
    // Check if the click occurred on the max_phase_color or line elements or their descendants
    if (event.target.closest('.rect') || event.target.closest('.line')) {

      selected_maxphase = d.category;
      clickedDiv = d3.select(this);

      var clickX = event.clientX;
      var clickY = event.clientY;

      cardshow = document.getElementById("cardid");
      cardshow.style.display = "block";
      cardshow.style.left = clickX + "px";
      cardshow.style.top = clickY + "px";
      count = 0;
      return; // Ignore the click on max_phase_color or line elements
    }
    // Rest of your code for color_click_onchange
    // Add a click event listener to the document body
  }

  document.body.addEventListener('click', function(e) {
    // Check if the click is outside the cardid
    if (event.target.closest('.rect') || event.target.closest('.line')) {} else {

      var cardshow = document.getElementById("cardid");
      cardshow.style.display = "none";

    }
  });


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

      if (selected_maxphase === "Unknown" || selected_maxphase === "") {
        if ((node.MAX_PHASE === "Unknown" || node.MAX_PHASE === "") && node.type === "parentnode") {
          d3.select(this).select("rect").attr("fill", colorpick);
        }
      } else if (node.MAX_PHASE === selected_maxphase && node.type === "parentnode") {
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
    not_remove = false;
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
    if (clicked3 === "Unknown") {
      // If 'clicked' is "unknown", check if an empty string ("") is in 'list_hidden'
      const emptyStringIndex = list_hidden_childnode.indexOf("");
      if (emptyStringIndex === -1) {
        // If an empty string is not in the array, push it
        list_hidden_childnode.push("");
        list_hidden_childnode.push("Unknown")
      } else {
        // If an empty string is already in the array, splice it (remove)
        list_hidden_childnode.splice(emptyStringIndex, 2);
      }
    } else

    if (index === -1) {
      list_hidden_childnode.push(clicked3);
    } else {
      list_hidden_childnode.splice(index, 1);
    }
    range_of_links(minValue, maxValue, slider_range);

  }