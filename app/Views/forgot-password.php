<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="login-style.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
  <!-- Default theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
  <!-- Semantic UI theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
  <!-- Bootstrap theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

  <title>
    <?php echo $pageTitle ?>
  </title>
</head>

<body>



  <div class="container-sm wrapper">
    <div class="form-forgot p-2">
      <div id="backArrow" class="return mt-2 ms-2"><a class="a-return" href="<?php echo base_url('login') ?>"><i
            class="fa-solid fa-arrow-left"></i></a></div>
      <div class="">
        <h3 class="text-center sign-up fw-bold mt-2">Forgot Password</h3>
      </div>
      <div class="mb-3 px-5 py-3 d-flex flex-column justify-content-center">

        <div class="user">
          <form id="checkEmail" class="checkEmail">
            <label for="username" class="form-label fw-bold">Enter username</label>

            <input type="text" class="form-control mb-0" id="username" name="username" required />
            <span id="checkEmailError" class="text-danger"></span>
            <label id="username-error" class="error manual-error" for="username" style=""></label>
            <div class="d-flex justify-content-center align-items-center">
              <button type="submit" class="btn-send btn-login fw-bold rounded px-2 py-1 mt-3 mb-3 check-btn"
                id="btnCheckUsername">
                Next
              </button>
            </div>
          </form>
        </div>

        <form id="checkOTP" class="checkOTP d-none">
          <div class="otp mb-1">
            <label for="otp" class="form-label fw-bold">Enter OTP</label>
            <span class="text-danger" style="float:right;" id="divCounter"></span>
            <input type="text" class="form-control mb-0" id="otp" name="otp" required maxlength="4"
              onkeypress="return isNumber(event)" />
            <span id="checkEmailErrors" class="text-danger"></span>
            <span id="checkOTPError" class="text-danger"></span>
            <div class="get-code d-flex justify-content-end mt-1">

              <div class="getcode-wrapper"><button style="border: none;" id="btnGetCode" type="button">Get
                  Code</button>
              </div>
            </div>

            <label id="otp-error visibility-hidden" class="error " for="otp"></label>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <button type="button" id="previous"
              class="btn-send btn-login fw-bold rounded px-2 py-1 mt-3 mb-3 check-btn">
              Previous
            </button>
            <button type="submit" id="sendOTP" class="btn-send btn-login fw-bold rounded px-2 py-1 mt-3 mb-3 check-btn">
              Next
            </button>
          </div>
        </form>




        <div id="changePassWrapper" class="d-none">
          <form id="formChangePassword">
            <div class="pass mb-3">
              <label for="newPassword" class="form-label fw-bold">Enter New Password</label>
              <input type="password" class="form-control mb-0" id="newPassword" name="newPassword" />
              <input type="hidden" class="form-control mb-0" id="hdnUsername" name="hdnUsername" />
            </div>
            <div class="pass mb-3">
              <label for="confirmPassword" class="form-label fw-bold">Confirm Password</label>
              <input type="password" class="form-control mb-0" id="confirmPassword" name="confirmPassword" />
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
    const otp = document.getElementById('sendOTP');
    const userLevel = document.getElementById('changePassWrapper');
    var checkEmail = document.getElementById("checkEmail");
    var checkOTP = document.getElementById("checkOTP");
    var backArrow = document.getElementById("backArrow");

    $('#btnGetCode').on('click', function () {
      setTimeout(function () {
        $('#btnGetCode').prop('disabled', true);
        if (current == 0) {
          setTimeout(function () {
            $('#btnGetCode').prop('disabled', false);
          }, 2500);
        }
      }, 100);


    });






    jQuery('#username').on('input', function () {
      $('#checkEmailError').html('');
    });

    jQuery('#otp').on('input', function () {
      $('#checkOTPError').html('');
    });


    $('#btnGetCode').on('click', function () {
      // Disable the button when it is clicked
      // setTimeout(function () {
      //   $('#btnGetCode').prop('disabled', true);
      // }, 100);
      var checkUsername = localStorage.getItem('usernameValidation');
      var userEmail = localStorage.getItem('userEmail');
      $.ajax({
        url: '/sendOTPForgot',
        type: 'POST',
        data: {
          checkUsername, userEmail
        },
        success: function (data) {
          console.log(data);
          // $('#btnCheckUsername').prop('disabled', true);
          if (data === true) {
            $('#checkOTPError').html('');
            alertify.success('OTP Sent to your email!');
            if (current != 0)
              return;
            $('#divCounter').text(current);
            startCountdown()
          }
          else {
            console.log("checkEmailErrors");
            $('#checkEmailError').html('No user found!');
          }

        }
      });



    });




    $('#previous').on('click', function () {
      checkOTP.classList.add("d-none");
      checkEmail.classList.remove("d-none");
      backArrow.classList.remove("d-none");
    });

    $("#checkEmail").validate({
      rules: {
        username: {
          required: true
        },
      },
      messages: {
      },
      submitHandler: function (form) {
        var checkUser = $("#username").val();
        $.ajax({
          url: '/checkEmail',
          type: 'POST',
          data: {
            checkUser
          },
          success: function (data) {
            console.log(data);
            // $('#btnCheckUsername').prop('disabled', true);
            if (data.success === true) {
              console.log("asd");
              checkOTP.classList.remove("d-none");
              checkEmail.classList.add("d-none");
              backArrow.classList.add("d-none");
              localStorage.setItem('userEmail', data.email);
              localStorage.setItem('usernameValidation', data.usernameValidation);
            }
            else {
              console.log("checkEmailErrors");
              $('#checkEmailError').html('No user found!');
            }

          }
        });
      }
    });


    $("#checkOTP").validate({
      rules: {
        otp: {
          required: true,
          digits: true
        },
      },
      messages: {

      },
      submitHandler: function (form) {
        var checkOTP = $("#otp").val();
        var checkUsername = localStorage.getItem('usernameValidation');
        var userEmail = localStorage.getItem('userEmail');
        var checkOTPs = document.getElementById("checkOTP");
        $.ajax({
          url: '/checkOTP',
          type: 'POST',
          data: {
            checkOTP, checkUsername,
          },
          success: function (data) {
            if (data === true) {
              clearInterval(interval);
              current = 0;
              localStorage.removeItem("counter");
              userLevel.classList.remove('d-none');
              checkOTPs.classList.add('d-none');
              backArrow.classList.add("d-none");
              let oldUsername = $('#username').val();
              // $('#btnGetCode').prop('disabled', true);
              // document.getElementById("username").disabled = true;
              // $('#sendOTP').prop('disabled', true);
              // document.getElementById("otp").disabled = true;
              $('#checkOTPError').html('');
              $('#checkEmailError').html('');
              $('#hdnUsername').val(oldUsername);

            }
            else {
              $('#checkEmailErrors').html('');
              $('#checkOTPError').html('Incorrect OTP');


            }

          }
        });
      }
    });



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
          var Username = $("#hdnUsername").val();
          $.ajax({
            url: '/forChangePassword',
            type: 'POST',
            data: {
              confirmPass, Username
            },
            success: function (data) {
              if (data === true) {
                localStorage.removeItem('userEmail');
                localStorage.removeItem('usernameValidation');
                window.localStorage.setItem('show_popup_forgot', 'true');
                window.location.href = "/login";
              }
              else {
                $('#changePasswordError').html('Something went wrong');
              }
            }
          });
        }
      });



      // Add event listener for password input changes
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


    let start = 60;
    let current = localStorage.getItem("counter") || 0;
    let interval;

    let countDown = () => {
      if (current <= 0) {
        clearInterval(interval);
        localStorage.setItem("counter", start);
        current = 0;
        $('#divCounter').text("00:00");
        console.log("hello");
        $('#divCounter').hide();
        localStorage.removeItem('counter');
        $('#btnGetCode').prop('disabled', false);
        // document.getElementById("username").disabled = false;
      } else {
        $('#btnGetCode').prop('disabled', true);
        $('#divCounter').show();
        // document.getElementById("username").disabled = true;
        current--;
        localStorage.setItem("counter", current);
        let minutes = ('00' + Math.floor(current / 60)).slice(-2);
        let seconds = ('00' + (current % 60)).slice(-2);
        $('#divCounter').text(minutes + ':' + seconds);
      }
    };

    let startCountdown = () => {
      if (current == 0) {
        current = start;
      }
      if (current != 0) {
        countDown();
        interval = setInterval(countDown, 1000);
      }
    }

    if (current != 0)
      startCountdown();


    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    }




  </script>
</body>

</html>