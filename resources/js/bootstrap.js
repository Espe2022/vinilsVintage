/*
¿Qué hace este archivo en general?
Configura Axios para hacer peticiones HTTP desde el frontend y lo deja preparado con valores por defecto.
*/

/*Importa la librería Axios desde node_modules para poder usarla en el proyecto*/
import axios from 'axios';

window.axios = axios;

/*¿Qué hace esta configuración?
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Añade un header por defecto a todas las peticiones indicando que son peticiones AJAX.

¿Para qué sirve X-Requested-With?
Permite al servidor (Laravel) identificar que la petición viene de JavaScript y no de una navegación 
normal del navegador.
*/
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/*
¿Qué es Axios?
Es una librería de JavaScript que permite hacer peticiones HTTP (GET, POST, etc.) al servidor de forma 
sencilla.

¿Qué es AJAX?
Es una técnica que permite hacer peticiones al servidor sin recargar la página.

¿Ésto tiene relación con seguridad?
Sí, puede ayudar a identificar el tipo de petición, pero la seguridad real en Laravel se gestiona con 
tokens CSRF.

¿Dónde se usa esto realmente?
Cuando haces cosas como:
    - Formularios sin recarga
    - Peticiones desde Alpine.js
    - APIs internas

¿Qué pasa si no configuras ese header?
Normalmente la app seguiría funcionando, pero el servidor no podría distinguir fácilmente si la petición 
es AJAX.

*/