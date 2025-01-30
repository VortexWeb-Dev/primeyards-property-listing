const modal = document.getElementById("addModal");

function toggleModal(show) {
  if (show) {
    modal.classList.remove("hidden");
  } else {
    modal.classList.add("hidden");
  }
}

function toggleCheckboxes(source) {
  const checkboxes = document.querySelectorAll('input[name="property_ids[]"]');
  checkboxes.forEach(checkbox => {
      checkbox.checked = source.checked;
  });
}