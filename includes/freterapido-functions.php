<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function text_domain_taxonomy_add_new_meta_field() {
		/** @var WP_Term[] $fr_categories */
		$fr_categories = get_terms(
			[
				'taxonomy'   => 'fr_category',
				'hide_empty' => false,
			]
		);
		?>
		<hr>
		<h1>Configurações do Frete Rápido</h1>
		<div class="form-field">
			<label for="term_meta[fr_category]"><?php _e( 'Categoria no Frete Rápido', 'freterapido' ); ?></label>
			<select name="term_meta[fr_category]" id="term_meta[fr_category]">
				<option value="0" selected>-- Selecione --</option>
				<?php
				foreach ( $fr_categories as $fr_category ) {
					echo "<option value='{$fr_category->description}'>{$fr_category->name}</option>";
				}
				?>
			</select>
		</div>
		<h2>Dados de Origem:</h2>
		<p><b>Os dados de origem somente serão usados se todos os campos do <i>Endereço</i> (exceto o complemento), e da <i>Empresa</i>, estiverem preenchidos.</b></p>
		<span>Dados de endereço específicos por categoria</span>
		<h2>Endereço:</h2>
		<div class="form-field">
			<label for="term_meta[fr_origin_cep]"><?php _e( 'CEP', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_cep]" id="term_meta[fr_origin_cep]" maxlength="8" pattern="[0-9]{8}">
			<p class="description"><?php _e( 'Only numbers', 'freterapido' ); ?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[fr_origin_rua]"><?php _e( 'Rua', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_rua]" id="term_meta[fr_origin_rua]">
		</div>
		<div class="form-field">
			<label for="term_meta[fr_origin_numero]"><?php _e( 'Número', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_numero]" id="term_meta[fr_origin_numero]">
		</div>
		<div class="form-field">
			<label for="term_meta[fr_origin_bairro]"><?php _e( 'Bairro', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_bairro]" id="term_meta[fr_origin_bairro]">
		</div>
		<div class="form-field">
			<label for="term_meta[fr_origin_complemento]"><?php _e( 'Complemento', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_complemento]" id="term_meta[fr_origin_complemento]">
		</div>
		<h2>Empresa:</h2>
		<div class="form-field">
			<label for="term_meta[fr_origin_cnpj]"><?php _e( 'CNPJ', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_cnpj]" id="term_meta[fr_origin_cnpj]" pattern="[0-9]{14}" maxlength="14">
			<p class="description"><?php _e( 'Only numbers', 'freterapido' ); ?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[fr_origin_razao_social]"><?php _e( 'Razão Social', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_razao_social]" id="term_meta[fr_origin_razao_social]">
		</div>
		<div class="form-field">
			<label for="term_meta[fr_origin_inscricao_estadual]"><?php _e( 'Inscrição Estadual', 'freterapido' ); ?></label>
			<input type="text" name="term_meta[fr_origin_inscricao_estadual]" id="term_meta[fr_origin_inscricao_estadual]">
		</div>

		<hr>
		<?php
}

	add_action( 'product_cat_add_form_fields', 'text_domain_taxonomy_add_new_meta_field', 10, 2 );

	//Product Cat Edit page
