<?php
class Product extends Database
{

  public function getProduct($keyword)
  {
    $query = "SELECT product.id, product.name, product.image, product.category_id, category.name as category_name
    FROM category, product
    WHERE category.id=product.category_id AND product.name LIKE '%$keyword%'";

    $result = mysqli_query($this->connectionString, $query);
    $array = array();
    while ($rows = mysqli_fetch_assoc($result)) {
      $array[] = $rows;
    }
    return json_encode($array);
  }

  public function getImageByID($productID)
  {
    $query = "SELECT image FROM product WHERE id = '$productID'";
    $result = mysqli_query($this->connectionString, $query);
    $rows = mysqli_fetch_assoc($result);
    return json_encode($rows['image']);
  }

  public function insertProduct($name, $categoryId, $image)
  {
    $query = "INSERT product VALUES (NULL,$categoryId, '$name','$image')";
    return json_encode(mysqli_query($this->connectionString, $query));
  }

  public function editProduct($productId, $name, $categoryId, $image)
  {
    $query = "UPDATE product SET name = '$name', category_id = '$categoryId', image = '$image' WHERE id = '$productId'";
    return json_encode(mysqli_query($this->connectionString, $query));
  }

  public function removeProduct($productID)
  {
    $query = "DELETE FROM product WHERE ID = $productID";
    return json_encode(mysqli_query($this->connectionString, $query));
  }
}
