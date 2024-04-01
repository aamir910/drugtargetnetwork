
function tableData() {
  event.preventDefault();
  // Specify the URL of the new page (e.g., https://www.example.com) in the window.open() function
  // window.open('table.html', '_blank');
  // Construct the URL with query parameters
  var url = 'table.php?arr1=' + JSON.stringify(oncotree_change1) +
    '&arr2=' + JSON.stringify(MaxPhase1) +
    '&arr3=' + JSON.stringify(DataPlatform) +

    '&arr4=' + JSON.stringify(disease_class1) +
    '&singleValue=' + pic50;

  // Redirect to index2.html

  window.open(url, '_blank');


}




const diseases = [

  "Ewing's Sarcoma", "Melanoma", "Glioblastoma", "Lung Carcinoid Tumor",
  "Lung Adenocarcinoma", "Bronchiolo-Alveolar Lung Carcinoma", "Non-Small Cell Lung Carcinoma",
  "Small Cell Lung Carcinoma", "Neuroblastoma", "Epithelioid Sarcoma", "Giant Cell Lung Carcinoma",
  "Esophageal Squamous Cell Carcinoma", "Ductal Breast Carcinoma", "Head and Neck Squamous Cell Carcinoma",
  "Adult T Acute Lymphoblastic Leukemia", "Bladder Carcinoma", "Renal Cell Carcinoma", "Non-Cancerous",
  "Chronic Myelogenous Leukemia", "Pancreatic Ductal Adenocarcinoma", "Plasma Cell Myeloma",
  "Adult Acute Myeloid Leukemia", "Pleural Epithelioid Mesothelioma", "Childhood T Acute Lymphoblastic Leukemia",
  "Anaplastic Large Cell Lymphoma", "Colon Adenocarcinoma", "Amelanotic Melanoma",
  "Clear Cell Renal Cell Carcinoma", "Gliosarcoma", "Astrocytoma", "Colon Carcinoma",
  "High Grade Ovarian Serous Adenocarcinoma", "Salivary Gland Squamous Cell Carcinoma",
  "Childhood B Acute Lymphoblastic Leukemia", "Breast Carcinoma",
  "Epstein-Barr Virus-Related Burkitt's Lymphoma", "Diffuse Large B-Cell Lymphoma", "Medulloblastoma",
  "Burkitt's Lymphoma", "Skin Squamous Cell Carincrementcinoma", "Gastric Small Cell Neuroendocrine Carcinoma",
  "Chronic Eosinophilic Leukemia", "Intrahepatic Cholangiocarcinoma", "Gastric Adenocarcinoma",
  "Mycosis Fungoides and Sezary Syndrome", "Hairy Cell Leukemia", "Erythroleukemia", "Duodenal Adenocarcinoma",
  "Gestational Choriocarcinoma", "Mantle Cell Lymphoma", "B-Cell Prolymphocytic Leukemia",
  "Childhood Acute Myeloid Leukemia with Maturation", "Anaplastic Astrocytoma", "Chondrosarcoma",
  "Acute Myelomonocytic Leukemia", "Hodgkin's Lymphoma", "Prostate Carcinoma", "Cecum Adenocarcinoma",
  "B-Cell Non-Hodgkin's Lymphoma", "B Acute Lymphoblastic Leukemia", "Adult Acute Monocytic Leukemia",
  "Pleural Biphasic Mesothelioma", "Childhood Acute Differentiated Monocytic Leukemia",
  "Adult B Acute Lymphoblastic Leukemia", "Testicular Embryonal Carcinoma", "Gastric Carcinoma",
  "Large Cell Lung Carcinoma", "Acute Myeloid Leukemia", "Lymphoma", "Gastric Choriocarcinoma",
  "Osteosarcoma", "Vulvar Leiomyosarcoma", "Primitive Neuroectodermal Tumor", "Uterine Corpus Leiomyosarcoma",
  "Childhood Precursor T Lymphoblastic Lymphoma", "Fibrosarcoma", "Liposarcoma", "Vulvar Carcinoma",
  "Undifferentiated Gallbladder Carcinoma", "Precursor Lymphoblastic Lymphoma", "Follicular Lymphoma",
  "Pancreatic Adenocarcinoma", "Thyroid Gland Anaplastic Carcinoma Squamous Cell",
  "Endometrial Adenocarcinoma", "Adrenal Gland Neuroblastoma",
  "Invasive Ductal Carcinoma Not Otherwise Specified", "Tongue Squamous Cell Carcinoma",
  "Primary Effusion Lymphoma", "Ovarian Granulosa Cell Tumor", "Follicular Thyroid Carcinoma",
  "Vulvar Squamous Cell Carcinoma", "Rhabdomyosarcoma", "Undifferentiated Pleomorphic Sarcoma",
  "Adenosquamous Endometrial Carcinoma", "Natural Killer Cell Lymphoblastic Leukemia or Lymphoma",
  "Ovarian Clear Cell Adenocarcinoma", "Signet Ring Cell Gastric Adenocarcinoma",
  "Acute Promyelocytic Leukemia", "Acute Biphenotypic Leukemia", "ONCOTREE_PRIMARY_DISEASE",
  "Splenic Marginal Zone B-Cell Lymphoma with Villous", "Hereditary Spherocytosis",
  "Gastric Tubular Adenocarcinoma", "Gallbladder Carcinoma", "Vulvar Melanoma",
  "Cervical Small Cell Carcinoma", "Alveolar Rhabdomyosarcoma", "Synovial Sarcoma",
  "Cervical Squamous Cell Carcinoma", "Human Papilloma Virus-Related Cervical Squamous Cell Carcinoma",
  "Bronchogenic Carcinoma", "Squamous Cell Lung Carcinoma", "Pleural Sarcomatoid Mesothelioma",
  "Gingival Squamous Cell Carcinoma", "Lung Mucoepidermoid Carcinoma", "Oral Cavity Squamous Cell Carcinoma",
  "Pancreatic Carcinoma", "Papillary Renal Cell Carcinoma", "Cutaneous Melanoma",
  "Ovarian Serous Cystadenocarcinoma", "Breast Adenocarcinoma", "Ovarian Endometrioid Adenocarcinoma",
  "Thyroid Gland Anaplastic Carcinoma", "Pharyngeal Squamous Cell Carcinoma", "Cervical Carcinoma",
  "Ovarian Mucinous Adenocarcinoma", "Hypopharyngeal Squamous Cell Carcinoma",
  "Endometrial Stromal Sarcoma", "Squamous Cell Breast Carcinoma Acantholytic Variant",
  "Hepatocellular Carcinoma", "Epithelioid Cell Type Gastrointestinal Stromal Tumor",
  "Rhabdoid Tumour of the Kidney", "Askin's Tumor", "Uterine Corpus Sarcoma",
  "Gastric Adenosquamous Carcinoma", "Adenosquamous Lung Carcinoma", "Papillary Lung Adenocarcinoma",
  "Ovarian Mixed Germ Cell Tumor", "Ovarian Serous Adenocarcinoma", "Embryonal Rhabdomyosarcoma",
  "Adrenal Cortex Carcinoma", "Rectal Adenocarcinoma", "Esophageal Adenocarcinoma", "Barrett's Adenocarcinoma",
  "Renal Pelvis Urothelial Carcinoma", "Hepatoblastoma", "Oral Dysplasia", "Papillary Thyroid Carcinoma",
  "Benign Prostatic Hyperplasia", "Hereditary Thyroid Gland Medullary Carcinoma", "Endometrial Carcinoma",
  "Malignant Pleural Mesothelioma", "Parotid Gland Mucoepidermoid Carcinoma", "Oligodendroglioma",
  "Laryngeal Squamous Cell Carcinoma", "Ovarian Adenocarcinoma", "Pyriform Fossa Squamous Cell Carcinoma",
  "Cervical Adenocarcinoma", "Pancreatic Adenosquamous Carcinoma", "Ovarian Leiomyosarcoma",
  "Pancreatic Somatostatinoma", "Lung Carcinoma", "Ovarian Carcinoma", "Ovarian Cystadenocarcinoma",
  "Childhood Acute Megakaryoblastic Leukemia", "Mediastinal Thymic Large B-Cell Cell Lymphoma",
  "Gastric Fundus Carcinoma", "Colorectal Carcinoma", "Sacral Chordoma", "Myelodysplastic syndrome",
  "Squamous Papilloma", "Mucinous Gastric Adenocarcinoma", "Cutaneous T-Cell Lymphoma",
  "Chronic Lymphocytic Leukemia", "Adult Acute Megakaryoblastic Leukemia"
];