function text_domain_taxonomy_edit_meta_field( $term ) {
	//getting term ID
	$term_id = $term->term_id;
	/** @var WP_Term[] $fr_categories */
	$fr_categories = get_terms(
		[
			'taxonomy'   => 'fr_category',
			'hide_empty' => false,
		]
	);
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( 'taxonomy_' . $term_id );
	?>
		<tr class="form-field">
			<th scope="row" valign="top">
			</th>
			<td>
				<hr>
				<h1>Configurações do Frete Rápido</h1>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="term_meta[fr_category]"><?php _e( 'Categoria no Frete Rápido', 'text_domain' ); ?></label>
			</th>
			<td>
				<select name="term_meta[fr_category]" id="term_meta[fr_category]">
					<option value="0">-- Selecione --</option>
					<?php
					foreach ( $fr_categories as $fr_category ) {
						$fr_category_id_selected = esc_attr( $term_meta['fr_category'] ) ? esc_attr( $term_meta['fr_category'] ) : '';
						$is_selected             = $fr_category->description == $fr_category_id_selected;
						echo "<option value='{$fr_category->description}'" . ( $is_selected ? 'selected' : '' ) . ">{$fr_category->name}</option>";
					}
					?>
					</select>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
				</th>
				<td>
					<h2>Dados de Origem:</h2>
					<p><b>Os dados de origem somente serão usados se todos os campos do <i>Endereço</i> (exceto o complemento), e da <i>Empresa</i>, estiverem preenchidos.</b></p>
					<br>
					<span>Dados de endereço específicos por categoria</span>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<h4>Endereço:</h4>
				</th>
				<td>

				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_cep]"><?php _e( 'CEP', 'text_domain' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_cep]" id="term_meta[fr_origin_cep]" value="<?php echo esc_attr( $term_meta['fr_origin_cep'] ) ? esc_attr( $term_meta['fr_origin_cep'] ) : ''; ?>" maxlength="8" pattern="[0-9]{8}">
					<p class="description"><?php _e( 'Only numbers', 'freterapido' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_rua]"><?php _e( 'Rua', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_rua]" id="term_meta[fr_origin_rua]" value="<?php echo esc_attr( $term_meta['fr_origin_rua'] ) ? esc_attr( $term_meta['fr_origin_rua'] ) : ''; ?>">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_numero]"><?php _e( 'Número', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_numero]" id="term_meta[fr_origin_numero]" value="<?php echo esc_attr( $term_meta['fr_origin_numero'] ) ? esc_attr( $term_meta['fr_origin_numero'] ) : ''; ?>">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_bairro]"><?php _e( 'Bairro', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_bairro]" id="term_meta[fr_origin_bairro]" value="<?php echo esc_attr( $term_meta['fr_origin_bairro'] ) ? esc_attr( $term_meta['fr_origin_bairro'] ) : ''; ?>">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_complemento]"><?php _e( 'Complemento', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_complemento]" id="term_meta[fr_origin_complemento]" value="<?php echo esc_attr( $term_meta['fr_origin_complemento'] ) ? esc_attr( $term_meta['fr_origin_complemento'] ) : ''; ?>">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<h4>Empresa:</h4>
				</th>
				<td>

				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_cnpj]"><?php _e( 'CNPJ', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_cnpj]" id="term_meta[fr_origin_cnpj]" pattern="[0-9]{14}" maxlength="14" value="<?php echo esc_attr( $term_meta['fr_origin_cnpj'] ) ? esc_attr( $term_meta['fr_origin_cnpj'] ) : ''; ?>">
					<p class="description"><?php _e( 'Only numbers', 'freterapido' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_razao_social]"><?php _e( 'Razão Social', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_razao_social]" id="term_meta[fr_origin_razao_social]" value="<?php echo esc_attr( $term_meta['fr_origin_razao_social'] ) ? esc_attr( $term_meta['fr_origin_razao_social'] ) : ''; ?>">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="term_meta[fr_origin_inscricao_estadual]"><?php _e( 'Inscrição Estadual', 'freterapido' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[fr_origin_inscricao_estadual]" id="term_meta[fr_origin_inscricao_estadual]" value="<?php echo esc_attr( $term_meta['fr_origin_inscricao_estadual'] ) ? esc_attr( $term_meta['fr_origin_inscricao_estadual'] ) : ''; ?>">
				</td>
			</tr>
			<tr>
				<th scope="row" valign="top">
				</th>
				<td>
					<hr>
				</td>
			</tr>
		<?php
}

	add_action( 'product_cat_edit_form_fields', 'text_domain_taxonomy_edit_meta_field', 10, 2 );

function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = get_option( 'taxonomy_' . $term_id );
		$cat_keys  = array_keys( $_POST['term_meta'] );

		foreach ( $cat_keys as $key ) {
			if ( isset( $_POST['term_meta'][ $key ] ) ) {
				$term_meta[ $key ] = $_POST['term_meta'][ $key ];
			}
		}

		update_option( 'taxonomy_' . $term_id, $term_meta );
	}
}

	add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 );
	add_action( 'create_product_cat', 'save_taxonomy_custom_meta', 10, 2 );

