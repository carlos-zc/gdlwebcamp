<?php 

function productos_json(&$boletos, &$camisas = 0, &$etiquetas = 0){
    $dias = [0 => 'un_dia', 1 => 'pase_completo', 2 => 'pase_2dias'];
    
    // unset($boletos['un_dia']['precio']);
    // unset($boletos['completo']['precio']);
    // unset($boletos['dos_dias']['precio']);

    $cantidades = [];
    foreach ($boletos as $pase => $boleto) {
        $cantidades[$pase] = (int) $boleto['cantidad'];
    }
    
    $total_boletos = array_combine($dias, $cantidades);
    
    // $json = array();

    // foreach($total_boletos as $key => $boletos){
    //     if((int) $boletos > 0){
    //         $json[$key] = (int) $boletos;
    //     }
    // }

    $camisas = (int) $camisas;
    if($camisas > 0){
        $total_boletos['camisas'] = $camisas;
    }

    $etiquetas = (int) $etiquetas;
    if($etiquetas > 0){
        $total_boletos['etiquetas'] = $etiquetas;
    }

    return json_encode($total_boletos);
}

function eventos_json(&$eventos){
    $eventos_json = array();
    foreach ($eventos as $evento) {
        $eventos_json['eventos'][] = $evento;
    }

    return json_encode($eventos_json);
}