<?php

/**
 * Classe que grava o filtro para exibição dos itens
 */

 if(!defined('WPINC')){
    die();
 }

$fileName = DOWNLOAD_RFF_DIR_FILE.'filtro.txt';
 class DownRffFilter {
    function save_filter($filtro){
        global $fileName;
        if(isset($filtro)){
            $arq = fopen($fileName, 'w'); // 'a' é para abrir o arquivo em modo de acréscimo (append)
            if ($arq) {
                // Escreve o conteúdo no arquivo
                // fwrite($arq, $_POST['down_rff_filtro'] . PHP_EOL); // Adiciona uma nova linha após o texto
                fwrite($arq, $_POST['down_rff_filtro']);
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
        global $fileName;
        // Ler o arquivo em um array
        $linhas = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $val = null;
        // Verificar se a leitura foi bem-sucedida
        if ($linhas === false) {
            // echo 'Erro ao ler o arquivo.';
        } else {
            // echo '<h2>Conteúdo do Arquivo:</h2>';
            // echo '<ul>';
            // // Exibir cada linha
            // foreach ($linhas as $linha) {
            //    echo '<li>' . htmlspecialchars($linha) . '</li>';
            // }
            // echo '</ul>';
            if(sizeof($linhas)>0){
            // echo '<h1>'.$linhas[0].'</h1>';
                if($linhas[0]!=0){
                    $val = $linhas[0];
                    $itemDados = $conn_download_rff->down_rff_item_by_id_categ($linhas[0]);
                }else{
                    $itemDados = $conn_download_rff->down_rff_item_get_all();
                }
            }else{
                echo '---------------------------';
                $itemDados = $conn_download_rff->down_rff_item_get_all();
            }
            return ['val'=>$val, 'itemDados'=>$itemDados];
        }
    }
 }