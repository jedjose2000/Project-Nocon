<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Time Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="login-style.css" />
</head>

<body>

    <body>
        <div class="container-sm wrapper">
            <div class="form-forgot p-2">
                <div class="return mt-2 ms-2"><a class="a-return" href="<?php echo base_url('login') ?>"><i
                            class="fa-solid fa-arrow-left"></i></a></div>
                <div class="">
                    <h3 class="text-center sign-up fw-bold mt-1">First Time Login</h3>
                    <h5 class="text-center sign-up fw-bold mt-2">Change Password</h5>

                </div>
                <div class="mb-3 px-5 py-3 d-flex flex-column justify-content-center">

                    <div id="changePassWrapper">
                        <form id="formChangePassword">
                            <div class="pass mb-3">
                                <label for="newPassword" class="form-label fw-bold">Enter New Password</label>
                                <input type="password" class="form-control mb-0" id="newPassword" name="newPassword" />
                                <input type="hidden" class="form-control mb-0" id="hdnUsername" name="hdnUsername" />
                            </div>
                            <div class="pass mb-3">
                                <label for="confirmPassword" class="form-label fw-bold">Confirm Password</label>
                                <input type="password" class="form-control mb-0" id="confirmPassword"
                                    name="confirmPassword" />
                                <span id="changePasswordError" class="text-danger"></span>
                            </div>
                            <div class="conditions mb-3">
                                <div class="condition">
                                    <span class="condition-icon">X</span>
                                    <span class="condition-label lowercase">At least one lowercase letter</span>
                                </div>
                                <div class="condition">
                                    <span class="condition-icon">X</span>
                                    <span class="condition-label uppercase">One uppercase letter</span>
                                </div>
                                <div class="condition">
                                    <span class="condition-icon">X</span>
                                    <span class="condition-label number">One number</span>
                                </div>
                                <div class="condition">
                                    <span class="condition-icon">X</span>
                                    <span class="condition-label special-char">One special character</span>
                                </div>
                                <div class="condition">
                                    <span class="condition-icon">X</span>
                                    <span class="condition-label length">At least 8 characters long</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn-login fw-bold rounded fs-6 mt-4 check-btn">
                                    SUBMIT
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/f38a62f9ed.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
            integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>


        <script>
            // Retrieve user ID from flash data
            var userId = <?php echo json_encode(session()->getFlashdata('user_id')); ?>;

            // Save user ID to local storage
            localStorage.setItem('user_id', userId);
        </script>




        <script>
            $(document).ready(function () {
                $("#formChangePassword").validate({
                    rules: {
                        newPassword: {
                            required: true,
                            passwordStrength: true
                        },
                        confirmPassword: {
                            required: true,
                            equalTo: "#newPassword"
                        }
                    },
                    messages: {
                        newPassword: {
                            required: "Please enter a new password."
                        },
                        confirmPassword: {
                            required: "Please confirm your new password.",
                            equalTo: "Passwords do not match."
                        }
                    },
                    submitHandler: function (form) {
                        var confirmPass = $("#confirmPassword").val();
                        var userID = localStorage.getItem('user_id');
                        $.ajax({
                            url: '/forFirstTimeChangePassword',
                            type: 'POST',
                            data: {
                                confirmPass, userID
                            },
                            success: function (data) {
                                if (data === true) {
                                    localStorage.removeItem('user_id');
                                    window.localStorage.setItem('show_popup_firstTime', 'true');
                                    window.location.href = "/login";
                                }
                                else {
                                    $('#changePasswordError').html('Something went wrong');
                                }
                            }
                        });
                    }
                });


                $.validator.addMethod('passwordStrength', function (value) {
                    let lowercaseRegex = /^(?=.*[a-z])/;
                    let uppercaseRegex = /^(?=.*[A-Z])/;
                    let numberRegex = /^(?=.*\d)/;
                    let specialCharRegex = /^(?=.*[^\da-zA-Z])/;
                    let lengthRegex = /^.{8,}$/;

                    let isLowercaseSatisfied = lowercaseRegex.test(value);
                    let isUppercaseSatisfied = uppercaseRegex.test(value);
                    let isNumberSatisfied = numberRegex.test(value);
                    let isSpecialCharSatisfied = specialCharRegex.test(value);
                    let isLengthSatisfied = lengthRegex.test(value);

                    // Update class for each condition
                    function updateConditionClass(condition, className) {
                        if (condition) {
                            $(`.${className}`).addClass('checked');
                        } else {
                            $(`.${className}`).removeClass('checked');
                        }
                    }
                    updateConditionClass(isLowercaseSatisfied, 'lowercase-condition');
                    updateConditionClass(isUppercaseSatisfied, 'uppercase-condition');
                    updateConditionClass(isNumberSatisfied, 'number-condition');
                    updateConditionClass(isSpecialCharSatisfied, 'special-char-condition');
                    updateConditionClass(isLengthSatisfied, 'length-condition');
                    let errorMessage = '';

                    // if (!isLowercaseSatisfied) {
                    //   errorMessage += 'Password must contain at least one lowercase letter. ';
                    // }
                    // if (!isUppercaseSatisfied) {
                    //   errorMessage += 'Password must contain at least one uppercase letter. ';
                    // }
                    // if (!isNumberSatisfied) {
                    //   errorMessage += 'Password must contain at least one number. ';
                    // }
                    // if (!isSpecialCharSatisfied) {
                    //   errorMessage += 'Password must contain at least one special character. ';
                    // }
                    // if (!isLengthSatisfied) {
                    //   errorMessage += 'Password must be at least 8 characters long. ';
                    // }

                    $.validator.messages.passwordStrength = errorMessage;
                    return isLowercaseSatisfied && isUppercaseSatisfied && isNumberSatisfied && isSpecialCharSatisfied && isLengthSatisfied;
                });

                $("#newPassword").on("input", function () {
                    updateConditions();
                });
                function updateConditions() {
                    var newPassword = $("#newPassword").val();

                    var lowercaseCondition = /^(?=.*[a-z])/;
                    var uppercaseCondition = /^(?=.*[A-Z])/;
                    var numberCondition = /^(?=.*\d)/;
                    var specialCharCondition = /^(?=.*[^\da-zA-Z])/;
                    var lengthCondition = /^.{8,}$/;

                    updateConditionStatus(lowercaseCondition, ".condition-label.lowercase");
                    updateConditionStatus(uppercaseCondition, ".condition-label.uppercase");
                    updateConditionStatus(numberCondition, ".condition-label.number");
                    updateConditionStatus(specialCharCondition, ".condition-label.special-char");
                    updateConditionStatus(lengthCondition, ".condition-label.length");
                }


                function updateConditionStatus(condition, selector) {
                    var conditionLabel = $(selector);
                    var conditionIcon = conditionLabel.prev(".condition-icon");

                    if (condition.test($("#newPassword").val())) {
                        conditionLabel.addClass("checked");
                        conditionLabel.css("color", "green");
                        conditionIcon.html("&#x2713;");
                    } else {
                        conditionLabel.removeClass("checked");
                        conditionLabel.css("color", "red");
                        conditionIcon.html("X");
                    }
                }
            });
        </script>
    </body>

</html>