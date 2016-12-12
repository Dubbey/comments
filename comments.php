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
    parent::__construct();
  }

  public function getContent()
  {
    return 'Config test.';
  }
}


 ?>
