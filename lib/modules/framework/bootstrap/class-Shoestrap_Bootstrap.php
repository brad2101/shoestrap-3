<?php

if ( !class_exists( 'Shoestrap_Bootstrap' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class Shoestrap_Bootstrap {

		/**
		 * Class constructor
		 */
		function __construct() {

			$this->defines = array(
				// Layout
				'container'  => 'container',
				'row'        => 'row',
				'col-mobile' => 'col-xs',
				'col-tablet' => 'col-sm',
				'col-normal' => 'col-md',
				'col-large'  => 'col-lg',

				// Buttons
				'button'         => 'btn',
				'button-default' => 'btn-default',
				'button-primary' => 'btn-primary',
				'button-success' => 'btn-success',
				'button-info'    => 'btn-info',
				'button-warning' => 'btn-warning',
				'button-danger'  => 'btn-danger',
				'button-link'    => 'btn-link',

				'button-extra-small' => 'btn-xs',
				'button-small'       => 'btn-sm',
				'button-medium'      => null,
				'button-large'       => 'btn-lg',
				'button-extra-large' => 'btn-lg',

				// Button-Groups
				'button-group'             => 'btn-group',
				'button-group-extra-small' => 'btn-group-xs',
				'button-group-small'       => 'btn-group-sm',
				'button-group-default'     => null,
				'button-group-large'       => 'btn-group-lg',
				'button-group-extra-large' => 'btn-group-lg',

				// Alerts
				'alert'         => 'alert',
				'alert-success' => 'alert-success',
				'alert-info'    => 'alert-info',
				'alert-warning' => 'alert-warning',
				'alert-danger'  => 'alert-danger',

				// Miscelaneous
				'clearfix' => '<div class="clearfix"></div>',
			);

			add_filter( 'shoestrap_frameworks_array', array( $this, 'add_framework' ) );
		}

		/**
		 * Define the framework.
		 * These will be used in the redux admin option to choose a framework.
		 */
		function define_framework() {
			$framework = array(
				'shortname' => 'bootstrap',
				'name'      => 'Bootstrap',
				'classname' => 'Shoestrap_Bootstrap',
			);

			return $framework;

		}

		/**
		 * Add the framework to redux
		 */
		function add_framework( $frameworks ) {
			$frameworks[] = $this->define_framework();

			return $frameworks;
		}

		/**
		 * Makes a container
		 */
		// function make_container( $context = 'open' )

		/**
		 * Creates a row using the framework definitions.
		 *
		 * @param string $context         'open' or 'close'. 'open' uses all the other variables as well to build the row. 'close' only uses the 'element' argument to close the row.
		 * @param string $element         Can be any valid dom element.
		 * @param string $id              The element ID.
		 * @param string $extra_classes   Any extra classes we want to add to the row. extra classes should be separated using a space.
		 * @param string $properties      Can be something like 'name="left_top"'.
		 */
		function make_row( $context = 'open', $element = 'div', $id = null, $extra_classes = null, $properties = null ) {

			$classes = $this->defines['row'];

			if ( !is_null( $id ) ) {
				$id = ' id=' . $id . '"';
			}

			if ( !is_null( $extra_classes ) ) {
				$classes .= ' ' . $extra_classes;
			}

			if ( !is_null( $properties ) ) {
				$properties = ' ' . $properties;
			}

			if ( $context == 'open' ) {
				return '<' . $element . $id . ' class="' . $classes . '"' . $properties . '>';
			} elseif ( $context == 'close' ) {
				return '</' . $element . '>';
			}

		}

		/**
		 * Creates a column using the framework definitions.
		 *
		 * @param string $context         'open' or 'close'. 'open' uses all the other variables as well to build the row. 'close' only uses the 'element' argument to close the row.
		 * @param string $element         Can be any valid dom element.
		 * @param array  $sizes           Format is size => columns. Example: array( 'mobile' => 12, 'tablet' => 12, 'normal' => 6, 'large' => 4 )
		 * @param string $id              The element ID.
		 * @param string $extra_classes   Any extra classes we want to add to the row. extra classes should be separated using a space.
		 * @param string $properties      Can be something like 'name="left_top"'.
		 */
		function make_col( $context = 'open', $element = 'div', $sizes = array( 'normal' => 12 ), $id = null, $extra_classes = null, $properties = null ) {

			$classes = array();

			// Get the classes based on the $sizes array.
			foreach ( $sizes as $size => $columns ) {
				$classes[] = $this->defines['col-' . $size] . '-' . $columns;
			}

			// If extra classes are defined, add them to the array of classes.
			if ( !is_null( $extra_classes ) ) {
				$extra_classes = explode( ' ', $extra_classes );

				foreach ( $extra_classes as $extra_class ) {
					$classes[] = $extra_class;
				}
			}

			// build the CSS classes from the array
			$css_classes = implode( ' ', $classes );

			// If an ID has been defined, format it properly.
			if ( !is_null( $id ) ) {
				$id = ' id=' . $id . '"';
			}

			// Are there any extra properties to add?
			if ( !is_null( $properties ) ) {
				$properties = ' ' . $properties;
			}

			if ( $context == 'open' ) {
				// Open the column
				return '<' . $element . $id . ' class="' . $css_classes . '"' . $properties . '>';
			} elseif ( $context == 'close' ) {
				// Close the column.
				return '</' . $element . '>';
			}
		}

		/**
		 * Get the button classes
		 *
		 * @param string $color
		 * @param string $size
		 * @param string $type
		 */
		function button_classes( $color = 'primary', $size = 'medium', $type = null, $extra = null ) {

			$classes = array();

			$classes[] = $this->defines['button'];

			// Should we allow multiple colors?
			// Perhaps we should... you never know.
			if ( !is_null( $color ) ) {
				$colors = explode( ' ', $color );

				foreach ( $colors as $color ) {
					$classes[] = $this->defines['button-' . $color];
				}
			}

			// Get the proper class for button sizing from the framework definitions.
			if ( $size == 'extra-small' ) {
				$classes[] = $this->defines['button-extra-small'];
			} elseif ( $size == 'small' ) {
				$classes[] = $this->defines['button-small'];
			} elseif ( $size == 'medium' ) {
				$classes[] = $this->defines['button-medium'];
			} elseif ( $size == 'large' ) {
				$classes[] = $this->defines['button-large'];
			} elseif ( $size == 'extra-large' ) {
				$classes[] = $this->defines['button-extra-large'];
			}

			if ( !is_null( $type ) ) {
				$types = explode( ' ', $type );

				foreach ( $types as $type ) {
					$classes[] = $type;
				}
			}

			if ( !is_null( $extra ) ) {
				$extras = explode( ' ', $extra );

				foreach ( $extras as $extra ) {
					$classes[] = $extra;
				}
			}

			// build the CSS classes from the array
			$css_classes = implode( ' ', $classes );

			return $css_classes;
		}

		function button_group_classes( $size = 'medium', $type = null, $extra_classes = null ) {

			$classes = array();

			$classes[] = $this->defines['button-group'];

			// Get the proper class for button sizing from the framework definitions.
			if ( $size == 'extra-small' ) {
				$classes[] = $this->defines['button-group-extra-small'];
			} elseif ( $size == 'small' ) {
				$classes[] = $this->defines['button-group-small'];
			} elseif ( $size == 'medium' ) {
				$classes[] = $this->defines['button-group-medium'];
			} elseif ( $size == 'large' ) {
				$classes[] = $this->defines['button-group-large'];
			} elseif ( $size == 'extra-large' ) {
				$classes[] = $this->defines['button-group-extra-large'];
			}

			if ( !is_null( $extra_classes ) ) {
				$extras = explode( ' ', $extra_classes );

				foreach ( $extras as $extra ) {
					$classes[] = $extra;
				}
			}

			if ( !is_null( $type ) ) {
				$types = explode( ' ', $type );

				foreach ( $types as $type ) {
					$classes[] = $type;
				}
			}
			$classes = implode( ' ', $classes );

			return $classes;
		}

		/**
		 * The framework's clearfix
		 */
		function clearfix() {
			return $this->defines['clearfix'];
		}

		/**
		 * The framework's alert boxes.
		 */
		function alert( $type = 'info', $content = '', $id = null, $extra_classes = null, $dismiss = false ) {
			$classes = array();

			$classes[] = $this->defines['alert'];
			$classes[] = $this->defines['alert-' . $type];

			if ( true == $dismiss ) {
				$classes[] = 'alert-dismissable';

				$dismiss = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			} else {
				$dismiss = null;
			}

			if ( !is_null( $extra_classes ) ) {
				$extras = explode( ' ', $extra_classes );

				foreach ( $extras as $extra ) {
					$classes[] = $extra;
				}
			}

			// If an ID has been defined, format it properly.
			if ( !is_null( $id ) ) {
				$id = ' id=' . $id . '"';
			}

			$classes = implode( ' ', $classes );

			return '<div class="' . $classes . '"' . $id . '>' . $dismiss . $content . '</div>';
		}

		function nav_template() {
			if ( !has_action( 'shoestrap_do_navbar' ) ) {
				get_template_part( 'lib/modules/framework/bootstrap/header-top-navbar' );
			} else {
				do_action( 'shoestrap_do_navbar' );
			}
		}
	}

	$bootstrap = new Shoestrap_Bootstrap();
}