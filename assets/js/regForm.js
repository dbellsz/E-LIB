//@author Tobechukwu Treasure Osueke, x17132070

 $(document).ready(function(){
     $('[data-toggle="tooltip"]').tooltip(); // this is to make my tool tip work on load of the form
//     // $('[data-toggle="tooltip"]').css("background-color", 'red');

 });



$(document).ready(function(){
    // $("#businessnameID").keyup(function(){
    //     $("#businessnameID").css("border-color", 'black');
    //    $("#bizNameErr").hide();
    // });
    // $("#bizcategory").keyup(function(){
    //     $("#bizcategory").css("border-color", 'black');
    //    $("#serviceErr").hide();
    // });
    // $("#email").keyup(function(){
    //     $("#email").css("border-color", 'black');
    //    $("#emailErr").hide();
    // });
    // $("#phonenumber").keyup(function(){
    //     $("#phonenumber").css("border-color", 'black');
    //    $("#phoneErr").hide();
    // });
    // $("#streetnumber").keyup(function(){
    //     $("#streetnumber").css("border-color", 'black');
    //    $("#buildingNumberErr").hide();
    // });
    // $("#area").keyup(function(){
    //     $("#area").css("border-color", 'black');
    //    $("#areaErr").hide();
    // });
    //  $("#streetname").keyup(function(){
    //     $("#streetname").css("border-color", 'black');
    //    $("#streetNameErr").hide();
    // });
    // $("#username").keyup(function(){
    //     $("#username").css("border-color", 'black');
    //    $("#userNameErr").hide();
    // });
    $("#pwd").keyup(function(){
        $("#pwd").css("border-color", 'black');
       $("#pwdErr").hide();


       if($("#pwd").val().length == 0)
       {

           $(".progress").hide();
           $(".progress-bar").hide();
            $("#pwdstatus").hide();
              // $("#pwdErr").text("This field can't be left blank");
              $("#pwd").css("border-color", 'red');
              $("#pwdErr").css("color", 'red');
              $("#pwd").focus();
                   return false;
        }
        else if($("#pwd").val().length > 0) {
          $(".progress").show();
          $(".progress-bar").show();
           $("#pwdstatus").show();


        }


    });

      $("#repwd").keyup(function(){
        $("#repwd").css("border-color", 'black');
       $("#repwdErr").hide();
    });


    $("#submitReg").click(function()
    {


    //
    //     if ($("#businessnameID").val().length == 0){
    //             $("#bizNameErr").text("name field can't be left blank");
    //             $("#businessnameID").css("border-color", 'red');
    //             $("#bizNameErr").show();
    //             $("#bizNameErr").css("color", 'red');
    //             $("#businessnameID").focus();
    //              return false;
    //   }
    //
    //
    //
    // else if($("#bizcategory").val() === "Select service category..."){
    //       $("#serviceErr").text("Select your service");
    //       $("#bizcategory").css("border-color", 'red');
    //       $("#serviceErr").css("color", 'red');
    //       $("#bizcategory").focus();
    //             return false;
    //   }
    //
    //     else if($("#email").val().length == 0){
    //         $("#emailErr").text("email can't be left blank");
    //         $("#email").css("border-color", 'red');
    //         $("#emailErr").css("color", 'red');
    //         $("#email").focus();
    //             return false;
    //   }
    //
    //     else if($("#phonenumber").val().length == 0){
    //         $("#phoneErr").text("Provide Phone Number");
    //         $("#phonenumber").css("border-color", 'red');
    //         $("#phoneErr").css("color", 'red');
    //         $("#phonenumber").focus();
    //             return false;
    //   }
    //
    //
    //  else  if(/[a-z]/i.test($("#phonenumber").val()) || /^[a-zA-Z!@#£$%^&*()_!`¬\-=\~[\]{};':"\\|,./<>\/?]*$/.test($("#phonenumber").val())){
    //         $("#phoneErr").text("Invalid value");
    //         $("#phonenumber").css("border-color", 'red');
    //         $("#phoneErr").css("color", 'red');
    //          $("#phonenumber").focus();
    //             return false;
    //   }
    //
    //     else if($("#streetnumber").val().length == 0){
    //         $("#buildingNumberErr").text("This field can't be left blank");
    //         $("#streetnumber").css("border-color", 'red');
    //         $("#buildingNumberErr").css("color", 'red');
    //         $("#streetnumber").focus();
    //             return false;
    //   }
    //
    //   else  if(/[a-z]/i.test($("#streetnumber").val()) || /^[a-zA-Z!@#£$%^&*()+_!`¬\-=\~[\]{};':"\\|,./<>\/?]*$/.test($("#streetnumber").val())){
    //         $("#buildingNumberErr").text("Invalid value");
    //         $("#streetnumber").css("border-color", 'red');
    //         $("#buildingNumberErr").css("color", 'red');
    //          $("#streetnumber").focus();
    //             return false;
    //   }
    //
    //    else if($("#streetname").val().length == 0){
    //         $("#streetNameErr").text("This field can't be left blank");
    //         $("#streetname").css("border-color", 'red');
    //         $("#streetNameErr").css("color", 'red');
    //         $("#streetname").focus();
    //             return false;
    //   }
    //
    //
    //
    //     else if($("#area").val() === "Select area of service..."){
    //         $("#areaErr").text("Select area of service...");
    //         $("#area").css("border-color", 'red');
    //         $("#areaErr").css("color", 'red');
    //          $("#area").focus();
    //              return false;
    //   }
    //
    //     else if($("#username").val().length == 0){
    //         $("#userNameErr").text("This field can't be left blank");
    //         $("#username").css("border-color", 'red');
    //         $("#userNameErr").css("color", 'red');
    //         $("#username").focus();
    //              return false;
    //   }
    //   else if($("#username").val().length < 6){
    //       $("#userNameErr").text("The minimum lenght accepted for username is 8");
    //       $("#username").focus();
    //       return false;
    //   }

     if($("#pwd").val().length == 0)
     {

         $(".progress").hide();
      //   $(".progress-bar").show();
            // $("#pwdErr").text("This field can't be left blank");
            $("#pwd").css("border-color", 'red');
            $("#pwdErr").css("color", 'red');
            $("#pwd").focus();
                 return false;
      }

      //check for minimum password length
      else if($("#pwd").val().length < 10){
         $("#pwdErr").text("The minimum length accepted for password is 10");
         $("#pwd").focus();
         return false;
      }


        else if($("#repwd").val()!==$("#pwd").val()){
            $("#repwdErr").text("password do not match");
            $("#repwd").css("border-color", 'red');
            $("#repwdErr").css("color", 'red');
            $("#repwd").focus();
                 return false;
      }

      else {
          return true;
      }

    });
});


