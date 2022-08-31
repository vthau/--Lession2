<?php
class Category extends Database
{

  public function getCategory()
  {
    $query = "SELECT * FROM category ";

    $result = mysqli_query($this->connectionString, $query);
    $array = array();
    while ($rows = mysqli_fetch_assoc($result)) {
      $array[] = $rows;
    }
    return json_encode($array);
  }
}
