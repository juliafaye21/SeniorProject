/*global $, document, window, setTimeout, navigator, console, location*/
$(document).ready(function () {

    'use strict';

    var usernameError = true,
        emailError    = true,
        passwordError = true,
        phoneError    = true,
        passConfirm   = true;

  var   loginEmailErr = true,
        loginPassErr = true;
    

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

   
    

    // Label effect
    $('input').focus(function () {

        $(this).siblings('label').addClass('active');
    });

    // Form validation
    if($(this).closest('signup-form')){
    $('input').blur(function () {

        // User Name
      
        
        if ($(this).hasClass('name')) {
           // var loginName = $(this).val();
            var lettersOnly = /^[a-zA-Z-' ]*$/;
           
            
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please type your full name').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else if ($(this).val().length > 1 && $(this).val().length <= 6) {
                $(this).siblings('span.error').text('Please type at least 6 characters').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } 
            else if (!lettersOnly.test($(this).val())){
               $(this).siblings('span.error').text('Please only use Upper and Lower case letters').fadeIn().parent('.form-group').addClass('hasError');
             // alert(loginName);
                usernameError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                //alert(loginName);
                usernameError = false;
            }
        }

        // Email
        if ($(this).hasClass('email')) {
            //var emailName = $(this).val();
            var emailOnly = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i; 
    //insert here
     //$('#email').blur(function(){
            //.bind("propertychange click change keyup keydown paste input"
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('Please type your email address').fadeIn().parent('.form-group').addClass('hasError');
                emailError = true;
             } 
           else if (!emailOnly.test($(this).val())){
                $(this).siblings('span.error').text('Please enter correct email address').fadeIn().parent('.form-group').addClass('hasError');
              // alert(loginName);
                 emailError = true;
                }
            else{
            var emailcheck = $('#email').val();
            $('#emailcheck').html('<img src="loading.gif" width="150" />');
            $.post('check.php' , {'email' : emailcheck}, function(data)
             {
                if(data==1){
            
               $('#email').siblings('span.error').text('This email is already taken').fadeIn().parent('.form-group').addClass('hasError');
                //alert("Data1:" + data);
               emailError = true;
               }
           else{

                $('#email').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
               // alert("Data2:" + data)
               emailError = false;
           }
      });
    }   
         
        }
        //validate phone number if entered
        if ($(this).hasClass('phone')) {
              // var phoneReg = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            var phoneReg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
           // var phoneReg = /[0-9]/;
              if ($(this).val().length === 0){
               $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
               phoneError = false;
                } 
            if(phoneReg.test($(this).val()) || $(this).val().length == ''){
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                phoneError = false;
               
             } else {
                $(this).siblings('span.error').text('Please use real phone number').fadeIn().parent('.form-group').addClass('hasError');
                phoneError = true;
             }
    }

        // PassWord
        if ($(this).hasClass('pass')) {
            //var passVal = $(this).val();
            var passReg = /^[A-Za-z]\w{6,14}$/;
            if ($(this).val().length < 7) {
                $(this).siblings('span.error').text('Please type at least 7 charcters').fadeIn().parent('.form-group').addClass('hasError');
                passwordError = true;
            } else if (!passReg.test($(this).val())){ 
                $(this).siblings('span.error').text('Must be between 7 to 14 characters. Only underscore allowed for special charater. Must start with a letter.').fadeIn().parent('.form-group').addClass('hasError');
              // alert(loginName);
                 passwordError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                passwordError = false;
            }
        }

        // PassWord confirmation
        if ($('.pass').val() !== $('.passConfirm').val()) {
            $('.passConfirm').siblings('.error').text('Passwords don\'t match').fadeIn().parent('.form-group').addClass('hasError');
            passConfirm = true;
        } else {
            $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
            passConfirm = false;
        }

        //email login validation

        // if($(this).val().length === 0){
          //   $(this).siblings('.error').text('Please enter user name').fadeIn().parent('.form-group').addClass('hasError');
                //alert($('this').val());
          //  loginEmailErr = false;
       // } else {
         //   $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
         //   loginEmailErr = true;
      // }
   // }

        // PassWord login validation
       // if ($('.pass').val() !== $('.passConfirm').val()) {
          //  $('.passConfirm').siblings('.error').text('Wrong password').fadeIn().parent('.form-group').addClass('hasError');
          //  passConfirm = true;
       // } else {
          //  $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
          //  passConfirm = false;
       // } 

        // label effect
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }

    });
}
   

    $('input').blur(function () {
    if ($(this).hasClass('loginemail')){
        var loginEmailCk = $('#loginemail').val();
        var loginPassCheck = $('#loginPassword').val();
        $.post('loginPassCheck.php' , {'loginemail' : loginEmailCk,'loginPassword' : loginPassCheck}, function(data)
        {
       if ($('#loginemail').val().length == ""){
                $('#loginemail').siblings('span.errors').text('Please enter an email').fadeIn().parent('.form-groups').addClass('hasErrors');
              // alert("Data2 : " + data);   
                loginEmailErr = true;
            }
        else if (data==4){
            $('#loginemail').siblings('span.errors').text('This email is not valid').fadeIn().parent('.form-groups').addClass('hasErrors');
           // alert("Data1 : " + data);   
            loginEmailErr = true;
        }
        else {
            $('#loginemail').siblings('.errors').text('').fadeOut().parent('.form-groups').removeClass('hasErrors');
           // alert("Data3 : " + data);
            loginEmailErr = false;
        }
    });
}

    if ($(this).hasClass('loginPassword')) {
       var loginEmailCk2 = $('#loginemail').val();
       var loginPassCheck2 = $('#loginPassword').val();
       $.post('loginPassCheck.php' , {'loginemail' : loginEmailCk2,'loginPassword' : loginPassCheck2}, function(data)
            {
                if (data==13 || data==4){
                    $('#loginPassword').siblings('span.errors').text('This password is not correct').fadeIn().parent('.form-groups').addClass('hasErrors');
                     //alert("Data0: " + data + "Email: " + loginEmailCk2);   
                    loginPassErr = true;
                }
                else {
                     $('#loginPassword').siblings('.errors').text('').fadeOut().parent('.form-groups').removeClass('hasErrors');
                     //alert("Data1: " + data + "Email: " + loginEmailCk2);
                     loginPassErr = false;
            }
        
        });
    }

  
if ($(this).val().length > 0) {
    $(this).siblings('label').addClass('active');
} else {
    $(this).siblings('label').removeClass('active');
}
});

    // form switch
    $('a.switch').click(function (e) {
        $(this).toggleClass('active');
        e.preventDefault();

        if ($('a.switch').hasClass('active')) {
            $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');

        } else {
            $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
        }
    });
