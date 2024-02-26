
function toggleDiv() {
    event.preventDefault();
    

    var overlay = document.getElementById("customOverlay");
    var interactiveDiv = document.getElementById("customInteractiveDiv");
  
    overlay.style.display = (overlay.style.display == "block") ? "none" : "block";
    interactiveDiv.style.display = (interactiveDiv.style.display == "block") ? "none" : "block";
  }
  
  function submitCommand() {
    var command = document.getElementById("customSearchBar").value;
    console.log("Submitted command:", command);
    // You can do whatever you want with the command here
  }
  

  