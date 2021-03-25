/** Some JavaScript created by Mohamed Hasan https://github.com/priyesh18/book-store but modified by Julia George to make more secure. */
/*global $, document, window, setTimeout, navigator, console, location*/
//Used for client side user input validation
$(document).ready(function () {
    'use strict';
    //Declare variables for errors.
    var usernameError = true,
        emailError    = true,
        passwordError = true,
        phoneError    = true,
        passConfirm   = true;

    var loginEmailErr = true,
        loginPassErr = true;
    

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

    // Label effect
    $('input').focus(function () {

        $(this).siblings('label').addClass('active');
    });

    // Form validation for the form to signup for a user account.
    if($(this).closest('signup-form')){
        $('input').blur(function () {
            // User Name
            if ($(this).hasClass('name')) {
                //Uses regular expressions to have the user use upper and lower case letter. This was added by me.
                var lettersOnly = /^[a-zA-Z-' ]*$/;
           
                if ($(this).val().length === 0) {
                    $(this).siblings('span.error').text('Please type your full name').fadeIn().parent('.form-group').addClass('hasError');
                    usernameError = true;
                    //Have user only allow length of the user has to be 6 or more characters.
                } else if ($(this).val().length > 1 && $(this).val().length <= 6) {
                    $(this).siblings('span.error').text('Please type at least 6 characters').fadeIn().parent('.form-group').addClass('hasError');
                    usernameError = true;
                } 
                //Checks if the user only uses upper and lower case letters. This eas added by me.
                else if (!lettersOnly.test($(this).val())){
                    $(this).siblings('span.error').text('Please only use Upper and Lower case letters').fadeIn().parent('.form-group').addClass('hasError');
                    usernameError = true;
                } else {
                    //If the user has the correct format in the text box then the error message is not displayed on the screen.
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    usernameError = false;
                }
        }

        // Email
        if ($(this).hasClass('email')) {
            //Uses regular expressions to check if the email is formatted correctly.
            var emailOnly = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i; 
            //Checks if the email is empty
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('Please type your email address').fadeIn().parent('.form-group').addClass('hasError');
                emailError = true;
            } 
            //Checks the regular expression and test if the email is in the correct email format. Added by me.
            else if (!emailOnly.test($(this).val())){
                $(this).siblings('span.error').text('Please enter correct email address').fadeIn().parent('.form-group').addClass('hasError');
                 emailError = true;
            }
            else{
                //Checks if email is in use or not.
                var emailcheck = $('#email').val();
                $('#emailcheck').html('<img src="loading.gif" width="150" />');
                //Check if email is already in the database through the code check.php page. Added by me.
                $.post('check.php' , {'email' : emailcheck}, function(data)
                {
                    if(data==1){
                        $('#email').siblings('span.error').text('This email is already taken').fadeIn().parent('.form-group').addClass('hasError');
                        emailError = true;
                    }
                    else{
                        //If email is not in use then error is suppressed on the page.
                        $('#email').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        emailError = false;
                    }
                });
            }   
        }
        //validate phone number if entered. JavaScript/JQuery added by me.
        if ($(this).hasClass('phone')){
            //Use regular expressions to make sure only correct format is used for phone numbers. 
            var phoneReg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
            //Checks if the length of the phone number value is not zero then it suppresses the error. Reason is the phone number is not a required field.
            if ($(this).val().length === 0){
               $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
               phoneError = false;
            }
            /**Checks the length of the value is not empty also test if the regular expression met if it is then it suppresses the error.
             * Nulls are allowed so when it test if it is empty this is allowed. */ 
            if(phoneReg.test($(this).val()) || $(this).val().length == ''){
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                phoneError = false;
               
             } else {
                //If the able is not met then it throws an error on the page.
                $(this).siblings('span.error').text('Please use real phone number').fadeIn().parent('.form-group').addClass('hasError');
                phoneError = true;
             }
        }

        // PassWord
        if ($(this).hasClass('pass')) {
            //Created regular expression to check the password is between 7 and 14 characters. Added by me.
            var passReg = /^[A-Za-z]\w{6,14}$/;
            //Checks to make sure the length us at least 7 letters long if not then it will throw an error on page. 
            if ($(this).val().length < 7) {
                $(this).siblings('span.error').text('Please type at least 7 charcters').fadeIn().parent('.form-group').addClass('hasError');
                passwordError = true;
            //checks if the regular expression is met if it is suppresses the error. Added by me.
            } else if (!passReg.test($(this).val())){ 
                $(this).siblings('span.error').text('Must be between 7 to 14 characters. Only underscore allowed for special charater. Must start with a letter.').fadeIn().parent('.form-group').addClass('hasError');
                 passwordError = true;
                //Throws an error if the able conditions are not met.
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                passwordError = false;
            }
        }

        // PassWord confirmation
        //Checks if the password confirmation text box is the same as the password text box if not throws an error.
        if ($('.pass').val() !== $('.passConfirm').val()) {
            $('.passConfirm').siblings('.error').text('Passwords don\'t match').fadeIn().parent('.form-group').addClass('hasError');
            passConfirm = true;
            //If it is then it suppresses the error
        } else {
            $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
            passConfirm = false;
        }

        // This creates the label effect of the lable showing up an disappearing.
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }

        });
    }
   
    //Form validation used for form to sign in. JavaScript/JQuery added by me.
    $('input').blur(function () {
        if ($(this).hasClass('loginemail')){
            var loginEmailCk = $('#loginemail').val();
            var loginPassCheck = $('#loginPassword').val();
            //Gets loginPassCheck.php page to help validate user input to see if the user exist or not.
            $.post('loginPassCheck.php' , {'loginemail' : loginEmailCk,'loginPassword' : loginPassCheck}, function(data)
            {
                //Check if the login email is null.
                if ($('#loginemail').val().length == ""){
                    $('#loginemail').siblings('span.errors').text('Please enter an email').fadeIn().parent('.form-groups').addClass('hasErrors');   
                    loginEmailErr = true;
                }
                //Goes to loginPassCheck.php and checks the code if the email is valid or not.
                else if (data==4){
                    $('#loginemail').siblings('span.errors').text('This email is not valid').fadeIn().parent('.form-groups').addClass('hasErrors');  
                    loginEmailErr = true;
                }
                //If the code is not 4 then it passes check and suppresses the error
                else {
                    $('#loginemail').siblings('.errors').text('').fadeOut().parent('.form-groups').removeClass('hasErrors');
                    loginEmailErr = false;
                }
            });
        }
        //Checks the user password if it is correct or not for login.
        if ($(this).hasClass('loginPassword')) {
            var loginEmailCk2 = $('#loginemail').val();
            var loginPassCheck2 = $('#loginPassword').val();
            $.post('loginPassCheck.php' , {'loginemail' : loginEmailCk2,'loginPassword' : loginPassCheck2}, function(data)
            {
                if (data==13 || data==4){
                    $('#loginPassword').siblings('span.errors').text('This password is not correct').fadeIn().parent('.form-groups').addClass('hasErrors');  
                    loginPassErr = true;
                }
                else {
                     $('#loginPassword').siblings('.errors').text('').fadeOut().parent('.form-groups').removeClass('hasErrors');
                     loginPassErr = false;
                }
        
            });
        }

        //Used for labels to hide or be seen for errors.
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
    });

    // form switch using the class attribute.
    $('a.switch').click(function (e) {
        $(this).toggleClass('active');
        e.preventDefault();

        if ($('a.switch').hasClass('active')) {
            $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');

        } else {
            $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
        }
    });
    //Submit login-form. Javascript/JQuery added by me.
    $('#login-form').submit(function(evt)
    {
        if(loginPassErr==false && loginEmailErr==false){
             ('#login-form').submit();
       }
       else{
       evt.preventDefault();
       }
    });
    //Submit signup form
    var form = $('#signup-form');
    form.on("submit", function (e) {  
        e.preventDefault();
        setTimeout(function(){
            form.off("submit");
            form.find("input[type=submit], button[type=submit]").eq(0).click();
        }, 500);
    });

    // Reload page
    $('a.profile').on('click', function () {
        location.reload(true);
    });


});
//Function used to toggle from the signup form to the login form.
function buttonSwitch(){
    $('#signup-form').toggleClass('active');
    $('.login').removeClass('switched');
    $('.signup').addClass('switched');
    var myClass3 = $('#signup-form').attr("class");
    var myClass = $('.signup').attr("class");
    var myClass2 = $('.login').attr("class");
    alert(myClass);
    alert(myClass2);
    alert(myClass3); 
    return false;
}
//Function used to switch from login form to the signup form. 
function buttonloginSwitch(){
    $('#login-form').toggleClass('active');
    if($('#login-form').hasClass('active')){
        $('errorpassword').removeClass('errors');
        $('errorpassword').addClass('error');
        $('erroremail').removeClass('errors');
        $('erroremail').addClass('error');
        $('.login').removeClass('switched');
        $('.signup').addClass('switched'); 
        var myClass3 = $('#login-form').attr("class");
        var myClass = $('#errorpassword').attr("class");
        var myClass2 = $('#erroremail').attr("class");
        alert(myClass);
        alert(myClass2);
        alert(myClass3); 
        return false;
    }
}