const dropdownContent = document.getElementById('dropdownContent3');

// Loop through the diseases array and create checkboxes and labels
for (let i = 0; i < diseases.length; i++) {
  // Create a label element
  const label = document.createElement('label');
  label.title = diseases[i];
  // Create an input element with type 'checkbox'
  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.value = diseases[i]; // Set the value attribute to the disease name

  // Add the checkbox to the label
  label.appendChild(checkbox);

  // Add the disease name as text content to the label
  label.appendChild(document.createTextNode(diseases[i]));

  // Append the label to the dropdownContent div
  dropdownContent.appendChild(label);
}

// fitleration for the dropdown 
function filterOptions() {
  var input, filter, options, i, noMatchesMessage;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  options = document.getElementById("dropdownContent3").getElementsByTagName("label");
  noMatchesMessage = document.getElementById("noMatchesMessage");

  for (i = 0; i < options.length; i++) {
    var optionText = options[i].innerText || options[i].textContent;
    if (optionText.toUpperCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }

  // Check if there are no matching options
  var noMatches = true;
  for (i = 0; i < options.length; i++) {
    if (options[i].style.display !== "none") {
      noMatches = false;
      break;
    }
  }

  // Display or hide the "No matches found" message
  if (noMatches) {
    if (!noMatchesMessage) {
      noMatchesMessage = document.createElement("span");
      noMatchesMessage.id = "noMatchesMessage";
      noMatchesMessage.innerText = "No match found";
      document.getElementById("dropdownContent3").appendChild(noMatchesMessage);
    }
    noMatchesMessage.style.display = "block";
  } else {
    if (noMatchesMessage) {
      noMatchesMessage.style.display = "none";
    }
  }
}

const Drug_class_Categories = [
  'Behavior mechanisms',
  'Cardiovascular',
  'Chemically-Induced disorders', 'Congenital and neonatal', 'Digestive system', 'Endocrine system', 'Eye', 'Female urogenital',
  'Genetic inborn',
  'Hemic and lymphatic', 'Immune system', 'Infections', 'Male urogenital',
  'Mental disorders', 'Musculoskeletal', 'Neoplasm',
  'Nervous system', 'Nutritional and Metabolic',
  'Occupational diseases', 'Otorhinolaryngologic',
  'Pathological conditions', 'Respiratory tract',
  'Skin and connective tissue', 'Stomatognathic', 'Wounds and injuries'
];

const dropdownContent2 = document.getElementById('dropdownContent6');

// Loop through the diseases array and create checkboxes and labels
for (let i = 0; i < Drug_class_Categories.length; i++) {
  // Create a label element
  const label = document.createElement('label');
  label.title = Drug_class_Categories[i];
  // Create an input element with type 'checkbox'
  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.value = Drug_class_Categories[i]; // Set the value attribute to the disease name

  // Add the checkbox to the label
  label.appendChild(checkbox);

  // Add the disease name as text content to the label
  label.appendChild(document.createTextNode(Drug_class_Categories[i]));

  // Append the label to the dropdownContent div
  dropdownContent2.appendChild(label);
}





// function to close the other dropdown 
function Close_other_dropdown(drophere) {

  for (let i = 1; i <= 6; i++) {
    let dropdownContent = document.getElementById(`dropdownContent${i}`);


    if (dropdownContent != drophere) {

      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      }
    }
  }

}

