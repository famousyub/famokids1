<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles the output of the text editor used on many sections
 * of the site.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: editor.class.php 6599 2013-09-06 08:18:37Z phpFox LLC $
 */
class Phpfox_Editor
{
	/**
	 * ARRAY of default buttons for text editor.
	 *
	 */
	private $_aButtons = array(
		array(
			'image' => 'text_bold.png',
			'command' => 'b',
			'phrase' => 'core.bold'
		),
		array(
			'image' => 'text_italic.png',
			'command' => 'i',
			'phrase' => 'core.italic'
		),
		array(
			'image' => 'text_underline.png',
			'command' => 'u',
			'phrase' => 'core.underline'
		),
		array(
			'separator'
		),
		array(
			'image' => 'text_align_left.png',
			'command' => 'left',
			'phrase' => 'core.align_left'
		),
		array(
			'image' => 'text_align_center.png',
			'command' => 'center',
			'phrase' => 'core.align_center'
		),
		array(
			'image' => 'text_align_right.png',
			'command' => 'right',
			'phrase' => 'core.align_right'
		),
		array(
			'separator'
		),
		array(
			'image' => 'text_list_bullets.png',
			'js' => "Editor.getList(\'bullet\');",
			'phrase' => 'core.bullets'
		),
		array(
			'image' => 'text_list_numbers.png',
			'js' => "Editor.getList(\'number\');",
			'phrase' => 'core.ordered_list'
		),
		array(
			'separator'
		)
	);
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
		(($sPlugin = Phpfox_Plugin::get('editor_construct')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Gets the HTML output of the current textarea editor.
	 *
	 * @param string $iId ID of the textarea name, which also creates a unique ID for the HTML <textarea>
	 * @param array $aParams Any special params that the specific form behaves different from other forms can be passed here.
	 * @return string Returns the HTML output of the <textarea>
	 */
	public function get($iId, $aParams = array())
	{				
		$sStr = '';
		if (isset($aParams['user_group_setting']) && Phpfox::getUserParam($aParams['user_group_setting']) == false)
		{
			$sStr .= '<div class="close_warning" id="layer_' . $iId . '"><textarea name="val[' . (isset($aParams['name']) ? $aParams['name'] : $iId) . ']" rows="' . (isset($aParams['rows']) ? $aParams['rows'] : '12') . '" cols="' . (isset($aParams['cols']) ? $aParams['cols'] : '50') . '" style="width:98%;">' . $this->getValue($iId) . '</textarea></div>';
			return $sStr;
		}
        $placeholder = '';
        if (isset($aParams['placeholder'])) {
            $placeholder = ' placeholder="' . (Core\Lib::phrase()->isPhrase($aParams['placeholder']) ? _p($aParams['placeholder']) : $aParams['placeholder']) . '" ';
        }
        $sStr .= '<div class="edit_menu_container">' . "\n";

        (($sPlugin = Phpfox_Plugin::get('get_editor_mid')) ? eval($sPlugin) : false);

        $sStr .= '<script type="text/javascript">$Behavior.getEditor = function() { Editor.setId(\'' . $iId . '\'); };</script>' . "\n";

        $sStr .= '<div id="layer_' . $iId . '"><textarea ' .(isset($aParams['props'])?$aParams['props']: ' '). $placeholder . (isset($aParams['enter']) ? 'class="form-control on_enter_submit close_warning"' : 'class="form-control close_warning"') . ' name="val[' . (isset($aParams['name']) ? $aParams['name'] : $iId) . ']" rows="' . (isset($aParams['rows']) ? $aParams['rows'] : '12') . '" cols="' . (isset($aParams['cols']) ? $aParams['cols'] : '50') . '" id="' . $iId . '"' . (isset($aParams['tabindex']) ? ' tabindex="' . $aParams['tabindex'] . '"' : '') . '>' . $this->getValue($iId, (isset($aParams['default_value']) ? $aParams['default_value'] : null)) . '</textarea></div>';
        $sStr .= "\n" . '</div>';

        (($sPlugin = Phpfox_Plugin::get('get_editor_end')) ? eval($sPlugin) : false);


		return $sStr;
	}
	
	/**
	 * Gets the $_POST form value based on the ID passed.
	 *
	 * @param string $iId ID of the <textarea> form
	 * @return string Returns the value if we can find it, if not the value is blank.
	 */
	public function getValue($iId, $sDefaultValue = null)
	{
		if (!($aParams = Phpfox_Request::instance()->getArray('val')))
		{
			$aParams = Phpfox_Template::instance()->getVar('aForms');
		}
		return (isset($aParams[$iId]) ? Phpfox::getLib('parse.output')->clean($aParams[$iId]) : ($sDefaultValue === null ? '' : $sDefaultValue));
	}
	
	/**
	 * Get all the buttons for an editor.
	 *
	 * @return array Returns ARRAY of buttons.
	 */
	public function getButtons()
	{
		if (defined('PHPFOX_INSTALLER'))
		{
			return $this->_aButtons;
		}
		
		foreach ($this->_aButtons as $iKey => $aValue)
		{
			if (isset($aValue['image']))
			{
				$this->_aButtons[$iKey]['image'] = Phpfox_Template::instance()->getStyle('image', 'editor/' . $aValue['image']);
			}
			if (isset($aValue['phrase']))
			{
				if (strpos($aValue['phrase'], '.'))
				{
					$this->_aButtons[$iKey]['phrase'] = _p($aValue['phrase']);
				}
			}
		}		
				
		return $this->_aButtons;	
	}
}