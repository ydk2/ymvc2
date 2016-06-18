<?php
if($this->Controller(SCONTROLLER."Theme",MODEL."model")):
$this->action->viewdata = array_merge($this->action->viewdata, $this->action->model->viewdata);
$this->viewdata=$this->action->viewdata;
?>
  </body>

</html>
<?php endif; ?>