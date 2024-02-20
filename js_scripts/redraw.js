const section = document.querySelector("section"),
overlay = document.querySelector(".overlay"),
showBtn = document.querySelector("#export"),
closeBtn = document.querySelector(".close-btn");

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
};
// Event listener for the redraw button
d3.select("#redraw").on("click", redraw);