// dropdown 1 

let oncotree_change1 = [];




// Function to toggle the display of the dropdown content
function toggleDropdown(event) {

  // event.preventDefault();
  var dropdownContent = document.getElementById("dropdownContent1");
  var dropdownBtn = document.getElementById("dropdownBtn");

  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";

  } else {
    dropdownContent.style.display = "block";
    event.stopPropagation();
  }
  Close_other_dropdown(dropdownContent);
}

// Function to handle checkbox changes and update the button text
function handleCheckboxChange() {
  oncotree_change1 = [];

  // Get all checkboxes within the dropdown
  var checkboxes = document.querySelectorAll('#dropdownContent1 input[type="checkbox"]:checked');
  // Update the array with the selected values
  checkboxes.forEach(function(checkbox) {
    oncotree_change1.push(checkbox.value);
  });
  console.log("bone" ,  oncotree_change1)
  // Update the button text with selected values
  var dropdownBtn = document.getElementById("dropdownBtn");
  dropdownBtn.textContent = oncotree_change1.length > 0 ? oncotree_change1.join(', ') : "Select tissues";


}

// Add event listeners to the checkboxes
var checkboxList = document.querySelectorAll('#dropdownContent1 input[type="checkbox"]');
checkboxList.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {

    handleCheckboxChange();
  });
});
handleCheckboxChange();
let MaxPhase1 = ["Approved", "Phase II"];

