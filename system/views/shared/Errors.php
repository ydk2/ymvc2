<?php

if($this->Controller(SCONTROLLER.'shared/errors')):
	$this->action->Register_values(array($this->ecode));
?>
<div class="section alert_fixed">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
              <div class="alert alert-danger">
              	
              	<strong><?=$this -> viewdata('title') ?> <?=$this -> viewdata('title_error') ?></strong>
              	<span> <?=$this -> viewdata('text_error') ?><?=$this -> viewdata('num_error')?> </span>
              	
              	<a href="#" class="close" data-dismiss="alert" aria-label="close">&nbsp;&nbsp;&times;</a>
       		</div>
          </div>
        </div>
      </div>
</div>
<?php endif; ?>
