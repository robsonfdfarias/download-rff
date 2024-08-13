<?php

/**
 * Arquivo de funções de conexão com o DB
 *  */

 //se chamar diretamente e não pelo wordpress, aborta
 if(!defined('WPINC')){
    die();
 }

 //Registrar tipos e campos no GraphQl tabela categoria
 function register_custom_table_download_rff_categ_in_graphql(){
    register_graphql_object_type('CustomTableTypesDownloadRffCateg', [
        'fields' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type' => 'String',
                'description' => __('titulo do item', 'your-textdomain'),
            ],
            'statusItem' => [
                'type' => 'String',
                'description' => __('status do item', 'your-textdomain'),
            ],
        ]
    ]);

    register_graphql_field('RootQuery', DOWNLOAD_RFF_TABLE_CATEG, [
        'type'=>['list_of' => 'CustomTableTypesDownloadRffCateg'],
        'description' => __('Query de consulta da tabela', 'your-textdomain'),
        'args' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type' => 'String',
                'description' => __('Título do item', 'your-textdomain'),
            ],
            'statusItem' => [
                'type' => 'String',
                'description' => __('Status do item', 'your-textdomain'),
            ],
        ],
        'resolve' => function($root, $args, $context, $info){
            global $wpdb;
            $table_categ = $wpdb->prefix.DOWNLOAD_RFF_TABLE_CATEG;
            $where_clauses = [];
            if(!empty($args['id'])){
                $where_clauses[] = $wpdb->prepare('id = %d', $args['id']);
            }
            if(!empty($args['title'])){
                $where_clauses[] = $wpdb->prepare('title = %s', $args['title']);
            }
            if(!empty($args['statusItem'])){
                $where_clauses[] = $wpdb->prepare('statusItem = %s', $args['statusItem']);
            }
            $where_sql = '';
            if(!empty($where_clauses) && sizeof($where_clauses)>0){
                $where_sql = "WHERE ".implode(' AND ', $where_clauses);
            }
            $queryCateg = "SELECT * FROM $table_categ $where_sql";
            $results = $wpdb->get_results($queryCateg);
            return $results;
        }
    ]);
 }

 //Registrar tipos e campos no GraphQl tabela itens
 function register_custom_table_download_rff_items_in_graphql(){
    register_graphql_object_type('CustomTableTypesDownloadRffItems', [
        'fields' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type' => 'String',
                'description' => __('titulo do item', 'your-textdomain'),
            ],
            'content' => [
                'type' => 'String',
                'description' => __('Descrição com detalhes do item', 'your-textdomain'),
            ],
            'urlPage' => [
                'type' => 'String',
                'description' => __('url da página do item', 'your-textdomain'),
            ],
            'urlDoc' => [
                'type' => 'String',
                'description' => __('url do arquivo do item', 'your-textdomain'),
            ],
            'startDate' => [
                'type' => 'String',
                'description' => __('Data de validade inicial(que fica ativo) do item', 'your-textdomain'),
            ],
            'endDate' => [
                'type' => 'String',
                'description' => __('Data de validade final(que fica inativo) do item', 'your-textdomain'),
            ],
            'category' => [
                'type' => 'String',
                'description' => __('Categoria do item', 'your-textdomain'),
            ],
            'clicks' => [
                'type' => 'String',
                'description' => __('Quantidade de clicks do item', 'your-textdomain'),
            ],
            'tags' => [
                'type' => 'String',
                'description' => __('Tags do item', 'your-textdomain'),
            ],
            'statusItem' => [
                'type' => 'String',
                'description' => __('status do item', 'your-textdomain'),
            ],
            'dateUp' => [
                'type' => 'String',
                'description' => __('Data de publicação do item', 'your-textdomain'),
            ],
            'orderItems' => [
                'type' => 'String',
                'description' => __('Ordem em que os itens devem aparecer do item', 'your-textdomain'),
            ],
        ]
    ]);

    register_graphql_field('RootQuery', DOWNLOAD_RFF_TABLE_ITEMS, [
        'type'=>['list_of' => 'CustomTableTypesDownloadRffItems'],
        'description' => __('Query de consulta da tabela', 'your-textdomain'),
        'args' => [
            'id' => [
                'type' => 'ID',
                'description' => __('ID of the item', 'your-textdomain'),
            ],
            'title' => [
                'type' => 'String',
                'description' => __('titulo do item', 'your-textdomain'),
            ],
            'content' => [
                'type' => 'String',
                'description' => __('Descrição com detalhes do item', 'your-textdomain'),
            ],
            'startDate' => [
                'type' => 'String',
                'description' => __('Data de validade inicial(que fica ativo) do item', 'your-textdomain'),
            ],
            'endDate' => [
                'type' => 'String',
                'description' => __('Data de validade final(que fica inativo) do item', 'your-textdomain'),
            ],
            'category' => [
                'type' => 'String',
                'description' => __('Categoria do item', 'your-textdomain'),
            ],
            'tags' => [
                'type' => 'String',
                'description' => __('Tags do item', 'your-textdomain'),
            ],
            'statusItem' => [
                'type' => 'String',
                'description' => __('status do item', 'your-textdomain'),
            ],
            'dateUp' => [
                'type' => 'String',
                'description' => __('Data de publicação do item', 'your-textdomain'),
            ],
            'orderItems' => [
                'type' => 'String',
                'description' => __('Ordem em que os itens devem aparecer do item', 'your-textdomain'),
            ],
        ],
        'resolve' => function($root, $args, $context, $info){
            global $wpdb;
            $table_categ = $wpdb->prefix.DOWNLOAD_RFF_TABLE_ITEMS;
            $where_clauses = [];
            if(!empty($args['id'])){
                $where_clauses[] = $wpdb->prepare('id = %d', $args['id']);
            }
            if(!empty($args['title'])){
                $where_clauses[] = $wpdb->prepare('title like %s', '%'.$args['title'].'%');
            }
            if(!empty($args['content'])){
                $where_clauses[] = $wpdb->prepare('content like %s', '%'.$args['content'].'%');
            }
            if(!empty($args['startDate'])){
                $where_clauses[] = $wpdb->prepare('startDate like %s', '%'.$args['startDate'].'%');
            }
            if(!empty($args['endDate'])){
                $where_clauses[] = $wpdb->prepare('endDate like %s', '%'.$args['endDate'].'%');
            }
            if(!empty($args['category'])){
                $where_clauses[] = $wpdb->prepare('category like %s', '%'.$args['category'].'%');
            }
            if(!empty($args['tags'])){
                $where_clauses[] = $wpdb->prepare('tags like %s', '%'.$args['tags'].'%');
            }
            if(!empty($args['statusItem'])){
                $where_clauses[] = $wpdb->prepare('statusItem like %s', '%'.$args['statusItem'].'%');
            }
            if(!empty($args['dateUp'])){
                $where_clauses[] = $wpdb->prepare('dateUp like %s', '%'.$args['dateUp'].'%');
            }
            $where_sql = '';
            if(!empty($where_clauses) && sizeof($where_clauses)>0){
                $where_sql = "WHERE ".implode(' AND ', $where_clauses);
            }
            $order = '';
            if(!empty($args['orderItem'])){
                $order = "ORDER BY orderItem ".$args['orderItem'];
            }
            $queryCateg = "SELECT * FROM $table_categ $where_sql $order";
            $results = $wpdb->get_results($queryCateg);
            return $results;
        }
    ]);
 }