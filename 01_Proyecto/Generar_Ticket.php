<?php

function Crear_Ticket($items,$PagoTotal){
    $fecha = date('Y-m-d_H-i-s');
    $nombre_archivo = __DIR__."/tickets/ticket_$fecha.txt"; // __DIR__ obtiene la ruta de la carpeta donde estA este archivo PHP actualmente

    //si no existe el directorio, lo creamos
    if(!file_exists('tickets')){
        mkdir('tickets', 0777, true);
    }

    //Contenido del ticket (el punto indica otra linea)
    $contenido = "================================\n";
    $contenido .= "      TICKET DE COMPRA        \n";
    $contenido .= "================================\n";
    $contenido .= "Fecha: " . date('d/m/Y H:i:s') . "\n";
    $contenido .= "--------------------------------\n";

    foreach($items as $item){

        $Nombre = $item['name'];
        $Precio = $item['price'];
        $Cantidad = $item['quantity'];
        $subtotal = $Precio * $Cantidad;
        
        //Linea del producto que ira en el tickey
        $contenido .= sprintf("%-15s x%d  $%6.2f\n", substr($Nombre, 0, 15), $Cantidad, $subtotal);
    }

    $contenido .= "--------------------------------\n";
    $contenido .= sprintf("TOTAL:                 $%6.2f\n", $PagoTotal);
    $contenido .= "================================\n";
    $contenido .= "¡Gracias por su compra!\n";

    //guardamos el archivo
    if(file_put_contents($nombre_archivo, $contenido )){
        return $nombre_archivo; //para el correo
    }else{
        return false;
    }
}