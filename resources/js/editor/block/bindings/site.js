import { registerBlockBindingsSource } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { select } from '@wordpress/data';

registerBlockBindingsSource({
	name: 'x3p0/site',
	label: __('Site Data', 'x3p0-a-boy-in-the-wild'),
	getValues({ bindings }) {
		const siteUrl = select('core').getSite()?.url;

		const values = {};

		for (const [ attributeName, source ] of Object.entries(bindings)) {
			const field = source.args?.field || attributeName;

			values[ attributeName ] = field === 'url'
				? (siteUrl ?? __('Site URL', 'x3p0-a-boy-in-the-wild'))
				: field;
		}

		return values;
	},
	getFieldsList() {
		return [
			{
				label: __('Site URL', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  { field: 'url' }
			},
		];
	},
	canUserEditValue: () => false
});
