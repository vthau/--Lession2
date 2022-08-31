<?php
class Home extends ViewModel
{
  public $product;
  public $category;

  function __construct()
  {
    $this->category = $this->getModel('Category');
    $this->product = $this->getModel('Product');
  }

  public function Index($page = 1, $keyword = "")
  {
    $categorys = json_decode($this->category->getCategory(), true);
    $allProduct = json_decode($this->product->getProduct($keyword), true);

    $products = array();
    $pageSize = 10;
    $totalItem = count($allProduct);
    $totalPage = ceil($totalItem / $pageSize);
    $maxPage = 10;
    $nextPage = $page + 1;
    $prevPage = $page - 1;
    $skip = ($page - 1) * $pageSize;
    $take = $skip + $pageSize;
    for ($i = $skip; $i < $take; $i++) {
      if (!empty($allProduct[$i])) {
        array_push($products, $allProduct[$i]);
      }
    }

    $this->loadView('Shared', 'Layout', [
      'title' => 'Lampart',
      'page' => 'Home/Index',
      'keyword' => $keyword,
      'categorys' => $categorys,
      'products' => $products,
      'totalItem' => $totalItem,
      'totalPage' => $totalPage,
      'maxPage' => $maxPage,
      'nextPage' => $nextPage,
      'prevPage' => $prevPage,
      'currentPage' => $page
    ]);
  }

  public function updateProduct()
  {
    $name = $_POST['name'];
    $productId = isset($_POST['id']) ? $_POST['id'] : "";
    $categoryId = $_POST['category_id'];
    $type = $_POST['type'];
    $image = "";

    if ($type == "NEW" || $type == "COPY") {
      if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $fileName = $_FILES['image']['name'];
        $fileExt = explode('.', $fileName);
        $imageFileType = strtolower(end($fileExt));

        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $allowed)) {
          $image =  substr(md5(time()), 0, 10) . rand(0, 99) . '.' . $imageFileType;

          $location = 'Public/images/' . $image;
          if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
            $this->product->insertProduct($name, $categoryId, $image);
          }
        }
      } else {

        $image = json_decode($this->product->getImageByID($productId), true);

        $this->product->insertProduct($name, $categoryId, $image);
      }
    }

    if ($type == "EDIT") {

      if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $fileName = $_FILES['image']['name'];
        $fileExt = explode('.', $fileName);
        $imageFileType = strtolower(end($fileExt));

        $allowed = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $allowed)) {
          $image =  substr(md5(time()), 0, 10) . rand(0, 99) . '.' . $imageFileType;

          $location = 'Public/images/' . $image;
          if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
            $this->product->editProduct($productId, $name, $categoryId, $image);
          }
        }
      } else {
        $image = json_decode($this->product->getImageByID($productId), true);
        $this->product->editProduct($productId, $name, $categoryId, $image);
      }
    }
    return header("Location: /lamp");
  }
}
