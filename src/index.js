const { createElement } = wp.element;
const { TextControl } = wp.components;
const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

registerBlockType( 'wpqba/block', {
    title: __( 'WP Query Block Attributes', 'wp-query-block-attributes' ),

    description: __( 'An example block to demo WP Query Block Attributes.', 'wp-query-block-attributes' ),

    supports: {
		className: true,
		anchor: true,
		multiple: false,
		reusable: false,
	},

    icon: 'feedback',

    category: 'common',

    attributes: {
        wpqbaAttributeOne: {
			type: 'string',
		},
		wpqbaAttributeTwo: {
			type: 'integer',
		},
    },

    edit: function( { attributes, setAttributes } ) {
        return (
            <div>
				<h2>{ __( 'Test Form', 'wp-query-block-attributes' ) }</h2>
				<hr/>
                <TextControl
					label={ __( 'Test input One', 'wp-query-block-attributes' ) }
					value={ attributes.wpqbaAttributeOne }
					onChange={ ( text ) => {
						setAttributes( { wpqbaAttributeOne: text } );
					} }
				/>
				<TextControl
					label={ __( 'Test input Two', 'wp-query-block-attributes' ) }
					value={ attributes.wpqbaAttributeTwo }
					onChange={ ( text ) => {
						setAttributes( { wpqbaAttributeTwo: parseInt( text, 10 ) } );
					} }
				/>
            </div>
        );
    },

    save: function( { attributes } ) {
		return (
			<div>
				<h2>{ __( 'Test inputs', 'wp-query-block-attributes' ) }</h2>
				<div className="row">
					<div className="label">
						<span>{ __( 'Test input One', 'wp-query-block-attributes' ) }</span>
					</div>
					<div className="value">
						<span>{ attributes.wpqbaAttributeOne }</span>
					</div>
					<div className="label">
						<span>{ __( 'Test input Two', 'wp-query-block-attributes' ) }</span>
					</div>
					<div className="value">
						<span>{ attributes.wpqbaAttributeTwo }</span>
					</div>
				</div>
			</div>
		);
	},
} );
