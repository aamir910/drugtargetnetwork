
    let checkbox_names = [];

    let checkbox_saves = [];

    let checkbox_saves_child = [];



    // function ton show the alert MessageEvent of apply filteration 
    function showSuccessAlert() {
      // Make sure to hide the existing alert

      // Show the new alert
      var successAlert = document.getElementById('applyfilter');
      successAlert.style.display = 'block';

      // Set a timeout to start the fade-out effect after 3 seconds
      setTimeout(function() {
        successAlert.style.opacity = '0';

        // Hide the alert after the fade-out effect completes
        setTimeout(function() {
          successAlert.style.display = 'none';
          // Reset opacity for future use
          successAlert.style.opacity = '1';
        }, 1000); // 1 second matches the duration of the fade-out transition
      }, 3000);
    }
    // ENDED    



    // Make the dialog draggable
    dragElement(document.getElementById("dialog-container"));

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
    // drag ended here 
    // Initial generation of the name list

    function toggleDialog() {

      var dialog = document.getElementById("dialog-container");
      dialog.style.display = (dialog.style.display === "block") ? "none" : "block";

    }

    function toggleDialog2() {

      var dialog = document.getElementById("dialog-container");
      dialog.style.display = (dialog.style.display === "block") ? "none" : "block";

      create_it = true;
    }

    function focusSearch(search_val) {
      document.getElementById(search_val).focus();
    }

    // ENDED 


    var nameList = document.getElementById("name-list");
    nameList.innerHTML = ''; // Clear existing list

    var nameList2 = document.getElementById("name-list2");
    nameList2.innerHTML = ''; // Clear existing list

    // filter the select All 
    function toggleCheckboxes(listname, id) {
      var checkboxes = document.querySelectorAll(`#${listname} input[type="checkbox"]`);
      var selectAllLink = document.querySelector(`#${id}`);

      checkboxes.forEach(function(checkbox) {
        checkbox.checked = !checkbox.checked;
      });

      selectAllLink.textContent = checkboxes[0].checked ? 'UnselectAll' : 'SelectAll';
    }
    // ended 


    function generateNameList() {

      //  HERE REMOVE  THE UNCHECKBOX THAT DISAPPEARS 

      for (var i = 0; i < visible_parentnode.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem = document.createElement('li');
        let name1 = visible_parentnode[i];
        if (checkbox_saves.includes(name1)) {
          var index = checkbox_saves.indexOf(name1);
          if (index !== -1) {
            checkbox_saves.splice(index, 1);
          }
        }
      }
      for (var i = 0; i < visible_childnode.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem = document.createElement('li');
        let name1 = visible_childnode[i];
        if (checkbox_saves_child.includes(name1)) {
          var index = checkbox_saves_child.indexOf(name1);
          if (index !== -1) {
            checkbox_saves_child.splice(index, 1);
          }
        }
      }
      // ENDED 

      // CLEAR THE LIST  

      nameList.innerHTML = '';
      nameList2.innerHTML = '';

      // ENDED 
      //  UPDATED THE LIST WITH THE CHECK BOX 

      for (var i = 0; i < checkbox_saves.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem = document.createElement('li');
        let name1 = checkbox_saves[i];
        listItem.innerHTML = `<input type="checkbox" id="${name1}" > <label for="${name1}">${name1}</label>`;

        nameList.appendChild(listItem);
      }

      for (var i = 0; i < checkbox_saves_child.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem2 = document.createElement('li');
        let name1 = checkbox_saves_child[i];
        listItem2.innerHTML = `<input type="checkbox" id="${name1}" > <label for="${name1}">${name1}</label>`;
        nameList2.appendChild(listItem2);
      }
      // ENDED 

      // LIST OF THE COMPOUND_NAME 
      for (var i = 0; i < visible_parentnode.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem = document.createElement('li');
        let name1 = visible_parentnode[i];
        listItem.innerHTML = `<input type="checkbox" id="${name1}" checked > <label for="${name1}">${name1}</label>`;
        nameList.appendChild(listItem);

      }
      // ENDED 

      // LIST OF CELL_LINE_NAME 
      for (var i = 0; i < visible_childnode.length; i++) {
        var nameId = 'name' + (i + 1);
        var listItem = document.createElement('li');
        let name1 = visible_childnode[i];
        listItem.innerHTML = `<input type="checkbox" id="${name1}" checked  > <label for="${name1}">${name1}</label>`;
        nameList2.appendChild(listItem);

      }
      // ENDED

    }
    // generateNameList ENDED 

    // Function to filter names based on the search bar input
    //  FILTERNAMES 

    function filterNames(id_vlaue) {
      var input, filter, checkboxes, names, i;
      input = document.getElementById("search-bar");
      filter = input.value.toLowerCase();
      checkboxes = document.getElementById(id_vlaue).getElementsByTagName("input");

      var noMatches = document.getElementById("no-matches");
      var matchesFound = false;


      for (i = 0; i < checkboxes.length; i++) {
        names = checkboxes[i].id;

        var label = document.querySelector('label[for=' + names + ']');

        // Check if the names contain the filter string
        var containsFilter = names.toLowerCase().indexOf(filter) > -1;

        // Check if the label text contains the filter string
        var labelContainsFilter = label.innerText.toLowerCase().indexOf(filter) > -1;

        // Display or hide based on filter conditions
        if (containsFilter || labelContainsFilter) {
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


    // first filteration ended here 
    // ENDED 



    function filterNames2(id_vlaue) {

      var input, filter, checkboxes3, names, i;
      input = document.getElementById("search-bar2");
      filter = input.value.toLowerCase();
      checkboxes3 = document.getElementById(id_vlaue).getElementsByTagName("input");

      var noMatches = document.getElementById("no-matches2");
      var matchesFound = false;


      for (i = 0; i < checkboxes3.length; i++) {
        names = checkboxes3[i].id;

        var label = document.querySelector('label[for=' + names + ']');

        // Check if the names contain the filter string
        var containsFilter = names.toLowerCase().indexOf(filter) > -1;

        // Check if the label text contains the filter string
        var labelContainsFilter = label.innerText.toLowerCase().indexOf(filter) > -1;

        // Display or hide based on filter conditions
        if (containsFilter || labelContainsFilter) {
          checkboxes3[i].style.display = "";
          label.style.display = "";
          matchesFound = true;
        } else {
          checkboxes3[i].style.display = "none";
          label.style.display = "none";
        }

      }
      // Show or hide the entire list based on matches
      var nameList2 = document.getElementById("name-list2");
      nameList2.style.display = matchesFound ? "block" : "none";
      // Show or hide "No matches" message
      noMatches.style.display = matchesFound ? "none" : "block";

    }


    var checkboxes2;
    // Function to save selected names in an array
    function saveNames() {
      showSuccessAlert();
      create_it = false;
      var checkboxes = document.getElementById("name-list").getElementsByTagName("input");

      checkboxes2 = document.getElementById("name-list2").getElementsByTagName("input");
      checkbox_names = [];

      for (var i = 0; i < checkboxes.length; i++) {
        if (!checkboxes[i].checked) {

          checkbox_names.push(checkboxes[i].id);

          if (!checkbox_saves.includes(checkboxes[i].id))
            checkbox_saves.push(checkboxes[i].id);
        }
      }
      // namelist2
      for (var i = 0; i < checkboxes2.length; i++) {
        if (!checkboxes2[i].checked) {

          checkbox_names.push(checkboxes2[i].id);

          if (!checkbox_saves_child.includes(checkboxes2[i].id))
            checkbox_saves_child.push(checkboxes2[i].id);
        }
      }
      range_of_links(minValue, maxValue, slider_range);
    }