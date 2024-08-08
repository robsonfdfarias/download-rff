<?php

/*
* Classe de upload do arquivo
*/

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }


 class DownRffUpload {
    //upload do arquivo
    function upload_file_download_rff($file){
        $upload_dir = str_replace('inc/', 'downloads/', plugin_dir_path(__FILE__));
        $urlBase = str_replace('inc/', '', plugins_url('downloads/', __FILE__));
        $upload_dir.=date('Y-m-d').'/';
        $urlBase.=date('Y-m-d').'/';
        //Verifica se o diretório exoiste, caso contrário, tenta criar
        if(!file_exists($upload_dir)){
            wp_mkdir_p($upload_dir);
        }
        //Verifica o tipo de arquivo e o tamanho, se necessário
        $file_type = wp_check_filetype($file['name']);
        if($file_type['ext']=='sh' || $file_type['ext']=='exe' ){
            echo '<div class="notice notice-failure is-dismissible"><p>Formato de arquivo não permitido!</p></div>';
            return false;
        }
        $upload_overrides = array('test_form'=>false, 'move_uploaded_file'=>true);
        //Move o arquivo carregado para o diretório downloads
        $movefile = wp_handle_upload($file, $upload_overrides);
        if($movefile && !isset($movefile['error'])){
            $arqName = basename($movefile['file']);
            $partes = explode('.', $arqName);
            $newName = $partes[0].'_'.time().'.'.$partes[1];
            $new_file_path = $upload_dir.$newName;
            echo 'Endereço novo do arquivo: '.$new_file_path;
            if(rename($movefile['file'], $new_file_path)){
                return $urlBase.basename($new_file_path);
            }else{
                echo '<div class="notice notice-failure is-dismissible"><p>Erro ao mover o arquivo para o diretório de destino!</p></div>';
                return false;
            }
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>Erro ao carregar arquivo: '.$movefile['error'].'</p></div>';
            return false;
        }
    }

    function remove_file_download_rff($file){
        $partes = explode('/', $file);
        $path = DOWNLOAD_RFF_DIR_FILE.$partes[(sizeof($partes)-1)];
        if(file_exists($path)){
            if(unlink($path)){
                echo '<div class="notice notice-success is-dismissible"><p>Arquivo excluída com sucesso!</p></div>';
            }else{
                echo '<div class="notice notice-failure is-dismissible"><p>Não foi possível excluir o arquivo!</p></div>';
                die();
            }
        }else{
            echo '<div class="notice notice-failure is-dismissible"><p>arquivo não encontrada!</p></div>';
            die();
        }
    }
 }