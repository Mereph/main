<?php
function get_products(string $sort = "DESC"): mysqli_result|false {
  global $db;

  return $db->query("
    SELECT `id`, `name`, `description`, `price`
    FROM `" . sql_database . "`.`" . db_products_list . "`
    ORDER BY UNIX_TIMESTAMP(`createdAt`) $sort
  ");
}
