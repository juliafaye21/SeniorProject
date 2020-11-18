/*global $, document, window, setTimeout, navigator, console, location*/
$(document).ready(function () {

    'use strict';

    var address_err = true,
        city_err = true,
        state_err = true,
        zip_err = true,
        cardName_err = true,
        cardNum_err = true,
        expmonth_err = true,
        expyear_err = true,
        cvv_err = true;

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

    $('input').focus(function () {

        $(this).siblings('label').addClass('active');
    });

    $('input').blur(function () {

        if ($(this).hasClass('address')) {
            var addressChk = /^[a-zA-Z0-9-' .\-]+$/i;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please type an address').fadeIn().parent('.form-group').addClass('hasError');
                address_err = true;
            }
            else if (!addressChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please only use numbers, letters, period or hyphen').fadeIn().parent('.form-group').addClass('hasError');
                address_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                address_err = false;
            }
        }
        if ($(this).hasClass('city')) {
            var cityChk=/^[a-zA-Z-' ]*$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a City').fadeIn().parent('.form-group').addClass('hasError');
                city_err = true;
            }
            else if (!cityChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please only use letters and spaces').fadeIn().parent('.form-group').addClass('hasError');
                city_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                city_err = false;
            }
        }
        if ($(this).hasClass('state')) {
            var stateChk=/^[A-Z]{2}$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a State').fadeIn().parent('.form-group').addClass('hasError');
                state_err = true;
            }
            else if (!stateChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please enter state abrieviation').fadeIn().parent('.form-group').addClass('hasError');
                state_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                state_err = false;
            }
        }
        if ($(this).hasClass('zip')) {
            var zipChk = /^[0-9]{5}(-[0-9]{4})?$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a zip code').fadeIn().parent('.form-group').addClass('hasError');
                zip_err = true;
            }
            else if (!zipChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please enter valid state').fadeIn().parent('.form-group').addClass('hasError');
                zip_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                zip_err = false;
            }
        }
        if ($(this).hasClass('cardname')) {
            var cardchk = /^[a-zA-Z-' ]*$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter name as seen on Card').fadeIn().parent('.form-group').addClass('hasError');
                cardname_err = true;
            }
            else if (!cardchk.test($(this).val())) {
                $(this).siblings('span.error').text('Only letters and spaces allowed').fadeIn().parent('.form-group').addClass('hasError');
                cardname_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                cardname_err = false;
            }
        }
        if ($(this).hasClass('cardnumber')) {
            var cardNumChk = /^[0-9]{16}$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a card number.').fadeIn().parent('.form-group').addClass('hasError');
                cardnumber_err = true;
            }
            else if (!cardNumChk.test($(this).val())) {
                $(this).siblings('span.error').text('Must be valid 16 digits').fadeIn().parent('.form-group').addClass('hasError');
                cardname_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                cardnumber_err = false;
            }
        }
        if ($(this).hasClass('expmonth')) {
            var expmonthChk = /^([1-9]|1[012])$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter the experation Month').fadeIn().parent('.form-group').addClass('hasError');
                expmonth_err = true;
            }
            else if(!expmonthChk.test($(this).val())){
                $(this).siblings('span.error').text('Please enter valid month').fadeIn().parent('.form-group').addClass('hasError');
                expmonth_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                expmonth_err = false;
            }
        }

    if ($(this).hasClass('expyear')) {
            var expyearChk = /^[0-9]{2}$/;
            //var year = Date().getFullYear().toString().substr(2,2);
            var d = new Date();
            var n = d.getFullYear();
            var getYear = n.toString().substr(2);
            //var twoDigitYear = Date().getFullYear().toString().substr(-2);
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter experation year').fadeIn().parent('.form-group').addClass('hasError');
                //alert(getYear);
                expyear_err = true;
            }
            else if (!expyearChk.test($(this).val())) {
                $(this).siblings('span.error').text('Year formatted yy').fadeIn().parent('.form-group').addClass('hasError');
                expyear_err = true;
            }
           else if($(this).val() <= getYear){
              $(this).siblings('span.error').text('Please enter a valid year').fadeIn().parent('.form-group').addClass('hasError');
                     //alert(getYear);
                expyear_err = true;
               }
            else{
               $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
               expyear_err = false;
            }
        }
        if ($(this).hasClass('cvv')) {
            var cvvChk = /^[0-9]{3}$/;
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter cvv of your card').fadeIn().parent('.form-group').addClass('hasError');
                cvv_err = true;
            }
            else if (!cvvChk.test($(this).val())) {
                $(this).siblings('span.error').text('Valid 3 digit cvv').fadeIn().parent('.form-group').addClass('hasError');
                cvv_err = true;
            }
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                cvv_err = false;
            }
        }
      // var form = ".checkout-form";
     // form.on("submit", function (e) {

            // Do your thing
       // if(cardname_err==false || cardNum_err==false || expmonth_err==false || expyear_err==false || cvv_err==true || address_err==true || state_err==true || zip_err==true || city_err==true){
                //$('., .email, .pass, .passConfirm').blur();
          //      $('.address, .city, .state, .zip, .cardname, .cardnumber, .expmonth, .exyear, .cvv').blur();
         //  }
          // else{
          //  e.preventDefault();
        
          //  setTimeout(function(){
            //    form.off("submit");
             //   form.find("input[type=submit], button[type=submit]").eq(0).click();
           // }, 500);
       // }
       // });
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }

    });
});