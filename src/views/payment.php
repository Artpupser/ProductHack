<section class="section_pay">
  <div class="pay-wrapper">
    <h2 class="pay-title">Выберите способ оплаты</h2>

    <form action="./payment/fake-gateway" method="POST" class="pay-form">
      <div class="pay-group">
        <label class="pay-label">Система быстрых платежей</label>
        <button type="submit" name="gateway" value="sbp" class="pay-btn">СБП</button>
      </div>

      <div class="pay-group">
        <label class="pay-label">Карта «Мир»</label>
        <button type="submit" name="gateway" value="mir" class="pay-btn">Мир</button>
      </div>

      <div class="pay-group">
        <label class="pay-label">Перейти на страницу платёжного сервиса</label>
        <button type="submit" name="gateway" value="yandex" class="pay-btn">Яндекс Касса</button>
        <button type="submit" name="gateway" value="ukassa" class="pay-btn">ЮКасса</button>
      </div>
    </form>
  </div>
</section>