<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <div class="ms-auto dropdown">
    <button class="btn btn-secondary dropdown-toggle me-2" type="button" id="dropdownMenuButton1"
      data-bs-toggle="dropdown" aria-expanded="false">
      Account
    </button>
    <?php if ($userLevel == '1') { ?>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#createAccountModal" data-bs-toggle="modal"><i
              class="fa-solid fa-user-plus me-2"></i>Create Account
          </a></li>
        <li><a class="dropdown-item" href="#changePassModal" data-bs-toggle="modal"><i
              class="fa-solid fa-key me-2"></i>Change
            Password</a></li>
        <li><a href="<?php echo base_url('logout'); ?>" class="text-decoration-none dropdown-item"><i
              class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
      </ul>
    <?php } else { ?>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#changePassModal" data-bs-toggle="modal"><i
              class="fa-solid fa-key me-2"></i>Change
            Password</a></li>
        <li><a href="<?php echo base_url('logout'); ?>" class="text-decoration-none dropdown-item"><i
              class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
      </ul>
    <?php } ?>

    
  </div>



</nav>




<div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="changePassModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formChangePass">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-5">
                            <div class="mb-4">
                                <label for="currentPass" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="currentPass" name="currentPass"
                                    placeholder="Enter current password">
                                <span id="changePassError" class="text-danger"></span>
                            </div>
                            <div class="mb-4">
                                <label for="newPass" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPass" name="newPass"
                                    placeholder="Enter new password">
                            </div>
                            <div class="mb-4">
                                <label for="confirmPass" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPass" name="confirmPass"
                                    placeholder="Confirm password">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Create Account Modal -->

        <div class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static" id="createAccountModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5">
                        <form id="formCreateOTP">
                            <div class="mb-4">
                                <label for="createUser" class="form-label">Username</label>
                                <input type="text" class="form-control" id="createUser" name="createUser"
                                    placeholder="Enter Username">
                            </div>
                            <div class="mb-4 row">
                                <div class="col">
                                    <label for="createEmail" class="form-label">Email</label><span class="text-danger"
                                        style="float:right;" id="divCounter"></span>
                                    <input type="email" class="form-control" id="createEmail" name="createEmail"
                                        placeholder="Enter Email" aria-describedby="emailHelp">
                                    <span id="emailSentError" class="text-danger"></span>
                                </div>
                                <div class="container text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-sm" id="btnOTP">Send OTP</button>
                                </div>
                            </div>
                        </form>
                        <div class="row mb-4 justify-content-center user-active " id="userWrapperOTP">
                            <div class="col-8">
                                <form id="formVerifyOTP">
                                    <div class="otp-wrap">
                                        <label for="createOTP" class="form-label">OTP</label>
                                        <input type="text" class="form-control" id="getOTP" name="getOTP"
                                            placeholder="Enter OTP" onkeypress="return isNumber(event)" maxlength="4">
                                        <input type="hidden" class="required" id="hdnUserChecker" name="hdnUserChecker"
                                            placeholder="Enter Username">
                                        <label id="getOTP-error" style="display:none;" class="error manual-error"
                                            for="txtEmpNumber"></label>
                                        <span id="checkIfOTPError" class="text-danger"></span>
                                        <div class="text-center">
                                            <button class="btn-getOTP" type="submit" id="btnVerifyOTP">Verify
                                                OTP</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <form id="formAccountCreation">
                            <div class="user-wrapper user-active" id="userWrapper">
                                <div class="mb-4">
                                    <label for="createPassword" class="form-label">Select User Level</label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                        id="userLevel" name="userLevel">
                                        <option value="2">Staff</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="btnCreateAcc">Create
                                        Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary d-none">Create Account</button>
                    </div>
                </div>
            </div>
        </div>