function toggleDropdown2(event) {
  MaxPhase1 = [];
  var dropdownContent = document.getElementById("dropdownContent2");
  var dropdownBtn = document.getElementById("dropdownBtn2");
  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
    event.stopPropagation();
  }
  Close_other_dropdown(dropdownContent);
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
  dropdownBtn.textContent = MaxPhase1.length > 0 ? MaxPhase1.join(', ') : "Select max clinical phase";

}

var checkboxList2 = document.querySelectorAll('#dropdownContent2 input[type="checkbox"]');
checkboxList2.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    handleCheckboxChange2();
  });
});

// 4th data platform 
let DataPlatform = [];

function toggleDropdown4(event) {

  var dropdownContent = document.getElementById("dropdownContent4");
  var dropdownBtn = document.getElementById("dropdownBtn4");

  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
    event.stopPropagation();
  }

  Close_other_dropdown(dropdownContent);
}


function handleCheckboxChange4() {
  DataPlatform = [];

  // Get all checkboxes within the dropdown
  var checkboxes = document.querySelectorAll('#dropdownContent4 input[type="checkbox"]:checked');
  // Update the array with the selected values
  checkboxes.forEach(function(checkbox) {
    DataPlatform.push(checkbox.value);
  });

  // Update the button text with selected values
  var dropdownBtn = document.getElementById("dropdownBtn4");
  dropdownBtn.textContent = DataPlatform.length > 0 ? DataPlatform.join(', ') : "Select data platform";


  // Close the dropdown
  // var dropdownContent = document.getElementById("dropdownContent4");
  // dropdownContent.style.display = "none";
}

var checkboxList4 = document.querySelectorAll('#dropdownContent4 input[type="checkbox"]');
checkboxList4.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    handleCheckboxChange4();
  });
});
// assign the value in advance  

handleCheckboxChange4();

// 5th dropdown pic50 
let pic50;

function toggleDropdown5(event) {
  var dropdownContent = document.getElementById("dropdownContent5");
  var dropdownBtn = document.getElementById("dropdownBtn5");

  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
    event.stopPropagation();
  }

  Close_other_dropdown(dropdownContent);
}

function handleCheckboxChange5(value) {
  pic50 = value;
  // Update the button text with selected value
  var dropdownBtn = document.getElementById("dropdownBtn5");
  dropdownBtn.textContent = pic50 !== undefined ? pic50 : "Select pIC50";

  // Close the dropdown
  var dropdownContent = document.getElementById("dropdownContent5");
  dropdownContent.style.display = "none";
}

var checkboxList5 = document.querySelectorAll('#dropdownContent5 input[type="checkbox"]');
checkboxList5.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    if (this.checked) {
      // Uncheck other checkboxes
      checkboxList5.forEach(function(otherCheckbox) {
        if (otherCheckbox !== checkbox) {
          otherCheckbox.checked = false;
        }
      });
      handleCheckboxChange5(checkbox.value);
    } else {
      // If a checkbox is unchecked, clear the selection
      handleCheckboxChange5(undefined);
    }
  });

});


// Close dropdown on document click
document.addEventListener('click', function() {
  var dropdownContent = document.getElementById("dropdownContent5");
  dropdownContent.style.display = "none";
});

function Close_other_dropdown(currentDropdown) {
  var dropdowns = document.getElementsByClassName("dropdown-content");
  for (var i = 0; i < dropdowns.length; i++) {
    var openDropdown = dropdowns[i];
    if (openDropdown !== currentDropdown) {
      openDropdown.style.display = 'none';
    }
  }
}



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

  Close_other_dropdown(dropdownContent);
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
  dropdownBtn.textContent = Chembl_id1.length > 0 ? Chembl_id1.join(', ') : "Select decease";


}
// Close the dropdown
var checkboxList3 = document.querySelectorAll('#dropdownContent3 input[type="checkbox"]');
checkboxList3.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    handleCheckboxChange3();
  });
});

// sixth dropdown 

let disease_class1 = [];

