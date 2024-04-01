function toggleDiv() {
  var overlay = document.getElementById("customOverlay");
  var interactiveDiv = document.getElementById("customInteractiveDiv");
  
  overlay.style.display = (overlay.style.display == "block") ? "none" : "block";
  interactiveDiv.style.display = (interactiveDiv.style.display == "block") ? "none" : "block";
}

function submitCommand() {
  var command = document.getElementById("customSearchBar").value.trim();
  
  if (validateCommand(command)) {
    console.log("Submitted command:", command);
    // Perform desired action here
  } else {
    alert("Please enter data without spaces, semicolons, or tabs.");
  }
}

function validateCommand(command) {
  // Regular expression to check if the command does not contain spaces, semicolons, or tabs
  var regex = /^[^\s;,\t]+(?:\s*[^\s;,\t]+)*$/;
  return regex.test(command);
}
