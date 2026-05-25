import {registerPlugin} from '@wordpress/plugins';
import {PluginDocumentSettingPanel} from '@wordpress/editor';
import {MediaUpload, MediaUploadCheck} from '@wordpress/block-editor';
import {
	Button,
	Icon,
	__experimentalTruncate as Truncate
} from '@wordpress/components';
import {useSelect, useDispatch} from '@wordpress/data';
import {__} from '@wordpress/i18n';
import {reset as resetIcon, audio} from '@wordpress/icons';

const META_KEY = 'x3p0_audio';

function AudioPanel() {
	const {audioId, audioMedia, postId} = useSelect((select) => {
		const postId = select('core/editor').getCurrentPostId();
		const id =
			select('core/editor').getEditedPostAttribute('meta')
				?.[META_KEY] || 0;
		const media = id
			? select('core').getEntityRecord('postType', 'attachment', id)
			: null;
		return {audioId: id, audioMedia: media, postId};
	});

	const {editEntityRecord} = useDispatch('core');

	function setAudio(media) {
		editEntityRecord('postType', 'post', postId, {
			meta: {[META_KEY]: media.id}
		});
	}

	function removeAudio() {
		editEntityRecord('postType', 'post', postId, {
			meta: {[META_KEY]: 0}
		});
	}

	const title = audioMedia?.title?.raw || audioMedia?.slug || null;

	return (
		<PluginDocumentSettingPanel
			name="audio"
			title={__('Audio', 'x3p0-a-boy-in-the-wild')}
			className="x3p0-audio-panel"
		>
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
					onSelect={setAudio}
					allowedTypes={['audio']}
					value={audioId}
					render={({open}) => (
						<>
							{audioId && title ? (
								<div className="x3p0-audio-panel__preview">
									<Button
										className="x3p0-audio-panel__toggle"
										onClick={open}
										aria-label={__(
											'Replace chapter audio',
											'x3p0-a-boy-in-the-wild'
										)}
									>
										<span className="x3p0-audio-panel__toggle-inner">
											<span className="x3p0-audio-panel__icon">
												<Icon icon={audio} size={20} />
											</span>
											<Truncate numberOfLines={1}>
												{title}
											</Truncate>
										</span>
									</Button>
									<Button
										className="x3p0-audio-panel__reset"
										label={__(
											'Remove audio',
											'x3p0-a-boy-in-the-wild'
										)}
										size="small"
										icon={resetIcon}
										onClick={removeAudio}
									/>
								</div>
							) : (
								<Button
									__next40pxDefaultSize
									variant="secondary"
									className="x3p0-audio-panel__set"
									onClick={open}
								>
									{__(
										'Set chapter audio',
										'x3p0-a-boy-in-the-wild'
									)}
								</Button>
							)}
						</>
					)}
				/>
			</MediaUploadCheck>
		</PluginDocumentSettingPanel>
	);
}

registerPlugin('x3p0-audio', {
	render: AudioPanel
});
