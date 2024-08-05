<?php

/*
Plugin Name: Slide image RFF
Plugin URI: http://exemplo.com
Description: Cria um sistema de administração de downloads.
Version: 1.0
Author: Robson Ferreira de Farias
Email: robsonfdfarias@gmail.com
Author URI: http://infocomrobson.com.br
License: GPL2
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }


 // Definição das constantes
 define('DOWNLOAD_RFF_DIR_INC', dirname(__FILE__).'/inc/');
 define('DOWNLOAD_RFF_DIR_IMG', dirname(__FILE__).'/img/');
 define('DOWNLOAD_RFF_URL_IMG', plugins_url('img/', __FILE__));
 define('DOWNLOAD_RFF_URL_CSS', plugins_url('css/', __FILE__));
 define('DOWNLOAD_RFF_URL_JS', plugins_url('js/', __FILE__));
//Constantes com os nomes das tabelas
define('DOWNLOAD_RFF_TABLE_CATEG', 'down_rff_categ');
define('DOWNLOAD_RFF_TABLE_ITEMS', 'down_rff_items');