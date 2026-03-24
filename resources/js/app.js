/*
Este archivo mezcla frontend moderno con Laravel.
Este archivo actúa como punto de entrada del frontend y se encarga de inicializar Alpine para añadir 
reactividad sin necesidad de frameworks pesados.”
*/

/*
¿Qué hace esta línea?
        import './bootstrap';
Importa un archivo donde normalmente se configuran cosas globales como:
    - Axios (para peticiones HTTP)
    - CSRF token en Laravel
    - Configuración base de JS
*/
import './bootstrap';

/*Importa la librería Alpine desde node_modules para poder usarla en el proyecto*/
import Alpine from 'alpinejs';

/*
¿Por qué lo asigno a window?
Para hacer Alpine accesible globalmente en el navegador, lo que permite usarlo 
en cualquier parte del HTML.
*/
window.Alpine = Alpine;

/*
¿Qué hace Alpine.start();?
Inicializa Alpine, haciendo que:
    - Detecte directivas como x-data, x-show, etc.
    - Active la reactividad en el DOM.

Si no se llama: Alpine no funcionaría, porque no se inicializa el sistema reactivo.
*/
Alpine.start();

/*
¿Para qué sirve este fichero?
Este archivo inicializa JavaScript del frontend, concretamente:
    - Importa configuraciones base (bootstrap.js)
    - Carga Alpine.js
    - Lo activa en la aplicación

¿Qué es Alpine.js?
Alpine.js es un framework ligero de JavaScript que permite añadir interactividad directamente en el HTML, 
similar a Vue pero mucho más simple. Ejemplo:
        <div x-data="{ open: false }">

¿Qué diferencia hay entre Alpine y Vue/React?
    - Alpine → ligero, se usa directamente en HTML
    - Vue/React → frameworks más complejos, basados en componentes

Laravel usa herramientas como Vite para compilar JS, y este archivo suele ser el punto de entrada 
del frontend.

¿Esto se ejecuta en servidor o en cliente?
En el cliente (navegador), porque es JavaScript del frontend.
*/