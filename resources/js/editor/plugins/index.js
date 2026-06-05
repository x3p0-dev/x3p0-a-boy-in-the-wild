import {registerPlugin} from '@wordpress/plugins';

import ChapterPanel from './ChapterPanel';

registerPlugin('x3p0-chapter', {render: ChapterPanel});
