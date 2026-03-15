<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Оплата через ЮKassa</title>
<script src="https://yookassa.ru/checkout-widget/v1/checkout-widget.js"></script>
</head>
<body>

<section class="section_pay">
  <div class="pay-wrapper">
    <h2 class="pay-title">Оплата через ЮKassa</h2>
    <button type="button" class="pay-btn" onclick="pay()">
      <img alt="ЮKassa" class="pay-btn__logo">
      <span>Оплатить 100 руб</span>
    </button>
    <div id="payment-form"></div>
  </div>
</section>

<script>
function pay() {
    fetch("http://127.0.0.1:8300/create-payment")
    .then(response => response.json()) 
    .then(data => {
        const token = data.confirmation_token;
        const checkout = new window.YooMoneyCheckoutWidget({
            confirmation_token: token,
            return_url: "http://localhost:8000",
            error_callback: function(error){
                console.log("error");
            }
        });
        checkout.render("payment-form");
    })

};

</script>

</body>
</html>