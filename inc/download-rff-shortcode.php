<?php

/*
* Núcleo do plugin
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }


/**
 * Includes
 */
if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-table-class.php')){
    require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-table-class.php');
}

$conn_table_down_rff = new DownRffConn();

 function download_rff_format_item($categ){
    global $conn_table_down_rff;
    
    $dados=$conn_table_down_rff->down_rff_get_item_active($categ->id);
    if($dados!=null){
        $return = '<div class="down_obj">';
        $return .= '<div class="down_categ" title="Esta categoria possui '.sizeof($dados).' registro(s)"><span id="down_rff_simb">+</span> '.$categ->title.'</div>';
        $return .= '<div class="down_files">';
        // $return .= '<ul>';
        foreach($dados as $dado){
            $partes = explode('/', $dado->urlDoc);
            $fileName = $partes[(sizeof($partes)-1)];
            $return .= '<div style="padding: 0px 5px 5px 20px;">→ <a href="'.$dado->urlDoc.'" target="_blank" title="'.$fileName.'">'.substr($fileName, 0, 20).'...</a></div>';
        }
        // $return .= '</ul>';
        $return .= '</div>';
        $return .= '</div>';
        return $return;
    }
    return (
        ''
    );
 }

 function download_rff_model1($atts){
    global $conn_table_down_rff;
    $atts = shortcode_atts(array(
        'idcateg'=> 0,
        'iditem'=> 0
    ), $atts);
    $dados=null;
    if(isset($atts['idcateg'])){
        $dados = $conn_table_down_rff->down_rff_get_categ_active($atts['idcateg']);
    }
    if($dados!=null){
        $return = '<div class="down_objs">';
        foreach($dados as $dado){
            $return .= download_rff_format_item($dado);
        }
        $return .= '</div>';
        return $return;
    }
    return (
        '<h1>'.$atts['idcateg'].' - '.$atts['iditem'].'</h1>'
    );
 }

 /**
  * registro de todos os shortcodes
  */

function download_rff_register_shortcodes(){
    add_shortcode('down_rff_1', 'download_rff_model1');
}
add_action('init', 'download_rff_register_shortcodes');