<?php
    session_start();

    require_once 'Generar_Ticket.php';
    require_once 'Mandar_Correo.php';


    //Recibimos los datos del carrito
    $json = file_get_contents('php://input'); //leemos la entrada
    $data = json_decode($json, true); // transformamos lo que recivimos del json a un array para que lo procese php

    //Conectamos con la base de datos
    $link = mysqli_connect("Localhost", "root", "" , "sistemasii" );
    if(!$link){
        echo json_encode(['succes' => false, 'massage' => 'Error en conexion con la BD']);
        exit;
    }

    //guardamos el contenido del array en variables
    $items = $data['items'];
    $PagoTotal = $data['total'];
    $UsuarioID = $_SESSION['id_usuario'] ?? null; 
    $Correo_Usuario = $_SESSION['correo'] ?? null;
    $Nombre_Usuario = $_SESSION['usuario'] ?? null;

    if (!$UsuarioID) {
    echo json_encode(['success' => false, 'message' => 'Sesion no encontrada. Vuelve a iniciar sesion.']);
    exit;
    }


    //Agregamos la informacion a nuestra tabla Ticket
    $Agre_Ticket = "INSERT INTO ticket(Id_Usuario,fecha,Total_Pago) VALUES ('$UsuarioID', NOW(), '$PagoTotal' )";

    //si la consulta fue correcta y se ejecuto
    if(mysqli_query($link, $Agre_Ticket)){
        $Id_Ticket = mysqli_insert_id($link); //obtenemos el id del ticket que se acaba de crear

        $TodoBien=true;

        foreach ($items as $item){
            $Id_Producto = $item['id'];
            $Nombre = $item['name'];
            $Precio = $item['price'];
            $Cantidad = $item['quantity'];

            //Conectamos con la tabla detalles_t
            $Agre_Detalles = "INSERT INTO detalles_t(Id_Ticket,Id_Carro, Precio_Unitario, Cantidad) VALUES ('$Id_Ticket','$Id_Producto', '$Precio','$Cantidad')";

            if (!mysqli_query($link, $Agre_Detalles)) {
                $TodoBien=False;
                break;
            }

        }
            
            if($TodoBien){
                $nombre_archivo = Crear_Ticket($items,$PagoTotal); //recordar que con el return obtenemos el nombre del ticket
                if($nombre_archivo){
                    $Mandar_Correo =  enviarTicketPorCorreo($Correo_Usuario, $Nombre_Usuario, $nombre_archivo);
                    if($Mandar_Correo){
                    echo json_encode(['success' => true, 'message' => 'Compra guardada, Ticket generado y enviado.']);
                } else {
                    echo json_encode(['success' => true, 'message' => 'Compra guardada pero falló el envío del correo.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear el archivo físico del Ticket.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar los detalles en la BD.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear el ticket maestro.']);
    }

    mysqli_close($link);
