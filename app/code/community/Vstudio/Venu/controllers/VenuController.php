<?php

class Vstudio_Venu_VenuController
extends Mage_Core_Controller_Front_Action {

	public function indexAction() {
		$this -> loadLayout() -> renderLayout();
	}

}
