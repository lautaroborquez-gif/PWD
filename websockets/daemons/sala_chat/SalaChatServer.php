<?php
require_once('websockets.php');
require_once('users.php');

class SalaChatServer extends WebSocketServer {
    
    // Cuando llega un mensaje desde un cliente
    protected function process($user, $message) {
        // Si el usuario todavía no tiene un nombre asignado, el primer mensaje será su nick
        if (!isset($user->nickname)) {
            $user->nickname = trim($message);
            $this->send($user, "Tu nick ha sido establecido como: " . $user->nickname);
            echo "Nuevo usuario conectado: " . $user->nickname . PHP_EOL;
            return;
        }

        // Mostrar en consola del servidor
        echo $user->nickname . " dice: " . $message . PHP_EOL;

        // Reenviar el mensaje a todos los usuarios conectados
        foreach ($this->users as $currentUser) {
            
                $this->send($currentUser, $user->nickname . ": " . $message);
        }
    }

    protected function connected($user) {
        echo "Nuevo cliente conectado" . PHP_EOL;
        $this->send($user, "Bienvenido al chat. Por favor ingresa tu nombre:");
    }

    protected function closed($user) {
        echo "Cliente desconectado" . PHP_EOL;
    }
}

// Iniciar servidor
$chatServer = new SalaChatServer("localhost", "9000");
try {
    $chatServer->run();
} catch (Exception $e) {
    $chatServer->stdout($e->getMessage());
}
?>
