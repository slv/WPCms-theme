<?php

Class WPCmsDatePicker Extends WPCmsField {
  function __construct ($config)
  {
    //default options:
    $this->options = array(
      'monthNames' => array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"),
      'dayNamesMin' => array("do","lu","ma","me","gi","ve","sa"),
      'dateFormat' => 'd MM yy',
      'altFormat' => 'yy-mm-dd',
      'firstDay' => 1,
      'numberOfMonths' => 3,
      'showWeek' => 0,
      'autoSize' => 0
    );

    if (isset($config['options']))
     $this->options = array_merge($this->options, $config['options']);

    if (isset($config['maxDate']))
      $this->maxDate = $config['maxDate'];

    if (isset($config['minDate']))
      $this->minDate = $config['minDate'];

    parent::__construct($config);
  }

  public function addActionAdminEnqueueScripts ($hook)
  {
    wp_enqueue_style('jquery.ui.theme', WPCMS_STYLESHEET_URI . '/WPCms/assets/jquery-ui-datepicker/css/jquery-ui-1.10.2.custom.min.css');
    wp_enqueue_script('jquery-ui-datepicker');
  }

  public function renderInnerInput ($post, $data = array())
  {
    $startdate = 'null';
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['value'])){
      $date = explode('-', $data['value']);
      $startdate = "new Date($date[0], $date[1] - 1, $date[2])";
    } ?>
    <div class="jquery-ui-datepicker">
      <input type="hidden" name="<?php echo $data['name']?>" id="hidden-<?php echo $data['id'] ?>" value="<?php echo esc_attr($data['value']) ?>">
      <input style="cursor:pointer" type="text" name="pretty-<?php echo $data['name'] ?>" id="<?php echo $data['id'] ?>" size="30" autocomplete="off" readonly>
      <div></div>
      <script type="application/javascript">
        jQuery(document).ready(function ($) {
          var options = <?php echo json_encode($this->options) ?>;
          options.altField = '#hidden-<?php echo $data['name']?>';

          <?php if (isset($this->maxDate)): ?>
            if ($('input#hidden-wpcms_<?php echo $this->maxDate ?>').length)
              options.beforeShow = function() {return {maxDate: new Date($('input#hidden-wpcms_<?php echo $this->maxDate ?>').val())}};
          <?php endif ?>
          <?php if (isset($this->minDate)): ?>
            if ($('input#hidden-wpcms_<?php echo $this->minDate ?>').length)
              options.beforeShow = function() {return {minDate: new Date($('input#hidden-wpcms_<?php echo $this->minDate ?>').val())}};
          <?php endif ?>
          $("#<?php echo $data['id']?>").datepicker(options);
          $("#<?php echo $data['id']?>").datepicker("setDate", <?php echo $startdate ?>);
        })
      </script>
    </div>
    <?php
  }

}