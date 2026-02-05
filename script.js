document.getElementById("signin-form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let formData = new FormData(this);

    fetch("process.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("message").textContent = data;
    })
    .catch(error => console.error("Error:", error));
});
<script>
function addToWishlist(productId, productName) {
  // Send to server
  fetch('add_to_wishlist.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'product_id=' + productId
  })
  .then(response => response.text())
  .then(data => {
    alert(data); // optional
    if (data.includes('Added')) {
      updateWishlistUI(productName);
    }
  });
}

function updateWishlistUI(productName) {
  const list = document.getElementById('wishlist-items');
  const listItem = document.createElement('li');
  listItem.textContent = productName;
  list.appendChild(listItem);
}
</script>
