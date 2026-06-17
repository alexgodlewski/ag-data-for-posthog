<?php
/**
 * AG Data for PostHog Settings Page.
 *
 * Adds a AG Data for PostHog tab to WooCommerce > Settings. This file is only
 * loaded when WC_Settings_Page is available (admin context).
 *
 * @package AGDataForPostHog
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class APHA_Settings_Page
 *
 * Extends WC_Settings_Page to provide a dedicated settings tab.
 */
class APHA_Settings_Page extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'ag-data-for-posthog';
		$this->label = 'AG Data';

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array Settings fields.
	 */
	public function get_settings() {
		$settings = array(
			array(
				'title' => __( 'PostHog Configuration', 'ag-data-for-posthog' ),
				'type'  => 'title',
				'id'    => 'apha_posthog_configuration',
			),

			array(
				'title'    => __( 'PostHog API Key', 'ag-data-for-posthog' ),
				'desc'     => __( 'Your PostHog project API key (starts with phc_).', 'ag-data-for-posthog' ),
				'id'       => 'apha_api_key',
				'type'     => 'text',
				'default'  => '',
				'desc_tip' => true,
			),

			array(
				'title'   => __( 'Region', 'ag-data-for-posthog' ),
				'id'      => 'apha_region',
				'type'    => 'select',
				'default' => 'us',
				'options' => array(
					'us' => __( 'US (us.posthog.com)', 'ag-data-for-posthog' ),
					'eu' => __( 'EU (eu.posthog.com)', 'ag-data-for-posthog' ),
				),
			),

			array(
				'title'    => __( 'Custom Proxy URL', 'ag-data-for-posthog' ),
				'desc'     => __( 'Optional. External reverse proxy domain for first-party tracking (e.g., https://ph.yourdomain.com). Leave empty to use PostHog directly.', 'ag-data-for-posthog' ),
				'id'       => 'apha_custom_proxy_url',
				'type'     => 'text',
				'default'  => '',
				'desc_tip' => false,
			),

			array(
				'type' => 'sectionend',
				'id'   => 'apha_posthog_configuration',
			),

			array(
				'title' => __( 'Tracking Options', 'ag-data-for-posthog' ),
				'type'  => 'title',
				'id'    => 'apha_tracking_options',
			),

			array(
				'title'   => __( 'Enable Server-Side Tracking', 'ag-data-for-posthog' ),
				'desc'    => __( 'Track Order Completed, Refunded, and Status Changed events server-side (recommended).', 'ag-data-for-posthog' ),
				'id'      => 'apha_server_tracking',
				'type'    => 'checkbox',
				'default' => 'yes',
			),

			array(
				'title'   => __( 'Enable Frontend Tracking', 'ag-data-for-posthog' ),
				'desc'    => __( 'Track browsing events (Product Viewed, Cart Viewed, etc.) via JavaScript.', 'ag-data-for-posthog' ),
				'id'      => 'apha_frontend_tracking',
				'type'    => 'checkbox',
				'default' => 'yes',
			),

			array(
				'title'   => __( 'Person Profiles', 'ag-data-for-posthog' ),
				'id'      => 'apha_person_profiles',
				'type'    => 'select',
				'default' => 'always',
				'options' => array(
					'always'          => __( 'Always create profiles', 'ag-data-for-posthog' ),
					'identified_only' => __( 'Identified users only', 'ag-data-for-posthog' ),
				),
			),

			array(
				'title'   => __( 'Consent Mode', 'ag-data-for-posthog' ),
				'desc'    => __( 'Require cookie consent before tracking. Supports CookieYes and Complianz.', 'ag-data-for-posthog' ),
				'id'      => 'apha_consent_mode',
				'type'    => 'checkbox',
				'default' => 'no',
			),

			array(
				'title'   => __( 'Form Identification', 'ag-data-for-posthog' ),
				'desc'    => __( 'Identify visitors when they enter an email address in any form (checkout, contact, signup).', 'ag-data-for-posthog' ),
				'id'      => 'apha_form_identify',
				'type'    => 'checkbox',
				'default' => 'yes',
			),

			array(
				'title'   => __( 'Element Visibility Tracking', 'ag-data-for-posthog' ),
				'desc'    => __( 'Track when visitors see key page elements. Add CSS class <code>apha-track-view</code> to any element.', 'ag-data-for-posthog' ),
				'id'      => 'apha_element_visibility',
				'type'    => 'checkbox',
				'default' => 'no',
			),

			array(
				'type' => 'sectionend',
				'id'   => 'apha_tracking_options',
			),
		);

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Standard WooCommerce settings filter.
	}
}
