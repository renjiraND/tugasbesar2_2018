<!DOCTYPE html>
<html>
<head>
  <title>Register Form</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
  <link rel="stylesheet" type="text/css" href="../css/register.css">
  <script type="text/javascript" src="../js/validate.js"></script>
</head>
<body>
  <div class="flex center">
    <div class="register-box register-bg">
      <div class="flex center-horizontal text-size-very-large font-title text-bold">R E G I S T E R</div>
      <div class="flex center">
        <form class="margin-top-medium margin-bot-medium center-horizontal" method="POST" name="reg-form" onsubmit="return validateAll()" action="../php/register-action.php" id="credentials">
          <div class="flex row center align-right">
            <div class="margin-right-small font-default"> Name </div>
            <input class="input-medium flex align-right border-radius font-field" type="text" name="input-name">
          </div>
          <div class="flex row center margin-top-small align-right">
            <div class="margin-right-small font-default"> Username </div>
            <input class="input-small flex align-right border-radius fakecheck font-field" type="text" name="input-username" id="inputuser" onkeyup="validateUserAjax(this.value)">
            <img id="check-user" class="checkvalid hide" src="../res/misc/validcheck.png">
          </div>
          <div class="flex row center margin-top-small align-right">
            <div class="margin-right-small font-default"> Email </div>
            <input class="input-small flex align-right border-radius fakecheck font-field" type="text" name="input-email" id="inputemail" onkeyup="validateEmailAjax(this.value)">
            <img id="check-email" class="checkvalid hide" src="../res/misc/validcheck.png">
          </div>
          <div class="flex row center margin-top-small align-right">
            <div class="margin-right-small font-default"> Password </div>
            <input class="input-medium flex align-right border-radius font-field" type="password" name="input-password">
          </div>
          <div class="flex row center margin-top-small align-right">
            <div class="margin-right-small font-default"> Confirm Password </div>
            <input class="input-medium flex align-right border-radius font-field" type="password" name="input-password2">
          </div>
          <div class="flex row center-horizontal margin-top-small align-right">
            <div class="margin-right-small font-default"> Address </div>
            <textarea class="input-large flex align-right border-radius font-field" type="text" name="input-address"></textarea>
          </div>
          <div class="flex row center margin-top-small align-right">
            <div class="margin-right-small font-default"> Phone Number </div>
            <input class="input-medium flex align-right border-radius font-field" type="tel" name="input-phone-number">
          </div>
          <div class="flex row center margin-top-small align-right">
            <div class="margin-right-small font-default"> Card Number </div>
            <input class="input-medium flex align-right border-radius font-field" type="tel" name="input-card-number">
          </div>
        </form>
      </div>
      <div class="margin-left-small">
        <a href="login.php" class="text-color-black text-size-very-very-small font-default">Already have an account?</a>
      </div>
      <div class="flex center margin-top-medium">
        <button class="btn-register text-color-orange bg-color-white text-bold font-default" type="submit" form="credentials">R E G I S T E R</button>
      </div>
    </div>
  </div>
</body>
</html>
