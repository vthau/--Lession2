<div class="row">
  <div class="col-12">
    <div class="mt-4">
      <div class="form-group">
        <input class="form-control btn-search" data-action="<?php echo BASE_URL . 'Home/Index/1/'; ?>" type="text" placeholder="Keyword..." />
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-10">
    <?php if ($model["keyword"] != "") : ?>
      <p>Search found <?php echo $model["totalItem"]; ?> results</p>
    <?php else : ?>
      <p>All product</p>
    <?php endif; ?>
  </div>
  <div class="col-2">
    <button class="btn float-right cursor-pointer" onclick="addItem()">
      <i class="fa fa-plus-circle text-primary" style="font-size: 24px" aria-hidden="true"></i>
    </button>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" class="text-center">#</th>
          <th scope="col" class="text-center">Product</th>
          <th scope="col" class="text-center">Category</th>
          <th scope="col" class="text-center">Image</th>
          <th scope="col" class="text-center">Operations</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($model["products"] as $product) : ?>
          <tr>
            <td class="text-center"><?php echo $product["id"] ?></td>
            <td class="text-center"><?php echo $product["name"] ?></td>
            <td class="text-center"><?php echo $product["category_name"] ?></td>
            <td class="text-center">
              <img src="<?php echo IMAGE_URL . $product["image"]; ?>" width="60" height="60" alt="" />
            </td>
            <td class="text-center text-primary" style="font-size: 20px">
              <span class="cursor-pointer" data-id="<?php echo $product["id"] ?>" data-name="<?php echo $product["name"] ?>" data-cate-id="<?php echo $product["category_id"] ?>" onclick="editItem(this)">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </span>
              <span class="cursor-pointer" role="button" onclick="removeProduct(<?php echo $product['id'] ?>)">
                <i class="fa fa-minus-circle" aria-hidden="true"></i>
              </span>
              <span class="cursor-pointer" role="button" data-id="<?php echo $product["id"] ?>" data-name="<?php echo $product["name"] ?>" data-cate-id="<?php echo $product["category_id"] ?>" onclick="copyItem(this)">
                <i class="fa fa-clone" aria-hidden="true"></i>
              </span>
              <span class="cursor-pointer" role="button" data-id="<?php echo $product["id"] ?>" data-name="<?php echo $product["name"] ?>" data-cate-id="<?php echo $product["category_id"] ?>" data-cate-name="<?php echo $product["category_name"] ?>" data-image="<?php echo IMAGE_URL . $product["image"]; ?>" onclick="detailItem(this)">
                <i class="fa fa-eye" aria-hidden="true"></i>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>


      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <nav class="d-flex justify-content-center">

      <ul class="pagination">
        <?php if ($model['currentPage'] > 1) : ?>
          <li class="page-item"><a class="page-link" href=<?php echo BASE_URL . 'Home/Index/' . $model['keyword']; ?>>First</a></li>
          <li class="page-item"><a class="page-link" href=<?php echo BASE_URL . 'Home/Index/' . $model['prevPage'] . '/' . $model['keyword']; ?>><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
        <?php endif; ?>

        <?php
        $startPage = 1;
        $endPage = $model['totalPage'];
        if ($model['currentPage'] - ($model['maxPage'] / 2) > 1) {
          $startPage = $model['currentPage'] - ($model['maxPage'] / 2);
        }
        if ($model['currentPage'] + ($model['maxPage'] / 2) < $model['totalPage']) {
          $endPage = $model['currentPage'] + ($model['maxPage'] / 2);
        }
        ?>
        <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
          <?php if ($model['currentPage'] == $i) : ?>
            <li class="page-item active"><a class="page-link" href=<?php echo BASE_URL . 'Home/Index/' . $i . '/' . $model['keyword']; ?>><?php echo $i; ?></a></li>
          <?php else : ?>
            <li class="page-item"><a class="page-link" href=<?php echo BASE_URL . 'Home/Index/' . $i . '/' . $model['keyword']; ?>><?php echo $i; ?></a></li>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($model['currentPage'] < $model['totalPage']) : ?>
          <li class="page-item"><a class="page-link" href=<?php echo BASE_URL . 'Home/Index/' . $model['nextPage'] . '/' . $model['keyword']; ?>><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
          <li class="page-item"><a class="page-link" href=<?php echo BASE_URL . 'Home/Index/' . $model['totalPage'] . '/' . $model['keyword']; ?>>End</a></li>
        <?php endif; ?>
      </ul>


    </nav>
  </div>
</div>

<div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Add new product
        </h5>
      </div>
      <form id="form-product" action="/lamp/Home/updateProduct" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Product name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter product name..." />
            <small id="emailHelp" class="form-text text-muted">Enter product name.</small>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>
            <select class="form-control category" id="exampleFormControlSelect1" name="category_id">
              <?php foreach ($model["categorys"] as $category) : ?>
                <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlFile1">Product image</label>
            <input type="file" name="image" id="product-image" class="form-control-file" />
            <div class="alert alert-danger alert-image hidden mt-3">Vui lòng chọn một hình ảnh</div>
          </div>
        </div>
        <div class="modal-footer justify-content-start">
          <input type="hidden" name="id" />
          <input type="hidden" name="type" />
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Detail Product
        </h5>
      </div>
      <div id="form-detail">
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Product name</label>
            <h6 class="product-name">Hello</h6>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>
            <h6 class="product-category">Hello</h6>
          </div>

          <div class="form-group">
            <label for="exampleFormControlFile1">Product image</label>
            <br>
            <img class="product-image" src="" width="60" height="60" alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>