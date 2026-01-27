<section id="edge" class="max-w-7xl mx-auto px-6 py-32 border-t border-white/5">
  <div class="grid lg:grid-cols-2 gap-20 items-center">
    <div class="order-2 lg:order-1">
      <div class="glass-card p-1 rounded-[2rem] overflow-hidden">
        <div class="bg-[#0b1120] rounded-[1.8rem] p-8">
          <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
              <div class="w-3 h-3 rounded-full bg-orange-500 animate-pulse"></div>
              <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest">Local Inference Active</span>
            </div>
            <span class="text-[10px] font-mono text-slate-600">NODE_ID: 0x992-Kwale</span>
          </div>
          
          <div class="space-y-6">
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
              <span class="text-xs font-bold text-white uppercase tracking-tight">AI Model Confidence</span>
              <span class="text-orange-400 font-mono font-bold">94.2%</span>
            </div>
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
              <span class="text-xs font-bold text-white uppercase tracking-tight">Processing Latency</span>
              <span class="text-sky-400 font-mono font-bold">12ms</span>
            </div>
            <div class="pt-4 border-t border-white/10">
              <p class="text-[9px] font-mono text-slate-500 uppercase mb-3">Live Log stream</p>
              <div class="bg-black/40 p-4 rounded-lg font-mono text-[10px] text-emerald-500/80 leading-relaxed">
                [INFO] Loading Hailo-8 bitstream... OK<br/>
                [AI] Detection: Surface Erosion Detected (Area 4C)<br/>
                [SYNC] Comparing with Sentinel-2 48h trend...<br/>
                [SUCCESS] Cross-layer match. Event Confirmed.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="order-1 lg:order-2">
      <h2 class="text-xs font-bold text-orange-500 tracking-[0.3em] uppercase mb-4">Ground Intelligence</h2>
      <h3 class="text-5xl font-black text-white mb-6 uppercase tracking-tighter">The Edge AI Layer</h3>
      <p class="text-slate-400 text-sm leading-relaxed mb-8 uppercase tracking-wide font-bold">
        Our Edge nodes serve as the localized "Truth Validators" for orbital predictions.
      </p>
      <p class="text-slate-500 text-sm leading-relaxed mb-10">
        Equipped with industrial Raspberry Pi 5 hardware and the Hailo-8 AI accelerator, these nodes process multispectral vision and vibration data locally. This eliminates the need for expensive high-bandwidth video streaming while providing real-time geotechnical confirmation.
      </p>
      <ul class="space-y-4">
        <li class="flex items-start gap-4">
          <svg class="w-5 h-5 text-orange-500 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <div>
            <h4 class="text-white font-bold text-xs uppercase tracking-widest">Verification Index</h4>
            <p class="text-xs text-slate-500 mt-1 uppercase">Local sensor fusion creates a 0.4 weighted truth index to confirm satellite anomalies.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <svg class="w-5 h-5 text-orange-500 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <div>
            <h4 class="text-white font-bold text-xs uppercase tracking-widest">Fail-Safe Logic</h4>
            <p class="text-xs text-slate-500 mt-1 uppercase">If satellite cloud cover exceeds 80%, the Edge Node takes over as the primary alert trigger.</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</section>
