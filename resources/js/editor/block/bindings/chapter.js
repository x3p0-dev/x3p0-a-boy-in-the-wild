/**
 * Defines the `x3p0/chapter` block binding source.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   GPL-3.0-or-later
 */

import {registerBlockBindingsSource} from '@wordpress/blocks';
import {__} from '@wordpress/i18n';
import {select} from '@wordpress/data';

const REST_FIELD = 'x3p0-a-boy-in-the-wild/chapter';

// The field list is generated from the PHP ChapterField enum and handed over by
// EditorAssets, so it cannot drift from the schema or the renderer. See
// ChapterField::options().

// noinspection JSUnresolvedVariable
const FIELDS = window.x3p0ABoyInTheWild?.chapterFields ?? {};

registerBlockBindingsSource({
	name: 'x3p0/chapter',
	label: __('Chapter Data', 'x3p0-a-boy-in-the-wild'),
	getValues({context, bindings}) {
		const record = select('core').getEntityRecord(
			'postType',
			'post',
			context?.postId
		);

		const chapterData = record?.[REST_FIELD] ?? {};
		const values = {};

		for (const [attributeName, source] of Object.entries(bindings)) {
			const field = source.args?.field || attributeName;

			values[attributeName] = chapterData[field]
				?? __('Chapter Data', 'x3p0-a-boy-in-the-wild');
		}

		return values;
	},
	getFieldsList() {
		return Object.entries(FIELDS).map(([field, label]) => ({
			label,
			type: 'string',
			args: {field}
		}));
	},
	canUserEditValue: () => false
});
