$(document).ready(function () {
  $(".alert-image").hide();

  $("#form-product").on("submit", function (e) {
    e.preventDefault();
    confirmUpdateItem();
  });
});

function getBaseUrl() {
  var pathArray = location.href.split("/");
  var protocol = pathArray[0];
  var host = pathArray[2];
  var url = protocol + "//" + host + "/lamp/";

  return url;
}

$(".btn-search").keyup(function (e) {
  if (e.keyCode == 13 || e.which == 13) {
    const url = $(this).data("action");
    const keyword = $(this).val();

    window.location = url + keyword;
  }
});

function confirmUpdateItem() {
  const popup = $("#modalProduct");
  const type = popup.find("input[name=type]").val();

  const file = $("#product-image")[0];
  if ((!file.files || !file.files[0]) && type == "NEW") {
    console.log("Vui long cho file");
    popup.find(".alert-image").show();
    return false;
  }

  popup.find("form")[0].submit();
}

function detailItem(el) {
  const popup = $("#modalDetail");
  popup.modal("show");

  popup.find(".modal-header .modal-title").text(el.getAttribute("data-name"));
  popup.find(".product-name").text(el.getAttribute("data-name"));
  popup.find(".product-category").text(el.getAttribute("data-cate-name"));
  popup.find(".product-image").attr("src", el.getAttribute("data-image"));

  console.log("Detail item");
}

function editItem(el) {
  const popup = $("#modalProduct");
  popup.modal("show");

  popup.find(".modal-header .modal-title").text("Sửa Sản Phẩm");
  popup.find("input[name=name]").val(el.getAttribute("data-name"));
  popup.find(".category").val(el.getAttribute("data-cate-id")).change();
  popup.find("input[name=id]").val(el.getAttribute("data-id"));
  $("#product-image").val("");
  popup.find("input[name=type]").val("EDIT");

  console.log("Edit item");
}

function copyItem(el) {
  const popup = $("#modalProduct");
  popup.modal("show");

  popup.find(".modal-header .modal-title").text("Sao Chép Sản Phẩm");
  popup.find("input[name=name]").val(el.getAttribute("data-name"));
  popup.find(".category").val(el.getAttribute("data-cate-id")).change();
  popup.find("input[name=id]").val(el.getAttribute("data-id"));
  $("#product-image").val("");
  popup.find("input[name=type]").val("COPY");

  console.log("Edit item");
}

function addItem() {
  const popup = $("#modalProduct");
  popup.modal("show");

  popup.find(".modal-header .modal-title").text("Thêm Sản Phẩm");
  popup.find("input[name=name]").val("");
  popup.find("input[name=id]").val("");
  $("#product-image").val("");
  popup.find("input[name=type]").val("NEW");

  console.log("New item");
}

function removeProduct(productID) {
  console.log("ProductID: ", productID);

  swal({
    title: "Bạn có muốn xóa sản phẩm ?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        url: getBaseUrl() + "Ajax/removeProduct",
        method: "post",
        data: {
          productID: productID,
        },
        success: function (response) {
          swal("Xóa sản phẩm thành công", {
            icon: "success",
          });

          setTimeout(() => {
            location.reload();
          }, 1000);
        },
        error: function (err) {
          swal("Xóa sản phẩm thất bại", {
            icon: "danger",
          });
        },
      });
    }
  });
}
