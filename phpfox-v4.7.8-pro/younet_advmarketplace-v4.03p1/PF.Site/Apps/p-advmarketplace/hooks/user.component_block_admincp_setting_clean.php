<?php
$aSettings = $this->template()->getVar('aSettings');
$product_id = 'younet_advmarketplace4';
if (isset($aSettings[$product_id])) {
$aModuleSettings = $aSettings[$product_id][$this->request()->get('module_id')];
$support_sponsor = "";
foreach ($aModuleSettings as $aKey => $aVal) {
    if (preg_match('/_sponsor_price/i', $aVal['name'])) {

        $aVals = Phpfox::getLib('parse.format')->isSerialized($aVal['value_actual']) ? unserialize($aVal['value_actual']) : 'No price set';
        if (is_array($aVals) && is_numeric(reset($aVals))) { // so a module can have 2 settings with currencies (music.song, music.album)
            $this->setParam('currency_value_val[value_actual][' . $aVal['setting_id'] . ']', $aVals);
        }
        $aSettings[$product_id][$this->request()->get('module_id')][$aKey]['isCurrency'] = 'Y';
        $support_sponsor = array();
        $support_sponsor[$product_id][$this->request()->get('module_id')][$aKey] = $aSettings[$product_id][$this->request()->get('module_id')][$aKey];
        $param_id = $support_sponsor[$product_id][$this->request()->get('module_id')][$aKey]['setting_id'];
    }
}

if ($support_sponsor) {
$oTemplate = Phpfox::getLib('template');

$oTemplate->assign(array(
    'aSettings' => $support_sponsor,
));
$oTemplate->getTemplate('user.block.admincp.setting');
?>

<script type="text/javascript">
  $a = $(document.getElementsByName('val[value_actual][<?php echo $param_id; ?>]'));
  var color = $a.first().parent().parent().parent().css('background-color');
  $(document.getElementsByName('val[value_actual][<?php echo $param_id; ?>]')).
    first().
    parent().
    parent().
    remove();
  if (color == 'rgb(255, 255, 255)') {
    $(document.getElementsByName('val[value_actual][<?php echo $param_id; ?>]')).
      last().
      parent().
      parent().
      removeClass('table2').
      addClass('table1');
  }
  else {
    $(document.getElementsByName('val[value_actual][<?php echo $param_id; ?>]')).
      last().
      parent().
      parent().
      removeClass('table1').
      addClass('table2');
  }
</script>

    <?php
    }
    }
    ?>