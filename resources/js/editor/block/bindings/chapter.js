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

const FIELDS = {
	day:              __('Day',                 'x3p0-a-boy-in-the-wild'),
	dayLabel:         __('Day (Labeled)',       'x3p0-a-boy-in-the-wild'),
	designation:      __('Designation',         'x3p0-a-boy-in-the-wild'),
	designationRoman: __('Designation (Roman)', 'x3p0-a-boy-in-the-wild'),
	number:           __('Number',              'x3p0-a-boy-in-the-wild'),
	numberRoman:      __('Number (Roman)',      'x3p0-a-boy-in-the-wild'),
	season:           __('Season',              'x3p0-a-boy-in-the-wild'),
	timeOfDay:        __('Time of Day',         'x3p0-a-boy-in-the-wild'),
	type:             __('Type',                'x3p0-a-boy-in-the-wild'),
	year:             __('Year',                'x3p0-a-boy-in-the-wild'),
	yearLabel:        __('Year (Labeled)',      'x3p0-a-boy-in-the-wild')
};

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
