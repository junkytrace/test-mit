<?php

$filename = "products.csv";

// Открыть csv-файл
$file = fopen($filename, "r");

// Соединяет с сервером
$conn = mysqli_connect("localhost", "username", "password", "database_name");

// Подготовка оператора sql
$insert_stmt = mysqli_prepare($conn, "INSERT INTO products (id, name, category, price) VALUES (?, ?, ?, ?)");

// Подготовка оператора sql для обновления
$update_stmt = mysqli_prepare($conn, "UPDATE products SET name=?, category=?, price=? WHERE id=?");

// Запускаем цикл по данным
while (($data = fgetcsv($file)) !== FALSE) {
  list($id, $name, $category, $price) = $data;
  
  // Проверить существует ли продукт
  $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
  if (mysqli_num_rows($query) > 0) {
    // Назначаем новые значения к оператору
    mysqli_stmt_bind_param($update_stmt, "sssd", $name, $category, $price, $id);
    
    // Выполняем обновление, с учетом готового оператора
    mysqli_stmt_execute($update_stmt);
  } else {
    // Привяжите значения в подготовленном операторе для вставки
    mysqli_stmt_bind_param($insert_stmt, "issd", $id, $name, $category, $price);
    
    // Выполнение оператора для вставки
    mysqli_stmt_execute($insert_stmt);
  }
}

// Закрываем операторов
mysqli_stmt_close($insert_stmt);
mysqli_stmt_close($update_stmt);

// Закрываем CSV файл
fclose($file);

// Разъединяем с сервером
mysqli_close($conn);

?>