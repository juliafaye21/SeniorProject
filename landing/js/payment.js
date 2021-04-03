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

    //Set focus on input field changing label class to active.
    $('input').focus(function () {

        $(this).siblings('label').addClass('active');
    });
    //Using the blur function on input field.
    $('input').blur(function () {
        //On input that has class address perform these if statements on it.
        if ($(this).hasClass('address')) {
            //Set variable addressChk to regular expressions that needs used to test user input against.
            var addressChk = /^[a-zA-Z0-9-' .\-]{10,100}+$/i;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please type an address').fadeIn().parent('.form-group').addClass('hasError');
                address_err = true;
            }
            //Test the regular expression assigned to value addressChk against value user input in the form. 
            else if (!addressChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please only use numbers, letters, period or hyphen').fadeIn().parent('.form-group').addClass('hasError');
                address_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                address_err = false;
            }
        }
        //On input that has class city perform these if statements on it.
        if ($(this).hasClass('city')) {
            //Set variable cityChk to regular expression that needs used to test user input against.
            var cityChk=/^[a-zA-Z-' ]*$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a City').fadeIn().parent('.form-group').addClass('hasError');
                city_err = true;
            }
            //Test the regular express assigned to value cityChk against value user input in the form.
            else if (!cityChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please only use letters and spaces').fadeIn().parent('.form-group').addClass('hasError');
                city_err = true;
            }
            //Else set error to false and remove class hasError.
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                city_err = false;
            }
        }
        //On input that has class state perform these if statements on it.
        if ($(this).hasClass('state')) {
            //Set variable stateChk to regular expression that needs used to test user input against.
            var stateChk=/^[A-Z]{2}$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a State').fadeIn().parent('.form-group').addClass('hasError');
                state_err = true;
            }
            //Test the regular express assigned to value stateChk against value user input in the form.
            else if (!stateChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please enter state abrieviation').fadeIn().parent('.form-group').addClass('hasError');
                state_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                state_err = false;
            }
        }
        //On input that has class zip perform these if statements on it.
        if ($(this).hasClass('zip')) {
            //Set variable zipChk to regular expression that needs used to test user input against.
            var zipChk = /^[0-9]{5}(-[0-9]{4})?$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a zip code').fadeIn().parent('.form-group').addClass('hasError');
                zip_err = true;
            }
            //Test the regular express assigned to value zipChk against value user input in the form.
            else if (!zipChk.test($(this).val())) {
                $(this).siblings('span.error').text('Please enter valid state').fadeIn().parent('.form-group').addClass('hasError');
                zip_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                zip_err = false;
            }
        }
        //On input that has class cardname perform these if statements on it.
        if ($(this).hasClass('cardname')) {
            //Set variable cardChk to regular expression that needs used to test user input against.
            var cardchk = /^[a-zA-Z-' ]{10,50}*$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter name as seen on Card').fadeIn().parent('.form-group').addClass('hasError');
                cardname_err = true;
            }
            //Test the regular express assigned to value cardChk against value user input in the form.
            else if (!cardchk.test($(this).val())) {
                $(this).siblings('span.error').text('Only letters and spaces allowed').fadeIn().parent('.form-group').addClass('hasError');
                cardname_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                cardname_err = false;
            }
        }
        //On input that has class cardnumber perform these if statements on it.
        if ($(this).hasClass('cardnumber')) {
            //Set variable cardNumChk to regular expression that needs used to test user input against.
            var cardNumChk = /^[0-9]{16}$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter a card number.').fadeIn().parent('.form-group').addClass('hasError');
                cardnumber_err = true;
            }
            //Test the regular express assigned to value cardNumChk against value user input in the form.
            else if (!cardNumChk.test($(this).val())) {
                $(this).siblings('span.error').text('Must be valid 16 digits').fadeIn().parent('.form-group').addClass('hasError');
                cardname_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                cardnumber_err = false;
            }
        }
        //On input that has class expmonth perform these if statements on it.
        if ($(this).hasClass('expmonth')) {
            //Set variable expmonthChk to regular expression that needs used to test user input against.
            var expmonthChk = /^([1-9]|01[012])$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter the experation Month').fadeIn().parent('.form-group').addClass('hasError');
                expmonth_err = true;
            }
            //Test the regular express assigned to value expmonthChk against value user input in the form.
            else if(!expmonthChk.test($(this).val())){
                $(this).siblings('span.error').text('Please enter valid month').fadeIn().parent('.form-group').addClass('hasError');
                expmonth_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                expmonth_err = false;
            }
        }
    //On input that has class expyear perform these if statements on it.
    if ($(this).hasClass('expyear')) {
        //Set variable expyeaerChk to regular expression that needs used to test user input against.
            var expyearChk = /^[0-9]{2}$/;
            //Set d to date
            var d = new Date();
            //Set n to date and year.
            var n = d.getFullYear();
            //Set getYear to string and get last 2 number in string.
            var getYear = n.toString().substr(2);
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter experation year').fadeIn().parent('.form-group').addClass('hasError');
                expyear_err = true;
            }
            //Test the regular express assigned to value expyearChk against value user input in the form.
            else if (!expyearChk.test($(this).val())) {
                $(this).siblings('span.error').text('Year formatted yy').fadeIn().parent('.form-group').addClass('hasError');
                expyear_err = true;
            }
            //Year needs to be this year or later.
           else if($(this).val() <= getYear){
              $(this).siblings('span.error').text('Please enter a valid year').fadeIn().parent('.form-group').addClass('hasError');
                expyear_err = true;
               }
            //Else set error to false and remove class hasError
            else{
               $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
               expyear_err = false;
            }
        }
        //On input that has class cvv perform these if statements on it.
        if ($(this).hasClass('cvv')) {
            //Set variable cvvChk to regular expression that needs used to test user input against.
            var cvvChk = /^[0-9]{3}$/;
            //Check if the length value is equal to zero if so then show error and add class hasError to the span html tag.
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Please enter cvv of your card').fadeIn().parent('.form-group').addClass('hasError');
                cvv_err = true;
            }
            //Test the regular express assigned to value cvvChk against value user input in the form.
            else if (!cvvChk.test($(this).val())) {
                $(this).siblings('span.error').text('Valid 3 digit cvv').fadeIn().parent('.form-group').addClass('hasError');
                cvv_err = true;
            }
            //Else set error to false and remove class hasError
            else{
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                cvv_err = false;
            }
        }
        //Check if the value in the input box has length to it more than 0 then adds css class active if the value is zero then it removes class.
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }

    });
});
