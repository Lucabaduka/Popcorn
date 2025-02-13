// Handy script to translate clicks to table rows to checks on our control form.
document.querySelector("table").addEventListener("click", ({target}) => {
  if (target.nodeName === "INPUT") return;

  const tr = target.closest("tr");

  if (tr) {
    const checkbox = tr.querySelector("input[type='checkbox']");

    if (checkbox) {
        checkbox.checked = !checkbox.checked;
    }
  }
});

// Functions to open and close a modal
document.addEventListener('DOMContentLoaded', () => {

  function openModal($el) {
    $el.classList.add('is-active');
  }

  function closeModal($el) {
    $el.classList.remove('is-active');
  }

  function closeAllModals() {
    (document.querySelectorAll('.modal') || []).forEach(($modal) => {
      closeModal($modal);
    });
  }

  // Add a click event on buttons to open a specific modal
  (document.querySelectorAll(".js-modal-trigger") || []).forEach(($trigger) => {
    const modal = $trigger.dataset.target;
    const $target = document.getElementById(modal);

    $trigger.addEventListener('click', () => {
      openModal($target);
    });
  });

  // Add a click event on various child elements to close the parent modal
  (document.querySelectorAll('.modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
    const $target = $close.closest('.modal');

    $close.addEventListener('click', () => {
      closeModal($target);
    });
  });

  // Add a keyboard event to close all modals
  document.addEventListener('keydown', (event) => {
    if(event.key === "Escape") {
      closeAllModals();
    }
  });
});

// Extraordinarily inefficient function for changing the admin selector to the background colour it's referencing
window.onload = function() {
  var painter_1 = document.getElementById("selector_1");
  var painter_2 = document.getElementById("selector_2");
  var painter_3 = document.getElementById("selector_3");
  var painter_4 = document.getElementById("selector_4");
  var painter_5 = document.getElementById("selector_5");
  painter_1.onchange = function() {document.getElementById("theme_1").style.backgroundColor = painter_1.value;}
  painter_2.onchange = function() {document.getElementById("theme_2").style.backgroundColor = painter_2.value;}
  painter_3.onchange = function() {document.getElementById("theme_3").style.backgroundColor = painter_3.value;}
  painter_4.onchange = function() {document.getElementById("theme_4").style.backgroundColor = painter_4.value;}
  painter_5.onchange = function() {document.getElementById("theme_5").style.backgroundColor = painter_5.value;}
}