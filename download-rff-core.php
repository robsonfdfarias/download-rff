<?php

/*
* Núcleo do plugin
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

//Importa as classes de CRUD das tabelas e de upload dos arquivos
 if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-table-class.php')){
   require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-table-class.php');
 }
 if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-upload-class.php')){
   require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-upload-class.php');
 }
 $conn_download_rff = new DownRffConn();
 $upload_download_rff = new DownRffUpload();

//Importa o arquivo de shortcode
// if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-shortcode.php')){
//    require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-shortcode.php');
// }

//Adiciona o menu na área administrativa
add_action('admin_menu', 'download_rff_add_admin_menu');
function download_rff_add_admin_menu(){
   add_menu_page(
      'Plugin de Download RFF', //Título da página
      'Download RFF', //Título do menu
      'manage_options', //nível de permissão
      'Download-RFF', //Slug
      'dowload_rff_admin_page', //Função chamada
      'dashicons-download', //Ícone https://developer.wordpress.org/resource/dashicons/#admin-generic
      4 //Posição no menu
   );
}

function load_dashicons() {
   wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons');

function dowload_rff_admin_page(){
   global $conn_download_rff;
   global $upload_download_rff;
    // Passar a URL do plugin para o script JavaScript
    echo '<script>localStorage.setItem("pluginPath", '.plugins_url('', __FILE__).'); </script>';
    ?>
    <div class="wrap">
        <div id="down_rff_dados_info"></div>
        <h1>
            Configuração do Download RFF 
            <img src="<?php echo plugins_url('/', __FILE__); ?>imginfo/youtube.svg" width="25" class="btGraphQl" title="Saiba como usar o plugin" id="down_rff_img_info">
            
        </h1>
        <h2>Categorias cadastradas</h2>
        <form method="post" action="" id="down-rff-form">
            <input type="text" name="titleCateg" placeholder="Digite o título" value="" required>
            <select className="down-rff-status" name="categStatus" style="<?php echo $style_select; ?>">
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
            <input type="submit" class="down-rff-bt-submit" id="cadastrar_categoria" name="cadastrar_categoria" value="Cadastrar categoria">
        </form>
    </div>
    <?php
    if(isset($_POST['cadastrar_categoria'])){
      $tituloCateg = sanitize_text_field($_POST['titleCateg']);
      $categStatus = sanitize_text_field($_POST['categStatus']);
      $conn_download_rff->down_rff_categ_insert($tituloCateg, $categStatus);
    }else if(isset($_POST['editar_categoria'])){
      $tituloCateg = sanitize_text_field($_POST['titleCateg']);
      $categStatus = sanitize_text_field($_POST['categStatus']);
      $conn_download_rff->down_rff_categ_edit($tituloCateg, $categStatus);
    }
    if(isset($_POST['cadastrar_item'])){
      if(isset($_POST['urlFile'])){
         $itemTitle = sanitize_text_field($_POST['itemTitle']);
      }
    }
}