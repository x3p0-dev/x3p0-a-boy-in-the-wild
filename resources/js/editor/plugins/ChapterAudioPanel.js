import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, BaseControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

function ChapterAudioPanel() {
	const audioId = useSelect( ( select ) => {
		return select( 'core/editor' ).getEditedPostAttribute( 'meta' )?.x3p0_chapter_audio || 0;
	} );

	const { editPost } = useDispatch( 'core/editor' );

	function setAudio( media ) {
		editPost( { meta: { x3p0_chapter_audio: media.id } } );
	}

	function removeAudio() {
		editPost( { meta: { x3p0_chapter_audio: 0 } } );
	}

	return (
		<PluginDocumentSettingPanel
			name="chapter-audio"
			title={ __( 'Chapter Sound', 'x3p0-a-boy-in-the-wild' ) }
			icon="controls-volumeon"
		>
			<BaseControl
				label={ __( 'Ambient audio loop', 'x3p0-a-boy-in-the-wild' ) }
				help={ __( 'Upload or select a looping audio file for this chapter. The sound begins on the reader\'s first interaction.', 'x3p0-a-boy-in-the-wild' ) }
			>
				<MediaUploadCheck>
					<MediaUpload
						onSelect={ setAudio }
						allowedTypes={ [ 'audio' ] }
						value={ audioId }
						render={ ( { open } ) => (
							<div style={ { display: 'flex', flexDirection: 'column', gap: '8px' } }>
								<Button
									variant={ audioId ? 'secondary' : 'primary' }
									onClick={ open }
								>
									{ audioId
										? __( 'Change sound', 'x3p0-a-boy-in-the-wild' )
										: __( 'Add to Archive', 'x3p0-a-boy-in-the-wild' )
									}
								</Button>
								{ audioId && (
									<Button
										variant="tertiary"
										isDestructive
										onClick={ removeAudio }
									>
										{ __( 'Remove sound', 'x3p0-a-boy-in-the-wild' ) }
									</Button>
								) }
								{ audioId && (
									<p style={ { fontSize: '12px', color: '#757575', margin: '0' } }>
										{ __( 'Attachment ID: ', 'x3p0-a-boy-in-the-wild' ) + audioId }
									</p>
								) }
							</div>
						) }
					/>
				</MediaUploadCheck>
			</BaseControl>
		</PluginDocumentSettingPanel>
	);
}

registerPlugin( 'x3p0-chapter-audio', {
	render: ChapterAudioPanel,
} );
