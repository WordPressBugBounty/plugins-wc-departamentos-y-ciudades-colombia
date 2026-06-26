=== QCode - Departamentos y Ciudades de Colombia para Woocommerce ===
Contributors: qcode1
Tags: ciudades de colombia, coordinadora, envíos colombia
Donate link: http://qcode.co/
Requires at least: 6.0.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin para mostrar el campo departamento y ciudad como listas de selección. Compatible con el plugin de Coordinadora.

== Description ==
Plugin para mostrar el campo departamento y ciudad como listas de selección. Compatible con el plugin de Coordinadora.

== Installation ==
1. Instale el plugin a través del Administrador de Plugins de su sitio o descárguelo y suba el archivo .zip.
2. Ingrese al Administrador de Plugins de su sitio y active el plugin.

== Frequently Asked Questions ==

== Screenshots ==
1. Selección de ciudad

== Changelog ==

= 1.2.0 =
* Probado en WordPress 6.9 y WooCommerce 10.9.1.
* Seguridad: se escapan las salidas del campo ciudad (esc_html) y la etiqueta (wp_kses_post).
* Fix: se corrige el guardado de la ciudad del pedido (se reemplaza el recorte de 11 caracteres por una expresión regular que elimina solo el sufijo " (CÓDIGO)").
* Mejora: detección de WooCommerce compatible con instalaciones multisitio / activación en red.
* Mejora: versionado del script para cache-busting y cabeceras de plugin (Text Domain, Requires PHP, Requires Plugins).
* Nota: se mantiene el formato del value del select "NOMBRE (CÓDIGO)" por compatibilidad con Coordinadora.

= 1.1.19 =
* Se actualiza la función elBodyDPWoo.on('change') en el archivo place-select.js.

= 1.0.16 =
* Se soluciona el error Undefined array key "Co-ant" en versiones de php > 8.

= 1.0.14 =
* Se reversa a mayúscula el nombre de las ciudades por incompatibilidad con la integración de Coordinadora.

= 1.0.13 =
* Se dejan los nombres de las ciudades en minúscula.
* Se testea en wp 6.3.2 y wc 8.2.1

= 1.0.12 =
* Se corrige error generado por el nombre del departamento en mayúscula después de una compra.

= 1.0.11 =
* Orden alfabético en la lista de departamentos y ciudades.

= 1.0.10 =
* Fix filter in init_states 

= 1.0.7 =
* Fix depatamento woocommerce ajustes

= 1.0.6 =
* fix bugs

= 1.0.5 =
* Se testea en wp 5.9 y wc 6.1.0

= 1.0.1 =
* fix bugs

= 1.0.1 =
* Se agregan los iconos

= 1.0.0 =
* Primera versión.
