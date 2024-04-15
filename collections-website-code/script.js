function openForm(ownerEmail) {
  document.getElementById("to").value = ownerEmail;
  document.getElementById("messageForm").style.display = "block";
}

// Close the message form
function closeForm() {
  document.getElementById("messageForm").style.display = "none";
}

// Show the image popup with the clicked image
function showImagePopup(image) {
  var popup = document.getElementById("imagePopup");
  var popupImage = popup.getElementsByClassName("popup-image")[0];
  popupImage.src = image.src;
  popup.style.display = "block";
}

// Close the image popup
function closeImagePopup() {
  document.getElementById("imagePopup").style.display = "none";
}

// Go back to the previous page
function goBack() {
  window.history.back();
}
