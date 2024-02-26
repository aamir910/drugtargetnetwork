  // downlaodPNG
  document.getElementById('png').addEventListener('click', function() {

    document.getElementById('buttonbar').style.display = 'none';
    section.classList.remove("active")

    var dialog = document.getElementById("dialog-container");
    let check1 = false;
    if (dialog.style.display === "block") {

      dialog.style.display = "none";
      check1 = true; // change is here 

    }


    downlaodPNG("png");
    document.getElementById('buttonbar').style.display = 'block';

    if (check1) {
      dialog.style.display = "block";
    }



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

    range_of_links(minValue, maxValue, slider_range);
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
    XLSX.writeFile(wb, 'DrugTargetNetwork_exported.xlsx');

    alert('XLSX file created successfully');

  }