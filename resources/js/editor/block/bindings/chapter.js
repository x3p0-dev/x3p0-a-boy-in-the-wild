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

const FIELD = 'x3p0-a-boy-in-the-wild/chapter';

registerBlockBindingsSource({
	name: 'x3p0/chapter',
	label: __('Chapter Data', 'x3p0-a-boy-in-the-wild'),
	getValues({context, bindings}) {
		const record = select('core').getEntityRecord(
			'postType',
			'post',
			context?.postId
		);

		const chapterData = record?.[FIELD] ?? {};
		const values = {};

		for (const [attributeName, source] of Object.entries(bindings)) {
			const field = source.args?.field || attributeName;

			values[attributeName] = chapterData[field]
				?? __('Chapter Data', 'x3p0-a-boy-in-the-wild');
		}

		return values;
	},
	getFieldsList() {
		return [
			{
				label: __('Day', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'day'}
			},
			{
				label: __('Day (Labeled)', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args: {field: 'dayLabel'}
			},
			{
				label: __('Number', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'number'}
			},
			{
				label: __('Number (Labeled)', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'numberLabel'}
			},
			{
				label: __('Number (Roman)', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'numberRoman'}
			},
			{
				label: __('Number (Roman, Labeled)', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'numberRomanLabel'}
			},
			{
				label: __('Season', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'season'}
			},
			{
				label: __('Time of Day', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'timeOfDay'}
			},
			{
				label: __('Year', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'year'}
			},
			{
				label: __('Year (Labeled)', 'x3p0-a-boy-in-the-wild'),
				type:  'string',
				args:  {field: 'yearLabel'}
			}
		];
	},
	canUserEditValue: () => false
});
