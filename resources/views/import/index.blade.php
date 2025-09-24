@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1000px; margin: 0 auto;">

        {{-- Header --}}
       <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;">
    <h1 style="color: #2d3748; margin: 0 0 10px 0; font-size: 2.2rem; font-weight: 700;">Service Import/Export</h1>
    <p style="color: #718096; margin: 0 0 20px 0; font-size: 1.1rem; line-height: 1.6;">
        Importez vos marchandises de Chine en toute simplicité avec AXE CAPITAL.<br>
        Nous nous occupons de tout, de la recherche à la livraison.
    </p>

    {{-- Bouton visible uniquement pour les utilisateurs ayant déjà fait une demande --}}
    @if(auth()->check())
        @php
            $hasImportExport = \App\Models\ImportExport::where('user_id', auth()->id())->exists();
        @endphp
        
        @if($hasImportExport)
        <a href="{{ route('status') }}"
            style="background: linear-gradient(135deg, #4299e1, #3182ce);
                  color: white;
                  text-decoration: none;
                  padding: 15px 35px;
                  border-radius: 50px;
                  font-weight: bold;
                  font-size: 1.1rem;
                  display: inline-block;
                  transition: all 0.3s;
                  margin-top: 10px;">
            📊 Suivre mes Importations
        </a>
        @endif
    @endif
