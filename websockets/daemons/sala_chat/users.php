<?php
class WebSocketUser {
    public $socket;
    public $id;
    public $handshake;
    public $nickname; // agregado para guardar el nick del usuario

    public function __construct($id, $socket) {
        $this->id = $id;
        $this->socket = $socket;
    }
}
?>
