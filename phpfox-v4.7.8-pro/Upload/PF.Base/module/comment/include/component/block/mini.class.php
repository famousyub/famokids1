<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox_Component
 * @version 		$Id: mini.class.php 5840 2013-05-09 06:14:35Z phpFox LLC $
 */
class Comment_Component_Block_Mini extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($aChildComments = $this->getParam('comment_custom')))
		{
			
			$this->template()->assign(array(
					'aComment' => $aChildComments,
					'bNotMoreNestedComments' => false
				)
			);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_mini_clean')) ? eval($sPlugin) : false);
		
		$this->template()->assign('bNotMoreNestedComments', false);
	}
}