function woocommerce_product_options_shipping_custom() {
	woocommerce_wp_text_input(
		array(
			'id'          => 'manufacturing_deadline',
			'label'       => __( 'Manufacturing deadline', 'freterapido' ),
			'description' => __( 'Will be added to the delivery time', 'freterapido' ),
			'desc_tip'    => true,
		)
	);
}

	// Display Fields using WooCommerce Action Hook
	add_action( 'woocommerce_product_options_shipping', 'woocommerce_product_options_shipping_custom' );

function woocommerce_process_product_meta_fields_save( $post_id ) {
	update_post_meta( $post_id, 'manufacturing_deadline', $_POST['manufacturing_deadline'] );
}

	// Save Fields using WooCommerce Action Hook
	add_action( 'woocommerce_process_product_meta', 'woocommerce_process_product_meta_fields_save' );

	global $fr_db_version;
	$fr_db_version = '1.0';

function fr_install() {
	global $fr_db_version;

	fr_category_init();

	$fr_categories = [
		[
			'name' => 'Abrasivos',
			'code' => 1,
		],
		[
			'name' => 'Adubos / Fertilizantes',
			'code' => 2,
		],
		[
			'name' => 'Alimentos perecíveis',
			'code' => 3,
		],
		[
			'name' => 'Artigos para Pesca',
			'code' => 4,
		],
		[
			'name' => 'Auto Peças',
			'code' => 5,
		],
		[
			'name' => 'Bebidas / Destilados',
			'code' => 6,
		],
		[
			'name' => 'Brindes',
			'code' => 7,
		],
		[
			'name' => 'Brinquedos',
			'code' => 8,
		],
		[
			'name' => 'Calçados',
			'code' => 9,
		],
		[
			'name' => 'CD / DVD / Blu-Ray',
			'code' => 10,
		],
		[
			'name' => 'Combustíveis / Óleos',
			'code' => 11,
		],
		[
			'name' => 'Confecção',
			'code' => 12,
		],
		[
			'name' => 'Cosméticos',
			'code' => 13,
		],
		[
			'name' => 'Couro',
			'code' => 14,
		],
		[
			'name' => 'Derivados Petróleo',
			'code' => 15,
		],
		[
			'name' => 'Descartáveis',
			'code' => 16,
		],
		[
			'name' => 'Editorial',
			'code' => 17,
		],
		[
			'name' => 'Eletrônicos',
			'code' => 18,
		],
		[
			'name' => 'Eletrodomésticos',
			'code' => 19,
		],
		[
			'name' => 'Embalagens',
			'code' => 20,
		],
		[
			'name' => 'Explosivos / Pirotécnicos',
			'code' => 21,
		],
		[
			'name' => 'Medicamentos',
			'code' => 22,
		],
		[
			'name' => 'Ferragens',
			'code' => 23,
		],
		[
			'name' => 'Ferramentas',
			'code' => 24,
		],
		[
			'name' => 'Fibras Ópticas',
			'code' => 25,
		],
		[
			'name' => 'Fonográfico',
			'code' => 26,
		],
		[
			'name' => 'Fotográfico',
			'code' => 27,
		],
		[
			'name' => 'Fraldas / Geriátricas',
			'code' => 28,
		],
		[
			'name' => 'Higiene',
			'code' => 29,
		],
		[
			'name' => 'Impressos',
			'code' => 30,
		],
		[
			'name' => 'Informática / Computadores',
			'code' => 31,
		],
		[
			'name' => 'Instrumento Musical',
			'code' => 32,
		],
		[
			'name' => 'Livro(s)',
			'code' => 33,
		],
		[
			'name' => 'Materiais Escolares',
			'code' => 34,
		],
		[
			'name' => 'Materiais Esportivos',
			'code' => 35,
		],
		[
			'name' => 'Materiais Frágeis',
			'code' => 36,
		],
		[
			'name' => 'Material de Construção',
			'code' => 37,
		],
		[
			'name' => 'Material de Irrigação',
			'code' => 38,
		],
		[
			'name' => 'Material Elétrico / Lâmpada(s)',
			'code' => 39,
		],
		[
			'name' => 'Material Gráfico',
			'code' => 40,
		],
		[
			'name' => 'Material Hospitalar',
			'code' => 41,
		],
		[
			'name' => 'Material Odontológico',
			'code' => 42,
		],
		[
			'name' => 'Material Pet Shop',
			'code' => 43,
		],
		[
			'name' => 'Material Veterinário',
			'code' => 44,
		],
		[
			'name' => 'Móveis montados',
			'code' => 45,
		],
		[
			'name' => 'Moto Peças',
			'code' => 46,
		],
		[
			'name' => 'Mudas / Plantas',
			'code' => 47,
		],
		[
			'name' => 'Papelaria / Documentos',
			'code' => 48,
		],
		[
			'name' => 'Perfumaria',
			'code' => 49,
		],
		[
			'name' => 'Material Plástico',
			'code' => 50,
		],
		[
			'name' => 'Pneus e Borracharia',
			'code' => 51,
		],
		[
			'name' => 'Produtos Cerâmicos',
			'code' => 52,
		],
		[
			'name' => 'Produto Químico Não Classificado',
			'code' => 53,
		],
		[
			'name' => 'Produtos Veterinários',
			'code' => 54,
		],
		[
			'name' => 'Revistas',
			'code' => 55,
		],
		[
			'name' => 'Sementes',
			'code' => 56,
		],
		[
			'name' => 'Suprimentos Agrícolas / Rurais',
			'code' => 57,
		],
		[
			'name' => 'Têxtil',
			'code' => 58,
		],
		[
			'name' => 'Vacinas',
			'code' => 59,
		],
		[
			'name' => 'Vestuário',
			'code' => 60,
		],
		[
			'name' => 'Vidros / Frágil',
			'code' => 61,
		],
		[
			'name' => 'Cargas refrigeradas/congeladas',
			'code' => 62,
		],
		[
			'name' => 'Papelão',
			'code' => 63,
		],
		[
			'name' => 'Móveis desmontados',
			'code' => 64,
		],
		[
			'name' => 'Sofá',
			'code' => 65,
		],
		[
			'name' => 'Colchão',
			'code' => 66,
		],
		[
			'name' => 'Travesseiro',
			'code' => 67,
		],
		[
			'name' => 'Móveis com peças de vidro',
			'code' => 68,
		],
		[
			'name' => 'Acessórios de Airsoft / Paintball',
			'code' => 69,
		],
		[
			'name' => 'Acessórios de Pesca ',
			'code' => 70,
		],
		[
			'name' => 'Simulacro de Arma / Airsoft',
			'code' => 71,
		],
		[
			'name' => 'Arquearia',
			'code' => 72,
		],
		[
			'name' => 'Acessórios de Arquearia',
			'code' => 73,
		],
		[
			'name' => 'Alimentos não perecíveis',
			'code' => 74,
		],
		[
			'name' => 'Caixa de embalagem',
			'code' => 75,
		],
		[
			'name' => 'TV / Monitores',
			'code' => 76,
		],
		[
			'name' => 'Linha Branca',
			'code' => 77,
		],
		[
			'name' => 'Vitaminas / Suplementos nutricionais',
			'code' => 78,
		],
		[
			'name' => 'Malas / Mochilas',
			'code' => 79,
		],
		[
			'name' => 'Máquina / Equipamentos',
			'code' => 80,
		],
		[
			'name' => 'Rações / Alimento para Animal',
			'code' => 81,
		],
		[
			'name' => 'Artigos para Camping',
			'code' => 82,
		],
		[
			'name' => 'Pilhas / Baterias',
			'code' => 83,
		],
		[
			'name' => 'Estiletes / Materiais cortantes',
			'code' => 84,
		],
		[
			'name' => 'Produto Químico Classificado',
			'code' => 85,
		],
		[
			'name' => 'Limpeza',
			'code' => 86,
		],
		[
			'name' => 'Extintores',
			'code' => 87,
		],
		[
			'name' => 'Equipamentos de segurança / EPI',
			'code' => 88,
		],
		[
			'name' => 'Outros',
			'code' => 999,
		],
	];

	foreach ( $fr_categories as $fr_category ) {
		wp_insert_term( $fr_category['name'], 'fr_category', [ 'description' => $fr_category['code'] ] );
	}

	add_option( 'fr_db_version', $fr_db_version );
}

	register_activation_hook( __FILE__, 'fr_install' );

