function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if (!regex.test(email)) {
    return false;
  } else {
    return true;
  }
}

function IsMobile(mobile) {
  var regex = /^[6-9]\d{9}$/;
  if (!regex.test(mobile)) {
    return false;
  } else {
    return true;
  }
}

function IsVehicleNumber(vehicle_number) {
  var regex = /^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,2}[0-9]{3,4}$/;
  if (!regex.test(vehicle_number)) {
    return false;
  } else {
    return true;
  }
}

function IsValidDate(date) {
  var regex = /^(0[1-9]|[12][0-9]|3[01])[-](0[1-9]|1[012])[-](19|20)\d\d$/;
  if (!regex.test(date)) {
    return false;
  } else {
    return true;
  }
}

function IsOnlyDigit(num) {
  var regex = /^[1-9][0-9]*$/;
  if (!regex.test(num)) {
    return false;
  } else {
    return true;
  }
}

function IsOnlyDigitWithZeroAccept(num) {
  var regex = /^[0-9]*$/;
  if (!regex.test(num)) {
    return false;
  } else {
    return true;
  }
}
function IsFloat(num) {
  var regex = /^-?(?:\d+|\d*\.\d+)$/;
  if (!regex.test(num)) {
    return false;
  } else {
    return true;
  }
}
function IsPincode(num) {
  var regex = /^[1-9][0-9]{5}$/;
  if (!regex.test(num)) {
    return false;
  } else {
    return true;
  }
}
function IsDate(num) { //d-m-Y (21-02-1998)
  var regex = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;
  if (!regex.test(num)) {
    return false;
  } else {
    return true;
  }
}
function IsGST(num) { //27AAPFU0939F1ZV
  var regex = /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}$/;
  if (!regex.test(num)) {
    return false;
  } else {
    return true;
  }
}
function scroll_to_id(id) {
  //alert(id);
  $('html, body').animate({
    scrollTop: $(id).offset().top - 100
  }, 1000);
  jQuery(id).focus();
}


/************************************************************************/
//Swal - Sweetalert
function swal_alert_without_redirect(msg, status) {
  swal("Hi...!", msg, status);
}
function swal_alert_with_redirect(msg, status, redirect_link, time) {
  swal("Hi...!", msg, status);
  setTimeout(() => { window.location.href = redirect_link; }, time);
}
/*******************************************************************************/

function isPassChange() {
  jQuery.ajax({
    url: 'ispasschange-ajax.php',
    success: function (result) {
      result = result.trim();
      if (result == 0) {//true
        swal_alert_with_redirect('Logout Successfully..', 'warning', 'logout.php', '1000');
        //window.location.href='logout.php';
      }
    }
  });
}
/*****************************************************************************/

function contact_form_submit() {
  var name = jQuery("#name").val().trim();
  var email = jQuery("#email").val().trim();
  var mobile = jQuery("#mobile").val().trim();
  var msg = jQuery("#msg").val().trim();
  jQuery('#error_name').html('');
  jQuery('#error_email').html('');
  jQuery('#error_mobile').html('');
  jQuery('#error_msg').html('');
  jQuery('#form_success_msg').html('');

  if (name == "") {
    scroll_to_id('#name');
    jQuery('#error_name').html('Please enter valid Name');
    return false;
  }
  else if (IsMobile(mobile) == false) {
    scroll_to_id('#mobile');
    jQuery('#error_mobile').html('Please enter 10 digit valid Mobile Number');
    return false;
  }
  else if (IsEmail(email) == false) {
    scroll_to_id('#email');
    jQuery('#error_email').html('Please enter valid Email');
    return false;
  }
  else if (msg == "") {
    scroll_to_id('#msg');
    jQuery('#error_msg').html('Please enter valid Message');
    return false;
  }
  else {
    jQuery('#form_success_msg').html('');
    jQuery('#submit').html('Please wait');
    jQuery('#submit').attr('disabled', true);

    jQuery.ajax({
      url: 'contact-submit.php',
      type: 'post',
      data: '&name=' + name + '&mobile=' + mobile + '&email=' + email + '&msg=' + msg,
      success: function (result) {
        alert(result);
        jQuery('#form_success_msg').html(result);
        jQuery('#submit').html('Submit');
        jQuery('#submit').attr('disabled', false);
        jQuery('#contact_form1')[0].reset();
      }
    })
  }
}

function confirm_function(){
  alert("f");
}

