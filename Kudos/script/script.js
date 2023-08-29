function filterNames() {
  let searchInput = document.querySelector("input[type='text']").value;

  let names = document.querySelectorAll("main h1");

  for (let i = 0; i < names.length; i++) {
    let name = names[i].textContent.toLowerCase();
    let listItem = names[i].parentNode.parentNode;

    if (name.includes(searchInput.toLowerCase()) || searchInput === "") {
      listItem.style.display = "block";
    } else {
      listItem.style.display = "none";
    }
  }
}

function addInputEventListener() {
  let searchInput = document.querySelector("input[type='text']");
  searchInput.addEventListener("input", filterNames);
}


document.addEventListener('DOMContentLoaded', addInputEventListener);
function statusColor() {
  let statuses = document.querySelectorAll('main li h2');
  for (let i = 0; i < statuses.length; i++) {
    if (statuses[i].textContent == 'Active')
      statuses[i].style.color = 'green';
    else if (statuses[i].textContent == 'Offline')
      statuses[i].style.color = 'red';
    else statuses[i].style.color = 'blue';
  }
}

function ShowCategories(data) {
  let selectElement = document.getElementById("cat");
  const option = document.createElement('option');
  option.value = "";
  option.innerHTML = "Sory By";
  option.hidden = true;
  selectElement.appendChild(option);
  for (let i = 0; i < data.category.length; i++) {
      const option = document.createElement('option');
      option.value = data.category[i];
      option.innerHTML = data.category[i];
      selectElement.appendChild(option);
  }

  selectElement.addEventListener('change', (event) => {
    let selectedStatus = event.target.value;
    let listItems = document.querySelectorAll('main li');
    if (selectedStatus === "All") {
        listItems.forEach((item) => {
            item.style.display = 'block';
        });
    } else {
        listItems.forEach((item) => {
            let itemStatus = item.querySelector('h2').textContent;
            if (itemStatus !== selectedStatus) {
              item.style.display = 'none';
            } else {
              item.style.display = 'block';
            }
        });
    }
});
}

fetch("data/category.json")
  .then(response => response.json())
  .then(data => ShowCategories(data));