function fr_category_init() {
	// create a new taxonomy
	register_taxonomy(
		'fr_category',
		'product',
		array(
			'label'        => __( 'FR Category' ),
			'hierarchical' => false,
			'show_ui'      => false,
		)
	);
}

	add_action( 'init', 'fr_category_init' );

	/**
	 * Register new status with ID "wc-misha-shipment" and label "Awaiting shipment"
	 */
function freterapido_register_awaiting_shipment_status() {
	register_post_status(
		'wc-awaiting-shipment', array(
			'label'                     => __( 'Awaiting shipment', 'freterapido' ),
			'public'                    => true,
			'show_in_admin_status_list' => true, // show count All (12) , Completed (9) , Awaiting shipment (2) ...
			'label_count'               => _n_noop( 'Awaiting shipment <span class="count">(%s)</span>', 'Awaiting shipment <span class="count">(%s)</span>', 'freterapido' ),
		)
	);
}

	add_action( 'init', 'freterapido_register_awaiting_shipment_status' );

	/*
     * Add registered status to list of WC Order statuses
     * @param array $wc_statuses_arr Array of all order statuses on the website
     */
function freterapido_add_status( $wc_statuses_arr ) {
	$new_statuses_arr = array();

	// add new order status after processing
	foreach ( $wc_statuses_arr as $id => $label ) {
		$new_statuses_arr[ $id ] = $label;

		if ( 'wc-on-hold' === $id ) { // after "Completed" status
			$new_statuses_arr['wc-awaiting-shipment'] = __( 'Awaiting shipment', 'freterapido' );
		}
	}

	return $new_statuses_arr;

}

	add_filter( 'wc_order_statuses', 'freterapido_add_status' );

