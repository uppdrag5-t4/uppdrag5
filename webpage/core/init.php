<?php

# Starta en session
session_start();
session_name(preg_replace('/[:\.\/-_]/', '', __FILE__));

# Slå på felmeddelanden
error_reporting(E_ALL);
ini_set('display_errors', true);

# Sätt default timezone till UTC
date_default_timezone_set('UTC');

# Starta autoloader och ladda in alla class-filer från mappen * class *
spl_autoload_register(function($class) {
    include 'class/' . $class . '.php';
});