/*******************************************************************************/
function emp_submit() {
  var name = jQuery("#name").val().trim();
  var email = jQuery("#email").val().trim();
  var mobile = jQuery("#mobile").val().trim();

  jQuery('#error_name').html('');
  jQuery('#error_email').html('');
  jQuery('#error_mobile').html('');

  if (IsEmail(email) == false) {
    scroll_to_id('#email');
    jQuery('#error_email').html('Please enter valid Email');
    return false;
  }
  else if (name == "") {
    scroll_to_id('#name');
    jQuery('#error_name').html('Please enter valid Name');
    return false;

  } else if (IsMobile(mobile) == false) {
    scroll_to_id('#mobile');
    jQuery('#error_mobile').html('Please enter 10 digit valid Mobile Number');
    return false;
  }
}
function cust_submit() {
  var mr = jQuery("#mr").val().trim();
  var name = jQuery("#name").val().trim();
  var owner_name = jQuery("#owner_name").val().trim();
  var email = jQuery("#email").val().trim();
  var mobile = jQuery("#mobile").val().trim();
  var manager_mob = jQuery("#manager_mob").val().trim();
  var manager_name = jQuery("#manager_name").val().trim();
  var pass = jQuery("#pass").val().trim();
  var address = jQuery("#address").val().trim();
  var pincode = jQuery("#pincode").val().trim();

  jQuery('#error_mr').html('');
  jQuery('#error_name').html('');
  jQuery('#error_owner_name').html('');
  jQuery('#error_email').html('');
  jQuery('#error_mobile').html('');
  jQuery('#error_manager_mob').html('');
  jQuery('#error_manager_name').html('');
  jQuery('#error_pass').html('');
  jQuery('#error_address').html('');
  jQuery('#error_pincode').html('');

  if (mr == "") {
    scroll_to_id('#mr');
    jQuery('#error_mr').html('Please enter valid Rk No');
    return false;
  }
  else if (name == "") {
    scroll_to_id('#name');
    jQuery('#error_name').html('Please enter valid Name');
    return false;
  }
  else if (owner_name == "") {
    scroll_to_id('#owner_name');
    jQuery('#error_owner_name').html('Please enter valid Name');
    return false;
  }
  else if (IsEmail(email) == false) {
    scroll_to_id('#email');
    jQuery('#error_email').html('Please enter valid Email');
    return false;
  }
  else if (IsMobile(mobile) == false) {
    scroll_to_id('#mobile');
    jQuery('#error_mobile').html('Please enter 10 digit valid Mobile Number');
    return false;
  }
  else if (manager_name == "") {
    scroll_to_id('#manager_name');
    jQuery('#error_manager_name').html('Please enter valid Name');
    return false;
  }
  else if (IsMobile(manager_mob) == false) {
    scroll_to_id('#manager_mob');
    jQuery('#error_manager_mob').html('Please enter 10 digit valid Mobile Number');
    return false;
  }

  else if (pass == "") {
    scroll_to_id('#pass');
    jQuery('#error_pass').html('Please enter valid Password');
    return false;
  }
  else if (address == "") {
    scroll_to_id('#address');
    jQuery('#error_address').html('Please enter valid Address');
    return false;
  }
  else if (IsPincode(pincode) == false) {
    scroll_to_id('#pincode');
    jQuery('#error_pincode').html('Please enter 6 digit valid Pincode');
    return false;
  }
}
// --------------------------------------------------------------------------
function daily_task_submit(id) {
  var cust_id = jQuery("#cust_id").val().trim();
  var is_casting = $('input[type=radio][name="is_casting"]:checked').val();
  var no_of_cubes = jQuery("#no_of_cubes").val().trim();
  var image = jQuery("#image").val().trim();

  jQuery('#error_cust_id').html('');
  jQuery('#error_no_of_cubes').html('');
  jQuery('#error_image').html('');

  if (cust_id == "Select Option") {
    scroll_to_id('#cust_id');
    jQuery('#error_cust_id').html('Please select an option');
    return false;
  }
  if (is_casting == 1 && no_of_cubes == "") {
    scroll_to_id('#no_of_cubes');
    jQuery('#error_no_of_cubes').html('Please Enter Value');
    return false;
  }
  if (typeof id == 'undefined' && image == "") {//id=0 means new entry
    scroll_to_id('#image');
    jQuery('#error_image').html('Please choose image');
    return false;
  }
}
// --------------------------------------------------------------------------
function selling_submit() {
  var cust_id = jQuery("#cust_id").val().trim();
  jQuery('#error_cust_id').html('');

  if (cust_id == "Select Option") {
    scroll_to_id('#cust_id');
    jQuery('#error_cust_id').html('Please select an option');
    return false;
  }
  //--------------------------

  const entry_field_mrp = [];
  const entry_field_price = [];

  isValid = true;

  function input_qty() {
    // alert(entry_field_price.length);
    var c = 1;
    $('input#qty').each(function () {
      var field = $(this).val().trim();//नग

      //if qty is entered then price should be enter
      if (entry_field_price.includes(c) && field == "") {
        isValid = false;
      }

      if (field != "" && IsOnlyDigit(field) == false) {
        isValid = false;
      }
      // else {
      //   isValid = true;
      // }
      if (isValid == false) {
        $(this).css({
          "border": "1px solid red"
        });
        scroll_to_id(this);
        return false;
      }
      else {
        $(this).css({
          "border": ""
        });
      }
      // for the checking which one is entered
      if (field != '') {
        entry_field_mrp.push(c);
      }
      c++;
    });

    if (isValid == false) {
      return false;
    }
  }
  if (input_qty() == false) {
    return false;
  }
  // -------------------

  isValid2 = true;
  var c = 1;
  $('input#price').each(function () {

    var field = $(this).val().trim();//price

    //if qty is entered then price should be enter
    if (entry_field_mrp.includes(c) && field == "") {
      isValid2 = false;
    }

    if (field != "" && IsFloat(field) == false) {
      isValid2 = false;
    }
    // else {
    //   isValid2 = true;
    // }
    if (isValid2 == false) {
      $(this).css({
        "border": "1px solid red"
      });
      scroll_to_id(this);
      return false;
    }
    else {
      $(this).css({
        "border": ""
      });
    }

    // for the checking which one is entered
    if (field != '') {
      entry_field_price.push(c);
    }
    c++;
  });

  if (isValid2 == false) {
    return false;
  }

  if (input_qty() == false) {
    return false;
  }

  //if no data is entered
  if (entry_field_mrp.length == 0) {
    alert("Please Enter any data");
    return false;
  }

}
// --------------------------------------------------------------------------
function selling_cust_submit() {

  const entry_field_mrp = [];
  var future_date = jQuery("#future_date").val().trim();
  jQuery('#error_future_date').html('');

  if (IsDate(future_date) == false) {
    scroll_to_id('#future_date');
    jQuery('#error_future_date').html('Please Select valid Date - d-m-Y');
    return false;
  }
  isValid = true;

    var c = 1;
    $('input#qty').each(function () {
      var field = $(this).val().trim();//नग

      if (field != "" && IsOnlyDigit(field) == false) {
        isValid = false;
      }

      if (isValid == false) {
        $(this).css({
          "border": "1px solid red"
        });
        scroll_to_id(this);
        return false;
      }
      else {
        $(this).css({
          "border": ""
        });
      }

      // for the checking which one is entered
      if (field != '') {
        entry_field_mrp.push(c);
      }
      c++;
    });

    if (isValid == false) {
      return false;
    }



  //if no data is entered
  if (entry_field_mrp.length == 0) {
    alert("Please Enter any data");
    return false;
  }

}
// --------------------------------------------------------------------------
function gst_type_submit() {
  var perc = jQuery("#perc").val().trim();

  jQuery('#error_perc').html('');

  if (IsFloat(perc) == false) {
    scroll_to_id('#perc');
    jQuery('#error_perc').html('Please Enter valid number');
    return false;
  }
}

