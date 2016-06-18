<?php
/*
 if($this->Controller(CONTROLLER."core",MODEL."model")):
 *
 */
//$this -> viewdata=$this -> action -> viewdata;

?>
  

    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
<div id="section1" class="container-fluid">
  <h1>Section 1</h1>
  <p>Try to scroll this section and look at the navigation bar while scrolling! Try to scroll this section and look at the navigation bar while scrolling!</p>
  <p>Try to scroll this section and look at the navigation bar while scrolling! Try to scroll this section and look at the navigation bar while scrolling!</p>
</div>
<div id="section2" class="container-fluid">
  <h1>Section 2</h1>
  <p>Try to scroll this section and look at the navigation bar while scrolling! Try to scroll this section and look at the navigation bar while scrolling!</p>
  <p>Try to scroll this section and look at the navigation bar while scrolling! Try to scroll this section and look at the navigation bar while scrolling!</p>
</div>
<div id="section3" class="container-fluid">
 <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><?=$this -> viewdata('title') ?></h3>
              </div>
              <div class="panel-body">
                <p><?=$this -> viewdata('text') ?></p>
                <p><?=$this -> viewdata('data') ?></p>
                <p><?=$this -> error ?></p>
                <p><?=var_dump($this) ?></p>
              </div>
            </div></div>          
          </div>
        </div>
      </div>
    </div>
 


<?php //endif; ?>