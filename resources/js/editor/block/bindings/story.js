import {__} from "@wordpress/i18n";
import {registerBlockBindingsSource} from "@wordpress/blocks";

registerBlockBindingsSource({
	name: 'x3p0/story',
	label: __('Story Data', 'x3p0-a-boy-in-the-wild'),
	getValues({ bindings }) {
		const placeholders = {
			firstChapterUrl:   __('#', 'x3p0-a-boy-in-the-wild'),
			firstChapterLabel: __('Begin at Chapter 1 →', 'x3p0-a-boy-in-the-wild')
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
				label: __('First Chapter URL', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  { field: 'firstChapterUrl' }
			},
			{
				label: __('First Chapter Label', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  { field: 'firstChapterLabel' }
			},
		];
	},
	canUserEditValue: () => false
});
