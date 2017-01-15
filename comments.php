<?php

class Comments extends Module
{

  function __construct()
  {
    $this->name = 'comments';
    $this->tab = 'front_office_features';
    $this->author = 'Dubby';
    $this->version= '0.1';
    $this->displayName = 'My comments module';
    $this->description = 'This module allows your customers to grade and comment your products';
    $this->bootstrap = true;
    parent::__construct();
  }
// --------------------- INSTALLATION ---------------------
  public function install()
  {
    parent::install();
    $this->registerHook('displayProductTabContent');
    return true;
  }
// --------------------- END INSTALLATION ---------------------

// --------------------- CONFIGURATION ---------------------
  public function getContent()
  {
    $this->processConfiguration();
    $this->assignConfiguration();
    return; $this->display(__FILE__,'getContent.tpl');
  }

  public function processConfiguration()
  {
    if (Tools::isSubmit('mymod_pc_form'))
    {
      $enable_grades = Tools::getValue('enable_grades');
      $enable_comments = Tools::getValue('enable_comments');

      Configuration::updateValue('MYMOD_GRADES', $enable_grades);
      Configuration::updateValue('MYMOD_COMMENTS', $enable_comments);
      $this->context->smarty->assign('confirmation', 'ok');
    }
  }

  public function assignConfiguration()
  {
    $enable_grades = Configuration::get('MYMOD_GRADES');
    $enable_comments = Configuration::get('MYMOD_COMMENTS');
    $this->context->smarty->assign('enable_grades', $enable_grades);
    $this->context->smarty->assign('enable_comments', $enable_comments);

  }
// --------------------- END CONFIGURATION ---------------------

// --------------------- DISPLAY ON PRODUCT TAB ---------------------

  public function processProductTabContent()
  {
    if (Tools::isSubmit('mymod_pc_submit_comment'))
    {
      $id_product = Tools::getValue('id_product');
      $grade = Tools::getValue('grade');
      $comment = Tools::getValue('comment');
      $insert = array(
      'id_product' => (int)$id_product,
      'grade' => (int)$grade,
      'comment' => pSQL($comment),
      'date_add' => date('Y-m-d H:i:s')
    );
      Db::getInstance()->insert('comment', $insert);
    }
  }

  public function assignProductTabContent()
  {

    $enable_grades = Configuration::get('MYMOD_GRADES');
    $enable_comments = Configuration::get('MYMOD_COMMENTS');

    $id_product = Tools::getValue('id_product');
    $comments = Db::getInstance()->executeS('SELECT * FROM
    '._DB_PREFIX_.'comment WHERE id_product = '.(int)$id_product);
    $this->context->smarty->assign('enable_grades', $enable_grades);
    $this->context->smarty->assign('enable_comments', $enable_comments);
    $this->context->smarty->assign('comments', $comments);
  }

  public function hookDisplayProductTabContent($params)
  {
    $this->processProductTabContent();
    $this->assignProductTabContent();
    return $this->display(__FILE__, 'displayProductTabContent.tpl');
  }
// --------------------- END DISPLAY ON PRODUCT TAB ---------------------

}
 ?>
