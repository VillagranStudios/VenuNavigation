<?php
/**
 * Villagran Studios
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Vtudio
 * @package     Vstudio_Venu
 * @copyright  Copyright (c) 2011-2017 Villagran Studios. and affiliates (http://www.villagranstudios.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Custom Link block
 *
 * @category   Vstudio
 * @package    Vstudio_Venu
 * @author     VillagranStudios Team <support@villagranstudios.com>
 */
 
class Vstudio_Venu_Block_Adminhtml_Form_Field_Renderer_Notice extends  Varien_Data_Form_Element_Abstract
{
    protected $_element;

    public function getElementHtml()
    {   
        $html = '<p id="'.$this->getHtmlId().'" '.$this->serialize($this->getHtmlAttributes()).'>'.$this->getText().'<p/>';
        $html .= $this->getAfterElementHtml();
        return $html;
    }
}