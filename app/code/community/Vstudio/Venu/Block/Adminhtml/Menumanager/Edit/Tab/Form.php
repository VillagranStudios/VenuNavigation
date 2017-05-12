<?php

class Vstudio_Venu_Block_Adminhtml_MenuManager_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

     public function __construct()
    {
        parent::__construct();
        $this->setTemplate('vstudio/venu/edit/tab/form.phtml');
    }

	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('menu_edit_form', array('legend' => Mage::helper('vstudio_venu')->__('Menu  information')));
		$options = Mage::getSingleton('vstudio_venu/options');

		$fieldset->addType('notice', 'Vstudio_Venu_Block_Adminhtml_Form_Field_Renderer_Notice');     
			
		$fieldset->addField('instruction', 'notice', array(
				'name'      => 'instructions',
				'text'     => 'After you click save and continue you will be able to see your custom link on the Menu Information tab'
		));


		$fieldset->addField('menu_title', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu Title'),
			'class' => 'required-entry',
			'required' => true,
			'name' => 'menu_title',
		));

		$fieldset->addField('menu_orientation', 'select', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu Orientation'),
			'name' => "menu_options[menu_orientation]",
			'values' => $options->getOptionOrientation(),
		));

		$fieldset->addField('menu_status', 'select', array(
			'label' => Mage::helper('vstudio_venu')->__('Status'),
			'name' => 'menu_status',
			'values' => $options->getOptionStatus(),
		));

		$fieldset->addField('advance_options', 'hidden', array('after_element_html' => '<button class="scalable save" type="button" title="Edit Menu Item" id="hide_advance">
									 <span><span><span>Show Advance Options</span></span></span></button>
									 <script>
									 document.observe("dom:loaded", function() {
									  	$$(\'.advance-options\').invoke(\'up\').invoke(\'up\').invoke(\'hide\');
										 $(\'hide_advance\').observe(\'click\', function(event) {
											 $$(\'.advance-options\').invoke(\'up\').invoke(\'up\').invoke(\'toggle\');
											});
									 });
									 </script>', ));
		$fieldset->addField('menu_css_id', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu CSS Id'),
			'name' => "menu_options[menu_css_id]",
			'class' => 'advance-options',
			'after_element_html' => '<p class="note"><span>The ID that is applied to the ul element which encloses the menu items.</span></p>',
		));
		$fieldset->addField('menu_css_class', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu CSS Class'),
			'name' => "menu_options[menu_css_class]",
			'class' => 'advance-options',
			'after_element_html' => '<p class="note"><span>The class that is applied to the ul element which encloses the menu items.</span></p>',
		));

		$fieldset->addField('container_id', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu container id'),
			'name' => "menu_options[container_id]",
			'class' => 'advance-options',
			'after_element_html' => '<p class="note"><span>The css id that is applied to the container</span></p>',
		));
		$fieldset->addField('container_class', 'text', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu container class'),
			'name' => "menu_options[container_class]",
			'class' => 'advance-options',
			'after_element_html' => '<p class="note"><span>The css class that is applied to the container</span></p>',
		));
		$fieldset->addField('menu_container', 'select', array(
			'label' => Mage::helper('vstudio_venu')->__('Menu Container'),
			'class' => 'advance-options',
			'name' => "menu_options[menu_container]",
			'onclick' => "",
			'onchange' => "",
			'value' => '4',
			'values' => array(
				'1' => array(
					'value' => 'nav',
					'label' => 'Use a nav'
				),
				'2' => array(
					'value' => 'div',
					'label' => 'Use a div'
				),
				'3' => array(
					'value' => 'none',
					'label' => 'Use nothing'
				),
			),
			'after_element_html' => '<p class="note"><span>Whether to wrap the ul, You can use div and nav tags</span></p>',
		));

		/** set form data **/
		if (Mage::getSingleton('adminhtml/session')->getVenuData()) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getVenuData());
			Mage::getSingleton('adminhtml/session')->setVenuData(null);
		} elseif (Mage::registry('venu_data')) {

			$data = Mage::registry('venu_data')->getData();
			// decode menu options and add it to the right field
			if ( ! empty($data['menu_options'])) {
				$options = json_decode($data['menu_options']);
				foreach ($options as $option => $value) {
					$data[$option] = $value;
				}
			}
			$menuItems = Mage::registry('venu_data')->getData('menu_items');
			$form->setValues($data);

			$code = Mage::registry('venu_data')->getData('menu_code');
			if ( ! empty($code)) {
				$fieldset->addField('menu_code', 'textarea', array(
					'label' => Mage::helper('vstudio_venu')->__('Menu Code'),
					'name' => 'menu_code',
					'value' => $code,
					'onclick' => "this.select();",
					'after_element_html' => '<p class="note">
											 <span style="width:100%; color:red;">
											 Use this to add this menu into pages,
											 category pages or static blocks
											 </span></p>',
				));
			}

			if ($menuItems > 0 && ! empty($menuItems)) {
				$field = 0;

				$this->_sortFields($menuItems, SORT_ASC, 'sort_order');
				foreach ($menuItems as $item) {
					$fieldset = $form->addFieldset("menu_edit_form_$field", array('legend' => Mage::helper('vstudio_venu')->__("Menu Item {$item['item_label']}  Menu Id : {$item['id']}")));

					$fieldset->addField('item_collapse_' . $field, 'hidden', array(
						'label' => Mage::helper('vstudio_venu')->__('Navigation Label'),
						'after_element_html' => '<button style="" onclick="$$(\'#menu_edit_form_' . $field . ' tr:gt(0) \').invoke(\'toggle\')" class="scalable save" type="button" title="Edit Menu Item" id=""><span><span><span>Edit Menu Link</span></span></span></button>',
					));
					$fieldset->addField('item_label_' . $field, 'text', array(
						'label' => Mage::helper('vstudio_venu')->__('Navigation Label'),
						'name' => 'item[' . $item['id'] . '][item_label]',
						'value' => $item['item_label'],
					));
					$fieldset->addField('item_hidden_' . $field, 'hidden', array(
						'label' => Mage::helper('vstudio_venu')->__('Navigation Label'),
						'name' => 'item[' . $item['id'] . '][id]',
						'value' => $item['id'],
					));
					$fieldset->addField('item_link_' . $field, 'text', array(
						'label' => Mage::helper('vstudio_venu')->__('Url Link'),
						'name' => 'item[' . $item['id'] . '][item_link]',
						'value' => urldecode($item['item_link']),
					));
					$fieldset->addField('sort_order_' . $field, 'text', array(
						'label' => Mage::helper('vstudio_venu')->__('Menu Item Position'),
						'name' => 'item[' . $item['id'] . '][sort_order]',
						'style' => 'width:30%;',
						'value' => $item['sort_order'],
					));
					$fieldset->addField('parent_id_' . $field, 'text', array(
						'label' => Mage::helper('vstudio_venu')->__('Parent Id'),
						'name' => 'item[' . $item['id'] . '][parent_id]',
						'style' => 'width:30%;',
						'value' => $item['parent_id'],
					));
					$fieldset->addField('delete_' . $field, 'checkbox', array(
						'label' => Mage::helper('vstudio_venu')->__('Delete Menu Item'),
						'name' => 'item[' . $item['id'] . '][delete]',
						'value' => $item['id'],
					));

					$fieldset->addField('hide_elements_' . $field, 'hidden', array(
						'label' => Mage::helper('vstudio_venu')->__('Navigation Label'),
						'after_element_html' => '<script>document.observe("dom:loaded", function() {  $$(\'#menu_edit_form_' . $field . ' tr:gt(0) \').invoke(\'hide\'); });</script>',
					));

					$field++;
				}
			}
		}
		return parent::_prepareForm();
	}

	
    protected function _getVenuData(){

        $formData = NULL;

        /** set form data **/
		if (Mage::getSingleton('adminhtml/session')->getVenuData()) {
			$formData = Mage::getSingleton('adminhtml/session')->getVenuData();
			Mage::getSingleton('adminhtml/session')->setVenuData(null);
		} elseif (Mage::registry('venu_data')) {

           
			$formData = Mage::registry('venu_data')->getData();
			// decode menu options and add it to the right field
			if ( ! empty($formData['menu_options'])) {
				$options = json_decode($formData['menu_options']);
				foreach ($options as $option => $value) {
					$formData[$option] = $value;
				}
                unset($formData['menu_options']);
			}

			$menuItems = Mage::registry('venu_data')->getData('menu_items');
            if (!empty($menuItems)) {
                $this->_sortFields($menuItems, SORT_ASC, 'sort_order');
                $formData['menu_items'] = $menuItems;
            }

		}

        return $formData;
    }

    
    /**
	 * Sort a multidimensional array by reference
	 *
	 * @param $data array
	 * @param $order order to be sorted
	 * @param $sortBy key to be sorted
	 */
	protected function _sortFields(&$data, $order = SORT_ASC, $sortBy = 'sort_order') {
		// Obtain a list of columns
		foreach ($data as $key => $row) {
			$sortOrder[$key] = $row[$sortBy];
		}

		// Sort the data with $sortBy ascending, edition ascending
		// Add $data as the last parameter, to sort by the common key
		array_multisort($sortOrder, $order, $data);
	}

}
