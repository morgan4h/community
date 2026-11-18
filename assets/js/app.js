(() => {
  'use strict';

  /* ── DOM references ── */
  const app          = document.querySelector('#app');
  const logoutButton = document.querySelector('#logoutButton');

  /* ── Catalog (injected by PHP, no extra request needed) ── */
  const movies = Array.isArray(window.TMK_CATALOG) ? window.TMK_CATALOG : [];

  /* ── App state ── */
  let screen               = 'auth';
  let authMode             = 'signup';   // 'signup' | 'login'
  let user                 = null;       // { id, name, email } or null
  let selectedCount        = 3;
  let roomMovie            = movies[0] || null;
  let chatLines            = [];
  let query                = '';

  /* Verification state */
  let verified             = false;
  let verificationSeed     = 0;
  let verificationChallengeId = '';
  let verificationStartedAt   = 0;
  let pendingAuth          = null;       // form values cached before going to verify screen

  /* ─────────────────────────────────────────────────────
     API helper — talks to api/auth.php
  ───────────────────────────────────────────────────── */
  async function api(action, body = null) {
    const opts = {
      method: body ? 'POST' : 'GET',
      headers: { 'Accept': 'application/json' },
      credentials: 'same-origin',
    };
    if (body) {
      opts.headers['Content-Type'] = 'application/json';
      opts.body = JSON.stringify({ action, ...body });
    }
    const url = `api/auth.php?action=${encodeURIComponent(action)}`;
    let res;
    try {
      res = await fetch(url, opts);
    } catch {
      throw new Error('Could not reach the server. Check your connection.');
    }
    const data = await res.json().catch(() => ({ ok: false, error: 'The server returned an invalid response.' }));
    if (!res.ok || data.ok === false) throw new Error(data.error || 'Request failed.');
    return data;
  }

  /* ─────────────────────────────────────────────────────
     Utilities
  ───────────────────────────────────────────────────── */
  function esc(value = '') {
    return String(value).replace(/[&<>"']/g, c => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
    })[c]);
  }

  function toast(message, isError = false) {
    document.querySelectorAll('.toast').forEach(n => n.remove());
    const node = document.createElement('div');
    node.className = isError ? 'toast error' : 'toast';
    node.textContent = message;
    document.body.append(node);
    setTimeout(() => node.remove(), 3200);
  }

  function setScreen(next) {
    screen = next;
    render();
  }

  function scrollChatToBottom() {
    const el = document.querySelector('#chatMessages');
    if (el) el.scrollTop = el.scrollHeight;
  }

  /* ─────────────────────────────────────────────────────
     Root render dispatcher
  ───────────────────────────────────────────────────── */
  function render() {
    logoutButton.classList.toggle('hidden', !user);
    switch (screen) {
      case 'auth':   renderAuth();         break;
      case 'verify': renderVerification(); break;
      case 'home':   renderHome();         break;
      case 'movies': renderMovies();       break;
      case 'setup':  renderSetup();        break;
      case 'room':   renderRoom();         break;
      case 'sports': renderSports();       break;
      default:       renderHome();
    }
  }

  /* ─────────────────────────────────────────────────────
     Auth screen (signup / login)
  ───────────────────────────────────────────────────── */
  function renderAuth() {
    const isSignup = authMode === 'signup';
    app.innerHTML = `
      <section class="auth-layout">
        <div class="hero-copy">
          <div class="eyebrow">Watch together, any distance</div>
          <h1>Good stories are<br>better <span>together.</span></h1>
          <p>Pick a film, invite your people, and make every watch party feel like movie night again.</p>
          <div class="feature-list">
            <span><b>▶</b> Shared room</span>
            <span><b>◎</b> Live chat</span>
            <span><b>✦</b> Your own space</span>
          </div>
        </div>

        <div class="auth-card">
          <h2>${isSignup ? 'Create your account' : 'Welcome back'}</h2>
          <p>${isSignup ? 'Start a watch party in just a moment.' : 'Sign in to pick up where you left off.'}</p>
          <form id="authForm" class="form-grid" novalidate autocomplete="on">
            ${isSignup ? `
            <div class="field">
              <label for="authName">Your name</label>
              <input id="authName" name="name" autocomplete="name" placeholder="What should we call you?" required maxlength="30">
            </div>` : ''}
            <div class="field">
              <label for="authEmail">Email address</label>
              <input id="authEmail" name="email" type="email" autocomplete="email" placeholder="you@example.com" required>
            </div>
            <div class="field">
              <label for="authPassword">Password</label>
              <input id="authPassword" name="password" type="password"
                autocomplete="${isSignup ? 'new-password' : 'current-password'}"
                placeholder="${isSignup ? 'At least 8 characters' : 'Your password'}"
                minlength="8" required>
            </div>
            <p class="form-error" id="formError" role="alert"></p>
            <button class="verification-button${verified ? ' done' : ''}" id="verificationButton" type="button">
              <span class="verification-icon">${verified ? '✓' : '◎'}</span>
              <span>
                <b>${verified ? 'Human verification complete' : 'Verify that you are human'}</b>
                <small>${verified ? 'You are verified — ready to continue' : 'Complete a quick visual challenge'}</small>
              </span>
              <span aria-hidden="true">›</span>
            </button>
            <button class="primary-button" type="submit" id="authSubmit">
              ${isSignup ? 'Create account' : 'Sign in'} →
            </button>
          </form>
          <p class="auth-switch">
            ${isSignup ? 'Already have an account?' : 'New here?'}
            <button id="authToggle" type="button">${isSignup ? 'Sign in' : 'Create account'}</button>
          </p>
          <p class="fine-print">Account data is stored server-side in JSON format. Use a unique password.</p>
        </div>
      </section>`;

    document.querySelector('#authToggle').addEventListener('click', () => {
      authMode = isSignup ? 'login' : 'signup';
      verified = false;
      renderAuth();
    });

    document.querySelector('#authForm').addEventListener('submit', handleAuth);

    document.querySelector('#verificationButton').addEventListener('click', async () => {
      /* cache form values so they survive the screen switch */
      pendingAuth = {
        name:     document.querySelector('#authName')?.value.trim() || '',
        email:    document.querySelector('#authEmail')?.value.trim() || '',
        password: document.querySelector('#authPassword')?.value || '',
      };
      const btn = document.querySelector('#verificationButton');
      btn.disabled = true;
      try {
        const challenge = await api('challenge', {});
        verificationSeed        = challenge.seed;
        verificationChallengeId = challenge.challengeId;
        verificationStartedAt   = Date.now();
        setScreen('verify');
      } catch (err) {
        toast(err.message, true);
        btn.disabled = false;
      }
    });
  }

  async function handleAuth(event) {
    event.preventDefault();
    const form     = new FormData(event.currentTarget);
    const name     = String(form.get('name') || '').trim();
    const email    = String(form.get('email') || '').trim().toLowerCase();
    const password = String(form.get('password') || '');
    const error    = document.querySelector('#formError');
    const submit   = document.querySelector('#authSubmit');

    if (!email || password.length < 8 || (authMode === 'signup' && !name)) {
      error.textContent = 'Please fill in every field. Passwords need at least 8 characters.';
      return;
    }
    if (!verified) {
      error.textContent = 'Complete the human verification first.';
      document.querySelector('#verificationButton')?.focus();
      return;
    }

    error.textContent = '';
    submit.disabled   = true;
    submit.textContent = authMode === 'signup' ? 'Creating account…' : 'Signing in…';

    try {
      const payload = authMode === 'signup'
        ? { name, email, password }
        : { email, password };
      const data = await api(authMode, payload);
      user = data.user;
      verified = false;
      setScreen('home');
    } catch (err) {
      error.textContent = err.message;
      submit.disabled   = false;
      submit.textContent = authMode === 'signup' ? 'Create account →' : 'Sign in →';
    }
  }

  /* ─────────────────────────────────────────────────────
     Verification screen
  ───────────────────────────────────────────────────── */
  function renderVerification() {
    const challenges = [
      { prompt: 'Select the filled diamond',    target: '◆', decoy: '◇' },
      { prompt: 'Select the snowflake',          target: '❄', decoy: '✦' },
      { prompt: 'Select the filled circle',      target: '●', decoy: '○' },
      { prompt: 'Select the half-filled circle', target: '◐', decoy: '◑' },
      { prompt: 'Select the filled hexagon',     target: '⬢', decoy: '⬡' },
      { prompt: 'Select the filled star',        target: '★', decoy: '☆' },
    ];
    const challenge  = challenges[verificationSeed % challenges.length];
    const targetIndex = 2 + (verificationSeed % 5);
    const tiles = Array.from({ length: 9 }, (_, i) => i === targetIndex ? challenge.target : challenge.decoy);

    app.innerHTML = `
      <section class="verification-page">
        <div class="verification-panel">
          <div class="verification-heading">
            <span class="verification-shield">TMK</span>
            <div>
              <small>SECURITY CHECK</small>
              <h1>Verify you're human</h1>
            </div>
          </div>
          <p class="verification-prompt">${challenge.prompt}</p>
          <div class="verification-grid" role="group" aria-label="Verification challenge">
            ${tiles.map((tile, i) => `
              <button class="verification-tile" type="button" data-index="${i}" aria-label="Tile ${i + 1}">${tile}</button>
            `).join('')}
          </div>
          <p class="verification-status" id="verificationStatus">
            Find and select the ${challenge.target} tile.
          </p>
          <button class="verification-back" id="verificationBack" type="button">
            ← Back to ${authMode === 'signup' ? 'sign up' : 'sign in'}
          </button>
        </div>
      </section>`;

    document.querySelector('#verificationBack').addEventListener('click', () => setScreen('auth'));

    document.querySelectorAll('.verification-tile').forEach(btn => {
      btn.addEventListener('click', async () => {
        const idx    = Number(btn.dataset.index);
        const status = document.querySelector('#verificationStatus');

        if (idx !== targetIndex) {
          status.textContent  = 'Not that one — look carefully and try again.';
          status.className    = 'verification-status error';
          btn.classList.add('wrong');
          setTimeout(() => btn.classList.remove('wrong'), 500);
          return;
        }

        if (Date.now() - verificationStartedAt < 600) {
          status.textContent = 'Take a moment to look at the challenge.';
          status.className   = 'verification-status error';
          return;
        }

        document.querySelectorAll('.verification-tile').forEach(t => { t.disabled = true; });

        try {
          await api('verify-human', { challengeId: verificationChallengeId, selectedIndex: idx });
        } catch (err) {
          status.textContent = err.message;
          status.className   = 'verification-status error';
          document.querySelectorAll('.verification-tile').forEach(t => { t.disabled = false; });
          return;
        }

        verified           = true;
        status.textContent = 'Verification complete — you can now continue.';
        status.className   = 'verification-status success';

        setTimeout(() => {
          setScreen('auth');
          /* restore form values */
          requestAnimationFrame(() => {
            if (!pendingAuth) return;
            const n = document.querySelector('#authName');
            const e = document.querySelector('#authEmail');
            const p = document.querySelector('#authPassword');
            if (n) n.value = pendingAuth.name;
            if (e) e.value = pendingAuth.email;
            if (p) p.value = pendingAuth.password;
          });
        }, 800);
      });
    });
  }

  /* ─────────────────────────────────────────────────────
     Home screen
  ───────────────────────────────────────────────────── */
  function renderHome() {
    app.innerHTML = `
      <section class="page-heading">
        <div class="eyebrow">Welcome${user?.name ? `, ${esc(user.name)}` : ''}</div>
        <h1>What are we <span>watching?</span></h1>
        <p>Choose your kind of night. Movie rooms are open and ready.</p>
      </section>
      <section class="choice-grid" aria-label="Choose what to watch">
        <button class="choice-card" id="movieChoice" type="button">
          <span class="choice-icon">▶</span>
          <span class="choice-content">
            <small>MOVIE NIGHT</small>
            <h2>Movies together</h2>
            <p>Browse the collection, set up your room, and watch with friends in sync.</p>
            <span class="inline-link">Browse the collection →</span>
          </span>
        </button>
        <button class="choice-card" id="sportsChoice" type="button">
          <span class="choice-icon">◉</span>
          <span class="choice-content">
            <small>THE BIG GAME</small>
            <h2>Live sports</h2>
            <p>Head to the official beIN SPORTS site for live coverage and match schedules.</p>
            <span class="inline-link">Visit beIN SPORTS →</span>
          </span>
        </button>
      </section>`;

    document.querySelector('#movieChoice').addEventListener('click', () => setScreen('movies'));
    document.querySelector('#sportsChoice').addEventListener('click', () => setScreen('sports'));
  }

  /* ─────────────────────────────────────────────────────
     Movies screen
  ───────────────────────────────────────────────────── */
  function renderMovies() {
    const q        = query.toLowerCase();
    const filtered = movies.filter(m =>
      `${m.title} ${m.genre} ${m.description}`.toLowerCase().includes(q)
    );

    app.innerHTML = `
      <div class="section-toolbar">
        <section class="page-heading">
          <div class="eyebrow">The movie room</div>
          <h1>Pick a <span>story.</span></h1>
          <p>Choose a film to set up your watch party.</p>
        </section>
        <label class="search-wrap" aria-label="Search movies">
          <input class="search-input" id="movieSearch" type="search"
            placeholder="Search movies…" aria-label="Search movies" value="${esc(query)}">
        </label>
      </div>
      <section class="movie-grid" id="movieGrid" aria-label="Movie catalogue">
        ${filtered.length
          ? filtered.map(movieCard).join('')
          : '<div class="empty-results">No movies matched your search.</div>'}
      </section>
      <button class="back-link" id="backHome">← Back to home</button>`;

    const searchInput = document.querySelector('#movieSearch');
    searchInput.addEventListener('input', e => {
      query = e.target.value;
      renderMovies();
      /* keep focus & cursor position */
      const el = document.querySelector('#movieSearch');
      if (el) { el.focus(); el.setSelectionRange(query.length, query.length); }
    });

    document.querySelectorAll('[data-movie]').forEach(btn =>
      btn.addEventListener('click', () => {
        roomMovie     = movies.find(m => m.id === btn.dataset.movie) || movies[0];
        selectedCount = 3;
        setScreen('setup');
      })
    );

    document.querySelector('#backHome').addEventListener('click', () => {
      query = '';
      setScreen('home');
    });
  }

  function movieCard(movie) {
    return `
      <article class="movie-card">
        <div class="movie-poster" style="background-image:url('${esc(movie.image)}')">
          <span class="poster-label">${esc(movie.genre.split(' · ')[0])}</span>
        </div>
        <div class="movie-meta">
          <div class="movie-meta-top">
            <h3>${esc(movie.title)}</h3>
            <span class="movie-year">${esc(String(movie.year))}</span>
          </div>
          <p>${esc(movie.description)}</p>
          <button class="secondary-button" type="button" data-movie="${esc(movie.id)}">
            Choose this film →
          </button>
        </div>
      </article>`;
  }

  /* ─────────────────────────────────────────────────────
     Setup screen
  ───────────────────────────────────────────────────── */
  function renderSetup() {
    const title = roomMovie?.title || 'Movie';
    app.innerHTML = `
      <section class="room-setup">
        <button class="back-link" id="backMovies">← Back to movies</button>
        <div class="page-heading">
          <div class="eyebrow">Set the scene</div>
          <h1>Your room, <span>your people.</span></h1>
          <p>Choose how many people will be watching so the room is sized for your group.</p>
        </div>
        <div class="setup-panel">
          <div class="setup-title">
            <h2>${esc(title)}</h2>
            <span class="live-pill"><span class="live-dot"></span> WATCH PARTY</span>
          </div>
          <div class="count-options" role="group" aria-label="Room size">
            ${[2, 3, 4, 5].map(n => `
              <button class="count-option${selectedCount === n ? ' active' : ''}"
                type="button" data-count="${n}">${n} people</button>
            `).join('')}
          </div>
          <p class="setup-note">Room size sets the display for your session. Invite your friends by sharing the link once you are inside.</p>
          <button class="primary-button" id="joinRoom" type="button">Enter the room →</button>
        </div>
      </section>`;

    document.querySelectorAll('[data-count]').forEach(btn =>
      btn.addEventListener('click', () => {
        selectedCount = Number(btn.dataset.count);
        renderSetup();
      })
    );
    document.querySelector('#backMovies').addEventListener('click', () => setScreen('movies'));
    document.querySelector('#joinRoom').addEventListener('click', () => {
      chatLines = [{ type: 'system', text: `Room opened for ${selectedCount} ${selectedCount === 1 ? 'person' : 'people'}. Share the page link to invite others.` }];
      setScreen('room');
    });
  }

  /* ─────────────────────────────────────────────────────
     Room screen
  ───────────────────────────────────────────────────── */
  function renderRoom() {
    const title = roomMovie?.title || 'Movie';
    const embed = roomMovie?.embed  || '';

    app.innerHTML = `
      <button class="back-link" id="leaveRoom">← Leave room</button>
      <div class="room-layout">

        <section class="room-main">
          <div class="room-title-row">
            <div>
              <h1>${esc(title)}</h1>
              <p>Room for ${selectedCount} · ${esc(roomMovie?.genre || '')}</p>
            </div>
            <span class="live-pill"><span class="live-dot"></span> LIVE ROOM</span>
          </div>

          <div class="video-shell" id="videoShell">
            ${embed
              ? `<iframe id="movieIframe"
                   src="${esc(embed)}"
                   title="${esc(title)} player"
                   allow="autoplay; fullscreen; picture-in-picture; encrypted-media"
                   allowfullscreen
                   referrerpolicy="strict-origin-when-cross-origin"></iframe>`
              : `<div style="display:grid;place-items:center;width:100%;height:100%;color:var(--muted);font-size:13px;">
                   No video source available for this title.
                 </div>`}
          </div>

          <div class="room-note">
            <span>ⓘ</span>
            <span>Playback is provided by the external embed linked in the catalogue. Keep this tab active to stay in sync.</span>
          </div>

          <div class="queue-header">
            <h2>Switch film</h2>
            <span>Changes your current room</span>
          </div>
          <div class="room-movie-strip">
            ${movies.map(m => `
              <button class="strip-item" type="button" data-room-movie="${esc(m.id)}">
                <div class="strip-poster" style="background-image:url('${esc(m.image)}')"></div>
                <b>${esc(m.title)}</b>
              </button>`).join('')}
          </div>
        </section>

        <aside class="room-sidebar" aria-label="Room chat">
          <div class="chat-head">
            <h2>Room chat</h2>
            <span>Say hello while the film rolls</span>
          </div>
          <div class="chat-members">
            <div class="avatars">
              <span class="avatar">${esc((user?.name || 'Y').slice(0, 1).toUpperCase())}</span>
              <span class="avatar" title="Invite more people">+</span>
            </div>
            <span>You · room for ${selectedCount}</span>
          </div>
          <div class="chat-messages" id="chatMessages">
            ${chatLines.map(msgHtml).join('')}
          </div>
          <form class="chat-form" id="chatForm">
            <input id="chatInput" maxlength="240" placeholder="Write a message…" aria-label="Chat message" autocomplete="off">
            <button class="chat-send" type="submit" aria-label="Send">↑</button>
          </form>
        </aside>
      </div>`;

    scrollChatToBottom();

    document.querySelector('#leaveRoom').addEventListener('click', () => setScreen('home'));

    document.querySelector('#chatForm').addEventListener('submit', e => {
      e.preventDefault();
      const input = document.querySelector('#chatInput');
      const text  = input.value.trim();
      if (!text) return;
      const line  = { name: user?.name || 'You', text };
      chatLines.push(line);

      const messages = document.querySelector('#chatMessages');
      const wrapper  = document.createElement('div');
      wrapper.innerHTML = msgHtml(line);
      messages.append(wrapper.firstElementChild);
      scrollChatToBottom();
      input.value = '';
      input.focus();
    });

    document.querySelectorAll('[data-room-movie]').forEach(btn =>
      btn.addEventListener('click', () => {
        const found = movies.find(m => m.id === btn.dataset.roomMovie);
        if (!found || found.id === roomMovie?.id) return;
        roomMovie = found;
        renderRoom();
        toast(`Now showing: ${roomMovie.title}`);
      })
    );
  }

  function msgHtml(line) {
    if (line.type === 'system') {
      return `<div class="message system">${esc(line.text)}</div>`;
    }
    return `<div class="message"><b>${esc(line.name || 'You')}</b>${esc(line.text)}</div>`;
  }

  /* ─────────────────────────────────────────────────────
     Sports screen
  ───────────────────────────────────────────────────── */
  function renderSports() {
    app.innerHTML = `
      <button class="back-link" id="sportsBack">← Back to home</button>
      <section class="page-heading">
        <div class="eyebrow">The big game</div>
        <h1>Bring on the <span>action.</span></h1>
        <p>For sports schedules and live broadcasts, visit the official broadcaster.</p>
      </section>
      <section class="sport-panel">
        <div class="sport-art" aria-hidden="true">◉</div>
        <div class="sport-info">
          <div class="eyebrow">Official sports destination</div>
          <h2>Find your next match</h2>
          <p>Browse live events, match schedules, and coverage on beIN SPORTS. Availability depends on your region and subscription.</p>
          <a class="primary-button" href="https://www.beinsports.com/" target="_blank" rel="noopener noreferrer">
            Visit beIN SPORTS ↗
          </a>
          <p class="fine-print">TMK Community is not affiliated with beIN SPORTS and does not host or stream any sports content.</p>
        </div>
      </section>`;

    document.querySelector('#sportsBack').addEventListener('click', () => setScreen('home'));
  }

  /* ─────────────────────────────────────────────────────
     Global listeners
  ───────────────────────────────────────────────────── */
  logoutButton.addEventListener('click', async () => {
    logoutButton.disabled = true;
    try {
      await api('logout', {});
    } catch (err) {
      toast(err.message, true);
    }
    user      = null;
    verified  = false;
    authMode  = 'login';
    logoutButton.disabled = false;
    setScreen('auth');
  });

  document.querySelector('[data-action="home"]')?.addEventListener('click', e => {
    e.preventDefault();
    if (user) setScreen('home');
  });

  /* ─────────────────────────────────────────────────────
     Boot — check if the session is already authenticated
  ───────────────────────────────────────────────────── */
  api('me')
    .then(data => {
      user   = data.authenticated ? data.user : null;
      screen = user ? 'home' : 'auth';
      render();
    })
    .catch(() => {
      user   = null;
      screen = 'auth';
      render();
    });

})();
