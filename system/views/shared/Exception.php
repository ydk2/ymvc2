<?php

if($this->Controller(SCONTROLLER.'shared/errors')):
	$this->action->e_values(array($this->ecode,$this->etitle,$this->etitle_error,$this->etext_error));
?>
<!DOCTYPE HTML>
<html>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
    rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
    rel="stylesheet" type="text/css">
    <title><?=$this ->ViewData('title') ?></title>
  </head>
  
  <body>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <h3 class="panel-title"><?=$this -> viewdata('title') ?> <?=$this -> viewdata('title_error') ?></h3>
              </div>
              <div class="panel-body">
              	<p> <?=$this -> viewdata('text_error') ?><?=$this -> viewdata('num_error')?> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
<?php endif; ?>
