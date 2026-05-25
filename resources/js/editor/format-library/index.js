import {registerFormatType, toggleFormat} from '@wordpress/rich-text';
import {RichTextToolbarButton} from '@wordpress/block-editor';
import {color} from '@wordpress/icons';
import {__} from '@wordpress/i18n';

const accentName = 'x3p0/accent';
const subtleName = 'x3p0/subtle';

registerFormatType(accentName, {
	title: __('Ink: Accent', 'x3p0-a-boy-in-the-wild'),
	tagName: 'span',
	className: 'has-ink-accent-color',
	edit({isActive, onChange, value}) {
		return (
			<RichTextToolbarButton
				icon={color}
				title={__('Ink: Accent', 'x3p0-a-boy-in-the-wild')}
				isActive={isActive}
				onClick={() => {
					onChange(toggleFormat(value, {type: accentName}));
				}}
			/>
		);
	}
});

registerFormatType(subtleName, {
	title: __('Ink: Subtle', 'x3p0-a-boy-in-the-wild'),
	tagName: 'span',
	className: 'has-ink-subtle-color',
	edit({isActive, onChange, value}) {
		return (
			<RichTextToolbarButton
				icon={color}
				title={__('Ink: Subtle', 'x3p0-a-boy-in-the-wild')}
				isActive={isActive}
				onClick={() => {
					onChange(toggleFormat(value, {type: subtleName}));
				}}
			/>
		);
	}
});
