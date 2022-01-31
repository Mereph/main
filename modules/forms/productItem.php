<?php
function productItem(object $data): string {
  $id = $data->id;
  $name = $data->name;
  $description = $data->description ?? "Нет описания";
  $price = (int) $data->price;
return <<<HTML
<div class="productItem">
    <h3 class="productItem__title">${name}</h3>
    <hr>
    <p class="productItem__description">${description}</p>
    <form method="post" action="payment_state" class="productItem__payContainer">
        <input type="hidden" name="product_id" value="${id}">
        <button class="productItem__button">
            Купить за ${price}₽
        </button>
    </form>
</div>
HTML;
}
