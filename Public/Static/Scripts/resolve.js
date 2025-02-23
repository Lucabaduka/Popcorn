// Get the category type from the card, and make it the default select
value = document.getElementById("card").className.split(" ");
let element = document.getElementById("category");
element.value = value[1];

// Update question title to the title input whenever it changes
function update() {
  let value = document.getElementById("question_input").value;
  document.getElementById("question_header").innerHTML = value;
}