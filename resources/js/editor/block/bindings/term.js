import {__} from "@wordpress/i18n";
import {registerBlockBindingsSource} from "@wordpress/blocks";

registerBlockBindingsSource({
	name: 'x3p0/term',
	label: __('Term Data', 'x3p0-a-boy-in-the-wild'),
	getValues({ bindings }) {
		const placeholders = {
			count: __('# Chapters', 'x3p0-a-boy-in-the-wild'),
		};

		const values = {};

		for (const [ attributeName, source ] of Object.entries(bindings)) {
			const field = source.args?.field || attributeName;
			values[ attributeName ] = placeholders[ field ] ?? field;
		}

		return values;
	},
	getFieldsList() {
		return [
			{
				label: __('Chapter Count', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  { field: 'count' }
			},
		];
	},
	canUserEditValue: () => false
});
