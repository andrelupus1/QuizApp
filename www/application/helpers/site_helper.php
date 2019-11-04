<?php 
/*******************************************************************************
 * FORMATA STATUS
 * 1-ATIVO
 * 0-INATIVO
 ******************************************************************************/
function getStatus($sts){
    switch($sts){
        case 0:
            $nome_sts = '<span class="label label-danger">Inativo</span>';
        break;
        case 1:
            $nome_sts = '<span class="label label-success">Ativo</span>';
        break;
    }
    
    return $nome_sts;
}
/*
 * Esta funcao apresenta a data e hora no formato brasileiro
 * * @access public
 * @param $dataBR
 */
function dataHora_BR($dataBR){
    // entrada da data yyyy-mm-dd      
    $data1   = substr($dataBR, 0, 10);
    $data_br = implode("/", array_reverse(explode("-", $data1)));

    // formata hora
    $hora1 = substr($dataBR, 11, 8);
    return $data_br. ' '. $hora1;
}
/*
 * Esta função apresenta apenas data no formato brasileiro
 * @access public
 * @param $dataBR
 */
function dataBR($dataBR){
    // entrada da data yyyy-mm-dd
    $data_br = implode("/", array_reverse(explode("-", $dataBR)));
    
    return $data_br;
}
/*
 * Esta função pega a data e hora e desmembra para exibição apenas a data
 * @access public
 * @param $dataBR
 */
function dataCurso($dataBR){
    // entrada da data yyyy-mm-dd      
    $data1   = substr($dataBR, 0, 10);
    $data_br = implode("/", array_reverse(explode("-", $data1)));
    
    return $data_br;
}
/*
 * Esta função pega a data e hora e desmembra para exibição apenas a data
 * @access public
 * @param $dataBR
 */
function horaCurso($dataBR){
    // entrada da data yyyy-mm-dd      
    $data1   = substr($dataBR, 0, 10);
    $data_br = implode("/", array_reverse(explode("-", $data1)));

    // formata hora
    $hora1 = substr($dataBR, 11, 5);
    return $hora1;
}
/*
 * Esta função retorna o nome do mês conforme numero
 * @access public
 * @param $mes
 */
function getMes($mes){
    switch ($mes){
        case '01':
            $n_mes = 'Janeiro';
        break; 
        case '02':
            $n_mes = 'Fevereiro';
        break; 
        case '03':
            $n_mes = 'Março';
        break; 
        case '04':
            $n_mes = 'Abril';
        break; 
        case '05':
            $n_mes = 'Maio';
        break; 
        case '06':
            $n_mes = 'Junho';
        break; 
        case '07':
            $n_mes = 'Julho';
        break; 
        case '08':
            $n_mes = 'Agosto';
        break; 
        case '09':
            $n_mes = 'Setembro';
        break; 
        case '10':
            $n_mes = 'Outubro';
        break; 
        case '11':
            $n_mes = 'Novembro';
        break; 
        case '12':
            $n_mes = 'Dezembro';
        break; 
    }
    return $n_mes;
}
/*
 * Esta função calcula uma data futura
 * @access public
 * @param $data, $dias, $meses, $ano
 */
function SomarData($data, $dias, $meses, $ano){
   /*www.brunogross.com*/
   //passe a data no formato Y-m-d
   $data = explode("-", $data);
   $newData = date("Y-m-d", mktime(0, 0, 0, $data[1] + $meses, $data[2] + $dias, $data[0] + $ano) );
   return $newData;
}
/*
 * Esta função substitui caracteres por vogais acentuadas e caracteres
 * @access public
 * @param $str
 */
function jsonRemoveUnicodeSequences($struct) {
   //return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}