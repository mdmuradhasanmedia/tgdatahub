<?php // footer.php ?>
</main>

<!-- Back to top -->
<button id="toTop" class="fixed bottom-5 right-5 hidden items-center justify-center
  w-10 h-10 rounded-full bg-indigo-600 text-white shadow-lg" aria-label="Back to top">↑</button>

<!-- ===== Footer (lighter with social icons) ===== -->
<footer class="w-full bg-gradient-to-t from-white via-slate-50 to-slate-100 text-slate-600 border-t border-slate-200">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm md:text-base">
    
    <!-- Column 1 -->
    <div>
      <h4 class="font-semibold text-slate-800 mb-2 text-base md:text-lg">TG Data Hub Tools</h4>
      <p class="text-slate-500 text-sm md:text-base leading-relaxed">
        We aim to craft simple yet powerful online tools that bring clarity and ease to your digital journey. 
        Every feature is designed with you in mind, as we constantly expand and improve our toolkit.
      </p>
    </div>

    <!-- Column 2 -->
    <div>
      <h4 class="font-semibold text-slate-800 mb-2 text-base md:text-lg">Important Links</h4>
      <ul class="space-y-1 text-sm md:text-base">
        <li><a href="/about.php" class="hover:text-indigo-600">About</a></li>
        <li><a href="/contact.php" class="hover:text-indigo-600">Contact</a></li>
      </ul>
    </div>

    <!-- Column 3 -->
    <div>
      <h4 class="font-semibold text-slate-800 mb-2 text-base md:text-lg">Policies</h4>
      <ul class="space-y-1 text-sm md:text-base">
        <li><a href="/privacy-policy.php" class="hover:text-indigo-600">Privacy Policy</a></li>
        <li><a href="/terms-conditions.php" class="hover:text-indigo-600">Terms &amp; Conditions</a></li>
        <li><a href="/dmca.php" class="hover:text-indigo-600">DMCA</a></li>
      </ul>
    </div>
  </div>

  <!-- Social Media Icons -->
  <div class="flex justify-center gap-6 pb-4">
    <!-- Facebook -->
  <!--  <a href="https://facebook.com" target="_blank" class="text-slate-500 hover:text-blue-600 transition">-->
  <!--    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">-->
  <!--      <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0 0 22 12"/>-->
  <!--    </svg>-->
  <!--  </a>-->

    <!-- Twitter/X -->
  <!--  <a href="https://twitter.com" target="_blank" class="text-slate-500 hover:text-sky-500 transition">-->
  <!--    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">-->
  <!--      <path d="M19.6 3H22l-5.1 5.8L22 21h-6.4l-3.9-6.3L7.2 21H2l5.7-6.7L2 3h6.6l3.5 5.8L19.6 3z"/>-->
  <!--    </svg>-->
  <!--  </a>-->

    <!-- GitHub -->
  <!--  <a href="https://github.com" target="_blank" class="text-slate-500 hover:text-gray-800 transition">-->
  <!--    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">-->
  <!--      <path fill-rule="evenodd" clip-rule="evenodd"-->
  <!--        d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-2c-2.9.6-3.5-1.4-3.5-1.4-.4-1-1-1.3-1-1.3-.8-.6.1-.6.1-.6.9.1 1.4.9 1.4.9.8 1.3 2.1.9 2.6.7.1-.6.3-1 .6-1.3-2.3-.3-4.6-1.2-4.6-5a4 4 0 0 1 1-2.7 3.7 3.7 0 0 1 .1-2.7s.9-.3 2.9 1a9.8 9.8 0 0 1 5.3 0c2-1.3 2.9-1 2.9-1a3.7 3.7 0 0 1 .1 2.7 4 4 0 0 1 1 2.7c0 3.8-2.3 4.6-4.6 4.9.3.3.6.9.6 1.8v2.6c0 .3.2.6.7.5A10 10 0 0 0 12 2z"/>-->
  <!--    </svg>-->
  <!--  </a>-->

    <!-- LinkedIn -->
  <!--  <a href="https://linkedin.com" target="_blank" class="text-slate-500 hover:text-blue-700 transition">-->
  <!--    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">-->
  <!--      <path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM3 9h4v12H3zM9 9h3.7v1.7h.1c.5-.9 1.8-1.9 3.7-1.9 4 0 4.7 2.6 4.7 6v6.2h-4V15c0-1.4 0-3.3-2-3.3-2 0-2.3 1.5-2.3 3.2v6.1H9V9z"/>-->
  <!--    </svg>-->
  <!--  </a>-->
  <!--</div>-->

  <!-- Bottom -->
  <div class="text-center text-xs md:text-sm text-slate-500 border-t border-slate-200 py-4">
    © <?= date('Y') ?> TG Data Hub Tools — All rights reserved.
  </div>
</footer>

<!-- ===== Scripts ===== -->
<script>
// Mobile menu
(function(){
  const btn = document.getElementById('mnavBtn');
  const panel = document.getElementById('mnavPanel');
  const overlay = document.getElementById('mnavOverlay');

  function openMenu(){
    panel.classList.remove('hidden'); overlay.classList.remove('hidden');
    requestAnimationFrame(()=>{
      overlay.classList.add('opacity-100');
      panel.classList.remove('opacity-0','scale-y-95');
      panel.classList.add('opacity-100','scale-y-100');
    });
    btn.setAttribute('aria-expanded','true');
    document.addEventListener('keydown', onEsc);
    document.addEventListener('click', onOutside, true);
  }
  function closeMenu(){
    overlay.classList.remove('opacity-100');
    panel.classList.remove('opacity-100','scale-y-100');
    panel.classList.add('opacity-0','scale-y-95');
    setTimeout(()=>{ panel.classList.add('hidden'); overlay.classList.add('hidden'); },180);
    btn.setAttribute('aria-expanded','false');
    document.removeEventListener('keydown', onEsc);
    document.removeEventListener('click', onOutside, true);
  }
  function onEsc(e){ if(e.key==='Escape') closeMenu(); }
  function onOutside(e){ if(!panel.contains(e.target) && !btn.contains(e.target)) closeMenu(); }

  btn?.addEventListener('click', ()=> (btn.getAttribute('aria-expanded')==='true') ? closeMenu() : openMenu());
  overlay?.addEventListener('click', closeMenu);
  panel.querySelectorAll('a').forEach(a=>a.addEventListener('click', closeMenu));
  panel.classList.add('scale-y-95','opacity-0'); // init state
})();

// Back-to-top
const topBtn = document.getElementById('toTop');
window.addEventListener('scroll', () => {
  topBtn.classList.toggle('hidden', window.scrollY < 600);
});
topBtn.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));
</script>


</body>
</html>
