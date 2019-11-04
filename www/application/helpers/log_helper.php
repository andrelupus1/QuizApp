<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Registrar acao do usuario
 */
function logUsuario($dados = array()) {
    /**
     * tipo_log: 1-acesso, 2-paginas, 3-menu
     */
    $CI = get_instance();
    $CI->load->model('Usuarios_model');


    $CI->Usuarios_model->log_usuario($dados);
}