function order_awaiting_shipment( $order_id ) {
	$order = wc_get_order( $order_id );

	// Verifica se o frete contratado é do Frete Rápido
	$method = array_filter(
		$order->get_shipping_methods(), function ( $method ) {
			return strrpos( $method['method_id'], 'freterapido' ) !== false;
		}
	);

	if ( empty( $method ) ) {
		return;
	}

	$item_id   = array_shift( array_keys( $method ) );
	$item_meta = wc_get_order_item_meta( $item_id, 'freterapido_quotes' );
	$settings  = get_option( 'woocommerce_freterapido_settings' );
	$address   = $order->get_address( 'shipping' );

	$hire_shipping = new WC_Freterapido_Hire_Shipping( $settings['token'] );
	$hire_shipping
		->add_order( $order_id )
		->add_sender( array( 'cnpj' => $settings['cnpj'] ) )
		->add_receiver(
			array(
				'cnpj_cpf' => WC_Freterapido_Helpers::fix_zip_code( $order->billing_cpf ),
				'nome'     => $order->get_formatted_shipping_full_name(),
				'email'    => $order->billing_email,
				'telefone' => WC_Freterapido_Helpers::fix_zip_code( $order->billing_phone ),
				'endereco' => array(
					'cep'    => WC_Freterapido_Helpers::fix_zip_code( $address['postcode'] ),
					'rua'    => $address['address_1'],
					'bairro' => isset( $address['neighborhood'] ) ? $address['neighborhood'] : '',
					'numero' => isset( $address['number'] ) ? $address['number'] : '',
				),
			)
		);

	$results = wc_get_order_item_meta( $order_id, 'freterapido_shippings' ) ?: array();

	foreach ( $item_meta as $item ) {
		$dispatcher = array();

		if ( $item['expedidor'] ) {
			$dispatcher = $item['expedidor'];
		}

		try {
			$response = $hire_shipping
				->add_dispatcher( $dispatcher )
				->hire_quote( $item['token'], $item['oferta'] );

			$results = array_merge( $results, array_values( $response ) );
		} catch ( Exception $e ) {
			continue;
		}
	}

	if ( count( $results ) == 0 ) {
		return;
	}

	wc_update_order_item_meta( $order_id, 'freterapido_shippings', array_values( $results ) );
}

	add_action( 'woocommerce_order_status_awaiting-shipment', 'order_awaiting_shipment' );
