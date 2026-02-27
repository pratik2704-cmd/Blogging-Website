<?php
require 'config/constants.php';

//Destroy all session and redirect to home page
session_destroy();
header('location: ' . ROOT_URl);
die();
