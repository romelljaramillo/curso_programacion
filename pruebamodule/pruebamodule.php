<?php
/*
* 2019 Roanja
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to info@roanja.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade Roanja to newer
* versions in the future. If you wish to customize Roanja for your
* needs please refer to http://www.roanja.com for more information.
*
*  @author Roanja <info@roanja.com>
*  @copyright  2019 Roanja
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of Roanja
*/
/**
 * @since   1.0.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class PruebaModule extends Module 
{
    protected $_html = '';
    protected $default_title = 'Hello Word';

    public function __construct()
    {
        $this->name = 'pruebamodule';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Roanja';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->trans('Roanja mudule prueba', array(), 'Modules.Pruebamodule.Admin');
        $this->description = $this->trans('modulo de prueba para prestashop.', array(), 'Modules.Pruebamodule.Admin');
        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        if (parent::install() &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayFooter')
        ) {

            $shops = Shop::getContextListShopID();
            $shop_groups_list = array();

            foreach ($shops as $shop_id) {
                $shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

                if (!in_array($shop_group_id, $shop_groups_list)) {
                    $shop_groups_list[] = $shop_group_id;
                }

                /* Sets up configuration */
                $res = Configuration::updateValue('PRUEBA_ROANJA_TITLE', $this->default_title, false, $shop_group_id, $shop_id);
            }

            /* Sets up Shop Group configuration */
            if (count($shop_groups_list)) {
                foreach ($shop_groups_list as $shop_group_id) {
                    $res &= Configuration::updateValue('PRUEBA_ROANJA_TITLE', $this->default_title, false, $shop_group_id);
                }
            }

            /* Sets up Global configuration */
            $res &= Configuration::updateValue('PRUEBA_ROANJA_TITLE', $this->default_title);

            /* Creates tables */
            $res &= $this->createTables();

            return (bool)$res;
        }
        return false;
    }

    protected function createTables()
    {
        /* Slides */
        $res = (bool)Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prueba_shop` (
                `id_prueba` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `id_shop` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id_prueba`, `id_shop`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');

        /* Slides configuration */
        $res &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prueba` (
              `id_prueba` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `position` int(10) unsigned NOT NULL DEFAULT \'0\',
              `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
              PRIMARY KEY (`id_prueba`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');

        /* Slides lang configuration */
        $res &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prueba_lang` (
              `id_prueba` int(10) unsigned NOT NULL,
              `id_lang` int(10) unsigned NOT NULL,
              `title` varchar(255) NOT NULL,
              `url` varchar(255) NOT NULL,
              PRIMARY KEY (`id_prueba`,`id_lang`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');

        return $res;
    }
    
    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {
        /* Deletes Module */
        if (parent::uninstall()) {
            return true;
        }
        return false;
    }

    public function getContent()
    {
        $this->_html .= $this->renderForm();

        return $this->_html;
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->getTranslator()->trans('Settings', array(), 'Admin.Global'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->getTranslator()->trans('Title', array(), 'Modules.Pruebamodulo.Admin'),
                        'name' => 'PRUEBA_ROANJA_TITLE',
                        'desc' => $this->getTranslator()->trans('el titulo del modulo.', array(), 'Modules.Pruebamodulo.Admin'),
                        'class' => 'fixed-width-lg'
                    )
                ),
                'submit' => array(
                    'title' => $this->getTranslator()->trans('Save', array(), 'Admin.Actions'),
                )
            ),
        );


        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitPrueba';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));

    }

    public function getConfigFieldsValues()
    {
        $id_shop_group = Shop::getContextShopGroupID();
        $id_shop = Shop::getContextShopID();

        return array(
            'PRUEBA_ROANJA_TITLE' => Tools::getValue('PRUEBA_ROANJA_TITLE', Configuration::get('PRUEBA_ROANJA_TITLE', null, $id_shop_group, $id_shop)),
        );
    }

    public function hookDisplayTop()
    {
        return 'hello word';
    }

    public function hookDisplayFooter()
    {
        // $data = array('PRUEBA_ROANJA_TITLE' => 'Hola mundo');

        $data = $this->getConfigFieldsValues();
        // var_dump($this->getConfigFieldsValues());
        return '<p class="h4 text-uppercase block-contact-title">'. $data['PRUEBA_ROANJA_TITLE'] .'</p>';
    }
}