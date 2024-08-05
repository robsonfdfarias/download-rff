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
            'statusItem' => [
                'type' => 'String',
                'description' => __('status do item', 'your-textdomain'),
            ],
        ]
    ]);

    register_graphql_field('RootQuery', DOWNLOAD_RFF_TABLE_CATEG, [
        'type'=>['list_of' => 'CustomTableTypesDownloadRffItems'],
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