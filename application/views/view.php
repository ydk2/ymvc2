<?php
	use \System\helpers\Intl as Intl;
	use \System\helpers\Helpers as Helpers;
	use \System\helpers\toAscii as toAscii;
	use \core\Router as Router;
	use \core\Helper as Helper;
	use \core\Controllers as Controllers;
	use \Data\Config\Config as Config;

$this->visable=FALSE;
$this->access=ACCESS_USER;
if($this->Controller(CONTROLLER."core")):

?>

    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading" >
                <h3 class="panel-title"><?=$this -> viewdata('title') ?></h3>
              </div>
              <div class="panel-body">
                <p><?=$this -> viewdata('text') ?></p>
                <p><?=Helper::Server('DOCUMENT_ROOT').' '.Helper::Server('PHP_SELF')?></p>
                <?php ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php else: ?>
<?php endif; ?>

