<?php require 'function.php';
$user = include 'user.php';
if(isAuth($user)){
  header('Location: ./index.php');
  exit;
}
if(!empty($_POST['name'])){
  logIn($_POST['name'], $_POST['pass'],$user);
  header('Location: ./index.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
		<link href="./css/jqvmap.css" rel="stylesheet">
    <link href="./css/nouislider.min.css" rel="stylesheet">

    <title>Вхід</title>
  </head>
  <style>
  html,
  body {
  height: 100%;
  }

  body {
  display: -ms-flexbox;
  display: -webkit-box;
  display: flex;
  -ms-flex-align: center;
  -ms-flex-pack: center;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
  }

  .form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
  }
  .form-signin .checkbox {
  font-weight: 400;
  }
  .form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
  }
  .form-signin .form-control:focus {
  z-index: 2;
  }
  .form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
  }
  .form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  }
  </style>
  <body class="text-center">
    <form class="form-signin" action="" method="post">
      <label for="inputEmail" class="sr-only">Адреса електронної пошти</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="name">
      <label for="inputPassword" class="sr-only">Пароль</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="pass">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Вхід </button>
    </form>
  </body>
</html>

<?php R::close(); ?>
