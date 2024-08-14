<?php

/**
 * Classe que grava o filtro para exibição dos itens
 */

 if(!defined('WPINC')){
    die();
 }

$fileNameDown = DOWNLOAD_RFF_DIR_FILE.'filtro.txt';
 class DownRffFilter {
    function save_filter($filtro){
        global $fileNameDown;
        if(isset($filtro)){
            $arq = fopen($fileNameDown, 'w'); // 'a' é para abrir o arquivo em modo de acréscimo (append)
            if ($arq) {
                // Escreve o conteúdo no arquivo
                // fwrite($arq, $_POST['down_rff_filtro'] . PHP_EOL); // Adiciona uma nova linha após o texto
                fwrite($arq, $filtro);
                // Fecha o arquivo
                fclose($arq);
                // Envia uma resposta ao cliente
                // echo 'Arquivo salvo com sucesso!';
            } else {
                // Se não conseguiu abrir o arquivo, enviar uma resposta de erro
                // echo 'Erro ao abrir o arquivo.';
            }
        }
        // 
    }

    function read_filter($conn_download_rff){
        global $fileNameDown;
        // echo $fileNameDown;
        if(!file_exists($fileNameDown)){
            $this->save_filter("0");
        }
        // Ler o arquivo em um array
        $linhas = file($fileNameDown, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $val = null;
        // Verificar se a leitura foi bem-sucedida
        if ($linhas === false) {
            $itemDados = $conn_download_rff->down_rff_item_get_all();
        } else {
            if(sizeof($linhas)>0){
                if($linhas[0]!=0){
                    $val = $linhas[0];
                    $itemDados = $conn_download_rff->down_rff_item_by_id_categ($linhas[0]);
                }else{
                    $itemDados = $conn_download_rff->down_rff_item_get_all();
                }
            }else{
                $itemDados = $conn_download_rff->down_rff_item_get_all();
            }
        }
        return ['val'=>$val, 'itemDados'=>$itemDados];
    }
 }