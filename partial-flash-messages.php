<?php

$data['FlashMessage'] = new Facade_FlashMessage;
Timber::render('partial/flash-messages.twig', $data);