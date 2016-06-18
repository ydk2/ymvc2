<?php

if($this->Controller(SCONTROLLER."errors")):
$this->viewdata=$this->action->viewdata;
?>

    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><?=$this->viewdata['title']?> <?=$this->viewdata['title_notexist']?></h3>
              </div>
              <div class="panel-body">
                <p><?=$this->viewdata['text_notexist']?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php endif; ?>
