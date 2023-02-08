SELECT p.name AS property_name, pv.value
FROM properties p
JOIN property_value pv ON p.id = pv.property_id
JOIN product pr ON pr.id = pv.product_id
WHERE pr.category_id = <category_id>
GROUP BY p.id
HAVING COUNT(DISTINCT pr.id) = 1;