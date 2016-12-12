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
    $this->description = 'This module allows your customers to grade and comment you products';
    $this->bootstrap = true;
    parent::__construct();
  }

  public function getContent()
  {
    $this->processConfiguration();
    return $this->display(__FILE__,'getContent.tpl');
  }

  public function processConfiguration()
  {
    if (Tools::isSubmit('mymod_pc_form'))
    {
      $enable_grades = Tools::getValue('enable_grades');
      $enable_comments = Tools::getValue('enable_comments');
      Configuration::updateValue('MYMOD_GRADES', $enable_grades);
      Configuration::updateValue('MYMOD_COMMENTS', $enable_comments);
      
    }
  }

}

 ?>
