import {PluginDocumentSettingPanel} from '@wordpress/editor';
import {MediaUpload, MediaUploadCheck} from '@wordpress/block-editor';
import {
	Button,
	Icon,
	SelectControl,
	__experimentalNumberControl as NumberControl,
	__experimentalTruncate as Truncate,
	__experimentalVStack as VStack
} from '@wordpress/components';
import {useSelect, useDispatch} from '@wordpress/data';
import {__} from '@wordpress/i18n';
import {reset as resetIcon, audio} from '@wordpress/icons';

const TYPE_KEY   = 'x3p0_chapter_type';
const NUMBER_KEY = 'x3p0_chapter_number';
const AUDIO_KEY  = 'x3p0_audio';

const SECTION_TYPES = [
	{label: __('Prologue',  'x3p0-a-boy-in-the-wild'), value: 'prologue'},
	{label: __('Chapter',   'x3p0-a-boy-in-the-wild'), value: 'chapter'},
	{label: __('Interlude', 'x3p0-a-boy-in-the-wild'), value: 'interlude'},
	{label: __('Epilogue',  'x3p0-a-boy-in-the-wild'), value: 'epilogue'},
	{label: __('Afterword', 'x3p0-a-boy-in-the-wild'), value: 'afterword'}
];

const ChapterPanel = () => {
	const {meta, audioMedia, postId, postType} = useSelect((select) => {
		const editor  = select('core/editor');
		const meta    = editor.getEditedPostAttribute('meta') || {};
		const audioId = meta[AUDIO_KEY] || 0;

		return {
			meta,
			audioMedia: audioId
				? select('core').getEntityRecord('postType', 'attachment', audioId)
				: null,
			postId:   editor.getCurrentPostId(),
			postType: editor.getCurrentPostType()
		};
	});

	const {editEntityRecord} = useDispatch('core');

	// Chapter data lives only on posts — never pages, templates, or anywhere
	// else the editor renders document panels.
	if (postType !== 'post') {
		return null;
	}

	function setMeta(values) {
		editEntityRecord('postType', 'post', postId, {meta: values});
	}

	const sectionType = meta[TYPE_KEY] || 'chapter';
	const number      = meta[NUMBER_KEY] || 0;
	const audioId     = meta[AUDIO_KEY] || 0;
	const audioTitle  = audioMedia?.title?.raw || audioMedia?.slug || null;

	return (
		<PluginDocumentSettingPanel
			name="chapter"
			title={__('Chapter', 'x3p0-a-boy-in-the-wild')}
			className="x3p0-chapter-panel"
		>
			<VStack spacing={4}>
				<SelectControl
					__next40pxDefaultSize
					__nextHasNoMarginBottom
					label={__('Story Section', 'x3p0-a-boy-in-the-wild')}
					value={sectionType}
					options={SECTION_TYPES}
					onChange={(value) => setMeta({[TYPE_KEY]: value})}
				/>

				<NumberControl
					__next40pxDefaultSize
					label={__('Number', 'x3p0-a-boy-in-the-wild')}
					help={__('Leave empty for an unnumbered section.', 'x3p0-a-boy-in-the-wild')}
					min={0}
					value={number || ''}
					onChange={(value) => setMeta({[NUMBER_KEY]: parseInt(value, 10) || 0})}
				/>

				<MediaUploadCheck
					fallback={
						<p className="x3p0-audio-panel__error">
							{__(
								'To set the chapter audio, you need permission to upload media.',
								'x3p0-a-boy-in-the-wild'
							)}
						</p>
					}
				>
					<MediaUpload
						onSelect={(media) => setMeta({[AUDIO_KEY]: media.id})}
						allowedTypes={['audio']}
						value={audioId}
						render={({open}) => (
							<>
								{audioId && audioTitle ? (
									<div className="x3p0-audio-panel__preview">
										<Button
											className="x3p0-audio-panel__toggle"
											onClick={open}
											aria-label={__('Replace chapter audio', 'x3p0-a-boy-in-the-wild')}
										>
											<span className="x3p0-audio-panel__toggle-inner">
												<span className="x3p0-audio-panel__icon">
													<Icon icon={audio} size={20} />
												</span>
												<Truncate numberOfLines={1}>
													{audioTitle}
												</Truncate>
											</span>
										</Button>
										<Button
											className="x3p0-audio-panel__reset"
											label={__('Remove audio', 'x3p0-a-boy-in-the-wild')}
											size="small"
											icon={resetIcon}
											onClick={() => setMeta({[AUDIO_KEY]: 0})}
										/>
									</div>
								) : (
									<Button
										__next40pxDefaultSize
										variant="secondary"
										className="x3p0-audio-panel__set"
										onClick={open}
									>
										{__('Set chapter audio', 'x3p0-a-boy-in-the-wild')}
									</Button>
								)}
							</>
						)}
					/>
				</MediaUploadCheck>
			</VStack>
		</PluginDocumentSettingPanel>
	);
};

export default ChapterPanel;