function toggleDropdown6(event) {

  var dropdownContent = document.getElementById("dropdownContent6");
  var dropdownBtn = document.getElementById("dropdownBtn6");

  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
    event.stopPropagation();
  }

  Close_other_dropdown(dropdownContent);
}

function handleCheckboxChange6() {
  disease_class1 = [];
  // Get all checkboxes within the dropdown
  var checkboxes = document.querySelectorAll('#dropdownContent6 input[type="checkbox"]:checked');
  // Update the array with the selected values
  checkboxes.forEach(function(checkbox) {
    disease_class1.push(checkbox.value);
  });
  // Update the button text with selected values
  var dropdownBtn = document.getElementById("dropdownBtn6");
  dropdownBtn.textContent = disease_class1.length > 0 ? disease_class1.join(', ') : "Select decease class ";


}
// Close the dropdown
var checkboxList6 = document.querySelectorAll('#dropdownContent6 input[type="checkbox"]');
checkboxList6.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    handleCheckboxChange6();
  });
});

// sixth dropdown closes 



function closeAllDropdowns() {
  var dropdowns = document.querySelectorAll('.dropdown-content');
  dropdowns.forEach(function(dropdown) {
    dropdown.style.display = 'none';
  });
}

// Click event handler for the window
window.onclick = function(event) {
  // Check if the clicked element is a dropdown button or its content

  // var cardshow = document.getElementById("cardid");

  //   if (cardshow.style.display === "block") {
  //     cardshow.style.display = "none";
  // }

  if (
    !event.target.matches('.dropdown') &&
    !event.target.matches('.dropdown-content') &&
    !event.target.closest('.dropdown-content')
  ) {
    // Close all dropdowns
    closeAllDropdowns();
  }
};

// compound class code 
var Compound_class_categories = [
    "Kinase inhibitors",
    "Transporter inhibitors",
    "Protease inhibitors",
    "Transcription factor inhibitors",
    "Cytosolic inhibitors",
    "Other inhibitors",
    "Ion channel inhibitors",
    "Epigenetic regulator inhibitors",
    "Phosphodiesterase inhibitors",
    "Enzyme inhibitors",
    "GPCR inhibitors",
    "Nuclear receptor inhibitors",
    "Cytochrome inhibitors",
    "Secreted protein inhibitors",
    "Membrane receptor inhibitors",
    "Phosphatase inhibitors",
    "Structural protein inhibitors",
    "Adhesion inhibitors",
    "Surface antigen inhibitors"
];
const dropdownContent7 = document.getElementById('dropdownContent7');

// Loop through the diseases array and create checkboxes and labels
for (let i = 0; i <Compound_class_categories.length; i++) {
  // Create a label element
  const label = document.createElement('label');
  label.title = Compound_class_categories[i];
  // Create an input element with type 'checkbox'
  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.value = Compound_class_categories[i]; // Set the value attribute to the disease name

  // Add the checkbox to the label
  label.appendChild(checkbox);

  // Add the disease name as text content to the label
  label.appendChild(document.createTextNode(Compound_class_categories[i]));

  // Append the label to the dropdownContent div
  dropdownContent7.appendChild(label);
}
// seventh dropdown

let compound_class1 = [];

function toggleDropdown7(event) {

  var dropdownContent = document.getElementById("dropdownContent7");
  var dropdownBtn = document.getElementById("dropdownBtn7");

  if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
  } else {
    dropdownContent.style.display = "block";
    event.stopPropagation();
  }

  Close_other_dropdown(dropdownContent);
}

function handleCheckboxChange7() {
  compound_class1 = [];
  // Get all checkboxes within the dropdown
  var checkboxes = document.querySelectorAll('#dropdownContent7 input[type="checkbox"]:checked');
  // Update the array with the selected values
  checkboxes.forEach(function(checkbox) {
    compound_class1.push(checkbox.value);
  });
  // Update the button text with selected values
  var dropdownBtn = document.getElementById("dropdownBtn7");
  dropdownBtn.textContent = compound_class1.length > 0 ? compound_class1.join(', ') : "Compound class ";

  console.log(compound_class1 , 'compound_class1')

}
// Close the dropdown
var checkboxList6 = document.querySelectorAll('#dropdownContent7 input[type="checkbox"]');
checkboxList6.forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    handleCheckboxChange7();
  });
});

// ened seventh

