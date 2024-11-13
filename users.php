<?php
require_once("header.php");

if(!isset( $_SESSION['innovins']) && empty($_SESSION['innovins'])) {
    header("Location: signin.php");
    exit;
}

$user_id = $_SESSION['innovins']['id'];
$query = "SELECT id,name,email,created_at FROM users WHERE id != $user_id";
$result = mysqli_query($conn, $query);
$result = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>



<h2 class=" my-4 text-center">Users Listing</h2>
<div class="d-flex justify-content-end me-4">
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModel">Add User</button> -->
    <button type="button"  class="btn btn-primary addUser  me-3">Add User</button>
</div>
<div class="d-flex justify-content-center ">
    <div class="container-fluid m-2 ">
        <div class="col-sm-12">
            <div class="" style="overflow:auto;">
                <table class="display dynamicTable compact table-sm table-striped table-bordered" style="width:100%" >
                    <thead class="">
                        <tr class="">
                            <th style="width:10px !important; text-align:left;">Sr no</th>
                            <th style="padding:8px;">Name</th>
                            <th>Email</th>
                            <th style="width:10px !important; text-align:left;">Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($result)){
                            foreach($result as $key => $value){  ?>
                            <tr class="">
                                <td style="text-align:left;"><?= ++$key ?></td>
                                <td style="text-align:left;"><?= ($value['name'])?></td>
                                <td style="text-align:left;"><?= ($value['email'])?></td>
                                <td style="text-align:left;" ><?= ($value['created_at'])?></td>
                                <td >
                                    <div>
                                        <button class="btn btn-danger deleteData " user_id="<?= $value["id"]?>">Delete</button>
                                        <button class="btn btn-secondary updateUser" user_id="<?= $value["id"]?>">Edit</button>
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
<div class="modal fade" id="updateUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true">
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

<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
    <form id="addUserForm" method="post">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addUserLabel">Add User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col col-12">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control"  name="name" placeholder="Enter Full Name">
                </div>
            </div>
            <div class="col col-12">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Id</label>
                    <input type="email" class="form-control"  name="email" placeholder="Enter Email ">
                </div>
            </div>
            <div class="col col-12">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="Addpassword"  name="password" placeholder="Enter Password ">
                </div>
            </div>
            <div class="col col-12">
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="text" class="form-control"  name="confirmPassword" placeholder="Enter Confirm Password ">
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

    $('.addUser').click(function(){
        $('#addUser').modal('show');
    })

    // add user
    $('#addUserForm').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
            required: true,
            minlength: 5
            },
            confirmPassword: {
            required: true,
            minlength: 5,
            equalTo: "#Addpassword"
            }
        },
        messages: {
            name: {
                required: 'Please enter Full Name.',
            },
            email: {
                required: 'Please enter Email.',
                email: 'Please enter a valid Email.'
            },
            password: {
                required: 'Please enter Password.',
                minlength: 'Password must be at least 5 characters long.'
            },
            confirmPassword: {
                required: 'Please enter Confirm Password.',
                equalTo: 'Confirm Password do not match with Password.',
                minlength: 'Confirm Password must be at least 5 characters long.'
            }

        },submitHandler: function (form) {
            $("#addUserForm").ajaxSubmit({
                url: "addUserForm.php",
                type: 'post',
                dataType: 'json',
                clearForm: false,
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        customtoater("success",response.msg);
                        $('#addUser').modal('hide');
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
                        $('#updateUser').modal('hide');
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

    $('.updateUser').click(function () {
        var id = $(this).attr('user_id');
        $.ajax({
            url: 'updateUser.php',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            beforeSend: function (form) {
                $(".fulloverlay").fadeIn();
            },
            success: function (response) {
                if(response.status){
                    $(".fulloverlay").fadeOut();
                    $('#updateUser').modal('show');
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
            var id = $(this).attr('user_id');
            $.ajax({
                url: 'delete_user.php',
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