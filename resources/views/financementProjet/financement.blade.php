@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1000px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;">
            <h1 style="color: #2d3748; margin: 0 0 10px 0; font-size: 2.2rem; font-weight: 700;">Financement de Projet</h1>
            <p style="color: #718096; margin: 0; font-size: 1.1rem; line-height: 1.6;">
                Réalisez vos rêves entrepreneuriaux avec AXE CAPITAL.<br>
                Nous accompagnons les jeunes camerounais dans le financement de leurs projets innovants.
            </p>
        </div>

        {{-- Information sur le processus --}}
        <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 20px 0; font-size: 1.4rem; text-align: center;">Processus de Financement</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📋</div>
                    <h4 style="margin: 0 0 10px 0;">1. Business Plan</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Établissez votre plan d'affaires détaillé</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">💰</div>
                    <h4 style="margin: 0 0 10px 0;">2. Apport Personnel</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Définissez votre contribution au projet</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📄</div>
                    <h4 style="margin: 0 0 10px 0;">3. Documents</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Fournissez tous les justificatifs requis</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🤝</div>
                    <h4 style="margin: 0 0 10px 0;">4. Partenariat</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Accord sur le ratio de remboursement</p>
                </div>
            </div>
        </div>

        {{-- Formulaire de demande --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h2 style="color: #2d3748; margin: 0 0 25px 0; font-size: 1.6rem; text-align: center;">Demande de Financement de Projet</h2>

            @if($errors->any())
            <div style="background: #fed7d7; color: #742a2a; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                <h4 style="margin: 0 0 10px 0;">Erreurs détectées :</h4>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{route('projet.store')}}" enctype="multipart/form-data">
                @csrf

                {{-- Informations sur le projet --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations sur le Projet</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Nom du projet *
                            </label>
                            <input type="text" name="nom_projet" value="{{ old('nom_projet') }}" required
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Secteur d'activité *
                            </label>
                            <select name="secteur_activite" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner un secteur...</option>
                                <option value="agriculture" {{ old('secteur_activite') == 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                                <option value="commerce" {{ old('secteur_activite') == 'commerce' ? 'selected' : '' }}>Commerce</option>
                                <option value="artisanat" {{ old('secteur_activite') == 'artisanat' ? 'selected' : '' }}>Artisanat</option>
                                <option value="services" {{ old('secteur_activite') == 'services' ? 'selected' : '' }}>Services</option>
                                <option value="technologie" {{ old('secteur_activite') == 'technologie' ? 'selected' : '' }}>Technologie</option>
                                <option value="tourisme" {{ old('secteur_activite') == 'tourisme' ? 'selected' : '' }}>Tourisme</option>
                                <option value="education" {{ old('secteur_activite') == 'education' ? 'selected' : '' }}>Éducation</option>
                                <option value="sante" {{ old('secteur_activite') == 'sante' ? 'selected' : '' }}>Santé</option>
                                <option value="transport" {{ old('secteur_activite') == 'transport' ? 'selected' : '' }}>Transport</option>
                                <option value="autre" {{ old('secteur_activite') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Description du projet *
                        </label>
                        <textarea name="description_projet" required placeholder="Décrivez votre projet en détail..." 
                            style="width: 100%; min-height: 120px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('description_projet') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Montant total du projet (FCFA) *
                            </label>
                            <input type="number" name="montant_total_projet" value="{{ old('montant_total_projet') }}" required min="100000" step="1000"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Montant minimum : 100 000 FCFA</small>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Montant du financement demandé (FCFA) *
                            </label>
                            <input type="number" name="montant_financement_demande" value="{{ old('montant_financement_demande') }}" required min="50000" step="1000"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Montant que vous souhaitez obtenir</small>
                        </div>
                    </div>
                </div>

                {{-- Apport personnel --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Apport Personnel</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Montant de l'apport personnel (FCFA) *
                            </label>
                            <input type="number" name="apport_personnel" value="{{ old('apport_personnel') }}" required min="10000" step="1000"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Durée de remboursement souhaitée (mois) *
                            </label>
                            <select name="duree_remboursement" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner la durée...</option>
                                <option value="12" {{ old('duree_remboursement') == '12' ? 'selected' : '' }}>12 mois</option>
                                <option value="18" {{ old('duree_remboursement') == '18' ? 'selected' : '' }}>18 mois</option>
                                <option value="24" {{ old('duree_remboursement') == '24' ? 'selected' : '' }}>24 mois</option>
                                <option value="36" {{ old('duree_remboursement') == '36' ? 'selected' : '' }}>36 mois</option>
                                <option value="48" {{ old('duree_remboursement') == '48' ? 'selected' : '' }}>48 mois</option>
                                <option value="60" {{ old('duree_remboursement') == '60' ? 'selected' : '' }}>60 mois</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Nature de l'apport personnel *
                        </label>
                        <textarea name="nature_apport" required placeholder="Décrivez la nature de votre apport (financier, matériel, compétences, etc.)"
                            style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('nature_apport') }}</textarea>
                    </div>
                </div>

                {{-- Documents requis --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Documents Requis</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Business Plan (PDF) *
                            </label>
                            <input type="file" name="business_plan" required accept=".pdf,.doc,.docx"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Formats acceptés : PDF, DOC, DOCX (Max: 5MB)</small>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Photocopie CNI *
                            </label>
                            <input type="file" name="photocopie_cni" required accept=".pdf,.jpg,.jpeg,.png"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Formats acceptés : PDF, JPG, PNG (Max: 2MB)</small>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Plan de localisation *
                            </label>
                            <input type="file" name="plan_localisation" required accept=".pdf,.jpg,.jpeg,.png"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Plan détaillé du lieu d'implantation</small>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Attestation d'immatriculation (NIU) *
                            </label>
                            <input type="file" name="attestation_niu" required accept=".pdf,.jpg,.jpeg,.png"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Numéro d'Identification Unique</small>
                        </div>
                    </div>
                </div>

                {{-- Informations complémentaires --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations Complémentaires</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Expérience dans le domaine
                            </label>
                            <select name="experience_domaine" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner...</option>
                                <option value="aucune" {{ old('experience_domaine') == 'aucune' ? 'selected' : '' }}>Aucune expérience</option>
                                <option value="moins_1_an" {{ old('experience_domaine') == 'moins_1_an' ? 'selected' : '' }}>Moins d'1 an</option>
                                <option value="1_3_ans" {{ old('experience_domaine') == '1_3_ans' ? 'selected' : '' }}>1 à 3 ans</option>
                                <option value="3_5_ans" {{ old('experience_domaine') == '3_5_ans' ? 'selected' : '' }}>3 à 5 ans</option>
                                <option value="plus_5_ans" {{ old('experience_domaine') == 'plus_5_ans' ? 'selected' : '' }}>Plus de 5 ans</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Nombre d'employés prévus
                            </label>
                            <input type="number" name="employes_prevus" value="{{ old('employes_prevus') }}" min="0" max="100"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Objectifs à court terme (1 an)
                        </label>
                        <textarea name="objectifs_court_terme" placeholder="Décrivez vos objectifs pour la première année"
                            style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('objectifs_court_terme') }}</textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Objectifs à long terme (3-5 ans)
                        </label>
                        <textarea name="objectifs_long_terme" placeholder="Décrivez votre vision à long terme"
                            style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('objectifs_long_terme') }}</textarea>
                    </div>
                </div>

                {{-- Frais d'étude --}}
                <div style="background: linear-gradient(135deg, #fbb6ce, #f093fb); color: white; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="margin: 0 0 15px 0; text-align: center;">Frais d'Étude du Business Plan</h3>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">5,000 FCFA</div>
                        <p style="margin: 0; font-size: 1.1rem; opacity: 0.9;">
                            Ces frais couvrent l'analyse détaillée de votre business plan par nos experts.
                        </p>
                        <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; margin-top: 15px;">
                            <label style="display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                <input type="checkbox" name="accepte_frais_etude" value="1" required style="margin-right: 10px; transform: scale(1.2);">
                                J'accepte de payer les frais d'étude de 5,000 FCFA
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Conditions générales --}}
                <div style="background: #fed7d7; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #742a2a; margin: 0 0 15px 0;">Conditions Importantes</h4>
                    <ul style="color: #742a2a; margin: 0; padding-left: 20px; line-height: 1.6;">
                        <li>Le remboursement se fera sous forme d'un ratio établi entre AXE CAPITAL et le client.</li>
                        <li>La période de remboursement sera déterminée selon votre apport et le montant du financement.</li>
                        <li>Tous les documents fournis doivent être authentiques et à jour.</li>
                        <li>L'approbation du financement dépend de l'évaluation de votre business plan.</li>
                        <li>Les frais d'étude de 5,000 FCFA sont non remboursables.</li>
                    </ul>
                    
                    <div style="background: rgba(255,255,255,0.8); padding: 15px; border-radius: 8px; margin-top: 15px;">
                        <label style="display: flex; align-items: center; font-weight: 600; color: #742a2a;">
                            <input type="checkbox" name="accepte_conditions" value="1" required style="margin-right: 10px; transform: scale(1.2);">
                            J'accepte toutes les conditions générales du financement de projet
                        </label>
                    </div>
                </div>

                {{-- Boutons de soumission --}}
                <div style="display: flex; gap: 20px; justify-content: center; margin-top: 30px;">
                    <a href="#" 
                        style="background: #a0aec0; color: white; padding: 15px 40px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 1.1rem;">
                        Annuler
                    </a>
                    <button type="submit" 
                        style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; border: none; padding: 15px 40px; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 1.1rem; transition: all 0.3s;">
                        Soumettre la Demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection