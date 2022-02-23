<?php 
defined('PHPFOX') or exit('NO DICE!');
?>

<div id="client_details">
    <form method="post" action="#key" id="js_form" class="form">
        <h1>
            License Information
        </h1>
        <div class="help-block">
           <center><strong>Enter "prowebber" in License ID and License Key.</center></strong>
        </div>

        <div id="errors" class="hide"></div>
        <div><input type="hidden" id="license_trial" name="val[is_trial]" value="0"></div>
        <div class="form-group">
            <label class="control-label">License ID</label>
            <input autofocus autocomplete="off" type="text" name="val[license_id]" id="license_id" value="{value type='input' id='license_id'}" size="30" placeholder="Enter your license id" class="form-control"/>
        </div>
        <div class="form-group">
            <label class="control-label">License Key</label>
            <input autocomplete="off" type="text" name="val[license_key]" id="license_key" value="{value type='input' id='license_key'}" size="30" placeholder="Enter your license key" class="form-control"/>
        </div>
        <input type="submit" value="Continue" class="hide" name="val[submit]"/>
        <div class="help-block">
        PROWEBBER.ru - 2019
        </div>
    </form>
</div>