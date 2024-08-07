<?php

/*
* Núcleo do plugin
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 //importa e instância a classe de upload
 $uploadFile = null;
 if(file_exists(DOWNLOAD_RFF_DIR_INC.'download-rff-upload-class.php')){
    require_once(DOWNLOAD_RFF_DIR_INC.'download-rff-upload-class.php');
    $uploadFile = new DownloadRffUpload();
 }

/**
 * Classe que controla o CRUD das tabelas
 */
 class DonwRffConn{
    /**
     * Funções da tabela de categoria
     */
    //Inserir categoria
    function down_rff_categ_insert($title, $statusItem){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_CATEG;
        $result = $wpdb->insert(
            $table_name,
            array(
                'title' => $title,
                'statusItem' => $statusItem,
            )
        );
        if($result!=false){
            echo '<div class="notice notice-success is-dismissible"><p>Categoria inserida com sucesso!</p></div>';
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível inserir a categoria. Erro: '.$wpdb->last_error.'</p></div>';
        }
    }

    //Editar categoria
    function down_rff_categ_edit($id, $title, $statusItem){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_CATEG; // Constante com o nome da tabela categoria declarada no arquivo principal
        $result = $wpdb->update(
            $table_name,
            array(
                'title' => $title,
                'statusItem' => $statusItem,
            ),
            array('id'=>$id),
            array('%s'),
            array('%d'),
        );
        if($result<=0 || $result==false){
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível editar a categoria. Erro: '.$wpdb->last_error.'</p></div>';
        }else{
            echo '<div class="notice notice-success is-dismissible"><p>Categoria <strong>atualizada</strong> com sucesso!</p></div>';
        }
    }

    //Excluir categoria
    function down_rff_categ_delete($id){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_CATEG;
        $result = $wpdb->delete(
            $table_name,
            array('id'=>$id),
            array('$d')
        );
        if($result<=0 || $result==false){
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível excluir a categoria. Erro: '.$wpdb->last_error.'</p></div>';
        }else{
            echo '<div class="notice notice-success is-dismissible"><p>Categoria <strong>excluída</strong> com sucesso!</p></div>';
        }
    }

    //Recupera todas as categorias
    function down_rff_categ_get_all(){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_CATEG;
        $results = $wpdb->get_results("SELECT * FROM $table_name");
        return $results;
    }

    //Recupera a categoria por ID
    function down_rff_categ_by_id($id){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_CATEG;
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$id");
        return $result;
    }

    /**
     * Funções da tabela Items
     */
    //Inserir item 
    function down_rff_item_insert($title, $content, $urlPage, $urlDoc, $dateStart, $dateEnd, $category, $statusItem, $tags, $file){
        if($uploadFile!=null){
            $uploadFile->upload_file_download_rff($file);
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Classe de controle de upload não encontrada!</p></div>';
        }
        $dateUp = date('Y-m-d');
        $click = 0;
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_ITEMS;
        $result = $wpdb->insert(
            $table_name,
            array(
                'title'=>$title,
                'content'=>$content,
                'urlPage'=>$urlPage,
                'urlDoc'=>$urlDoc,
                'dateStart'=>$dateStart,
                'dateEnd'=>$dateEnd,
                'category'=>$category,
                'statusItem'=>$statusItem,
                'tags'=>$tags,
                'dateUp'=>$dateUp,
                'click'=>$click,
            )
        );
        if($result<=0 || $result==false){
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível inserir o item. Erro: '.$wpdb->last_error.'</p></div>';
        }else{
            echo '<div class="notice notice-success is-dismissible"><p>Item <strong>inserido</strong> com sucesso!</p></div>';
        }
    }

    //Editar item
    function down_rff_item_edit($id, $title, $content, $urlPage, $urlDoc, $dateStart, $dateEnd, $category, $statusItem, $tags){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_ITEMS;
        $result = $wpdb->update(
            $table_name,
            array(
                'title'=>$title,
                'content'=>$content,
                'urlPage'=>$urlPage,
                'urlDoc'=>$urlDoc,
                'dateStart'=>$dateStart,
                'dateEnd'=>$dateEnd,
                'category'=>$category,
                'statusItem'=>$statusItem,
                'tags'=>$tags,
                'dateUp'=>$dateUp,
                'click'=>$click,
            ),
            array('id'=>$id),
            array('%s'),
            array('%d'),
        );
        if($result<=0 || $result==false){
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível <strong>atualizar</strong> o item. Erro: '.$wpdb->last_error.'</p></div>';
        }else{
            echo '<div class="notice notice-success is-dismissible"><p>Item <strong>atualizado</strong> com sucesso!</p></div>';
        }
    }

    //Excluir item
    function down_rff_item_delete($id, $file){
        if($uploadFile!=null){
            $uploadFile->remove_file_download_rff($file);
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Classe de controle de upload não encontrada!</p></div>';
        }
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_ITEMS;
        $result = $wpdb->delete(
            $table_name,
            array('id'=>$id),
            array('%d'),
        );
        if($result<=0 || $result==false){
            echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível <strong>excluir</strong> o item. Erro: '.$wpdb->last_error.'</p></div>';
        }else{
            echo '<div class="notice notice-success is-dismissible"><p>Item <strong>excluído</strong> com sucesso!</p></div>';
        }
    }

    //Recuperar todos os itens
    function down_rff_item_get_all(){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_ITEMS;
        $results = $wpdb->get_results("SELECT * FROM $table_name");
        return $results;
    }

    //Recupera o item por ID
    function down_rff_item_by_id($id){
        global $wpdb;
        $table_name = $wpdb->prefix.DOWNLOAD_RFF_TABLE_ITEMS;
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $id");
        return $result[0];
    }
 }