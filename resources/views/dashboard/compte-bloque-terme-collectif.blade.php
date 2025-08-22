<section style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 2rem 1rem;">
  <div style="max-width: 1200px; margin: 0 auto;">
    <!-- En-tête -->
    <div style="text-align: center; margin-bottom: 3rem;">
      <h1 style="color: white; font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; text-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);">
        Créer un nouveau compte
      </h1>
      <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.1rem;">
        Choisissez le type de compte qui correspond à vos besoins
      </p>
    </div>

    <!-- Grille des comptes -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
      <!-- Compte Bloqué -->

      @if ($bloqueExiste && $compteBloque)
      {{-- Afficher le bloc avec les infos existantes - VERSION AMÉLIORÉE --}}
      <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25), 0 0 0 1px rgba(248, 113, 113, 0.1); padding: 0; overflow: hidden; position: relative;">
        {{-- Header avec gradient --}}
        <div style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%); padding: 2rem; color: white; position: relative; overflow: hidden;">
          {{-- Motif décoratif en arrière-plan --}}
          <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); pointer-events: none;"></div>

          {{-- Icône et titre --}}
          <div style="position: relative; z-index: 2;">
            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
              <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; backdrop-filter: blur(10px);">
                <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                  <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                  <path d="M9 12l2 2 4-4" stroke="white" stroke-width="2" fill="none" />
                </svg>
              </div>
              <div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">Compte Bloqué</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 0.9rem; font-weight: 500;">Épargne sécurisée activée</p>
              </div>
            </div>

            {{-- Badge de statut --}}
            <div style="display: inline-flex; align-items: center; background: rgba(255, 255, 255, 0.2); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
              🔒 {{$compteBloque->status}}
            </div>
          </div>
        </div>

        {{-- Contenu principal --}}
        <div style="padding: 2rem;">
          {{-- Informations principales --}}
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 1.5rem; border-radius: 16px; border: 1px solid #f59e0b;">
              <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                <div style="width: 2.5rem; height: 2.5rem; background: #f59e0b; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                  <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                  </svg>
                </div>
                <div>
                  <p style="margin: 0; font-size: 0.8rem; color: #92400e; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Date de déblocage</p>
                  <p style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #451a03;">{{ $compteBloque->date_deblocage }}</p>
                </div>
              </div>
            </div>

            <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 1.5rem; border-radius: 16px; border: 1px solid #22c55e;">
              <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                <div style="width: 2.5rem; height: 2.5rem; background: #22c55e; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                  <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                  </svg>
                </div>
                <div>
                  <p style="margin: 0; font-size: 0.8rem; color: #166534; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Solde Bloqué</p>
                  <p style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #052e16;">{{ number_format($compteBloque->solde, 0, ',', ' ') }} FCFA</p>
                </div>
              </div>
            </div>
          </div>

          {{-- Informations supplémentaires --}}
          <div style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); padding: 1.5rem; border-radius: 16px; border: 1px solid #cbd5e1; margin-bottom: 1.5rem;">
            <h4 style="margin: 0 0 1rem 0; font-size: 1rem; font-weight: 700; color: #334155;">Détails du compte</h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
              <div style="display: flex; align-items: center;">
                <span style="color: #3b82f6; margin-right: 0.5rem;">📅</span>
                <span style="font-size: 0.85rem; color: #475569;">Durée de blocage en cours</span>
              </div>
              <div style="display: flex; align-items: center;">
                <span style="color: #8b5cf6; margin-right: 0.5rem;">💰</span>
                <span style="font-size: 0.85rem; color: #475569;">Intérêts : 5% à l'échéance</span>
              </div>
              <div style="display: flex; align-items: center;">
                <span style="color: #10b981; margin-right: 0.5rem;">🔒</span>
                <span style="font-size: 0.85rem; color: #475569;">Fonds sécurisés</span>
              </div>
              <div style="display: flex; align-items: center;">
                <span style="color: #f59e0b; margin-right: 0.5rem;">⚡</span>
                <span style="font-size: 0.85rem; color: #475569;">Déblocage automatique</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @else
      <div onclick="selectAccount('bloque')" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; transition: all 0.3s ease; cursor: pointer; border: 3px solid transparent;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 35px 70px -12px rgba(0, 0, 0, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)'" id="card-bloque">
        <div style="padding: 2rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
          <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
              <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
            </svg>
          </div>
          <div style="color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Compte Bloqué</div>
          <div style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">Épargne sécurisée avec intérêts</div>
        </div>
        <div style="padding: 2rem;">
          <ul style="list-style: none; margin-bottom: 1.5rem; padding: 0;">
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Versement unique seulement</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Retrait unique à date fixe</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Pas de frais d'entretien</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Durée minimum : 1 mois</li>
          </ul>
          <div style="display: inline-flex; align-items: center; background: linear-gradient(90deg, #ecfdf5 0%, #d1fae5 100%); color: #065f46; padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; border: 1px solid #10b981;">
            💰 Intérêt : 5% au déblocage
          </div>
        </div>
      </div>
      @endif


      @if($termeExiste && $compteTerme)
      {{-- Afficher le bloc avec les infos du compte à terme existant --}}
      <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25), 0 0 0 1px rgba(16, 185, 129, 0.1); padding: 0; overflow: hidden; position: relative;">
        {{-- Header avec gradient vert --}}
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); padding: 2rem; color: white; position: relative; overflow: hidden;">
          {{-- Icône et titre --}}
          <div style="position: relative; z-index: 2;">
            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
              <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; backdrop-filter: blur(10px);">
                <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
              </div>
              <div>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">Compte à Terme</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 0.9rem; font-weight: 500;">Épargne active</p>
              </div>
            </div>

            {{-- Badge de statut --}}
            <div style="display: inline-flex; align-items: center; background: rgba(255, 255, 255, 0.2); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
              📈 {{ strtoupper($compteTerme->status) }}
            </div>
          </div>
        </div>

        {{-- Contenu principal --}}
        <div style="padding: 2rem;">
          {{-- Informations principales --}}
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 1.5rem; border-radius: 16px; border: 1px solid #22c55e;">
              <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                <div style="width: 2.5rem; height: 2.5rem; background: #22c55e; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                  <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                  </svg>
                </div>
                <div>
                  <p style="margin: 0; font-size: 0.8rem; color: #166534; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Date d'échéance</p>
                  <p style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #052e16;">{{ $compteTerme->date_deblocage ?? 'À définir' }}</p>
                </div>
              </div>
            </div>

            <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 1.5rem; border-radius: 16px; border: 1px solid #22c55e;">
              <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                <div style="width: 2.5rem; height: 2.5rem; background: #22c55e; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                  <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                  </svg>
                </div>
                <div>
                  <p style="margin: 0; font-size: 0.8rem; color: #166534; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Solde Actuel</p>
                  <p style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #052e16;">{{ number_format($compteTerme->solde ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
              </div>
            </div>
          </div>

          {{-- Boutons d'action --}}
          <div style="display: flex; gap: 1rem; justify-content: center;">
            <button style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; padding: 0.75rem 2rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
              📊 Voir Détails
            </button>
            <button style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 0.75rem 2rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
              💰 Alimenter
            </button>
          </div>
        </div>
      </div>
      @else
      {{-- Afficher le formulaire de création du compte à terme --}}
      <div onclick="showForm('terme')"
        style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; transition: all 0.3s ease; cursor: pointer; border: 3px solid transparent;"
        onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 35px 70px -12px rgba(0, 0, 0, 0.35)'"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)'"
        id="card-terme">
        <div style="padding: 2rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
          <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
          </div>
          <div style="color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Compte à Terme</div>
          <div style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">Épargne progressive avec rendement</div>
        </div>
        <div style="padding: 2rem;">
          <ul style="list-style: none; margin-bottom: 1.5rem; padding: 0;">
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;">
              <span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>
              Versements multiples autorisés
            </li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;">
              <span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>
              Retrait unique à date fixe
            </li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;">
              <span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>
              Soumis aux frais d'entretien
            </li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;">
              <span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>
              Durée minimum : 2 mois
            </li>
          </ul>
          <div style="display: inline-flex; align-items: center; background: linear-gradient(90deg, #ecfdf5 0%, #d1fae5 100%); color: #065f46; padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; border: 1px solid #10b981;">
            📈 Intérêt : 2,5% sur le solde
          </div>
        </div>
      </div>
      @endif



      <!-- Formulaire (masqué par défaut) -->
      <div id="form-terme" style="display:none; margin-top:2rem; background:white; padding:2rem; border-radius:16px; box-shadow:0 10px 20px rgba(0,0,0,0.1);">
        <h3 style="font-size:1.2rem; font-weight:600; margin-bottom:1rem; color:#065f46;">
          Création d’un Compte à Terme
        </h3>

        <form action="{{ route('compte.terme.store') }}" method="POST">
          @csrf
          <div style="margin-bottom:1rem;">
            <label for="date_deblocage" style="display:block; font-weight:500; margin-bottom:0.5rem; color:#374151;">
              Date de déblocage (au moins 2 mois plus tard)
            </label>
            <input type="date" name="date_deblocage" id="date_deblocage" required
              min="{{ now()->addMonths(2)->toDateString() }}"
              style="width:100%; padding:0.75rem; border:1px solid #d1d5db; border-radius:8px;" />
          </div>

          <button type="submit"
            style="background:linear-gradient(90deg,#10b981,#059669); color:white; font-weight:600; padding:0.75rem 1.5rem; border:none; border-radius:12px; cursor:pointer;">
            Créer le compte
          </button>
        </form>
      </div>

      <script>
        function showForm(type) {
          if (type === 'terme') {
            document.getElementById('form-terme').style.display = 'block';
            window.scrollTo({
              top: document.getElementById('form-terme').offsetTop - 50,
              behavior: 'smooth'
            });
          }
        }
      </script>


      <!-- Compte Collectif -->
      <div onclick="selectAccount('collectif')" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; transition: all 0.3s ease; cursor: pointer; border: 3px solid transparent;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 35px 70px -12px rgba(0, 0, 0, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)'" id="card-collectif">
        <div style="padding: 2rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
          <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
              <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h3v-2c0-1.1.9-2 2-2h2.5l1.5-1.5L15 10.5c1.1 0 2 .9 2 2v2h3v4H4z" />
            </svg>
          </div>
          <div style="color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Compte Collectif</div>
          <div style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">Épargne partagée (2 à 7 membres)</div>
        </div>
        <div style="padding: 2rem;">
          <ul style="list-style: none; margin-bottom: 1.5rem; padding: 0;">
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Versements multiples libres</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Retraits sans restriction</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Soumis aux frais d'entretien</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Gestion collaborative</li>
          </ul>
          <div style="display: inline-flex; align-items: center; background: linear-gradient(90deg, #ecfdf5 0%, #d1fae5 100%); color: #065f46; padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; border: 1px solid #10b981;">
            👥 De 2 à 7 membres maximum
          </div>
        </div>
      </div>
    </div>

    <!-- Formulaire Compte Bloqué -->
    <form id="form-bloque" action="{{ route('compte.bloque.store') }}" method="POST" style="display: none; margin-top: 2rem;">
      @csrf
      <div style="margin-bottom: 1.5rem;">
        <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
          <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
            <svg width="16" height="16" fill="#4f46e5" viewBox="0 0 24 24">
              <path d="M9 11H7v8h2v-8zm4 0h-2v8h2v-8zm4 0h-2v8h2v-8zm2-7v2H3V4h3.5l1-1h5l1 1H17z" />
            </svg>
          </div>
          Date de déblocage (min. 1 mois)
        </label>
        <input type="date" name="date_deblocage" required style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;"
          onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'; this.style.transform='translateY(-1px)'"
          onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
      </div>

      <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
        <button type="reset" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: #f3f4f6; color: #374151;"
          onmouseover="this.style.background='#e5e7eb'; this.style.transform='scale(1.02)'"
          onmouseout="this.style.background='#f3f4f6'; this.style.transform='scale(1)'">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M6 6h12v12H6z" />
          </svg>
          Annuler
        </button>
        <button type="submit" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%); color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);"
          onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 20px 25px -5px rgba(79, 70, 229, 0.4)'"
          onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(79, 70, 229, 0.3)'">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
          </svg>
          Créer le compte
        </button>
      </div>
    </form>

  </div>

  <script>
    let selectedAccount = null;
    let members = [];

    function selectAccount(type) {
      document.querySelectorAll('[id^="card-"]').forEach(card => {
        card.style.borderColor = 'transparent';
        card.style.transform = 'translateY(0)';
      });

      document.querySelectorAll('[id^="form-"]').forEach(form => {
        form.style.display = 'none';
      });

      document.getElementById('card-' + type).style.borderColor = '#4f46e5';
      document.getElementById('card-' + type).style.transform = 'translateY(-5px)';
      selectedAccount = type;

      const form = document.getElementById('form-' + type);
      form.style.display = 'block';
      form.style.animation = 'slideIn 0.5s ease-out';

      setTimeout(() => {
        form.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }, 100);
    }

    function addMember() {
      const nameInput = document.getElementById('member-name');
      const phoneInput = document.getElementById('member-phone');

      const name = nameInput.value.trim();
      const phone = phoneInput.value.trim();

      if (!name || !phone) {
        alert('Veuillez remplir le nom et le téléphone du membre');
        return;
      }

      if (members.length >= 7) {
        alert('Maximum 7 membres autorisés');
        return;
      }

      if (members.some(member => member.phone === phone)) {
        alert('Ce numéro de téléphone est déjà enregistré');
        return;
      }

      members.push({
        name,
        phone
      });
      updateMembersList();

      nameInput.value = '';
      phoneInput.value = '';
    }

    function updateMembersList() {
      const membersList = document.getElementById('members-list');
      const membersCount = document.getElementById('members-count');

      if (!membersList || !membersCount) return;

      membersList.innerHTML = '';

      members.forEach((member, index) => {
        const memberItem = document.createElement('div');
        memberItem.style.cssText = 'background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1rem; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;';
        memberItem.innerHTML = `
          <div>
            <strong>${member.name}</strong><br>
            <span style="color: #6b7280; font-size: 0.875rem;">${member.phone}</span>
          </div>
          <button type="button" onclick="removeMember(${index})" style="background: #ef4444; color: white; border: none; padding: 0.5rem; border-radius: 8px; cursor: pointer;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13H5v-2h14v2z"/></svg>
          </button>
        `;
        membersList.appendChild(memberItem);
      });

      membersCount.textContent = members.length;
    }

    function removeMember(index) {
      members.splice(index, 1);
      updateMembersList();
    }

    function createAccount(event, type) {
      event.preventDefault();

      const form = event.target;
      const formData = new FormData(form);

      if (type === 'collectif') {
        if (members.length < 2) {
          alert('Vous devez ajouter au moins 2 membres pour un compte collectif');
          return;
        }
        formData.append('members', JSON.stringify(members));
      }

      if (type === 'bloque' || type === 'terme') {
        const dateDeblocage = formData.get('date_deblocage');
        if (!dateDeblocage) {
          alert("Veuillez renseigner la date de déblocage");
          return;
        }

        const today = new Date();
        const selectedDate = new Date(dateDeblocage);

        const minDate = new Date(today);
        if (type === 'bloque') {
          minDate.setMonth(today.getMonth() + 1);
        } else if (type === 'terme') {
          minDate.setMonth(today.getMonth() + 2);
        }

        // Réinitialiser l'heure pour éviter les effets de fuseau
        minDate.setHours(0, 0, 0, 0);
        selectedDate.setHours(0, 0, 0, 0);

        if (selectedDate < minDate) {
          const minDuration = type === 'bloque' ? '1 mois' : '2 mois';
          alert(`La date de déblocage doit être d'au moins ${minDuration} à partir d'aujourd'hui`);
          return;
        }
      }

      // Ici tu peux faire un fetch/POST vers ta route Laravel si tu veux persister
      // fetch('/comptes', { method: 'POST', body: formData });

      console.log('Création du compte:', type);
      console.log('Données:', Object.fromEntries(formData));

      const successMessage = document.getElementById('success-' + type);
      if (successMessage) {
        successMessage.style.display = 'flex';
        setTimeout(() => {
          successMessage.style.display = 'none';
        }, 5000);
      }

      form.reset();
      if (type === 'collectif') {
        members = [];
        updateMembersList();
      }
    }

    function resetForm() {
      document.querySelectorAll('[id^="card-"]').forEach(card => {
        card.style.borderColor = 'transparent';
        card.style.transform = 'translateY(0)';
      });

      document.querySelectorAll('[id^="form-"]').forEach(form => {
        form.style.display = 'none';
      });

      selectedAccount = null;
      members = [];
      updateMembersList();

      document.querySelectorAll('[id^="success-"]').forEach(msg => {
        msg.style.display = 'none';
      });

      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      const memberName = document.getElementById('member-name');
      const memberPhone = document.getElementById('member-phone');

      if (memberName && memberPhone) {
        memberName.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            memberPhone.focus();
          }
        });

        memberPhone.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            addMember();
          }
        });
      }

      // Pré-renseigner les dates min
      const oneMonthLater = new Date();
      oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);

      const twoMonthsLater = new Date();
      twoMonthsLater.setMonth(twoMonthsLater.getMonth() + 2);

      const dateInputBloque = document.querySelector('#form-bloque input[name="date_deblocage"]');
      if (dateInputBloque) dateInputBloque.min = oneMonthLater.toISOString().split('T')[0];

      const dateInputTerme = document.querySelector('#form-terme input[name="date_deblocage"]');
      if (dateInputTerme) dateInputTerme.min = twoMonthsLater.toISOString().split('T')[0];
    });
  </script>
  <script>
    function selectAccount(type) {
      if (type === 'bloque') {
        const form = document.getElementById('form-bloque');
        if (form.style.display === 'none') {
          form.style.display = 'block';
          form.scrollIntoView({
            behavior: 'smooth'
          }); // défilement vers le formulaire
        } else {
          form.style.display = 'none';
        }
      }
    }
  </script>

  <style>
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      [style*="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr))"] {
        grid-template-columns: 1fr !important;
      }

      [style*="display: flex; gap: 1rem; justify-content: flex-end"] {
        flex-direction: column !important;
      }
    }
  </style>
</section>