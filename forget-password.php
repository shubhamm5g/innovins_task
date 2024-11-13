<?php
require_once('header.php');
if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
    header("Location: users.php");
    exit;
}
?>

<div class="container-fluid px-4 pt-2">
    <h2 class="text-center my-4">Forget Password</h2>
    <div class="d-flex justify-content-center ">
        <div class="card p-2 w-50 ">
            <form id="forgetpassword" >
                <div class="row">
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Id</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-12 text-center">
                        <button type="submit" class="btn btn-primary">Forget Password</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

     $('#forgetpassword').validate({
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
                minlength: 'Password should be at least 5 characters long.'
            }
        },
        submitHandler: function (form) {
            $("#forgetpassword").ajaxSubmit({
                url: "sendForgetOtp.php",
                type: 'post',
                dataType: 'json',
                clearForm: false,
                beforeSend: function (form) {
                    $(".fulloverlay").fadeIn();
                },
                success: function (response) {
                    if(response.status){
                        customtoater("success",response.msg);
                        setTimeout(function(){
                            window.location.href = "verifyForgetOtp.php?id="+response.email;
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