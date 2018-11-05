<?php require 'function.php';
$user = include 'user.php';
if(!isAuth($user)){
  header('Location: ./login.php');
  exit;
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
    <link href="./css/style.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <title>Карта Украины</title>
  </head>
  <body>
  <script>var startValues = <?php echo getRangeData(); ?>;</script>
   <nav class="navbar navbar-light bg-light justify-content-between">
              <div class="container">
                  <a class="navbar-brand" href="#"></a>
                  <button class="btn btn-outline-danger my-2 my-sm-0" id="logout">Вихід</button>
              </div>
            </nav>
    <div class="container" style="margin: 20px auto;">
			<div class="row">
				<form class="text-center col-12 card" action="" method="get">
					<div class="form-row card-body">

            <div class="form-group col-12">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vizualType" id="vizualType1" value="1" checked>
                <label class="form-check-label" for="inlineRadio1">Кількість</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vizualType" id="vizualType2" value="2">
                <label class="form-check-label" for="inlineRadio2">Сума</label>
              </div>
            </div>

            <?php echo getGroupSelect(R::getAll('select * from groups')); ?>
						<?php echo getDrugSelect(R::getAll('select * from drug')); ?>
						<?php echo getDistrSelect(R::getAll('select * from distr')); ?>

            <script type="text/javascript">
              var dates = <?php echo getDateJson(R::getAll('select * from date')); ?>;
            </script>

            <div class="form-group col-12">
							<label for="date" id='dataLable'></label>
							<div id="range"></div>
                              <input type="text" id="range-l" name="range-l" value="1" hidden>
                              <input type="text" id="range-h" name="range-h" value="24" hidden>
						</div>
                        <div class="text-center col-12">
                          <button type="submit" class="btn btn-primary search">Пошук</button>
                          <a href="./index.php" class="btn btn-warning search">Cброс</a>
                        </div>
					</div>
				</form>
			</div>
		</div>
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Карта</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Гістограма</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Таблиця</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div id='print3'>
                        <p class="text-md-center" id='map-p'></p>
  						<div id="ua"></div>
  						<div id="legend"></div>
  						<div style="display:none">
                          <div id="pin">...</div>
                        </div>
  				</div>
          <div class="text-center col-12">
            <button class="btn btn-warning" style="margin: 20px;" onclick="toPDF('print3')">Зберегти в PDF</button>
          </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <script type="text/javascript">
            var dataGroupChart = <?php echo getGroupChartData(); ?>;
          </script>
          <div class="text-center" id="print">
              <p class="text-md-center" id='chart-p'></p>
              <canvas id="bar-chart-grouped" width="600" height="400" style="padding: 1em; padding-top: 5em;"></canvas>
          </div>
          <div class="text-center col-12">
            <button class="btn btn-warning" style="margin: 20px;" onclick="toPDF('print')">Зберегти в PDF</button>
          </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="text-center col-12">
            <a class="export btn btn-warning" style="margin-top: 20px;">Зберегти в CSV</a>
          </div>
          <div class="row">
            <div class="row card" style="margin: 50px; width: 980px;">
                <?php echo genTbl(); ?>
            </div>
          </div>
        </div>
      </div>
		</div>

    <script type="text/javascript">
      var visualDataStr = <?php echo getData(); ?>;
      var chartHide = <?php echo getChartHide(); ?>;
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="./js/jquery.min.js"></script>
		<script src="./js/jqvmap.js"></script>
		<script src="./js/ukraine.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/nouislider.min.js"></script>
    <script src="./js/html2pdf.bundle.min.js"></script>
    <script src="./js/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
		<script src="./js/script.js"></script>

    <script>

    </script>


  </body>
</html>

<?php R::close(); ?>
