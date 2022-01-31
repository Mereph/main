<?php
function productItem(object $data): string {
  $id = $data->id;
  $name = $data->name;
  $description = $data->description ?? "Нет описания";
  $price = (int) $data->price;
return <<<HTML
<div class="shop_product">
  <div class="ecosystem_support_tab" style="margin-bottom: 2.2em;">
    <h3>${name}</h3>
    <div class="align_sphere" style="width: 25px;">
      <div class="sphere"></div>
    </div>
  </div>
  <hr>
  <p>${description}</p>
  <form method="POST" action="payment_state">
    <input type="hidden" name="product_id" value="${id}">
    <button>Купить за ${price}₽</button>
  </form>
</div>
HTML;
}