/*------------------------------------------------------------------------------*/
function payment_type_submit() {
  var name = jQuery("#name").val().trim();

  jQuery('#error_name').html('');

  if (name == '') {
    scroll_to_id('#name');
    jQuery('#error_name').html('Please Enter valid Name');
    return false;
  }
}

/*------------------------------------------------------------------------------*/
function view_selling_submit() {

  // var mr_order_no = jQuery("#mr_order_no").val().trim();  
  var deliver_receipt = jQuery("#deliver_receipt").val().trim();  
  var original_invoice = jQuery("#original_invoice").val().trim();  
  var eway_bill = jQuery("#eway_bill").val().trim();  

  if(deliver_receipt=='' && original_invoice=='' && eway_bill==''){
    alert("Please Select Any PDF!!!");
    return false;
  }
  // jQuery('#error_mr_order_no').html('');

  // if (IsOnlyDigit(mr_order_no) == false) {
  //   scroll_to_id('#mr_order_no');
  //   jQuery('#error_mr_order_no').html('Please enter valid Number');
  //   return false;
  // }
}
// ================================================================================================================//
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
// ================================================================================================================//
/*-----------------------------------------------------------------*/
function membership_fee_submit() {
  var fee = jQuery("#fee").val().trim();

  jQuery('#error_fee').html('');

  if (IsFloat(fee) == false) {
    scroll_to_id('#fee');
    jQuery('#error_fee').html('Please valid digit');
    return false;
  }
}
// -----------------------------------------------------------------------------------------
function product_submit() {
  var name = jQuery("#name").val().trim();

  jQuery('#error_name').html('');

  if (name == "") {
    scroll_to_id('#name');
    jQuery('#error_name').html('Please enter valid text');
    return false;
  }
}

