#Venu Menu Navigation

##Introduction:

Create simple but versatile menu navigation from CMS pages, Categories URLs, or external URLs. Each element has css class so you can address any element by standard css.

##Features:

Upgrade Proof Module.
Tested for Magento version 1.7.0.0 - 1.9.3.2
Supports php version 5.5.11
 Easy to install nothing to configure.
Valid HTML5 structure
Valid CSS
Support for vertical or horizontal menu orientation
Drop-down menu when using the horizontal menu
Fly-out menu when using the vertical menu
You can easily add any menu to pages, static block, or categories pages by copying and pasting the block code that gets generated every time you create a new menu.
 

##Installation / Configuration:

After installation, make sure to clear you cache then:
To create menus navigate to Menu >> Manage Menus
After installation a sample menu will be added to the footer of you website.
To disable the sample menu simply copy the venu.xml file located in MageDirectory\app\design\frontend\default\default\layout  to your theme directory and remove the block reference to the sample menu.
To use Menu in your CMS pages use:
{{block type="vstudio_venu/menu" block_id="sample_menu" template="vstudio/venu/menu.phtml" menu_title="Sample Menu"}}
 NOTE: Here menu_title will be replaced with the menu name you created.
