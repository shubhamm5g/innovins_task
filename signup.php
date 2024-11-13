<?php
require_once('header.php');
if(isset( $_SESSION['innovins']) && !empty($_SESSION['innovins'])) {
    header("Location: users.php");
    exit;
}
?>
<div class="container-fluid px-4 pt-2">
    <h2 class="text-center my-4">User Registration</h2>
    <div class="d-flex justify-content-center ">
        <div class="card p-2 w-50 ">
            <form  id="signup_form" method="post">
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
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password ">
                        </div>
                    </div>
                    <div class="col col-12">
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter Confirm Password ">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $('#signup_form').validate({
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
            equalTo: "#password"
            }
        },
        messages: {
            name: 'Please enter Name.',
            email: {
                required: 'Please enter Email Address.',
                email: 'Please enter a valid Email Address.'
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
        },
        submitHandler: function (form) {
            $("#signup_form").ajaxSubmit({
                url: "registration.php",
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
                            window.location.href = "signin.php";
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