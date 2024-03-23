// script.js

// Category Filter
document.getElementById('category-filter').addEventListener('change', function() {
    var category = this.value.toLowerCase();
    var productBoxes = document.querySelectorAll('.product-box');

    productBoxes.forEach(function(box) {
        var boxCategories = box.dataset.categories.toLowerCase().split(','); // Retrieve categories stored in data-categories attribute
        if (category === 'all' || boxCategories.includes(category)) {
            box.style.display = 'inline-block';
        } else {
            box.style.display = 'none';
        }
    });
});