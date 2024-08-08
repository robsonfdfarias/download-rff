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

function dowload_rff_admin_page(){
   global $conn_download_rff;
   global $upload_download_rff;
   $style_select = "padding: 5px 15px; font-weight: bold; text-transform: uppercase; margin-top:-5px";
    // Passar a URL do plugin para o script JavaScript
    echo '<script>localStorage.setItem("pluginPath", '.plugins_url('', __FILE__).'); </script>';

   //  // Obtém o valor de 'upload_max_filesize'
   // $uploadMaxFilesize = ini_get('upload_max_filesize');
   // // Obtém o valor de 'post_max_size'
   // $postMaxSize = ini_get('post_max_size');
   // // Exibe os valores
   // echo "Tamanho máximo de upload de arquivos: " . $uploadMaxFilesize . "<br>";
   // echo "Tamanho máximo de dados POST: " . $postMaxSize;
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



    $categoryData = $conn_download_rff->down_rff_categ_get_all();
   //  if($categoryData){
   //      echo '<br><strong>Dados Gravados</strong>';
   //      echo '<table class="wp-list-table widefat fixed striped" style="table-layout: auto !important;">';
   //      echo '<thead><tr><th>ID</th><th>Título</th><th>Status</th><th>Ações</th></tr></thead>';
   //      echo '<tbody>';
   //      foreach($categoryData as $categData){
   //          echo '<tr>';
   //          echo '<form method="post" action="" enctype="multipart/form-data">';
   //          echo '<td><input type="hidden" value="'.esc_html($categData->id).'" name="idSlide" id="idSlide" />' . esc_html($categData->id) . '</td>';
   //          echo '<td><input type="text" value="' . esc_html($categData->title) . '" name="titleSlide" id="titleSlide" placeholder="Digite o título" /></td>';
   //          echo '<td><select className="si-rff-status" name="slideStatus" style="'.$style_select.'; margin:0px;">
   //                  <option value="'.esc_html($categData->statusItem).'">-> '.$categData->statusItem.' <-</option>
   //                  <option value="ativo">Ativo</option>
   //                  <option value="inativo">Inativo</option>
   //                </select></td>';
   //          // echo '<td><input type="text" value="' . esc_html($categData->slideStatus) . '" name="slideStatus" id="slideStatus" /></td>';
   //          echo '<td><input type="submit" class="si-rff-bt-submit" id="EditarSlide" name="EditarSlide" value="Editar" /><input type="submit" class="si-rff-bt-submit" id="ExcluirSlide" name="ExcluirSlide" value="Excluir" /></td>';
   //          echo '</form>';
   //          echo '</tr>';
   //      }
   //      echo '</tbody>';
   //      echo '</table>';
   //  }
   if($categoryData){
      echo '<br><strong>Dados Gravados</strong>';
      echo '<div class="geralCategItem">';
      foreach($categoryData as $categData){
         echo '<div class="categItem">';
          echo '<form method="post" action="" enctype="multipart/form-data">';
          echo '<input type="hidden" value="'.esc_html($categData->id).'" name="idSlide" id="idSlide" />' . esc_html($categData->id);
          echo '<br><input type="text" value="' . esc_html($categData->title) . '" name="titleSlide" id="titleSlide" placeholder="Digite o título" />';
          echo '<br><select className="si-rff-status" name="slideStatus" style="'.$style_select.'; margin:0px;">
                  <option value="'.esc_html($categData->statusItem).'">-> '.$categData->statusItem.' <-</option>
                  <option value="ativo">Ativo</option>
                  <option value="inativo">Inativo</option>
                </select>';
          // echo '<td><input type="text" value="' . esc_html($categData->slideStatus) . '" name="slideStatus" id="slideStatus" /></td>';
          echo '<br><input type="submit" id="editar_categoria" name="editar_categoria" value="Editar" /><input type="submit" id="excluir_categoria" name="excluir_categoria" value="Excluir" />';
          echo '</form>';
         echo '</div>';
      }
      echo '</div>';
  }




    if(isset($_POST['cadastrar_item'])){
      if(!empty($_FILES['urlFile']['name'])){
         $itemTitle = sanitize_text_field($_POST['itemTitle']);
         $itemContent = '';
         $itemUrlPage = sanitize_text_field($_POST['itemUrlPage']);
         $itemStartDate = sanitize_text_field($_POST['itemStartDate']);
         $itemEndDate = sanitize_text_field($_POST['itemEndDate']);
         $itemCategory = sanitize_text_field($_POST['itemCategory']);
         $itemTags = sanitize_text_field($_POST['itemTags']);
         $itemStatusItem = sanitize_text_field($_POST['itemStatusItem']);
         $itemOrderItems = sanitize_text_field($_POST['itemOrderItems']);
         $conn_download_rff->down_rff_item_insert(
                                                   $itemTitle, 
                                                   $itemContent, 
                                                   $itemUrlPage, 
                                                   $itemStartDate, 
                                                   $itemEndDate, 
                                                   $itemCategory, 
                                                   $itemStatusItem, 
                                                   $itemTags, 
                                                   $_FILES['urlFile'], 
                                                   $itemOrderItems
                                                );
      }else{
         echo '<div class="notice notice-failure is-dismissible"><p>Nenhum arquivo selecionado! Selecione um arquivo para efetuar o cadastro</p></div>';
      }
    }
    ?>
    <!-- <div class="wrap">
    <h2>Conteúdo dos slides </h2>
        <form method="post" action="" enctype="multipart/form-data" id="down_rff_form">
            <input type="text" name="itemTitle" placeholder="Digite o título" value="" style="width: 100%;" required>
            <input type="text" name="itemTags" placeholder="Insira as tags separadas por virgula(,). Ex: lista de candidatos,PHP,relatorio" value="" style="width: 100%;" required>
            <input type="text" name="itemUrlPage" placeholder="Digite a URL da página com as informações para esse item" value="" required>
            <input type="file" name="urlFile" required>
            <input type="date" name="itemStartDate" title="Data que estará disponível o arquivo" value="" required>
            <input type="date" name="itemEndDate" title="Data que não estará mais disponível o arquivo" value="" required>
            <input type="text" name="itemOrderItems" title="Ordem que deve aparecer o arquivo" placeholder="Ordem que deve aparecer o arquivo" value="" required>
            <select className="down-rff-status" name="itemStatusItem" style="<?php //echo $style_select; ?>">
               <option value="Ativo">Ativo</option>
               <option value="Inativo">Inativo</option>
            </select>
            <select className="down-rff-status" name="itemCategory" style="<?php //echo $style_select; ?>">
               <?php
                  // $categorias = $conn_download_rff->down_rff_categ_get_all();
                  // if($categorias){
                  //       foreach($categorias as $categoria){
                  //          echo '<option value="'.esc_html($categoria->id).'">'.esc_html($categoria->title).'</option>';
                  //       }
                  // }
               ?>
            </select>
            <input type="submit" class="down-rff-bt-submit" id="cadastrar_item" name="cadastrar_item" value="Cadastrar">
        </form>
    </div> -->

    <div class="wrap">
      
      <div id="centroDownRff">
         <div class="form-container">
            <h1>Formulário de Cadastro</h1>
            <div id="downRffClose">X</div>
            <form method="post" action="" enctype="multipart/form-data" id="down_rff_form">
                  <div class="form-group horizontal">
                     <div class="form-group">
                        <label for="itemTitle">Título</label>
                        <input type="text" id="itemTitle" name="itemTitle" placeholder="Digite o título" required>
                     </div>

                     <div class="form-group">
                        <label for="itemUrlPage">URL da Página</label>
                        <input type="url" id="itemUrlPage" name="itemUrlPage" placeholder="Digite a URL" required>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="urlFile">Arquivo</label>
                     <input type="file" id="urlFile" name="urlFile" required>
                  </div>

                  <div class="form-group date-group">
                     <div class="date-item">
                        <label for="itemStartDate">Data de Início</label>
                        <input type="date" id="itemStartDate" name="itemStartDate" required>
                     </div>
                     <div class="date-item">
                        <label for="itemEndDate">Data de Término</label>
                        <input type="date" id="itemEndDate" name="itemEndDate" required>
                     </div>
                  </div>

                  <div class="form-group horizontal">
                     <div class="form-group">
                        <label for="itemCategory">Categoria</label>
                        <select id="itemCategory" name="itemCategory" required>
                           <?php
                              $categorias = $conn_download_rff->down_rff_categ_get_all();
                              if($categorias){
                                    foreach($categorias as $categoria){
                                       echo '<option value="'.esc_html($categoria->id).'">'.esc_html($categoria->title).'</option>';
                                    }
                              }
                           ?>
                        </select>
                     </div>

                     <div class="form-group">
                        <label for="itemStatusItem">Status do Item</label>
                        <select id="itemStatusItem" name="itemStatusItem" required>
                              <option value="Ativo">Ativo</option>
                              <option value="Inativo">Inativo</option>
                        </select>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="itemTags">Tags</label>
                     <input type="text" id="itemTags" name="itemTags" placeholder="Digite as tags, separadas por vírgula" required>
                  </div>

                  <div class="form-group">
                     <label for="itemOrderItems">Ordem do Item</label>
                     <input type="number" id="itemOrderItems" name="itemOrderItems" placeholder="Digite a ordem" required>
                  </div>

                  <button type="submit" id="cadastrar_item" name="cadastrar_item">Enviar</button>
            </form>
         </div>
      </div>
    </div>
    <?php

    $itemDados = $conn_download_rff->down_rff_item_get_all();
    if($itemDados){
      echo '<h2>Itens cadastrados</h2>';
      echo '<button id="cadItemDownRff">Cadastrar Item</button><br>';
      echo '<strong>Dados Gravados</strong>';
      echo '<div id="geralItemItem">';
      echo '';
      foreach($itemDados as $itemdado){
         $partesDocsPath = explode('/', $itemdado->urlDoc);
         $name = $partesDocsPath[(sizeof($partesDocsPath)-1)];
         echo '<div class="itemItem">';
         echo '<form method="post" action="" enctype="multipart/form-data">';
         echo ''.$itemdado->id.'<br>';
         echo 'Titulo: <input type="text" name="itemTitle" value="'.$itemdado->title.'"><br>';
         echo 'Arquivo: <a href="'.$itemdado->urlDoc.'" title="'.$name.'" target="_blank">'.substr($name, 0, 25).'...</a><br>';
         echo '<input type="date" name="itemStartDate" title="Insira a data que ficará disponível esse arquivo" value="'.$itemdado->startDate.'">';
         echo '<input type="date" name="itemEndDate" title="Insira a data limite para estar disponível esse arquivo" value="'.$itemdado->endDate.'">';
         echo '';
         echo '<select name="itemStatusItem" style="width:112px; margin-top: -5px;" required>';
         echo '<option value="Ativo">Ativo</option>';
         echo '<option value="Inativo">Inativo</option>';
         echo '</select><br>';
         echo 'Categoria: <select style="width:100%;" name="itemCategory" required>';
         echo '<option value="Ativo">Categoria 1</option>';
         echo '<option value="Ativo">Categoria 2</option>';
         echo '</select>';
         echo 'Tags: <input type="text" name="itemTags" value="'.$itemdado->tags.'"><br>';
         echo 'Ordem: <input type="text" name="itemOrderItems" value="'.$itemdado->orderItems.'">';
         echo '<br><input type="submit" id="editar_item" name="editar_item" value="Editar" /><input type="submit" id="excluir_item" name="excluir_item" value="Excluir" />';
         echo '</form>';
         echo '</div>';
      }
      echo '</div>';
    }
}