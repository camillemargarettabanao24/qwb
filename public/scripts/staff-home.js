document.querySelector(".jsFilter").addEventListener("click", function () {
    document.querySelector(".filter-menu").classList.toggle("active");
  });
  
  document.querySelector(".grid").addEventListener("click", function () {
    document.querySelector(".list").classList.remove("active");
    document.querySelector(".grid").classList.add("active");
    document.querySelector(".products-area-wrapper").classList.add("gridView");
    document
      .querySelector(".products-area-wrapper")
      .classList.remove("tableView");
  });
  
  document.querySelector(".list").addEventListener("click", function () {
    document.querySelector(".list").classList.add("active");
    document.querySelector(".grid").classList.remove("active");
    document.querySelector(".products-area-wrapper").classList.remove("gridView");
    document.querySelector(".products-area-wrapper").classList.add("tableView");
  });
  
  var modeSwitch = document.querySelector('.mode-switch');
  modeSwitch.addEventListener('click', function () {                      document.documentElement.classList.toggle('light');
   modeSwitch.classList.toggle('active');
  });


//staff profile dropdown
function toggle() {
  let profileDropdownList = document.querySelector(".profile-dropdown-list");
  profileDropdownList.classList.toggle("active");
}

let btn = document.querySelector(".profile-dropdown-btn");

window.addEventListener("click", function (e) {
  let profileDropdownList = document.querySelector(".profile-dropdown-list");
  if (!btn.contains(e.target)) profileDropdownList.classList.remove("active");
});



// SEARCH JS
function search() {
  document.getElementById('find').addEventListener('input', search);
  let products = document.querySelectorAll('.products-row');

  products.forEach(product => {
      let productName = product.querySelector('.item').textContent.toUpperCase();
      let description = product.querySelector('.product-cell.description span').textContent.toUpperCase();
      let category = product.querySelector('.product-cell.category span').textContent.toUpperCase();
      let stockText = product.querySelector('.product-cell.stock span').textContent.trim();
      let stock = parseInt(stockText.replace(/[^\d]/g, ''), 10);
      let priceText = product.querySelector('.product-cell.price span').textContent.trim();
      let price = parseFloat(priceText.replace(/[^\d.]/g, ''));

      if (productName.includes(filter) || description.includes(filter) || category.includes(filter) || stock.toString().includes(filter) || priceText.includes(filter)) {
          product.style.display = "";
      } else {
          product.style.display = "none";
      }                             
  });
}



