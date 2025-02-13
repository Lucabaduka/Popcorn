// This handles any snacks me might receive from PHP on the roadtrip.
window.onload = freeSnacks()

function freeSnacks() {
  const ele = document.getElementById("status");
  let status = ele.getAttribute("data-values");

  if (status === "1") {
    var x = document.getElementById("snacks");
    x.classList.toggle("show")
    setTimeout(function(){ x.classList.toggle("show"); }, 2900);
  }
}