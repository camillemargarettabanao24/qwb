function toggle() {
  let profileDropdownList = document.querySelector(".profile-dropdown-list");
  profileDropdownList.classList.toggle("active");
}

let btn = document.querySelector(".profile-dropdown-btn");

window.addEventListener("click", function (e) {
  let profileDropdownList = document.querySelector(".profile-dropdown-list");
  if (!btn.contains(e.target)) profileDropdownList.classList.remove("active");
});



  function search() {
  let filter = document.getElementById('find').value.toUpperCase();
  let products = document.querySelectorAll('.box');

  products.forEach(product => {
      let productName = product.querySelector('h3').textContent.toUpperCase();
      let category = product.querySelector('.category').textContent.toUpperCase();
      let priceText = product.querySelector('.price').textContent.trim(); 
      let price = parseFloat(priceText.replace(/[^\d.]/g, '')); 

      if (productName.includes(filter) || category.includes(filter)) {
          product.style.display = "";
      } else {
          product.style.display = "none";
      }
  });
}