<script defer>
  $(document).ready(function () {

    window.localStorage.setItem('show_popup_changePass', 'false');
  });

  if (window.localStorage.getItem('show_popup_changePass') == 'true') {
    alertify.success('Password Updated');

  }


  jQuery('#currentPass').on('input', function () {
    $('#changePassError').html('');
  });

  $("#formChangePass").validate({
    rules: {
      currentPass: {
        required: true
      },
      newPass: {
        required: true,
        passwordStrength: true
      },
      confirmPass: {
        required: true,
        equalTo: "#newPass"
      },
    },
    messages: {
      confirmPass: {
        equalTo: "Password does not match!"
      },
    },
    submitHandler: function (form) {
      var currentPass = $("#currentPass").val();
      var confirmPass = $("#confirmPass").val();
      $.ajax({
        url: '/changePass',
        type: 'POST',
        data: {
          confirmPass, currentPass
        },
        success: function (data) {
          console.log(data);
          if (data === true) {
            window.localStorage.setItem('show_popup_changePass', 'true');
            window.location.reload();
          }
          else {
            $('#changePassError').html('Incorrect Password');
          }

        }
      });


    }

  });

</script>

<script defer type="text/javascript">
  $(document).ready(function () {
    $('#createUser').keyup(function () {
      $('#hdnUserChecker').val(this.value);
    })
    window.localStorage.setItem('show_popup_createAcc', 'false');
  });

  if (window.localStorage.getItem('show_popup_createAcc') == 'true') {
    alertify.success('Account Created Successfully!');

  }

  jQuery('#createUser').on('input', function () {
    $('#emailSentError').html('');
  });

  jQuery('#createEmail').on('input', function () {
    $('#emailSentError').html('');
  });

  jQuery('#getOTP').on('input', function () {
    $('#checkIfOTPError').html('');
  });

  jQuery.validator.addMethod("noSpace", function (value, element) {
    let newValue = value.trim();

    return (newValue) ? true : false;
  }, "This field is required");



  const otp = document.getElementById('btnOTP');
  const userLevel = document.getElementById('userWrapperOTP');



  const verifyOTP = document.getElementById('btnVerifyOTP');
  const checkIfVerified = document.getElementById('userWrapper');

  // $('#btnOTP').on('click', function () {
  //     // Disable the button when it is clicked
  //     setTimeout(function () {
  //         $('#btnOTP').prop('disabled', true);
  //     }, 200);

  // });

  //BUTTON QUICKLY REENABLES AGAIN DURING COUNTDOWN

  $('#btnOTP').on('click', function () {
    setTimeout(function () {
      $('#btnOTP').prop('disabled', true);
      if (current == 0) {
        setTimeout(function () {
          $('#btnOTP').prop('disabled', false);
        }, 2500);
      }
    }, 100);
  });


  $("#formCreateOTP").validate({
    rules: {
      createUser: {
        required: true,
        noSpace: true,
        remote: {
          url: "<?php echo base_url('checkUsernameExists'); ?>",
          type: "POST",
          data: {
            createUser: function () {
              return $("#createUser").val();
            }
          }
        }
      },
      createEmail: {
        required: true,
      }
    },
    messages: {
      createUser: {
        remote: "Username Already Exists!",
      }
    },
    submitHandler: function (form) {
      var checkEmail = $("#createEmail").val();
      $.ajax({
        url: '/checkEmailSendOTP',
        type: 'POST',
        data: {
          checkEmail
        },
        success: function (data) {
          console.log(data);
          if (data === true) {
            
            alertify.success('An OTP has been sent into the email address connected to this account');
            if (current != 0)
              return;

            $('#divCounter').text(current);
            startCountdown()
            userLevel.classList.remove('user-active');
          }
          else {
            $('#emailSentError').html('No such user is found!');
            userLevel.classList.add('user-active');
          }
        }
      });
    }
  });

  $.validator.setDefaults({
    ignore: [],
    // any other default options and/or rules
  });


  $('#hdnUserChecker').validate({ errorPlacement: function (error, element) { } });


  $("#formVerifyOTP").validate({
    ignore: [],
    rules: {
      getOTP: {
        required: true,
      },
      hdnUserChecker: {
        remote: {
          url: "<?php echo base_url('checkIfUsernameExists'); ?>",
          type: "POST",
          data: {
            hdnUserChecker: function () {
              return $("#hdnUserChecker").val();
            }
          }
        }
      }
    },
    messages: {

    },
    errorPlacement: function (error, element) {
      // Hide the error message for the 'name' field
      if (element.attr("name") == "hdnUserChecker") {
        return true;
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {
      var OTP = $("#getOTP").val();
      var email = $("#createEmail").val();
      $.ajax({
        url: '/checkOTPCorrect',
        type: 'POST',
        data: {
          OTP, email
        },
        success: function (data) {
          if (data === true) {
            if (current != 0)
              return;
            document.getElementById("createUser").disabled = true;
            document.getElementById("createEmail").disabled = true;
            userLevel.classList.add('user-active');
            checkIfVerified.classList.remove('user-active');
            $('#checkIfOTPError').html('OTP Verified!');
            $('#emailSentError').hide();
            document.getElementById('btnOTP').style.visibility = 'hidden';
          }
          else {
            $('#checkIfOTPError').html('Incorrect OTP!');
            // userLevel.classList.add('user-active');
          }
        }
      });
    }
  });




  $("#formAccountCreation").validate({
    rules: {
      createPassword: {
        required: true,
        passwordStrength: true,
      },
      createConfirm: {
        required: true,
        equalTo: "#createPassword",
      }
    },
    messages: {
      createConfirm: {
        equalTo: "Passwords do not match"
      }
    },
    submitHandler: function (form) {
      var confirmPass = $("#createConfirm").val();
      var email = $("#createEmail").val();
      var userLevel = $("#userLevel").val();
      var userName = $("#createUser").val();
      $.ajax({
        url: '/createAccount',
        type: 'POST',
        data: {
          confirmPass, email, userLevel, userName
        },
        success: function (data) {
          window.localStorage.setItem('show_popup_createAcc', 'true');
          window.location.reload();
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
    $.validator.messages.passwordStrength = errorMessage;
    return isLowercaseSatisfied && isUppercaseSatisfied && isNumberSatisfied && isSpecialCharSatisfied && isLengthSatisfied;
  });



  jQuery.validator.addMethod("passwordStrength", function (value, element) {
    let newValue = value.trim();

    return (newValue) ? true : false;
  }, "This field is required");













  $("#newPass").on("input", function () {
    updateConditions();
  });
  function updateConditions() {
    var newPassword = $("#newPass").val();

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

    if (condition.test($("#newPass").val())) {
      conditionLabel.addClass("checked");
      conditionLabel.css("color", "green");
      conditionIcon.html("&#x2713;");
    } else {
      conditionLabel.removeClass("checked");
      conditionLabel.css("color", "red");
      conditionIcon.html("X");
    }
  }


  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }




  //TIMER ALWAYS STARTS AT PAGE RELOAD (BUG)

  let start = 10;
  let current = localStorage.getItem("counterAcc") || 0;
  let interval;

  let countDown = () => {
    if (current <= 0) {
      clearInterval(interval);
      localStorage.setItem("counterAcc", start);
      current = 0;
      $('#divCounter').text("00:00");
      $('#divCounter').hide();
      localStorage.removeItem('counterAcc');
      $('#btnOTP').prop('disabled', false);
      document.getElementById("createUser").disabled = false;
      document.getElementById("createEmail").disabled = false;
    } else {
      $('#btnOTP').prop('disabled', true);
      document.getElementById("createUser").disabled = true;;
      document.getElementById("createEmail").disabled = true;
      $('#divCounter').show();
      current--;
      localStorage.setItem("counterAcc", current);
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

</script>