<?php
require_once('header.php');
if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
    header("Location: users.php");
    exit;
}
?>

<div class="container-fluid px-4 pt-2">
    <h2 class="text-center my-4">User Login</h2>
    <div class="d-flex justify-content-center ">
        <div class="card p-2 w-50 ">
            <form id="signin_form" >
                <div class="row">
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Id</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ">
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password ">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-12 text-right mb-2">
                        <a href="forget-password.php">Forget Password?</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-12 text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

     $('#signin_form').validate({
        rules: {

            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5,
            }
        },
        messages: {

            email: {
                required: 'Please enter Email Address.',
                email: 'Please enter a valid Email Address.',
            },
            password: {
                required: 'Please enter Password.',
                minlength: 'Password must be at least 5 characters long.'
            }
        },
        submitHandler: function (form) {
            $("#signin_form").ajaxSubmit({
                url: "login.php",
                type: 'post',
                dataType: 'json',
                clearForm: false,
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        customtoater("success",response.msg);

                        setTimeout(() => {
                            window.location.href = "index.php";
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
    });
</script>