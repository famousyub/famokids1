<?php
defined('PHPFOX') or exit('NO DICE!');
/**
 * @author Neil J.<neil@phpfox.com>
 */
?>
<form method="post" action="#getdefault" id="js_form" class="form" enctype="multipart/form-data">
    <h1>Select Apps To Install</h1>
    <div id="errors" class="hide"></div>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th width="30"><input type="checkbox" onchange="installer.toggleCheckAll(this,'.check_me')"/> </th>
            <th><strong>App Name</strong></th>
            <th><strong>Version</strong></th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$aDefaultApps key=sKey value=aApp}
        <tr class="l">
            <td>
                <input type="checkbox" name="val[apps][]" value="{$sKey}" id="{$sKey}" class="check_me" />
            </td>
            <td>
                <label for="{$sKey}">{$aApp.name}</label>
            </td>
            <td>
                <a {if !empty($aApp.url)} href="{$aApp.url}"{/if} target="_blank">
                    {$aApp.version}
                </a>
            </td>
        </tr>
        {/foreach}
        </tbody>
        <textarea class="hide" name="val[apps_serialized]">{$apps_serialized}</textarea>
    </table>
    <div class="help-block">
      PROWEBBER.ru - 2019
    </div>
    <input type="hidden" value="select app" name="val[select]"/>
    <input type="hidden" class="btn btn-success" value="Continue" name="val[submit]"/>
</form>