</div>


        {{-- Processus d'import --}}
        <div style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 25px 0; font-size: 1.4rem; text-align: center;">Comment ça Marche ?</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📸</div>
                    <h4 style="margin: 0 0 10px 0;">1. Envoi de la demande</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Photo + description de votre marchandise</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🔍</div>
                    <h4 style="margin: 0 0 10px 0;">2. Recherche</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Nous trouvons le produit chez nos fournisseurs</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">💰</div>
                    <h4 style="margin: 0 0 10px 0;">3. Devis</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Prix détaillé et disponibilité</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🚢</div>
                    <h4 style="margin: 0 0 10px 0;">4. Expédition</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Achat et envoi par bateau ou avion</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🏛️</div>
                    <h4 style="margin: 0 0 10px 0;">5. Douane</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Dédouanement à l'arrivée</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
                    <h4 style="margin: 0 0 10px 0;">6. Livraison</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Récupération ou livraison à domicile</p>
                </div>
            </div>
        </div>

        {{-- Informations importantes --}}
        <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h3 style="color: #2d3748; margin: 0 0 20px 0; text-align: center;">Informations Importantes</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                <div style="background: #f0f9ff; padding: 20px; border-radius: 10px; border-left: 4px solid #3b82f6;">
                    <h4 style="color: #1e40af; margin: 0 0 15px 0;">Délais de Livraison</h4>
                    <ul style="color: #1e3a8a; margin: 0; padding-left: 20px; line-height: 1.6;">
                        <li><strong>Par bateau :</strong> 2 à 3 mois</li>
                        <li><strong>Par avion :</strong> 1 à 1,5 mois</li>
                    </ul>
                </div>
                
                <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; border-left: 4px solid #16a34a;">
                    <h4 style="color: #15803d; margin: 0 0 15px 0;">Frais de Dédouanement</h4>
                    <ul style="color: #14532d; margin: 0; padding-left: 20px; line-height: 1.6;">
                        <li><strong>Douane :</strong> 10,000 FCFA/kg</li>
                        <li><strong>Commission AXE CAPITAL :</strong> 1,000 FCFA/kg</li>
                    </ul>
                </div>
            </div>

            <div style="background: #fef3c7; color: #92400e; padding: 20px; border-radius: 10px; margin-top: 20px;">
                <h4 style="margin: 0 0 10px 0;">Important :</h4>
                <p style="margin: 0; line-height: 1.6;">
                    Vous payez uniquement le coût de la marchandise au moment de la commande. 
                    Les frais de douane et notre commission sont payés à l'arrivée de la marchandise.
                </p>
            </div>
        </div>

        {{-- Formulaire de demande --}}
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <h2 style="color: #2d3748; margin: 0 0 25px 0; font-size: 1.6rem; text-align: center;">Demande d'Import/Export</h2>

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

            <form method="POST" action="{{ route('import.export.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Informations sur la marchandise --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations sur la Marchandise</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Nom/Type de marchandise *
                        </label>
                        <input type="text" name="nom_marchandise" value="{{ old('nom_marchandise') }}" required
                            placeholder="Ex: Chaussures de sport, Téléphones portables, Vêtements..."
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Catégorie *
                        </label>
                        <select name="categorie" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <option value="">Sélectionner une catégorie...</option>
                            <option value="electronique" {{ old('categorie') == 'electronique' ? 'selected' : '' }}>Électronique</option>
                            <option value="vetements" {{ old('categorie') == 'vetements' ? 'selected' : '' }}>Vêtements et Mode</option>
                            <option value="chaussures" {{ old('categorie') == 'chaussures' ? 'selected' : '' }}>Chaussures</option>
                            <option value="maroquinerie" {{ old('categorie') == 'maroquinerie' ? 'selected' : '' }}>Maroquinerie</option>
                            <option value="bijoux" {{ old('categorie') == 'bijoux' ? 'selected' : '' }}>Bijoux et Accessoires</option>
                            <option value="cosmetique" {{ old('categorie') == 'cosmetique' ? 'selected' : '' }}>Cosmétique et Beauté</option>
                            <option value="jouets" {{ old('categorie') == 'jouets' ? 'selected' : '' }}>Jouets</option>
                            <option value="maison" {{ old('categorie') == 'maison' ? 'selected' : '' }}>Maison et Décoration</option>
                            <option value="sport" {{ old('categorie') == 'sport' ? 'selected' : '' }}>Sport et Loisirs</option>
                            <option value="automobile" {{ old('categorie') == 'automobile' ? 'selected' : '' }}>Automobile</option>
                            <option value="autre" {{ old('categorie') == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Description précise de la marchandise *
                        </label>
                        <textarea name="description_marchandise" required placeholder="Décrivez précisément votre marchandise : couleur, taille, matériau, spécifications techniques, marque souhaitée, etc." 
                            style="width: 100%; min-height: 120px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('description_marchandise') }}</textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Photo de la marchandise *
                        </label>
                        <input type="file" name="photo_marchandise" required accept="image/*" multiple
                            style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        <small style="color: #718096;">Vous pouvez uploader plusieurs photos. Formats acceptés : JPG, PNG, WEBP (Max: 5MB par image)</small>
                    </div>
                </div>

                {{-- Quantité et préférences --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Quantité et Préférences</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Quantité approximative souhaitée *
                            </label>
                            <input type="number" name="quantite_souhaitee" value="{{ old('quantite_souhaitee') }}" required min="1"
                                placeholder="Exemple: 50 pièces"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Unité de mesure *
                            </label>
                            <select name="unite_mesure" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner...</option>
                                <option value="pieces" {{ old('unite_mesure') == 'pieces' ? 'selected' : '' }}>Pièces</option>
                                <option value="paires" {{ old('unite_mesure') == 'paires' ? 'selected' : '' }}>Paires</option>
                                <option value="lots" {{ old('unite_mesure') == 'lots' ? 'selected' : '' }}>Lots</option>
                                <option value="cartons" {{ old('unite_mesure') == 'cartons' ? 'selected' : '' }}>Cartons</option>
                                <option value="kg" {{ old('unite_mesure') == 'kg' ? 'selected' : '' }}>Kilogrammes</option>
                                <option value="metres" {{ old('unite_mesure') == 'metres' ? 'selected' : '' }}>Mètres</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Budget approximatif (FCFA)
                            </label>
                            <input type="number" name="budget_approximatif" value="{{ old('budget_approximatif') }}" min="10000" step="1000"
                                placeholder="Budget prévu pour la marchandise"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <small style="color: #718096;">Optionnel - nous aide à mieux cibler nos recherches</small>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Mode d'expédition préféré
                            </label>
                            <select name="mode_expedition" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Pas de préférence</option>
                                <option value="bateau" {{ old('mode_expedition') == 'bateau' ? 'selected' : '' }}>Par bateau (2-3 mois, moins cher)</option>
                                <option value="avion" {{ old('mode_expedition') == 'avion' ? 'selected' : '' }}>Par avion (1-1.5 mois, plus rapide)</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Exigences particulières
                        </label>
                        <textarea name="exigences_particulieres" placeholder="Couleurs spécifiques, tailles, qualité, certification, emballage spécial, etc."
                            style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('exigences_particulieres') }}</textarea>
                    </div>
                </div>

                {{-- Informations de livraison --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations de Livraison</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Lieu de livraison souhaité *
                        </label>
                        <select name="lieu_livraison" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            <option value="">Sélectionner...</option>
                            <option value="bureau" {{ old('lieu_livraison') == 'bureau' ? 'selected' : '' }}>Récupération au bureau AXE CAPITAL</option>
                            <option value="domicile" {{ old('lieu_livraison') == 'domicile' ? 'selected' : '' }}>Livraison à domicile (frais supplémentaires)</option>
                            <option value="point_relais" {{ old('lieu_livraison') == 'point_relais' ? 'selected' : '' }}>Point relais/Agence de transport</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Adresse de livraison
                        </label>
                        <textarea name="adresse_livraison" placeholder="Adresse complète si livraison à domicile ou autre lieu spécifique"
                            style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('adresse_livraison') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Ville *
                            </label>
                            <input type="text" name="ville_livraison" value="{{ old('ville_livraison') }}" required
                                placeholder="Ville de livraison"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Téléphone de contact *
                            </label>
                            <input type="tel" name="telephone_livraison" value="{{ old('telephone_livraison') }}" required
                                placeholder="+237 6XX XXX XXX"
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                        </div>
                    </div>
                </div>

                {{-- Informations complémentaires --}}
                <div style="background: #f7fafc; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Informations Complémentaires</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Urgence de la commande
                            </label>
                            <select name="urgence" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="normale" {{ old('urgence') == 'normale' ? 'selected' : '' }}>Normale</option>
                                <option value="rapide" {{ old('urgence') == 'rapide' ? 'selected' : '' }}>Rapide (priorité)</option>
                                <option value="tres_rapide" {{ old('urgence') == 'tres_rapide' ? 'selected' : '' }}>Très rapide (express)</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Usage prévu
                            </label>
                            <select name="usage_prevu" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                <option value="">Sélectionner...</option>
                                <option value="personnel" {{ old('usage_prevu') == 'personnel' ? 'selected' : '' }}>Usage personnel</option>
                                <option value="revente" {{ old('usage_prevu') == 'revente' ? 'selected' : '' }}>Revente/Commerce</option>
                                <option value="cadeau" {{ old('usage_prevu') == 'cadeau' ? 'selected' : '' }}>Cadeau</option>
                                <option value="professionnel" {{ old('usage_prevu') == 'professionnel' ? 'selected' : '' }}>Usage professionnel</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                            Commentaires supplémentaires
                        </label>
                        <textarea name="commentaires" placeholder="Toute information supplémentaire qui pourrait nous aider dans votre recherche..."
                            style="width: 100%; min-height: 80px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;">{{ old('commentaires') }}</textarea>
                    </div>
                </div>

                {{-- Contact AXE CAPITAL --}}
                <div style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h3 style="margin: 0 0 15px 0; text-align: center;">Contact AXE CAPITAL</h3>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 10px;">+237 688 82 22 32</div>
                        <p style="margin: 0; font-size: 1rem; opacity: 0.9;">
                            Vous pouvez aussi nous contacter directement via WhatsApp pour des demandes urgentes
                        </p>
                        <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 8px; margin-top: 15px;">
                            <label style="display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                <input type="checkbox" name="accepte_contact" value="1" required style="margin-right: 10px; transform: scale(1.2);">
                                J'accepte d'être contacté par AXE CAPITAL pour le suivi de ma demande
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Conditions générales --}}
                <div style="background: #e0f2fe; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                    <h4 style="color: #0277bd; margin: 0 0 15px 0;">Conditions Importantes</h4>
                    <ul style="color: #01579b; margin: 0; padding-left: 20px; line-height: 1.8;">
                        <li>Vous ne payez que le coût de la marchandise au moment de la commande</li>
                        <li>Les frais de douane (10,000 FCFA/kg) sont payés à l'arrivée</li>
                        <li>Notre commission (1,000 FCFA/kg) est payée à l'arrivée</li>
                        <li>Les délais peuvent varier selon la disponibilité des produits</li>
                        <li>Nous nous réservons le droit de refuser certaines marchandises</li>
                        <li>Les frais de livraison à domicile sont à votre charge</li>
                    </ul>
                    
                    <div style="background: rgba(255,255,255,0.8); padding: 15px; border-radius: 8px; margin-top: 15px;">
                        <label style="display: flex; align-items: center; font-weight: 600; color: #01579b;">
                            <input type="checkbox" name="accepte_conditions" value="1" required style="margin-right: 10px; transform: scale(1.2);">
                            J'accepte les conditions générales du service d'import/export
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
                        style="background: linear-gradient(135deg, #4299e1, #3182ce); color: white; border: none; padding: 15px 40px; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 1.1rem; transition: all 0.3s;">
                        Envoyer la Demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection