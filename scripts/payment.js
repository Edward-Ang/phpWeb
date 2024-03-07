document.addEventListener('DOMContentLoaded', function() {
    var paymentBtn = document.getElementById('payment-btn');
    var popupDiv = document.getElementById('popup-div');

    paymentBtn.addEventListener('click', function(){
        popupDiv.style.display = 'flex';
    });

});