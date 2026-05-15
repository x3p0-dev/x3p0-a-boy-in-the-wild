(function () {
	const canvas = document.querySelector('.x3p0-canvas-bg--storm');
	if (!canvas) return;

	const ctx = canvas.getContext('2d');
	let W = 0, H = 0, drops = [], splashes = [];
	const DPR = window.devicePixelRatio || 1;

	// --- Config ---
	const CONFIG = {
		count:   320,  // number of drops
		windX:   3.5,    // horizontal wind (-6 to 6)
		speed:   25,   // base fall speed
		opacity: 0.65, // overall canvas opacity (0–1)
	};

	function resize() {
		W = canvas.offsetWidth  * DPR;
		H = canvas.offsetHeight * DPR;
		canvas.width  = W;
		canvas.height = H;
		initDrops();
	}

	function mkDrop() {
		const layer = Math.random();
		return {
			x:     Math.random() * W * 1.5 - W * 0.25,
			y:     -Math.random() * H,
			len:   (8 + Math.random() * 18) * (0.4 + layer * 0.9) * DPR,
			speed: (6 + Math.random() * 10) * (0.4 + layer * 0.9),
			alpha: 0.18 + layer * 0.52,
			layer,
		};
	}

	function initDrops() {
		drops = [];
		for (let i = 0; i < CONFIG.count; i++) {
			const d = mkDrop();
			d.y = Math.random() * H; // scatter vertically on init
			drops.push(d);
		}
	}

	function spawnSplash(x, y, layer) {
		const parts = [];
		for (let i = 0; i < 5 + Math.floor(Math.random() * 4); i++) {
			const a = -Math.PI + Math.random() * Math.PI;
			const s = (1 + Math.random() * 2) * DPR;
			parts.push({ vx: Math.cos(a) * s, vy: Math.sin(a) * s - 2.5 * DPR, x, y });
		}
		splashes.push({
			x, y,
			r:     (2 + Math.random() * 4) * (0.4 + layer * 0.8) * DPR,
			parts,
			life:  1,
			alpha: 0.28 + layer * 0.42,
		});
	}

	function tick() {
		if (!W || !H) { requestAnimationFrame(tick); return; }

		const speedMult = CONFIG.speed / 15;
		const windVal   = CONFIG.windX;

		ctx.clearRect(0, 0, W, H);
		ctx.globalAlpha = CONFIG.opacity;

		// Draw drops
		for (let i = 0; i < drops.length; i++) {
			const d  = drops[i];
			const vx = windVal * (0.3 + d.layer * 0.9) * speedMult;
			const vy = d.speed * speedMult;
			d.x += vx;
			d.y += vy;

			const tx = d.x - (vx / vy) * d.len;
			const ty = d.y - d.len;

			const grad = ctx.createLinearGradient(tx, ty, d.x, d.y);
			grad.addColorStop(0, 'rgba(160,195,225,0)');
			grad.addColorStop(1, `rgba(160,195,225,${d.alpha})`);

			ctx.beginPath();
			ctx.moveTo(tx, ty);
			ctx.lineTo(d.x, d.y);
			ctx.strokeStyle = grad;
			ctx.lineWidth   = (0.7 + d.layer * 1.3) * DPR;
			ctx.stroke();

			if (d.y > H + d.len) {
				spawnSplash(d.x, H - DPR, d.layer);
				drops[i] = mkDrop();
			} else if (d.x > W * 1.3 || d.x < -W * 0.3) {
				drops[i] = mkDrop();
			}
		}

		// Draw splashes
		for (let s = splashes.length - 1; s >= 0; s--) {
			const sp = splashes[s];
			sp.life -= 0.055;
			if (sp.life <= 0) { splashes.splice(s, 1); continue; }

			ctx.beginPath();
			ctx.arc(sp.x, sp.y, sp.r * (1 + (1 - sp.life) * 0.6), 0, Math.PI * 2);
			ctx.strokeStyle = `rgba(160,195,225,${sp.alpha * sp.life})`;
			ctx.lineWidth   = 0.8 * DPR;
			ctx.stroke();

			for (const p of sp.parts) {
				p.x  += p.vx;
				p.y  += p.vy;
				p.vy += 0.22 * DPR;
				if (p.y < H) {
					ctx.beginPath();
					ctx.arc(p.x, p.y, DPR, 0, Math.PI * 2);
					ctx.fillStyle = `rgba(160,195,225,${sp.alpha * sp.life * 0.5})`;
					ctx.fill();
				}
			}
		}

		ctx.globalAlpha = 1;
		requestAnimationFrame(tick);
	}

	// Observe container resize
	const ro = new ResizeObserver(resize);
	ro.observe(canvas.parentElement || canvas);
	resize();
	tick();
})();
