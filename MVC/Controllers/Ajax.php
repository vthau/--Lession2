<?php
class Ajax extends ViewModel
{

  public function removeProduct()
  {
    $product = $this->getModel('Product');
    $product->removeProduct($_POST['productID']);
    $data = [
      "msg" => "success",
    ];

    echo json_encode($data);
  }

  public function updateView()
  {

    $product = $this->getModel('Product');
    $product->updateView($_POST['productID']);
    array_push($_SESSION['VISITED_SESSION'], $_POST['productID']);
  }
}
