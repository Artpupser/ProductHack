<h1 class="payment-title">Выбор способа оплаты</h1>
<div class="payment-wrapper">
  <form action="./payment/fake-gateway" method="POST">
    <label for="payType" class="visually-hidden">Способ оплаты</label>
    <div class="payment-btns">
      <button type="submit" name="gateway" value="ukassa" class="payment-btn">СБП (Система быстрых платежей)</button>
      <button type="submit" name="gateway" value="ukassa" class="payment-btn">Карта «Мир»</button>
      <button type="submit" name="gateway" value="yandex" class="payment-btn">Яндекс Касса</button>
      <button type="submit" name="gateway" value="ukassa" class="payment-btn">ЮКасса</button>
    </div>
  </form>
</div>