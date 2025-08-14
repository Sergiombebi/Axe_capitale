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
      <div onclick="selectAccount('bloque')" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; transition: all 0.3s ease; cursor: pointer; border: 3px solid transparent;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 35px 70px -12px rgba(0, 0, 0, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)'" id="card-bloque">
        <div style="padding: 2rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
          <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
              <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
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

      <!-- Compte à Terme -->
      <div onclick="selectAccount('terme')" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; transition: all 0.3s ease; cursor: pointer; border: 3px solid transparent;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 35px 70px -12px rgba(0, 0, 0, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)'" id="card-terme">
        <div style="padding: 2rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
          <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
          </div>
          <div style="color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Compte à Terme</div>
          <div style="color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">Épargne progressive avec rendement</div>
        </div>
        <div style="padding: 2rem;">
          <ul style="list-style: none; margin-bottom: 1.5rem; padding: 0;">
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Versements multiples autorisés</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Retrait unique à date fixe</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Soumis aux frais d'entretien</li>
            <li style="display: flex; align-items: center; margin-bottom: 0.75rem; color: #374151; font-size: 0.9rem;"><span style="color: #10b981; font-weight: bold; margin-right: 0.75rem; background: #d1fae5; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</span>Durée minimum : 2 mois</li>
          </ul>
          <div style="display: inline-flex; align-items: center; background: linear-gradient(90deg, #ecfdf5 0%, #d1fae5 100%); color: #065f46; padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600; border: 1px solid #10b981;">
            📈 Intérêt : 2,5% sur le solde
          </div>
        </div>
      </div>

      <!-- Compte Collectif -->
      <div onclick="selectAccount('collectif')" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; transition: all 0.3s ease; cursor: pointer; border: 3px solid transparent;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 35px 70px -12px rgba(0, 0, 0, 0.35)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 25px 50px -12px rgba(0, 0, 0, 0.25)'" id="card-collectif">
        <div style="padding: 2rem; position: relative; overflow: hidden; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
          <div style="width: 4rem; height: 4rem; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
              <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h3v-2c0-1.1.9-2 2-2h2.5l1.5-1.5L15 10.5c1.1 0 2 .9 2 2v2h3v4H4z"/>
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
    <div id="form-bloque" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); padding: 2rem; margin-top: 2rem; display: none;">
      <div id="success-bloque" style="background: linear-gradient(90deg, #d1fae5 0%, #a7f3d0 100%); border: 1px solid #10b981; border-radius: 16px; padding: 1rem; margin-bottom: 1rem; display: none; align-items: center;">
        <svg width="24" height="24" fill="#10b981" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
          <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <div>
          <h3 style="font-weight: 600; color: #065f46; margin-bottom: 0.25rem;">Compte bloqué créé avec succès !</h3>
          <p style="color: #059669; font-size: 0.875rem; margin: 0;">Votre compte sera activé après validation.</p>
        </div>
      </div>

      <div style="display: flex; align-items: center; margin-bottom: 2rem;">
        <div style="width: 3rem; height: 3rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
          <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
          </svg>
        </div>
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">Nouveau Compte Bloqué</div>
          <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; margin-bottom: 0;">Configurez votre épargne sécurisée</p>
        </div>
      </div>

      <form onsubmit="createAccount(event, 'bloque')">
        <div style="margin-bottom: 1.5rem;">
          <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
            <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
              <svg width="16" height="16" fill="#4f46e5" viewBox="0 0 24 24">
                <path d="M9 11H7v8h2v-8zm4 0h-2v8h2v-8zm4 0h-2v8h2v-8zm2-7v2H3V4h3.5l1-1h5l1 1H17z"/>
              </svg>
            </div>
            Date de déblocage (min. 1 mois)
          </label>
          <input type="date" name="date_deblocage" required style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'; this.style.transform='translateY(-1px)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
          <button type="button" onclick="resetForm()" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: #f3f4f6; color: #374151;" onmouseover="this.style.background='#e5e7eb'; this.style.transform='scale(1.02)'" onmouseout="this.style.background='#f3f4f6'; this.style.transform='scale(1)'">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
            Annuler
          </button>
          <button type="submit" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%); color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 20px 25px -5px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(79, 70, 229, 0.3)'">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            Créer le compte
          </button>
        </div>
      </form>
    </div>

    <!-- Formulaire Compte à Terme -->
    <div id="form-terme" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); padding: 2rem; margin-top: 2rem; display: none;">
      <div id="success-terme" style="background: linear-gradient(90deg, #d1fae5 0%, #a7f3d0 100%); border: 1px solid #10b981; border-radius: 16px; padding: 1rem; margin-bottom: 1rem; display: none; align-items: center;">
        <svg width="24" height="24" fill="#10b981" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
          <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <div>
          <h3 style="font-weight: 600; color: #065f46; margin-bottom: 0.25rem;">Compte à terme créé avec succès !</h3>
          <p style="color: #059669; font-size: 0.875rem; margin: 0;">Votre compte sera activé après validation.</p>
        </div>
      </div>

      <div style="display: flex; align-items: center; margin-bottom: 2rem;">
        <div style="width: 3rem; height: 3rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
          <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
          </svg>
        </div>
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">Nouveau Compte à Terme</div>
          <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; margin-bottom: 0;">Configurez votre épargne progressive</p>
        </div>
      </div>

      <form onsubmit="createAccount(event, 'terme')">
        <div style="margin-bottom: 1.5rem;">
          <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
            <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
              <svg width="16" height="16" fill="#4f46e5" viewBox="0 0 24 24">
                <path d="M9 11H7v8h2v-8zm4 0h-2v8h2v-8zm4 0h-2v8h2v-8zm2-7v2H3V4h3.5l1-1h5l1 1H17z"/>
              </svg>
            </div>
            Date de déblocage (min. 2 mois)
          </label>
          <input type="date" name="date_deblocage" required style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'; this.style.transform='translateY(-1px)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
        </div>

        <div style="margin-bottom: 1.5rem;">
          <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
            <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
              <svg width="16" height="16" fill="#4f46e5" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
              </svg>
            </div>
            Montant initial (facultatif)
          </label>
          <input type="number" name="montant_initial" placeholder="Montant du premier versement" min="0" step="0.01" style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'; this.style.transform='translateY(-1px)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
          <button type="button" onclick="resetForm()" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: #f3f4f6; color: #374151;" onmouseover="this.style.background='#e5e7eb'; this.style.transform='scale(1.02)'" onmouseout="this.style.background='#f3f4f6'; this.style.transform='scale(1)'">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
            Annuler
          </button>
          <button type="submit" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%); color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 20px 25px -5px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(79, 70, 229, 0.3)'">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            Créer le compte
          </button>
        </div>
      </form>
    </div>

    <!-- Formulaire Compte Collectif -->
    <div id="form-collectif" style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); padding: 2rem; margin-top: 2rem; display: none;">
      <div id="success-collectif" style="background: linear-gradient(90deg, #d1fae5 0%, #a7f3d0 100%); border: 1px solid #10b981; border-radius: 16px; padding: 1rem; margin-bottom: 1rem; display: none; align-items: center;">
        <svg width="24" height="24" fill="#10b981" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
          <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <div>
          <h3 style="font-weight: 600; color: #065f46; margin-bottom: 0.25rem;">Compte collectif créé avec succès !</h3>
          <p style="color: #059669; font-size: 0.875rem; margin: 0;">Votre compte sera activé après validation.</p>
        </div>
      </div>

      <div style="display: flex; align-items: center; margin-bottom: 2rem;">
        <div style="width: 3rem; height: 3rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
          <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h3v-2c0-1.1.9-2 2-2h2.5l1.5-1.5L15 10.5c1.1 0 2 .9 2 2v2h3v4H4z"/>
          </svg>
        </div>
        <div>
          <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">Nouveau Compte Collectif</div>
          <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; margin-bottom: 0;">Configurez votre épargne collaborative</p>
        </div>
      </div>

      <form onsubmit="createAccount(event, 'collectif')">
        <div style="background: #f8fafc; border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem;">
          <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
            Membres du compte (2 à 7 maximum)
          </h3>

          <div style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: end;">
            <div style="flex: 1;">
              <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Nom du membre</label>
              <input type="text" id="member-name" placeholder="Nom complet" style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
            </div>
            <div style="flex: 1;">
              <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Téléphone</label>
              <input type="tel" id="member-phone" placeholder="Numéro de téléphone" style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
            </div>
            <button type="button" onclick="addMember()" style="background: #10b981; color: white; border: none; padding: 0.75rem; border-radius: 12px; cursor: pointer; width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;">+</button>
          </div>

          <div id="members-list" style="margin-top: 1rem;"></div>
          <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem; margin-bottom: 0;">
            Membres ajoutés : <span id="members-count">0</span>/7
          </p>
        </div>

        <div style="margin-bottom: 1.5rem;">
          <label style="display: flex; align-items: center; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.75rem;">
            <div style="width: 1.25rem; height: 1.25rem; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
              <svg width="16" height="16" fill="#4f46e5" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
              </svg>
            </div>
            Montant initial (facultatif)
          </label>
          <input type="number" name="montant_initial" placeholder="Montant du premier versement" min="0" step="0.01" style="width: 100%; padding: 0.75rem 1rem; background: #f9fafb; border: 1px solid #d1d5db; border-radius: 16px; transition: all 0.3s; outline: none; font-size: 1rem;" onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 2px rgba(79, 70, 229, 0.2)'; this.style.transform='translateY(-1px)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6;">
          <button type="button" onclick="resetForm()" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: #f3f4f6; color: #374151;" onmouseover="this.style.background='#e5e7eb'; this.style.transform='scale(1.02)'" onmouseout="this.style.background='#f3f4f6'; this.style.transform='scale(1)'">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
            Annuler
          </button>
          <button type="submit" style="padding: 0.75rem 2rem; border-radius: 16px; font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%); color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 20px 25px -5px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(79, 70, 229, 0.3)'">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            Créer le compte
          </button>
        </div>
      </form>
    </div>
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
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

      members.push({ name, phone });
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
        minDate.setHours(0,0,0,0);
        selectedDate.setHours(0,0,0,0);

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
        setTimeout(() => { successMessage.style.display = 'none'; }, 5000);
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

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.addEventListener('DOMContentLoaded', function () {
      const memberName = document.getElementById('member-name');
      const memberPhone = document.getElementById('member-phone');

      if (memberName && memberPhone) {
        memberName.addEventListener('keypress', function (e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            memberPhone.focus();
          }
        });

        memberPhone.addEventListener('keypress', function (e) {
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

  <style>
    @keyframes slideIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
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
