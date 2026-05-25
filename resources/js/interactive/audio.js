import {store, getServerState} from '@wordpress/interactivity';

const STORE = 'x3p0-a-boy-in-the-wild/audio';

let audio        = null;
let fadeInterval = null;
let targetVolume = 0.4;
let text         = {};

const {state, actions} = store(STORE, {
	state: {
		playing: false,
		muted:   true,

		get label() {
			return state.playing && ! state.muted
				? (text.stop   ?? 'Stop')
				: (text.listen ?? 'Listen');
		},

		get ariaLabel() {
			if (! state.playing) return text.startSound ?? 'Start chapter sound';
			return state.muted
				? (text.unmuteSound ?? 'Unmute chapter sound')
				: (text.muteSound   ?? 'Mute chapter sound');
		}
	},

	actions: {
		toggle() {
			if (! state.playing) {
				actions.start();
				return;
			}

			if (state.muted) {
				state.muted = false;
				actions.fadeIn();
			} else {
				state.muted = true;
				actions.fadeOut(() => {
					audio.pause();
					audio.currentTime = 0;
					state.playing     = false;
				});
			}
		},

		start() {
			if (! audio || state.playing) return;

			audio.play().then(() => {
				state.playing = true;
				state.muted   = false;
				actions.fadeIn();
			}).catch(() => {});
		},

		fadeIn() {
			if (! audio) return;
			actions.clearFade();

			const step = targetVolume / 40;

			fadeInterval = setInterval(() => {
				if (audio.volume >= targetVolume) {
					audio.volume = targetVolume;
					actions.clearFade();
					return;
				}
				audio.volume = Math.min(audio.volume + step, targetVolume);
			}, 50);
		},

		fadeOut(callback) {
			if (! audio) return;
			actions.clearFade();

			if (audio.volume === 0) {
				callback?.();
				return;
			}

			const step = audio.volume / 20;

			fadeInterval = setInterval(() => {
				if (audio.volume <= 0.01) {
					audio.volume = 0;
					actions.clearFade();
					callback?.();
					return;
				}
				audio.volume = Math.max(audio.volume - step, 0);
			}, 50);
		},

		clearFade() {
			if (fadeInterval) {
				clearInterval(fadeInterval);
				fadeInterval = null;
			}
		}
	},

	callbacks: {
		init() {
			const serverState = getServerState(STORE);

			if (! serverState.url) return;

			text         = serverState.text ?? {};
			targetVolume = parseFloat(serverState.volume) || 0.4;
			audio        = new Audio(serverState.url);
			audio.loop   = true;
			audio.volume = 0;
		}
	}
});
