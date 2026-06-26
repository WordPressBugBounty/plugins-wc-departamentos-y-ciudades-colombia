<?php

/**
 * @package         QCode - Departamentos y Ciudades de Colombia para Woocommerce
 * @author          QCode
 * @version         1.2.0
 *
 * @wordpress-plugin
 * Plugin name:     QCode - Departamentos y Ciudades de Colombia para Woocommerce
 * Description:     Plugin para mostrar el campo departamento y ciudad como listas de selección. Compatible con el plugin de Coordinadora.
 * Author:          QCode
 * Version:         1.2.0
 * Author URI:      https://qcode.co/
 * Text Domain:     wc-qcode-departamentos-y-ciudades-colombia
 * Domain Path:     /languages
 * Requires at least: 6.0
 * Requires PHP:    7.4
 * Requires Plugins: woocommerce
 * WC tested up to: 10.9.1
 * WC requires at least: 7.6.0
 */

if (!defined('ABSPATH')) exit;

define('DYCDCPWC_VERSION', '1.2.0');
define('DYCDCPWC_TEXTDOMAIN', 'wc-qcode-departamentos-y-ciudades-colombia');

/**
 * Load plugin translations from /languages.
 */
add_action('init', function () {
  load_plugin_textdomain(
    'wc-qcode-departamentos-y-ciudades-colombia',
    false,
    dirname(plugin_basename(__FILE__)) . '/languages'
  );
});

/**
 * Check if WooCommerce is active, including network-activated installs.
 *
 * @return bool
 */
function DYCDCPWC_is_woocommerce_active()
{
  $active = (array) get_option('active_plugins', array());
  if (is_multisite()) {
    $active = array_merge($active, array_keys((array) get_site_option('active_sitewide_plugins', array())));
  }
  return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', $active), true);
}

if (DYCDCPWC_is_woocommerce_active()) {

  /** Places Coordinadora */
  require_once('includes/DYCDCPWC_Woo_Places_Class.php');
  $GLOBALS['wc_states_places'] = new DYCDCPWC_Woo_Places_Class(__FILE__);

  function DYCDCPWC_woo_default_address_fields($fields)
  {
    if ($fields['city']['priority'] < $fields['state']['priority']) {
      $state_priority = $fields['state']['priority'];
      $fields['state']['priority'] = $fields['city']['priority'];
      $fields['city']['priority'] = $state_priority;
    }
    $fields['postcode']['required'] = false;
    return $fields;
  }
  add_filter('woocommerce_default_address_fields', 'DYCDCPWC_woo_default_address_fields');

  add_action(
    'before_woocommerce_init',
    function () {
      if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
      }
    }
  );


  /**
   * Remove the trailing " (CODE)" suffix from the city value before saving.
   * The select value keeps the format "CITY NAME (CODE)" (other plugins like
   * Coordinadora depend on it); only the persisted order city is normalized.
   */
  function DYCDCPWC_strip_city_code($city)
  {
    if (!is_string($city) || $city === '') {
      return $city;
    }
    // Strip only a trailing numeric DANE code " (NNNN)"; leave any other
    // trailing group like " (QDIO)" intact so the saved value is not corrupted.
    return preg_replace('/\s*\(\d+\)\s*$/', '', $city);
  }

  add_action('woocommerce_checkout_update_order_meta', function ($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) {
      return;
    }

    $billing_city  = DYCDCPWC_strip_city_code($order->get_billing_city());
    $shipping_city = DYCDCPWC_strip_city_code($order->get_shipping_city());

    $changed = false;
    if ($billing_city !== $order->get_billing_city()) {
      $order->set_billing_city($billing_city);
      $changed = true;
    }
    if ($shipping_city !== $order->get_shipping_city()) {
      $order->set_shipping_city($shipping_city);
      $changed = true;
    }

    if ($changed) {
      $order->save();
    }
  }, 10, 2);
}
