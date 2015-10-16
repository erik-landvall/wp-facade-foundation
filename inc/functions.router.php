<?php

// Handles certain post data
if(isset($_POST['ns']))
  add_action('init', function() use ($_POST)
  {
    Facade_Form::mapper($_POST['ns']); 
  }, 100);