/*------------------------------------------------------------------------------*/
function edit_selling_submit() {
  var product_id = jQuery("#product_id").val().trim();
  var mrp = jQuery("#mrp").val().trim();
  var price = jQuery("#price").val().trim();
  var qty = jQuery("#qty").val().trim();

  jQuery('#error_product_id').html('');
  jQuery('#error_mrp').html('');
  jQuery('#error_price').html('');
  jQuery('#error_qty').html('');

  if (product_id == "Select Option") {
    jQuery('#error_product_id').html('Please select an option');
    return false;
  }
  if (IsFloat(mrp) == false) {
    scroll_to_id('#mrp');
    jQuery('#error_mrp').html('Please enter valid Number');
    return false;
  }
  if (IsFloat(price) == false) {
    scroll_to_id('#price');
    jQuery('#error_price').html('Please enter valid Number');
    return false;
  }
  if (IsOnlyDigit(qty) == false) {
    scroll_to_id('#qty');
    jQuery('#error_qty').html('Please enter valid Number');
    return false;
  }
}
/*------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
function gst_file_submit() {
  var cust_id = jQuery("#cust_id").val().trim();
  var gst_month = jQuery("#gst_month").val().trim();
  // var gst_file_pdf = jQuery("#gst_file_pdf").val().trim();

  jQuery('#error_cust_id').html('');
  jQuery('#error_gst_month').html('');
  // jQuery('#error_gst_file_pdf').html('');

  if (cust_id == "Select Option") {
    jQuery('#error_cust_id').html('Please select an option');
    return false;
  }
  if (gst_month == '') {
    scroll_to_id('#gst_month');
    jQuery('#error_gst_month').html('Please enter valid Month');
    return false;
  }
  // if (gst_file_pdf == '') {
  //   scroll_to_id('#gst_file_pdf');
  //   jQuery('#error_gst_file_pdf').html('Please Select PDF');
  //   return false;
  // }

}
/*------------------------------------------------------------------------------*/
function selling() {
  var cust_id = jQuery("#cust_id").val().trim();
  var count = jQuery("#add_more_from_vishal").val().trim();
  // alert("count "+count);

  jQuery('#error_cust_id').html('');
  // jQuery('#error_qty').html('');
  // jQuery('#error_medicine_name_id').html('');
  // jQuery('#error_medicine_name_id').html('');

  if (cust_id == "Select Option") {
    scroll_to_id('#cust_id');
    jQuery('#error_cust_id').html('Please select an Option');
    return false;
  }

  var isValid = true;
  var c = 0;//c==0 famer name and c==1 defalut medicine name
  const array_product_id = [];
  $('select').each(function () {
    if ($(this).val().trim() == 'Select Option') {
      // alert("d")
      isValid = false;
    }
    else {
      if (c == 1) {//if only one process
        array_product_id.push(Number(jQuery("#product_id").val().trim()));
      }
      else if (c != 0 && c != 1) {
        jQuery('#error_product_id' + c).html('');

        if (array_product_id.includes(Number(jQuery("#product_id" + c).val().trim())) == true) {
          jQuery('#error_product_id' + c).html('Please select another Product');
          isValid = false;
        }
        else {
          array_product_id.push(Number(jQuery("#product_id" + c).val().trim()));
          isValid = true;
        }
      }
    }
    if (isValid == false) {
      $(this).css({
        "border": "1px solid red"
      });
      scroll_to_id(this);
      return false;
    }
    else {
      $(this).css({
        "border": ""
      });
    }
    c++;
  });

  if (isValid == false) {
    return false;
  }

  isValid2 = true;
  var c = 1;
  $('input#qty').each(function () {
    //alert($('input#available_medicine').val());

    var field = $(this).val().trim();//नग
    // alert(field);
    if (IsOnlyDigit(field) == false) {
      isValid2 = false;
    }
    else {
      isValid2 = true;
    }
    if (isValid2 == false) {
      $(this).css({
        "border": "1px solid red"
      });
      scroll_to_id(this);
      return false;
    }
    else {
      $(this).css({
        "border": ""
      });
    }
    c++;
  });

  if (isValid2 == false) {
    return false;
  }

  isValid3 = true;

  $('input#common_id').each(function () {
    var field = $(this).val().trim();
    if (IsFloat(field) == false) {
      isValid3 = false;
    }
    else {
      isValid3 = true;
    }
    if (isValid3 == false) {
      $(this).css({
        "border": "1px solid red"
      });
      scroll_to_id(this);
      return false;
    }
    else {
      $(this).css({
        "border": ""
      });
    }
  });

  if (isValid3 == false) {
    return false;
  }
}
/*------------------------------------------------------------------------------*/

function manage_account_submit() {
  var deposit = jQuery("#deposit").val().trim();
  jQuery('#error_deposit').html('');

  if (IsFloat(deposit) == false) {
    jQuery('#error_deposit').html('Please enter valid Number.');
    return false;
  }
}