//////////////////////////////
   $('#login-form').submit(function(evt)
    {
        if(loginPassErr==false && loginEmailErr==false){
             ('#login-form').submit();
       }
       else{
       evt.preventDefault();
       }
       });
/////////////////////////////////
    // Form submit
   // var placeHolder = false;
    //$('#signup-form').click(function (evt) {
     //  event.preventDefault();
  // if($(this).hasClass('signup')){
     //   if(usernameError == true || emailError == true || passwordError == true || passConfirm == true){
           // $('.name, .email, .pass, .passConfirm').blur();
    //  }
   // else  {
  //$('#signup-form').on('submit', function(evt){

  //submit form//
   //  $("#signup-form").submit(function(evt){
      //    evt.preventDefault();
          //document.getElementById("signup-form").submit();
        //  return true;
   //  });
//   submit form//
      //  $('button.switch').click(function(e){
       // $('#signup').click(function (e) {
            
         //   $(this.form).ajaxSubmit({
            //$("#signup-form").ajaxSubmit({
           //     target: false,
             //   success: function()
              //  {
              //      buttonSwitch();
              //  },
           // });
      //  });

      //works sort of
   // var form = $('#login-form');
      //  form.on("submit", function (evt) {
          

        // Do your thing
     //   evt.preventDefault();
    
    //  setTimeout(function(){
           //form.off("submit");
           //form.find("input[type=submit], button[type=submit]").eq(1).click();
       //    document.getElementById("login-form").submit();
      //  }, 500);
   // });
     //var loginClick = $('#login');
      
   //  loginClick.click(function (evt){
       //  evt.preventDefault;

     //});

      var form = $('#signup-form');
      form.on("submit", function (e) {  

        // Do your thing
       // buttonSwitch();
       e.preventDefault();
    
        setTimeout(function(){
            form.off("submit");
            form.find("input[type=submit], button[type=submit]").eq(0).click();
        }, 500);
    });
    //works sort of
  // function sendForm(event){
   //    event.preventDefault();
  // }
   // document.getElementById("signup-form").addEventListener("submit", buttonSwitch);
       //setTimeout(function () { $('.signup, .login').hide(); }, 700);
      // setTimeout(function () { $('.brand').addClass('active'); }, 300);
       //setTimeout(function () { $('.heading').addClass('active'); }, 600);
       //setTimeout(function () { $('.success-msg p').addClass('active'); }, 900);
       //setTimeout(function () { $('.success-msg a').addClass('active'); }, 1050);
       //setTimeout(function () { $('.form').hide(); }, 700);
   // $('#signup-form.switched').on('submit', function(){
     //   location.reload(true);
   // });

    // Reload page
    $('a.profile').on('click', function () {
        location.reload(true);
    });


});
function buttonSwitch(){
    $('#signup-form').toggleClass('active');
    //e.preventDefault();
      
        
        $('.login').removeClass('switched');
        $('.signup').addClass('switched');
    
    var myClass3 = $('#signup-form').attr("class");
    var myClass = $('.signup').attr("class");
    var myClass2 = $('.login').attr("class");
    alert(myClass);
    alert(myClass2);
    alert(myClass3); 
      return false;
   // });
}

function buttonloginSwitch(){
    $('#login-form').toggleClass('active');
    //e.preventDefault();
      
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
   // });