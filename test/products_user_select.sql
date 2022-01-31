SELECT *, (
    SELECT group_concat(`productionId`)
    FROM mereph.products_history
    WHERE userId = mereph.users.id
) as `history`
FROM mereph.users
WHERE id = 1

