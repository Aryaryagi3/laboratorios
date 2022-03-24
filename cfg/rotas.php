<?php

$rotas = [
    '/' => [
        'GET' => '\Controlador\RaizControlador#index',
    ],
    '/login' => [
        'GET' => '\Controlador\LoginControlador#criar',
        'POST' => '\Controlador\LoginControlador#armazenar',
        'DELETE' => '\Controlador\LoginControlador#destruir'
    ],
    '/usuarios/criar' => [
        'GET' => '\Controlador\UsuarioControlador#criar',
        'POST' => '\Controlador\UsuarioControlador#armazenar'
    ],
    '/laboratorio' => [
        'GET' => '\Controlador\SolicitacaoControlador#mostrarLabs',
        'DELETE' => '\Controlador\SolicitacaoControlador#destruir'
    ],
    '/laboratorio/?' => [
        'GET' => '\Controlador\SolicitacaoControlador#mostrarLab',
        'POST' => '\Controlador\SolicitacaoControlador#armazenar'
    ],
    '/administrador' => [
        'GET' => '\Controlador\SolicitacaoControlador#listar',
        'POST' => '\Controlador\SolicitacaoControlador#atualizar',
        'DELETE' => '\Controlador\SolicitacaoControlador#destruir'
    ]
];
