<?php
require_once("header.php");

if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION['innovins']['id'];
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$result = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>



<h2 class=" my-4 text-center">Products Listing</h2>
<div class="d-flex justify-content-end me-4">
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModel">Add User</button> -->
    <button type="button"  class="btn btn-primary addProduct  me-3">Add Product</button>
</div>
<div class="d-flex justify-content-center ">
    <div class="container-fluid m-2 ">
        <div class="col-sm-12">
            <div class="" style="overflow:auto;">
                <table class="display dynamicTable compact table-sm table-striped table-bordered" style="width:100%" >
                    <thead class="">
                        <tr class="">
                            <th style="text-align:left;">Sr no</th>
                            <th style="padding:8px;">Name</th>
                            <th style="text-align:left;" >Description</th>
                            <th style="text-align:left;" >Price</th>
                            <th style="text-align:left;" >Created At</th>
                            <th style="text-align:left;" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($result)){
                            foreach($result as $key => $value){  ?>
                            <tr class="">
                                <td ><?= ++$key ?></td>
                                <td ><?= ($value['name'])?></td>
                                <td ><?= ($value['description'])?></td>
                                <td ><?= ($value['price'])?></td>
                                <td ><?= ($value['created_at'])?></td>
                                <td >
                                    <div>
                                        <button class="btn btn-danger deleteData " product_id="<?= $value["id"]?>">Delete</button>
                                        <button class="btn btn-secondary updateProduct" product_id="<?= $value["id"]?>">Edit</button>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- update model -->
<div class="modal fade" id="updateProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="updateuserform" method="post">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateUserLabel">Update User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" value="">
        <div class="row">
            <div class="col col-12">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name">
                </div>
            </div>
            <div class="col col-12">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Id</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ">
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
    <form id="addProductForm" method="post">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addUserLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col col-12">
                <div class="mb-3">
                    <label for="Addname" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="Addname"  name="name" placeholder="Enter Product Name">
                </div>
            </div>
            <div class="col col-12">
                <div class="mb-3">
                    <label for="Addprice" class="form-label">Price</label>
                    <input type="number" class="form-control" id="Addprice"  name="price" placeholder="Enter price ">
                </div>
            </div>
            <div class="col col-12">
                <div class="mb-3">
                    <label for="Adddescription" class="form-label">Description</label>
                    <textarea  class="form-control" id="Adddescription"  name="description" placeholder="Enter description "></textarea>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
    </div>
  </div>
</div>


<script>
    $(document).ready(function  () {
        $(".dynamicTable").DataTable();
    })

    $('.addProduct').click(function(){
        $('#addProduct').modal('show');
    })

    // add product
    $('#addProductForm').validate({
        rules: {
            name: {
                required: true
            },
            price: {
                required: true,
            },
            description: {
                required: true,
            }
        },
        messages: {
            name: {
                required: 'Please enter Full Name.',
            },
            price: {
                required: 'Please enter Price.',
            },
            description: {
                required: 'Please enter Description.',
            }
        },submitHandler: function (form) {
            $("#addProductForm").ajaxSubmit({
                url: "addProductForm.php",
                type: 'post',
                dataType: 'json',
                clearForm: false,
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        customtoater("success",response.msg);
                        $('#addProduct').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }else{
                        $(".fulloverlay").fadeOut();
                        customtoater("error",response.msg);
                    }
                },
                error: function (error) {
                    $(".fulloverlay").fadeOut();
                    customtoater("error","Server error");
                }
            })
        }
    })

    // update user
    $('#updateuserform').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            name: {
                required: 'Please enter Full Name.',
            },
            email: {
                required: 'Please enter Email.',
                email: 'Please enter a valid Email.'
            }
        },submitHandler: function (form) {
            $("#updateuserform").ajaxSubmit({
                url: "updateUserForm.php",
                type: 'post',
                dataType: 'json',
                clearForm: false,
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        customtoater("success",response.msg);
                        $('#updateProduct').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }else{
                        $(".fulloverlay").fadeOut();
                        customtoater("error",response.msg);
                    }
                },
                error: function (error) {
                    $(".fulloverlay").fadeOut();
                    customtoater("error","Server error");
                }
            })
        }
    })

    $('.updateProduct').click(function () {
        var id = $(this).attr('user_id');
        $.ajax({
            url: 'updateProduct.php',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            beforeSend: function (form) {
                $(".fulloverlay").fadeIn();
            },
            success: function (response) {
                if(response.status){
                    $(".fulloverlay").fadeOut();
                    $('#updateProduct').modal('show');
                    $('#updateuserform').find('input[name="id"]').val(response.data[0].id);
                    $('#updateuserform').find('input[name="name"]').val(response.data[0].name);
                    $('#updateuserform').find('input[name="email"]').val(response.data[0].email);
                }else{
                    $(".fulloverlay").fadeOut();
                    customtoater("error",response.msg);
                }
            },
            error: function (error) {
                $(".fulloverlay").fadeOut();
                customtoater("error","Server error");
            }
        })
    })

    $('.deleteData').click(function () {
        var conf = confirm("Are you sure you want to delete this record?");
        if (conf) {
            var id = $(this).attr('product_id');
            $.ajax({
                url: 'delete_product.php',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        console.log("Success");
                        customtoater("success",response.msg);
                        setTimeout(function(){
                            location.reload()
                        }, 1000);
                    }else{
                        $(".fulloverlay").fadeOut();
                        customtoater("error",response.msg);
                    }
                },
                error: function (error) {
                    $(".fulloverlay").fadeOut();
                    customtoater("error","Server error");
                }
            })
        }



    })
</script>