<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VBM</title>
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>login.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" />
</head>
<body class="container-fluid d-flex justify-content-center bg-light vh-100 vw-100">
  <div class="front-title">
    <h1>
      VIRTUAL<br/>
      LAB <span>Teknik Mesin</span>
    </h1>
  </div>
  <div class="col-lg-3 col-md-5 border align-self-center bg-white shadow p-1 rounded kotak">
    <form action="<?=site_url('login')?>" method="post" accept-charset="utf-8" class="container my-4">
      <?=(isset($error_login))? $error_login : ''?>
      <h3 class="text-center">LOGIN</h3>
        <div class="form-group mt-5">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><span class="oi oi-person"></span></span>
            </div>
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="right" title="Username" name="txtuser" />
          </div>
        </div>
        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><span class="oi oi-key"></span></span>
            </div>
            <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" data-toggle="tooltip" data-placement="right" title="Password" name="txtpass" />
          </div>
        </div>
        <div class="form-group text-right">
          <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
      </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../src/index.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>