"use strict";

function myFunction() {
  // Declare variables
  var input, filter, table, rows, cells, i, j, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.querySelector(".centered-table table"); // Get all rows from the table

  rows = table.getElementsByTagName("tr"); // Loop through all rows, and hide those that don't match the search query

  for (i = 1; i < rows.length; i++) {
    cells = rows[i].getElementsByTagName("td"); // Loop through all cells in the current row

    for (j = 0; j < cells.length; j++) {
      txtValue = cells[j].textContent || cells[j].innerText; // Check if the cell value matches the search query

      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        rows[i].style.display = "";
        break; // Break the loop if a match is found in any cell
      } else {
        rows[i].style.display = "none";
      }
    }
  }
}

function sortDorms(barangay) {
  var table, rows, i, cellValue, shouldShow;
  table = document.querySelector(".centered-table table");
  rows = table.getElementsByTagName("tr");

  for (i = 1; i < rows.length; i++) {
    cellValue = rows[i].getElementsByTagName("td")[4].innerHTML; // Assuming the "Address" column is at index 3

    shouldShow = barangay === 'All' || cellValue.toLowerCase().indexOf(barangay.toLowerCase()) > -1;

    if (shouldShow) {
      rows[i].style.display = ""; // Show the row
    } else {
      rows[i].style.display = "none"; // Hide the row
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {
  // Click event for the "Hide" buttons
  var hideButtons = document.querySelectorAll('.hide_btn');
  hideButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault(); // Prevent the default form submission behavior

      var dormId = this.closest('form').querySelector('input[name="dormId"]').value;
      hideDorm(dormId);
    });
  }); // Click event for the "Show" buttons

  var showButtons = document.querySelectorAll('.show_btn');
  showButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault(); // Prevent the default form submission behavior

      var dormId = this.closest('form').querySelector('input[name="dormId"]').value;
      showDorm(dormId);
    });
  });
});

function hideDorm(dormId) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'hide_dorm.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Handle the response if needed
      console.log(xhr.responseText); // Remove the corresponding row from the main table

      var mainTableRow = document.querySelector('.centered-table table tr[data-dorm-id="' + dormId + '"]');

      if (mainTableRow) {
        mainTableRow.remove();
      } // Reload or update the content on the page as required
      // For example, you can reload the current page using:


      window.location.reload(false);
    }
  }; // Build the request body


  var requestBody = 'dormId=' + dormId;
  xhr.send(requestBody);
}

function showDorm(dormId) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'show_dorm.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Handle the response if needed
      console.log(xhr.responseText); // Reload or update the content on the page as required
      // For example, you can reload the current page using:

      window.location.reload(false);
    }
  }; // Build the request body


  var requestBody = 'dormId=' + dormId;
  xhr.send(requestBody);
} // For handling dorm images upload


document.getElementById('dorm_images').addEventListener('change', function () {
  handleFileUpload(this.files, 'uploadedFiles');
});

function createDeleteButton(fileDiv) {
  var buttonContainer = document.createElement('div');
  buttonContainer.style.display = 'flex';
  buttonContainer.style.alignItems = 'center';
  buttonContainer.style.marginTop = '-5px';
  buttonContainer.style.marginBottom = '0';
  var deleteButton = document.createElement('img');
  deleteButton.src = 'assets/images/x.png';
  deleteButton.alt = 'Delete';
  deleteButton.style.cursor = 'pointer';
  deleteButton.style.width = '20px';
  deleteButton.addEventListener('click', function () {
    fileDiv.remove();
  });
  buttonContainer.appendChild(deleteButton);
  return buttonContainer;
}

function handleFileUpload(files, containerId) {
  var uploadedFilesContainer = document.getElementById(containerId); // Remove existing error messages

  var errorMessages = uploadedFilesContainer.getElementsByClassName('error');

  for (var i = 0; i < errorMessages.length; i++) {
    errorMessages[i].remove();
  }

  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var fileDiv = document.createElement('div');
    fileDiv.className = 'file';

    if (!isFileExtensionAllowed(file.name)) {
      var errorMessage = document.createElement('div');
      errorMessage.className = 'error';
      errorMessage.textContent = "Invalid file type. Please upload only JPG, JPEG, or PNG files.";
      uploadedFilesContainer.appendChild(errorMessage);
      continue; // Skip this file and move to the next one
    }

    var fileNameDiv = document.createElement('div');
    fileNameDiv.className = 'file__name';
    fileNameDiv.textContent = file.name;
    var deleteButton = createDeleteButton(fileDiv); // Pass the fileDiv to createDeleteButton

    fileNameDiv.appendChild(deleteButton);
    fileDiv.appendChild(fileNameDiv);
    uploadedFilesContainer.appendChild(fileDiv);
  }
}

function isFileExtensionAllowed(fileName) {
  var allowedExtensions = ['jpg', 'jpeg', 'png'];
  var fileExtension = fileName.split('.').pop().toLowerCase();
  return allowedExtensions.includes(fileExtension);
}