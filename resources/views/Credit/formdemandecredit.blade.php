@extends('layouts.home')

@section('content')
<div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: white; font-size: 2.8rem; font-weight: bold; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                📝 DEMANDE DE CRÉDIT
            </h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem; margin: 0;">
                Remplissez ce formulaire pour soumettre votre demande de crédit
            </p>
        </div>

        <!-- Formulaire Principal -->
        <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            
            <!-- Alerte d'information -->
            <div style="background: linear-gradient(135deg, #74b9ff, #0984e3); color: white; padding: 20px; border-radius: 15px; margin-bottom: 30px; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 10px;">ℹ️</div>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">Frais d'étude de dossier</h3>
                <p style="margin: 0; opacity: 0.9;">
                    Des frais de <strong>1 000 FCFA</strong> seront appliqués pour l'étude de votre dossier
                </p>
            </div>

            <form action="{{ route('credits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Section 1: Informations Personnelles -->
                 <input type="hidden" name="compte_id" value="{{ $compte->id }}">
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #74b9ff; padding-bottom: 10px;">
                        👤 Informations Personnelles
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Nom complet *
                            </label>
                            <input type="text" name="nom_complet" required 
                                   value="{{ old('nom_complet', auth()->user()->name ?? '') }}"
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#74b9ff'"
                                   onblur="this.style.borderColor='#ddd'">
                        </div>

                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Téléphone *
                            </label>
                            <input type="tel" name="phone" required 
                                   value="{{ old('email', auth()->user()->phone ?? '') }}"
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#74b9ff'"
                                   onblur="this.style.borderColor='#ddd'">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                            Email *
                        </label>
                        <input type="email" name="email" required 
                               value="{{ old('email', auth()->user()->email ?? '') }}"
                               style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;"
                               onfocus="this.style.borderColor='#74b9ff'"
                               onblur="this.style.borderColor='#ddd'">
                    </div>
                </div>

                <!-- Section 2: Détails du Crédit -->
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #00b894; padding-bottom: 10px;">
                        💰 Détails du Crédit Demandé
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Montant souhaité (FCFA) *
                            </label>
                            <input type="number" name="montant" required min="10000" 
                                   value="{{ old('montant') }}"
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='#00b894'"
                                   onblur="this.style.borderColor='#ddd'"
                                   oninput="calculerMontantMinimum(this.value)">
                        </div>

                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Durée souhaitée *
                            </label>
                            <select name="duree" required 
                                    style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;"
                                    onfocus="this.style.borderColor='#00b894'"
                                    onblur="this.style.borderColor='#ddd'"
                                    onchange="afficherTauxInteret(this.value)">
                                <option value="">Sélectionner la durée</option>
                                <option value="1" {{ old('duree') == '1' ? 'selected' : '' }}>1 mois</option>
                                <option value="2" {{ old('duree') == '2' ? 'selected' : '' }}>2 mois</option>
                                <option value="3" {{ old('duree') == '3' ? 'selected' : '' }}>3 mois</option>
                                <option value="4" {{ old('duree') == '4' ? 'selected' : '' }}>4 mois</option>
                                <option value="5" {{ old('duree') == '5' ? 'selected' : '' }}>5 mois</option>
                                <option value="6" {{ old('duree') == '6' ? 'selected' : '' }}>6 mois</option>
                                <option value="9" {{ old('duree') == '9' ? 'selected' : '' }}>9 mois</option>
                                <option value="12" {{ old('duree') == '12' ? 'selected' : '' }}>12 mois</option>
                            </select>
                        </div>
                    </div>

                    <!-- Affichage du taux d'intérêt -->
                    <div id="tauxInfo" style="background: #f8f9ff; border-left: 4px solid #74b9ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: none;">
                        <span style="color: #2c3e50; font-weight: bold;">Taux d'intérêt applicable: </span>
                        <span id="tauxTexte" style="color: #74b9ff; font-weight: bold;"></span>
                    </div>

                    <!-- Montant minimum requis en épargne -->
                    <div id="epargneInfo" style="background: #fff5f5; border-left: 4px solid #ff7675; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: none;">
                        <span style="color: #2c3e50; font-weight: bold;">Montant minimum requis en épargne (30%): </span>
                        <span id="epargneTexte" style="color: #d63031; font-weight: bold;"></span>
                    </div>

                    <div>
                        <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                            Objet du crédit *
                        </label>
                        <textarea name="objet_credit" required rows="3" 
                                  style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s; resize: vertical;"
                                  placeholder="Décrivez l'utilisation prévue du crédit..."
                                  onfocus="this.style.borderColor='#00b894'"
                                  onblur="this.style.borderColor='#ddd'">{{ old('objet_credit') }}</textarea>
                    </div>
                </div>

                <!-- Section 3: Avalistes -->
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #fdcb6e; padding-bottom: 10px;">
                        👥 Avalistes (2 requis)
                    </h2>

                    <!-- Avaliste 1 -->
                    <div style="background: #fffbf0; border: 2px solid #fdcb6e; border-radius: 15px; padding: 25px; margin-bottom: 20px;">
                        <h3 style="color: #e17055; margin: 0 0 15px 0; font-size: 1.3rem;">Premier Avaliste</h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                            <div>
                                <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 5px;">
                                    Nom complet *
                                </label>
                                <input type="text" name="avaliste1_nom" required 
                                       value="{{ old('avaliste1_nom') }}"
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 5px;">
                                    Téléphone *
                                </label>
                                <input type="tel" name="avaliste1_telephone" required 
                                       value="{{ old('avaliste1_telephone') }}"
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 5px;">
                                    N° CNI *
                                </label>
                                <input type="text" name="avaliste1_cni" required 
                                       value="{{ old('avaliste1_cni') }}"
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <!-- Avaliste 2 -->
                    <div style="background: #fffbf0; border: 2px solid #fdcb6e; border-radius: 15px; padding: 25px;">
                        <h3 style="color: #e17055; margin: 0 0 15px 0; font-size: 1.3rem;">Deuxième Avaliste</h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                            <div>
                                <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 5px;">
                                    Nom complet *
                                </label>
                                <input type="text" name="avaliste2_nom" required 
                                       value="{{ old('avaliste2_nom') }}"
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 5px;">
                                    Téléphone *
                                </label>
                                <input type="tel" name="avaliste2_telephone" required 
                                       value="{{ old('avaliste2_telephone') }}"
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 5px;">
                                    N° CNI *
                                </label>
                                <input type="text" name="avaliste2_cni" required 
                                       value="{{ old('avaliste2_cni') }}"
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Situation Personnelle -->
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #a29bfe; padding-bottom: 10px;">
                        📊 Situation Personnelle
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Statut professionnel *
                            </label>
                            <select name="statut_professionnel" required 
                                    style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box;">
                                <option value="">Sélectionner</option>
                                <option value="salarie" {{ old('statut_professionnel') == 'salarie' ? 'selected' : '' }}>Salarié</option>
                                <option value="fonctionnaire" {{ old('statut_professionnel') == 'fonctionnaire' ? 'selected' : '' }}>Fonctionnaire</option>
                                <option value="independant" {{ old('statut_professionnel') == 'independant' ? 'selected' : '' }}>Travailleur indépendant</option>
                                <option value="commercant" {{ old('statut_professionnel') == 'commercant' ? 'selected' : '' }}>Commerçant</option>
                                <option value="etudiant" {{ old('statut_professionnel') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                <option value="retraite" {{ old('statut_professionnel') == 'retraite' ? 'selected' : '' }}>Retraité</option>
                                <option value="chomeur" {{ old('statut_professionnel') == 'chomeur' ? 'selected' : '' }}>Sans emploi</option>
                                <option value="autre" {{ old('statut_professionnel') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Situation familiale *
                            </label>
                            <select name="situation_familiale" required 
                                    style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box;">
                                <option value="">Sélectionner</option>
                                <option value="celibataire" {{ old('situation_familiale') == 'celibataire' ? 'selected' : '' }}>Célibataire</option>
                                <option value="marie" {{ old('situation_familiale') == 'marie' ? 'selected' : '' }}>Marié(e)</option>
                                <option value="divorce" {{ old('situation_familiale') == 'divorce' ? 'selected' : '' }}>Divorcé(e)</option>
                                <option value="veuf" {{ old('situation_familiale') == 'veuf' ? 'selected' : '' }}>Veuf/Veuve</option>
                                <option value="union_libre" {{ old('situation_familiale') == 'union_libre' ? 'selected' : '' }}>Union libre</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Revenus mensuels (FCFA) *
                            </label>
                            <input type="number" name="revenus_mensuels" required min="0" 
                                   value="{{ old('revenus_mensuels') }}"
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box;">
                        </div>

                        <div>
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 8px;">
                                Nombre de personnes à charge
                            </label>
                            <input type="number" name="personnes_charge" min="0" max="20" 
                                   value="{{ old('personnes_charge', 0) }}"
                                   style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box;">
                        </div>
                    </div>
                </div>

                <!-- Section 5: Documents -->
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #fd79a8; padding-bottom: 10px;">
                        📎 Documents Requis
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                        <div style="background: #fdf2f8; border: 2px solid #fd79a8; border-radius: 15px; padding: 20px;">
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 10px;">
                                📝 Demande manuscrite *
                            </label>
                            <input type="file" name="demande_manuscrite" required accept=".pdf,.jpg,.jpeg,.png" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; background: white;">
                            <p style="color: #636e72; font-size: 0.85rem; margin: 5px 0 0 0;">
                                Format accepté: PDF, JPG, PNG (max 5MB)
                            </p>
                        </div>

                        <div style="background: #fdf2f8; border: 2px solid #fd79a8; border-radius: 15px; padding: 20px;">
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 10px;">
                                🆔 Photocopie CNI *
                            </label>
                            <input type="file" name="photocopie_cni" required accept=".pdf,.jpg,.jpeg,.png" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; background: white;">
                            <p style="color: #636e72; font-size: 0.85rem; margin: 5px 0 0 0;">
                                Format accepté: PDF, JPG, PNG (max 5MB)
                            </p>
                        </div>

                        <div style="background: #fdf2f8; border: 2px solid #fd79a8; border-radius: 15px; padding: 20px;">
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 10px;">
                                📍 Plan de localisation *
                            </label>
                            <input type="file" name="plan_localisation" required accept=".pdf,.jpg,.jpeg,.png" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; background: white;">
                            <p style="color: #636e72; font-size: 0.85rem; margin: 5px 0 0 0;">
                                Format accepté: PDF, JPG, PNG (max 5MB)
                            </p>
                        </div>

                        <div style="background: #fdf2f8; border: 2px solid #fd79a8; border-radius: 15px; padding: 20px;">
                            <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 10px;">
                                📊 Justificatifs financiers *
                            </label>
                            <input type="file" name="justificatifs_financiers" required accept=".pdf,.jpg,.jpeg,.png" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; background: white;">
                            <p style="color: #636e72; font-size: 0.85rem; margin: 5px 0 0 0;">
                                Bulletins de paie, relevés bancaires, etc.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 6: Garanties -->
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #00cec9; padding-bottom: 10px;">
                        🛡️ Garanties Proposées
                    </h2>

                    <div style="background: #f0fdff; border: 2px solid #00cec9; border-radius: 15px; padding: 25px;">
                        <label style="display: block; color: #2c3e50; font-weight: bold; margin-bottom: 15px;">
                            Description des garanties proposées *
                        </label>
                        <textarea name="garanties" required rows="4" 
                                  style="width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box; resize: vertical;"
                                  placeholder="Décrivez les biens ou garanties que vous proposez (titre foncier, véhicule, matériel, etc.)...">{{ old('garanties') }}</textarea>
                    </div>
                </div>

                <!-- Section 7: Déclarations -->
                <div style="margin-bottom: 35px;">
                    <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 3px solid #e84393; padding-bottom: 10px;">
                        ✅ Déclarations et Engagements
                    </h2>

                    <div style="background: #fef7f7; border: 2px solid #e84393; border-radius: 15px; padding: 25px;">
                        <div style="margin-bottom: 15px;">
                            <label style="display: flex; align-items: flex-start; color: #2c3e50; font-weight: bold; cursor: pointer;">
                                <input type="checkbox" name="declaration_fiable" required 
                                       style="margin-right: 10px; margin-top: 3px; transform: scale(1.2);">
                                <span>Je déclare être une personne fiable et honnête, et m'engage à respecter les conditions de remboursement.</span>
                            </label>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: flex; align-items: flex-start; color: #2c3e50; font-weight: bold; cursor: pointer;">
                                <input type="checkbox" name="verification_avalistes" required 
                                       style="margin-right: 10px; margin-top: 3px; transform: scale(1.2);">
                                <span>Je confirme que les deux avalistes mentionnés sont membres d'AXE CAPITAL et épargnent régulièrement.</span>
                            </label>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: flex; align-items: flex-start; color: #2c3e50; font-weight: bold; cursor: pointer;">
                                <input type="checkbox" name="acceptation_frais" required 
                                       style="margin-right: 10px; margin-top: 3px; transform: scale(1.2);">
                                <span>J'accepte les frais d'étude de dossier de 1 000 FCFA et les conditions de taux d'intérêt.</span>
                            </label>
                        </div>

                        <div>
                            <label style="display: flex; align-items: flex-start; color: #2c3e50; font-weight: bold; cursor: pointer;">
                                <input type="checkbox" name="acceptation_penalites" required 
                                       style="margin-right: 10px; margin-top: 3px; transform: scale(1.2);">
                                <span>Je comprends qu'en cas de retard de paiement, des pénalités de 1 000 FCFA par jour seront appliquées pendant 30 jours maximum.</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; gap: 15px; justify-content: center; align-items: center;">
                    <a href="#" 
                       style="background: #ddd; color: #2c3e50; text-decoration: none; padding: 15px 30px; border-radius: 50px; font-weight: bold; font-size: 1.1rem;">
                        ← Retour aux informations
                    </a>
                    
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #00b894, #00a085); color: white; border: none; padding: 15px 35px; border-radius: 50px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: all 0.3s;">
                        📤 Soumettre ma demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculerMontantMinimum(montant) {
    const epargneInfo = document.getElementById('epargneInfo');
    const epargneTexte = document.getElementById('epargneTexte');
    
    if (montant && montant > 0) {
        const montantMinimum = Math.round(montant * 0.3);
        epargneTexte.textContent = montantMinimum.toLocaleString() + ' FCFA';
        epargneInfo.style.display = 'block';
    } else {
        epargneInfo.style.display = 'none';
    }
}

function afficherTauxInteret(duree) {
    const tauxInfo = document.getElementById('tauxInfo');
    const tauxTexte = document.getElementById('tauxTexte');
    
    if (duree) {
        const dureeNum = parseInt(duree);
        let taux;
        
        if (dureeNum <= 3) {
            taux = '10%';
            tauxTexte.style.color = '#74b9ff';
        } else {
            taux = '20% (10% + 10% car > 3 mois)';
            tauxTexte.style.color = '#e17055';
        }
        
        tauxTexte.textContent = taux;
        tauxInfo.style.display = 'block';
    } else {
        tauxInfo.style.display = 'none';
    }
}

// Validation des fichiers
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Vérifier la taille (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux. Taille maximum: 5MB');
                    this.value = '';
                    return;
                }
                
                // Vérifier le type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Type de fichier non supporté. Utilisez PDF, JPG ou PNG.');
                    this.value = '';
                    return;
                }
            }
        });
    });
    
    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        const montant = document.querySelector('input[name="montant"]').value;
        const duree = document.querySelector('select[name="duree"]').value;
        
        if (montant && duree) {
            const confirmation = confirm(
                'Résumé de votre demande:\n' +
                '- Montant: ' + parseInt(montant).toLocaleString() + ' FCFA\n' +
                '- Durée: ' + duree + ' mois\n' +
                '- Taux: ' + (parseInt(duree) <= 3 ? '10%' : '20%') + '\n' +
                '- Frais d\'étude: 1 000 FCFA\n\n' +
                'Confirmer la soumission de votre demande?'
            );
            
            if (!confirmation) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection