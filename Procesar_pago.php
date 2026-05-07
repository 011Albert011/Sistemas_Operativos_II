<?php
ob_start(); // Atrapa cualquier salida accidental (errores, espacios)
session_start();

require_once 'Generar_Ticket.php';
require_once 'Mandar_Correo.php';

// Recibimos los datos del carrito
$json = file_get_contents('php://input'); 
$data = json_decode($json, true); 

// Conectamos con la base de datos
$link = mysqli_connect("localhost", "root", "", "sistemasii");
if(!$link){
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Error en conexion con la BD']);
    exit;
}

// Guardamos el contenido en variables
$items = $data['items'] ?? [];
$PagoTotal = $data['total'] ?? 0;
$UsuarioID = $_SESSION['id_usuario'] ?? null; 
$Correo_Usuario = $_SESSION['correo'] ?? null;
$Nombre_Usuario = $_SESSION['usuario'] ?? null;

if (!$UsuarioID) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Sesion no encontrada. Vuelve a iniciar sesion.']);
    exit;
}

// 1. Agregamos a la tabla Ticket
$Agre_Ticket = "INSERT INTO ticket(Id_Usuario, fecha, Total_Pago) VALUES ('$UsuarioID', NOW(), '$PagoTotal')";

if(mysqli_query($link, $Agre_Ticket)){
    $Id_Ticket = mysqli_insert_id($link); 
    $TodoBien = true;

    foreach ($items as $item){
        $Id_Producto = $item['id'];
        $Precio = $item['price'];
        $Cantidad = $item['quantity'];

        //Middleware de validacion 
        //consultamos la cantidad de los vehiculos
        $restStock = mysqli_query($link, "SELECT Stock FROM carro where Id_Carro = '$Id_Producto'" );
        $filastock =mysqli_fetch_assoc($restStock);
        $stockDisponible= $filastock['Stock'];
        $stockModificado= $stockDisponible - 1;

        if($stockModificado >= $Cantidad){
            //actualizamos el fucking recurso
            $nuevoStock = $stockDisponible - $Cantidad;
            mysqli_query($link, "UPDATE carro set Stock = $nuevoStock WHERE Id_Carro = '$Id_Producto'");

            $Agre_Detalles = "INSERT INTO detalles_t(Id_Ticket, Id_Carro, Precio_Unitario, Cantidad) VALUES ('$Id_Ticket', '$Id_Producto', '$Precio', '$Cantidad')";
            if(!mysqli_query($link, $Agre_Detalles)){
                $TodoBien = false;
                break;
            }

        }else {
        ob_clean();
            //si no hay suficniete stock
            echo json_encode(['success' => false, 'message' => "Stock insuficiente para un modelo seleccionado."]);
            mysqli_close($link);
            exit;
        }
    }
    
    if($TodoBien){
        $nombre_archivo = Crear_Ticket($items, $PagoTotal); 
        
        if($nombre_archivo){
            $Mandar_Correo = enviarTicketPorCorreo($Correo_Usuario, $Nombre_Usuario, $nombre_archivo);
            $soloNombre = basename($nombre_archivo);
            $_SESSION['ultimo_ticket'] = 'tickets/' . $soloNombre;

            ob_clean(); // Limpiamos el buffer antes de enviar el JSON final
            if($Mandar_Correo){
                echo json_encode([
                    'success' => true, 
                    'message' => 'Compra exitosa, ticket enviado e imprimiendo...',
                    'ruta' => 'tickets/' . $soloNombre
                ]);
            } else {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Compra guardada pero falló el envío del correo. Iniciando impresión...',
                    'ruta' => 'tickets/' . $soloNombre
                ]);
            }
            exit; // Terminamos aquí para evitar basura extra
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'Error al crear el archivo físico del Ticket.']);
        }
    } else {
        ob_clean();
        echo json_encode(['success' => false, 'message' => 'Error al guardar los detalles en la BD.']);
    }
} else {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Error al crear el ticket maestro.']);
}

mysqli_close($link);