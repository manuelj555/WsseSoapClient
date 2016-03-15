# WsseSoapClient

Libreria que facilita la creación de los Headers de seguridad WSSE para ser enviados a un servidor soap que requiera dichos parametros como por ejemplo el bundle https://github.com/manuelj555/WsseServerBundle.

# Instalación

Ejecutar el comando:

    composer require manuelj555/wsse-soap-client 1.0.*@dev
    
Con esto ya se puede utilizar la libreria.

# Uso

Existen dos clases:

#### Ku\WsseSoapClient\WsseHeadersFactory

Crea las cabeceras Username, Nonce, Create y PasswordDigest

#### Ku\WsseSoapClient\WssePasswordDigestCreator

Crea una clave pública en base a una clave privada, un nonce y una fecha dados.

### Ejemplo:

```php

use Ku\WsseSoapClient\WsseHeadersFactory;
use Ku\WsseSoapClient\WssePasswordDigestCreator;

$namespace = 'https://localhost/';
$username = 'YourUsername';
$privatePassword = 'YourPassword';

// Clase encargada de crear la clave pública.
$passwordDigestCreator = new WssePasswordDigestCreator($privatePassword);

$factory = new WsseHeadersFactory($namespace, $username, $passwordDigestCreator);

$nonce = // Obtenemos el nonce....
$headers = $factory->getHeaders($nonce);
// La variable headers contendrá las cabeceras Username, Nonce, Create y PasswordDigest
```
