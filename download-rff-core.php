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

//Importa o arquivo de filtro
if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-filter.php')){
   require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-filter.php');
}


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
        <div id="centroDownRffCadCateg">
            <div class="form-container">
               <h2>Cadastrar categoria</h2>
               <div id="downRffCloseCadCateg">X</div>
               <form method="post" action="" id="down-rff-form">
                     <input type="text" name="titleCateg" placeholder="Digite o título" value="" required>
                     <select className="down-rff-status" name="categStatus" style="<?php echo $style_select; ?>">
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                     </select>
                     <input type="submit" class="down_rff_bt" id="cadastrar_categoria" name="cadastrar_categoria" value="Cadastrar categoria">
               </form>
            </div>
        </div>
    </div>
    <?php
    if(isset($_POST['cadastrar_categoria'])){
      $tituloCateg = sanitize_text_field($_POST['titleCateg']);
      $categStatus = sanitize_text_field($_POST['categStatus']);
      $conn_download_rff->down_rff_categ_insert($tituloCateg, $categStatus);
    }else if(isset($_POST['editar_categoria'])){
      $categId = sanitize_text_field($_POST['categId']);
      $tituloCateg = sanitize_text_field($_POST['titleCateg']);
      $categStatus = sanitize_text_field($_POST['categStatus']);
      $conn_download_rff->down_rff_categ_edit($categId, $tituloCateg, $categStatus);
    }else if(isset($_POST['excluir_categoria'])){
      $categId = sanitize_text_field($_POST['categId']);
      $conn_download_rff->down_rff_categ_delete($categId);
    }


      echo '<div style="position: relative;"><h2>Categorias cadastradas</h2>';
      echo '<button id="cadCategDownRff" class="down_rff_bt">Cadastrar Categoria</button></div>';
    $categoryData = $conn_download_rff->down_rff_categ_get_all();
    if($categoryData){
        
        echo '<div id="downRffDivCateg">';
      //   echo '<table class="wp-list-table widefat fixed striped" style="table-layout: auto !important;">';
        echo '<table class="wp-list-table widefat">';
        echo '<thead><tr><th>ID</th><th>Título</th><th>Status</th><th>Ações</th></tr></thead>';
        echo '<tbody>';
        foreach($categoryData as $categData){
            echo '<tr>';
            echo '<form method="post" action="">';
            echo '<td width="3%"><input type="hidden" value="'.esc_html($categData->id).'" name="categId" id="categId" />' . esc_html($categData->id) . '</td>';
            echo '<td><input type="text" style="width: 100%; min-width: 30px;" value="' . esc_html($categData->title) . '" name="titleCateg" id="titleCateg" placeholder="Digite o título" /></td>';
            echo '<td width="10%"><select className="down-rff-status" name="categStatus" style="'.$style_select.'; margin:0px;">
                    <option value="'.esc_html($categData->statusItem).'">-> '.$categData->statusItem.' <-</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                  </select></td>';
            // echo '<td><input type="text" value="' . esc_html($categData->slideStatus) . '" name="slideStatus" id="slideStatus" /></td>';
            echo '<td width="18%"><input type="submit" id="editar_categoria" name="editar_categoria" value="Editar" /><input type="submit" id="excluir_categoria" name="excluir_categoria" value="Excluir" /></td>';
            echo '</form>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table></div>';
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
    }else if(isset($_POST['editar_item'])){
      $id = sanitize_text_field($_POST['itemId']);
      $itemTitle = sanitize_text_field($_POST['itemTitle']);
      $itemContent = ' ';
      $itemUrlPage = sanitize_text_field($_POST['itemUrlPage']);
      $itemStartDate = sanitize_text_field($_POST['itemStartDate']);
      $itemEndDate = sanitize_text_field($_POST['itemEndDate']);
      $urlFile = sanitize_text_field($_POST['urlFile']);
      $itemCategory = sanitize_text_field($_POST['itemCategory']);
      $itemTags = sanitize_text_field($_POST['itemTags']);
      $itemStatusItem = sanitize_text_field($_POST['itemStatusItem']);
      $itemOrderItems = sanitize_text_field($_POST['itemOrderItems']);
      $conn_download_rff->down_rff_item_edit(
                                                $id,
                                                $itemTitle, 
                                                $itemContent, 
                                                $itemUrlPage, 
                                                $urlFile, 
                                                $itemStartDate, 
                                                $itemEndDate, 
                                                $itemCategory, 
                                                $itemStatusItem, 
                                                $itemTags, 
                                                $itemOrderItems
                                             );
    }else if(isset($_POST['excluir_item'])){
      $id = sanitize_text_field($_POST['itemIdItem']);
      $file = sanitize_text_field($_POST['itemUrlDoc']);
      $conn_download_rff->down_rff_item_delete($id, $file);
    }
    ?>
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
    <hr style="border: 1px datesh #ddd; margin-top: 15px;" />
    </div>
    <?php

   $downRffFilter = new DownRffFilter();
   if(isset($_POST['down_save_filter'])){
      $downRffFilter->save_filter($_POST['down_save_filter']);
   }
   $filter = $downRffFilter->read_filter($conn_download_rff);

   echo '<div style="position:relative; margin-top: 30px;"><h2>Itens cadastrados</h2>';
   echo '<button id="cadItemDownRff">Cadastrar Item</button></div>';
   echo '<form method="post" action="">';
   echo '<select name="down_rff_filtro">';
   echo '<option value="0">Todos</option>';
   if($categorias){
      foreach($categorias as $categoria){
         echo '<option value="'.esc_html($categoria->id).'">'.esc_html($categoria->title).'</option>';
      }
   }
   echo '</select>';
   echo '<input type="submit" id="down_save_filter" name="down_save_filter" value="Filtrar">';
   //Aqui imprimi se você fez algum filtro
   if($filter['val']!=null){
      $categ = $conn_download_rff->down_rff_categ_by_id($filter['val']);
      echo ' Você selecionou a categoria: <strong>'.$categ->title.'</strong>';
   }
   echo '</form>';
   
   $itemDados = $filter['itemDados'];
   if($itemDados){
      echo '<table class="wp-list-table widefat">';
      echo '<thead><tr><th>ID</th><th>Ordem</th><th>Título</th><th>Documento</th><th>Ações</th></tr></thead>';
      echo '<tbody>';
      foreach($itemDados as $itemdado){
         $partesDocsPath = explode('/', $itemdado->urlDoc);
         $name = $partesDocsPath[(sizeof($partesDocsPath)-1)];
         $cat = $conn_download_rff->down_rff_categ_by_id($itemdado->category);
         echo '<form method="post" action="" enctype="multipart/form-data">';
         echo '<tr>';
         echo '<td>'.$itemdado->id.'</td>';
         echo '<td>'.$itemdado->orderItems.'</td>';
         echo '<td>'.$itemdado->title.'</td>';
         echo '<td><a href="'.$itemdado->urlDoc.'" title="'.$name.'" target="_blank">'.substr($name, 0, 25).'...</a></td>';
         echo '<td id="down_rff_bts"><input type="submit" class="edit" id="edit" name="edit" value="Editar" /><input type="submit" id="excluir_item" name="excluir_item" value="Excluir" /></td>';
         echo '<td style="display:none;">
                  <input type="text" id="itemUrlPage" name="itemUrlPage" value="'.$itemdado->urlPage.'">
                  <input type="date" id="itemStartDate" value="'.$itemdado->startDate.'">
                  <input type="date" id="itemEndDate" value="'.$itemdado->endDate.'">
                  <input type="text" id="itemTags" value="'.$itemdado->tags.'">
                  <input type="text" id="itemStatusItem" value="'.$itemdado->statusItem.'">
                  <input type="text" id="itemCategory" name="'.$cat->id.'" value="'.$cat->title.'">
                  <input type="text" id="itemUrlDoc" name="itemUrlDoc" value="'.$itemdado->urlDoc.'">
                  <input type="text" id="itemIdItem" name="itemIdItem" value="'.$itemdado->id.'">
               </td>';
         echo '</tr>';
         echo '</form>';
      }
      echo '</tbody>';
      echo '</table>';
    }


    ?>
    <div class="wrap">
      
      <div id="centroDownRffEdit">
         <div class="form-container">
            <h1>Formulário de Edição</h1>
            <div id="downRffCloseEdit">X</div>
            <form method="post" action="" enctype="multipart/form-data" id="down_rff_form">
                  <div class="form-group horizontal">
                     <div class="form-group">
                        <label for="itemTitle">Título</label>
                        <input type="hidden" id="itemId" name="itemId" placeholder="Digite o título" required>
                        <input type="text" id="itemTitleEdit" name="itemTitle" placeholder="Digite o título" required>
                     </div>

                     <div class="form-group">
                        <label for="itemUrlPage">URL da Página</label>
                        <input type="url" id="itemUrlPageEdit" name="itemUrlPage" placeholder="Digite a URL" required>
                     </div>
                  </div>

                  <div class="form-group">
                     <!-- <label for="urlFile">Arquivo</label> -->
                     <input type="hidden" id="urlFileEdit" name="urlFile" required>
                     Arquivo: <span id="itemFile"></span>
                  </div>

                  <div class="form-group date-group">
                     <div class="date-item">
                        <label for="itemStartDate">Data de Início</label>
                        <input type="date" id="itemStartDateEdit" name="itemStartDate" required>
                     </div>
                     <div class="date-item">
                        <label for="itemEndDate">Data de Término</label>
                        <input type="date" id="itemEndDateEdit" name="itemEndDate" required>
                     </div>
                  </div>

                  <div class="form-group horizontal">
                     <div class="form-group">
                        <label for="itemCategory">Categoria</label>
                        <select id="itemCategoryEdit" name="itemCategory" required>
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
                        <select id="itemStatusItemEdit" name="itemStatusItem" required>
                              <option value="Ativo">Ativo</option>
                              <option value="Inativo">Inativo</option>
                        </select>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="itemTags">Tags</label>
                     <input type="text" id="itemTagsEdit" name="itemTags" placeholder="Digite as tags, separadas por vírgula" required>
                  </div>

                  <div class="form-group">
                     <label for="itemOrderItems">Ordem do Item</label>
                     <input type="number" id="itemOrderItemsEdit" name="itemOrderItems" placeholder="Digite a ordem" required>
                  </div>

                  <button type="submit" id="editar_item" name="editar_item">Editar</button>
            </form>
         </div>
      </div>
    </div>
    <?php
}