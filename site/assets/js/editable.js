(function () {
  function T(key, fallback) {
    return (window.RL_T && window.RL_T[key]) || fallback;
  }

  function toast(msg) {
    const el = document.getElementById('rl-toast');
    if (!el) return;
    el.textContent = msg;
    el.classList.add('show');
    clearTimeout(el._t);
    el._t = setTimeout(() => el.classList.remove('show'), 2200);
  }

  async function postJSON(url, obj) {
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': window.RL_CSRF },
      body: JSON.stringify(obj),
    });
    const data = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(data.error || 'Erreur serveur.');
    return data;
  }

  async function postForm(url, formData) {
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'X-CSRF-Token': window.RL_CSRF },
      body: formData,
    });
    const data = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(data.error || 'Erreur serveur.');
    return data;
  }

  function openModal(title, fieldsHtml, onSubmit, submitLabel) {
    submitLabel = submitLabel || T('common.save', 'Enregistrer');
    const overlay = document.createElement('div');
    overlay.className = 'rl-modal-overlay';
    overlay.innerHTML =
      '<div class="rl-modal"><h3>' + title + '</h3><form>' + fieldsHtml +
      '<div class="rl-modal-actions">' +
      '<button type="button" class="rl-btn rl-btn-secondary" data-close>' + T('common.cancel', 'Annuler') + '</button>' +
      '<button type="submit" class="rl-btn rl-btn-primary">' + submitLabel + '</button>' +
      '</div></form></div>';
    document.body.appendChild(overlay);
    const form = overlay.querySelector('form');
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay || e.target.hasAttribute('data-close')) overlay.remove();
    });
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = form.querySelector('button[type=submit]');
      btn.disabled = true;
      btn.textContent = submitLabel + '…';
      try {
        await onSubmit(new FormData(form), form);
        overlay.remove();
      } catch (err) {
        alert(err.message || 'Une erreur est survenue.');
        btn.disabled = false;
        btn.textContent = submitLabel;
      }
    });
    const firstInput = form.querySelector('input, textarea');
    if (firstInput) firstInput.focus();
    return overlay;
  }

  function openMediaModal(key) {
    openModal('Modifier ce média', `
      <label>Choisir une image ou une vidéo</label>
      <input type="file" name="file" accept="image/jpeg,image/png,image/webp,image/svg+xml,video/mp4,video/webm">
      <label>Ou coller un lien vidéo YouTube / Vimeo</label>
      <input type="text" name="embed_url" placeholder="https://youtube.com/watch?v=...">
    `, async (fd) => {
      const file = fd.get('file');
      const embed = fd.get('embed_url');
      const upload = new FormData();
      upload.append('key', key);
      if (file && file.size) upload.append('file', file);
      else if (embed) upload.append('embed_url', embed);
      else throw new Error('Choisissez un fichier ou indiquez un lien vidéo.');
      await postForm('api/save-media.php', upload);
      location.reload();
    }, 'Enregistrer');
  }

  function wireEditableText() {
    // Empêche la navigation immédiate quand le texte éditable est à l'intérieur d'un lien
    // (sinon le premier clic d'un double-clic ferait déjà quitter la page).
    document.addEventListener('click', (e) => {
      const editable = e.target.closest('.rl-editable, .rl-media');
      if (editable && editable.closest('a')) {
        e.preventDefault();
      }
    }, true);

    document.querySelectorAll('.rl-editable').forEach((el) => {
      el.addEventListener('dblclick', () => {
        el.dataset.original = el.innerText;
        el.contentEditable = 'true';
        el.focus();
        const range = document.createRange();
        range.selectNodeContents(el);
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
      });
      el.addEventListener('blur', async () => {
        if (el.contentEditable !== 'true') return;
        el.contentEditable = 'false';
        const value = el.innerText.trim();
        if (value === (el.dataset.original || '').trim()) return;
        try {
          await postJSON('api/save-text.php', { key: el.dataset.editKey, value });
          toast(T('common.modified', 'Modifié ✓'));
        } catch (err) {
          alert(err.message);
          el.innerText = el.dataset.original || '';
        }
      });
      el.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
          el.innerText = el.dataset.original || '';
          el.blur();
        }
      });
    });

    document.querySelectorAll('.rl-media').forEach((el) => {
      el.addEventListener('dblclick', () => openMediaModal(el.dataset.mediaKey));
    });
  }

  function wireActions() {
    document.addEventListener('click', async (e) => {
      const btn = e.target.closest('[data-action]');
      if (!btn) return;
      const action = btn.dataset.action;
      try {
        if (action === 'edit-link') {
          const next = prompt('Adresse du lien :', btn.dataset.current || '');
          if (next === null) return;
          await postJSON('api/save-text.php', { key: btn.dataset.key, value: next.trim() });
          location.reload();
        } else if (action === 'add-sponsor') {
          openModal('Ajouter un sponsor', `
            <label>Nom du sponsor</label>
            <input type="text" name="name" required>
            <label>Logo (JPG, PNG, WebP, SVG)</label>
            <input type="file" name="logo" accept="image/jpeg,image/png,image/webp,image/svg+xml" required>
          `, async (fd) => { await postForm('api/sponsors-add.php', fd); location.reload(); }, 'Ajouter');
        } else if (action === 'delete-sponsor') {
          if (!confirm('Supprimer ce sponsor ?')) return;
          await postJSON('api/sponsors-delete.php', { id: btn.dataset.id });
          location.reload();
        } else if (action === 'add-team') {
          openModal("Ajouter une équipe FTC", `
            <label>Nom de l'équipe</label>
            <input type="text" name="name" required placeholder="Équipe 12345">
            <label>Statut affiché</label>
            <input type="text" name="status_label" value="Active">
            <label>Description courte</label>
            <textarea name="description" rows="3"></textarea>
          `, async (fd) => {
            const r = await postForm('api/teams-add.php', fd);
            location.href = 'equipe-ftc.php?slug=' + encodeURIComponent(r.slug);
          }, 'Ajouter');
        } else if (action === 'edit-team-info') {
          openModal("Modifier l'équipe", `
            <label>Nom de l'équipe</label>
            <input type="text" name="name" required value="${(btn.dataset.name || '').replace(/"/g, '&quot;')}">
            <label>Statut affiché</label>
            <input type="text" name="status_label" value="${(btn.dataset.status || '').replace(/"/g, '&quot;')}">
            <label>Description (français)</label>
            <textarea name="description" rows="4">${btn.dataset.description || ''}</textarea>
            <label>Description (anglais, optionnel — sinon le français s'affiche)</label>
            <textarea name="description_en" rows="4">${btn.dataset.descriptionEn || ''}</textarea>
          `, async (fd) => {
            await postJSON('api/teams-update.php', {
              id: btn.dataset.id,
              name: fd.get('name'),
              status_label: fd.get('status_label'),
              description: fd.get('description'),
              description_en: fd.get('description_en'),
            });
            location.reload();
          }, 'Enregistrer');
        } else if (action === 'delete-team') {
          if (!confirm("Supprimer cette équipe et toute sa page ? Cette action est irréversible.")) return;
          await postJSON('api/teams-delete.php', { id: btn.dataset.id });
          location.href = 'ftc.php';
        } else if (action === 'add-member') {
          openModal('Ajouter un membre', `
            <label>Nom</label><input type="text" name="name" required>
            <label>Rôle</label><input type="text" name="role" required>
            <label>Photo (optionnelle)</label><input type="file" name="photo" accept="image/jpeg,image/png,image/webp">
          `, async (fd) => {
            fd.append('team_id', btn.dataset.teamId);
            await postForm('api/members-add.php', fd);
            location.reload();
          }, 'Ajouter');
        } else if (action === 'delete-member') {
          if (!confirm('Retirer ce membre ?')) return;
          await postJSON('api/members-delete.php', { id: btn.dataset.id });
          location.reload();
        } else if (action === 'add-actu') {
          const today = new Date().toISOString().slice(0, 10);
          openModal('Ajouter une actualité', `
            <label>Titre</label><input type="text" name="title" required>
            <label>Date de publication</label><input type="date" name="published_at" value="${today}" required>
            <label>Date / période affichée sur la carte</label><input type="text" name="date_label" required placeholder="Saison 2026">
            <label>Affiche (optionnelle)</label><input type="file" name="image" accept="image/jpeg,image/png,image/webp">
          `, async (fd) => { await postForm('api/actus-add.php', fd); location.reload(); }, 'Ajouter');
        } else if (action === 'delete-actu') {
          if (!confirm('Supprimer cette actualité ?')) return;
          await postJSON('api/actus-delete.php', { id: btn.dataset.id });
          location.reload();
        } else if (action === 'add-admin') {
          openModal('Ajouter un administrateur', `
            <label>E-mail</label><input type="email" name="email" required>
            <label>Étiquette (Dev, CAO, Communication...)</label><input type="text" name="title" placeholder="Communication">
          `, async (fd) => {
            const r = await postJSON('api/admins-add.php', { email: fd.get('email'), title: fd.get('title') });
            alert(r.notice);
            location.reload();
          }, 'Ajouter');
        } else if (action === 'edit-admin') {
          openModal("Modifier l'administrateur", `
            <label>Étiquette</label>
            <input type="text" name="title" required value="${(btn.dataset.title || '').replace(/"/g, '&quot;')}">
            <label>Rôle</label>
            <select name="role">
              <option value="communication" ${btn.dataset.role !== 'owner' ? 'selected' : ''}>Membre (édition du contenu)</option>
              <option value="owner" ${btn.dataset.role === 'owner' ? 'selected' : ''}>Propriétaire (gestion des comptes)</option>
            </select>
          `, async (fd) => {
            await postJSON('api/admins-update.php', {
              id: btn.dataset.id,
              title: fd.get('title'),
              role: fd.get('role'),
            });
            location.reload();
          }, T('common.save', 'Enregistrer'));
        } else if (action === 'delete-admin') {
          if (!confirm('Retirer cet administrateur ?')) return;
          await postJSON('api/admins-delete.php', { id: btn.dataset.id });
          location.reload();
        } else if (action === 'upload-document') {
          openModal('Envoyer un dossier PDF', `
            <label>Fichier PDF</label>
            <input type="file" name="file" accept="application/pdf" required>
          `, async (fd) => {
            fd.append('key', btn.dataset.key);
            await postForm('api/save-document.php', fd);
            location.reload();
          }, 'Envoyer');
        } else if (action === 'add-mentor') {
          openModal('Ajouter un mentor', `
            <label>Nom</label><input type="text" name="name" required>
            <label>Rôle / domaine</label><input type="text" name="role" required placeholder="Mentor technique">
            <label>Photo (optionnelle)</label><input type="file" name="photo" accept="image/jpeg,image/png,image/webp">
          `, async (fd) => { await postForm('api/mentors-add.php', fd); location.reload(); }, 'Ajouter');
        } else if (action === 'delete-mentor') {
          if (!confirm('Retirer ce mentor ?')) return;
          await postJSON('api/mentors-delete.php', { id: btn.dataset.id });
          location.reload();
        } else if (action === 'upload-model') {
          openModal(T('robot.add_model', 'Modèle 3D'), `
            <label>Fichier .glb ou .gltf</label>
            <input type="file" name="file" accept=".glb,.gltf">
            <label>Ou URL vers un fichier .glb / .gltf</label>
            <input type="text" name="url" placeholder="https://.../robot.glb">
          `, async (fd) => {
            const file = fd.get('file');
            const url = (fd.get('url') || '').trim();
            const upload = new FormData();
            upload.append('key', btn.dataset.key);
            if (file && file.size) upload.append('file', file);
            else if (url) upload.append('url', url);
            else throw new Error('Choisissez un fichier ou indiquez une URL.');
            await postForm('api/save-model.php', upload);
            location.reload();
          }, T('common.save', 'Enregistrer'));
        } else if (action === 'change-password') {
          openModal('Changer mon mot de passe', `
            <label>Mot de passe actuel</label><input type="password" name="current_password" required>
            <label>Nouveau mot de passe</label><input type="password" name="new_password" required minlength="8">
          `, async (fd) => {
            await postJSON('api/change-password.php', {
              current_password: fd.get('current_password'),
              new_password: fd.get('new_password'),
            });
            alert('Mot de passe modifié.');
          }, 'Changer');
        }
      } catch (err) {
        alert(err.message || 'Une erreur est survenue.');
      }
    });
  }

  document.getElementById('rl-toggle-edit')?.addEventListener('click', async () => {
    try {
      await postJSON('api/toggle-edit-mode.php', {});
      location.reload();
    } catch (err) {
      alert(err.message);
    }
  });

  function wireMobileNav() {
    const toggle = document.getElementById('rl-nav-toggle');
    const panel = document.getElementById('rl-nav-mobile');
    if (!toggle || !panel) return;
    toggle.addEventListener('click', () => {
      const open = panel.classList.toggle('rl-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  function wireSeasonSelector() {
    document.querySelectorAll('[data-season-group]').forEach((group) => {
      const tabs = group.querySelectorAll('[data-season-tab]');
      tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
          const target = tab.dataset.seasonTab;
          group.querySelectorAll('[data-season-tab]').forEach((t) => t.classList.toggle('rl-season-active', t === tab));
          group.querySelectorAll('[data-season-panel]').forEach((p) => {
            p.style.display = p.dataset.seasonPanel === target ? '' : 'none';
          });
        });
      });
    });
  }

  function wireModelViewers() {
    document.querySelectorAll('model-viewer').forEach((mv) => {
      const wrap = mv.closest('.rl-model-viewer');
      const loader = wrap ? wrap.querySelector('[data-model-loading]') : null;
      if (!loader) return;
      mv.addEventListener('load', () => loader.remove());
      mv.addEventListener('error', () => {
        loader.textContent = 'Erreur de chargement du modèle 3D.';
      });
    });
  }

  function wireNewsletter() {
    const form = document.getElementById('rl-newsletter-form');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = form.querySelector('button[type=submit]');
      const msg = form.querySelector('.rl-newsletter-msg');
      const email = form.querySelector('input[name=email]').value;
      btn.disabled = true;
      try {
        await postJSON('api/newsletter-subscribe.php', { email });
        if (msg) { msg.textContent = T('footer.newsletter_ok', 'Merci, vous êtes inscrit·e !'); msg.style.color = '#1BA34A'; }
        form.reset();
      } catch (err) {
        if (msg) { msg.textContent = err.message; msg.style.color = '#D62828'; }
      }
      btn.disabled = false;
    });
  }

  if (window.RL_EDIT_MODE) {
    wireEditableText();
  }
  wireActions();
  wireMobileNav();
  wireSeasonSelector();
  wireNewsletter();
  wireModelViewers();
})();
