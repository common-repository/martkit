<?php


defined ('ABSPATH') or exit;

if (!class_exists ('Martkit_Add_To_Cart_Text')) :

	Class Martkit_Add_To_Cart_Text {

		public function __construct () {

			add_filter ('add_to_cart_text', [$this, 'martkit_atc_text_button'], 10, 1); //WooCommerce <2.1
			add_filter ('woocommerce_product_add_to_cart_text', [$this, 'martkit_atc_text_button'], 10, 1);
			add_filter ('woocommerce_product_single_add_to_cart_text', [$this, 'martkit_atc_text_button'], 10, 1);
			add_filter ('woocommerce_booking_single_add_to_cart_text', [$this, 'martkit_atc_text_button'], 10, 1); //WC Bookings
		}

		public function martkit_atc_text_button ($text) {

			global $product;

			if (!isset ($product) || !is_object ($product))
				return $text;

			$product_type = $product->get_type();

			$this->carga_opciones();

			//Cogemos el valor de la variable de la bd y si no por defecto
			$texto_externo = esc_attr (get_option ('add_to_cart_external', __('Buy product', 'woocommerce')));
			$texto_agrupado = esc_attr (get_option ('add_to_cart_grouped', __('View products', 'woocommerce')));
			$texto_simple = esc_attr (get_option ('add_to_cart_simple', __('Add to cart', 'woocommerce')));
			$texto_variable = esc_attr (get_option ('add_to_cart_variable', __('Select options', 'woocommerce')));
			$texto_bookable = esc_attr (get_option ('add_to_cart_bookable', __('Book now', 'woocommerce')));
			$texto_externo_single = esc_attr (get_option ('add_to_cart_external_single', $texto_externo));
			$texto_agrupado_single = esc_attr (get_option ('add_to_cart_grouped_single', $texto_simple));
			$texto_simple_single = esc_attr (get_option ('add_to_cart_simple_single', $texto_simple));
			$texto_variable_single = esc_attr (get_option ('add_to_cart_variable_single', $texto_simple));
			$texto_bookable_single = esc_attr (get_option ('add_to_cart_bookable_single', $texto_bookable));

			if (is_product()) { 

				switch ($product_type) {

					case 'external':
						return $this->add_to_cart_external_single;
						break;

					case 'grouped':
						return $this->add_to_cart_grouped_single;
						break;

					case 'simple':
						return $this->add_to_cart_simple_single;
						break;

					case 'variable':
						return $this->add_to_cart_variable_single;
						break;

					case 'booking':
						return $this->add_to_cart_bookable_single;
						break;

					default:
						return $this->addtocart;

					}
				}

			else { 

				switch ($product_type) {

					case 'external':
						return $this->add_to_cart_external;
						break;

					case 'grouped':
						return $this->add_to_cart_grouped;
						break;

					case 'simple':
						return $this->add_to_cart_simple;
						break;

					case 'variable':
						return $this->add_to_cart_variable;
						break;

					case 'booking':
						return $this->add_to_cart_bookable;
						break;

					default:
						return $this->addtocart;

					}
				}

			}


		private function carga_opciones () {

			$this->addtocart     = __('Add to cart', 'woocommerce');
			$this->buyproduct    = _x('Buy product', 'placeholder', 'woocommerce');
			$this->selectoptions = __('Select options', 'woocommerce');
			$this->viewproducts  = __('View products', 'woocommerce');
			$this->booknow       = __('Book now', 'woocommerce-bookings');

			$opciones = array(
				'add_to_cart_external' 			=> $this->buyproduct,
				'add_to_cart_grouped' 			=> $this->viewproducts,
				'add_to_cart_simple' 			=> $this->addtocart,
				'add_to_cart_variable' 			=> $this->selectoptions,
				'add_to_cart_external_single' 	=> $this->buyproduct,
				'add_to_cart_grouped_single' 	=> $this->addtocart,
				'add_to_cart_simple_single' 	=> $this->addtocart,
				'add_to_cart_variable_single' 	=> $this->addtocart,
				'add_to_cart_bookable' 			=> $this->booknow,
				'add_to_cart_bookable_single' 	=> $this->booknow,
				);

			if ($this->ajustes = get_option ('add_to_cart_button_text_settings'))
				foreach ($opciones as $opcion => $default)
					$this->$opcion = isset ($this->ajustes[$opcion]) ? $this->ajustes[$opcion] : false;

			else { 

				foreach ($opciones as $opcion => $default) {

					$this->$opcion          = get_option ($opcion, $default);
					$this->ajustes[$opcion] = $this->$opcion;
					}

				update_option ('add_to_cart_button_text_settings', $this->ajustes);
				}
			}

		}

endif;