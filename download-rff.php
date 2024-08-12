<?php

/*
Plugin Name: Download Rff
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
 define('DOWNLOAD_RFF_DIR_FILE', dirname(__FILE__).'/downloads/');
 define('DOWNLOAD_RFF_URL_FILE', plugins_url('downloads/', __FILE__));
 define('DOWNLOAD_RFF_URL_CSS', plugins_url('css/', __FILE__));
 define('DOWNLOAD_RFF_URL_JS', plugins_url('js/', __FILE__));
//Constantes com os nomes das tabelas
define('DOWNLOAD_RFF_TABLE_CATEG', 'down_rff_categ');
define('DOWNLOAD_RFF_TABLE_ITEMS', 'down_rff_items');


 /**
  * Registrando o css (backend)
  */
  function down_rff_registre_css_admin(){
    wp_enqueue_style('download-rff-admin', DOWNLOAD_RFF_URL_CSS.'download-rff-admin.css', null, time(), 'all');
  }
  add_action('admin_enqueue_scripts', 'down_rff_registre_css_admin');
  
 /**
  * Registrando o js (backend)
  */
  function down_rff_registre_js_admin(){
    if(!did_action('wp_enqueue_media')){
        wp_enqueue_media();
    }
    wp_enqueue_script('download-rff-js-admin', DOWNLOAD_RFF_URL_JS.'download-rff-admin.js', null, time(), 'all');
  }
  add_action('admin_enqueue_scripts', 'down_rff_registre_js_admin');
  

/**
 * Includes
 */
if(file_exists(plugin_dir_path(__FILE__).'download-rff-core.php')){
    require_once(plugin_dir_path(__FILE__).'download-rff-core.php');
}

if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-hooks.php')){
    require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-hooks.php');
    register_activation_hook(__FILE__, 'download_rff_install');
    register_deactivation_hook(__FILE__, 'download_rff_uninstall');
}

// if(file_exists())

//permitindo o upload de SVG
// Permitir upload de arquivos SVG
function permitir_upload_svg($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'permitir_upload_svg');

// Adicionar suporte para visualizar SVGs na biblioteca de mídia
function adicionar_tamanho_svg($sizes) {
  $sizes['svg'] = 'SVG';
  return $sizes;
}
add_filter('image_size_names_choose', 'adicionar_tamanho_svg');
