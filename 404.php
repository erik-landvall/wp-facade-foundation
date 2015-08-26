<?php

header('HTTP/1.0 404 Not Found', true, 404);

$context = Timber::get_context();
Timber::render('404.twig', $context);