$(document).ready(function(){
       $("#repwd").keyup(function(){
           $("#repwdErr").show();
           if($("#repwd").val()!==$("#pwd").val()){
            $("#repwdErr").text("password do not match");
            $("#repwd").css("border-color", 'red');
            $("#repwdErr").css("color", 'red');
            $("#repwd").focus();
                 return false;
      }
      else{
          $("#repwdErr").hide();
          $("#repwd").css("border-color", 'black');
      }
       });
       });

//coding password meter
$(document).ready(function()
{
    $(".progress").hide();
    $("#pwd").keyup(function(){
      //  $(".progress").show();
      //  $(".progress-bar").show();
   //var regularexpression = [/[a-z]/g,/[A-Z]/g,/\d/,/[\!\"\£\$\%\^\&\*\(\)\_\-\+\=\[\{\]\}\;\:\'\@\/\?\\|`¬.>,<\ ]/];
   var pwdlength = 10;
   var pwdscore = 0;
   //var pwdrank = [ 20, 60, 80, 100];
   var pwddesc = [ 'Weak', 'Good', 'Strong', 'Very Strong'];
   var color = ["red",  "orange", "green", "darkgreen"];


  if (/[a-z]/.test($("#pwd").val())){
           pwdscore += 20;
       }
       if($("#pwd").val().length >= 25){
           pwdscore += 80;
       }
   if (/[A-Z]/.test($("#pwd").val())){
           pwdscore += 20;
       }
     if (/\d/.test($("#pwd").val())){
           pwdscore += 20;
       }
   if (/[\!\"\£\$\%\^\&\*\(\)\_\-\+\=\[\{\]\}\;\:\'\@\/\?\\|`¬.>,<\ ]/.test($("#pwd").val())){
           pwdscore += 20;
       }
   if($("#pwd").val().length >= pwdlength){
       pwdscore += 20;
   }


   if (pwdscore >= 100) {
       $(".progress").show();
       $(".progress-bar").css("width", '100%');
       $(".progress-bar").css("background-color", color[3]);
       $("#pwdstatus").text(pwddesc[3]);

   }
  if(pwdscore == 80 ){
       $(".progress").show();
       $(".progress-bar").css("width", '80%');
       $(".progress-bar").css("background-color", color[2]);

       $("#pwdstatus").text(pwddesc[2]);
   }
   if(pwdscore == 60){

       $(".progress").show();
       $(".progress-bar").css("width", '60%');
       $(".progress-bar").css("background-color", color[1]);

       $("#pwdstatus").text(pwddesc[1]);
   }
   if(pwdscore == 40 || pwdscore == 20 ){

       $(".progress").show();
       $(".progress-bar").css("width", '40%');
       $(".progress-bar").css("background-color", color[0]);

       $("#pwdstatus").text(pwddesc[0]);
   }
//   else if(pwdscore >= pwdrank[0]){
//
//       $(".progress").show();
//       $(".progress-bar").css("width", '20%');
//       $(".progress-bar").css("background-color", color[0]);
//
//       $("#pwdstatus").text(pwddesc[0]);
//   }

});
});
