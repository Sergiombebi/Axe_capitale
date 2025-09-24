@extends('layouts.home')
@section('content')

<section style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        {{-- Header --}}
        <div style="background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: #2d3748; margin: 0; font-size: 1.8rem; font-weight: 700;">Évaluation du Projet</h1>
                    <p style="color: #718096; margin: 5px 0 0 0;">{{ $projet->nom_projet }} - FP-{{ str_pad($projet->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('projet.dashboard') }}" 
                    style="background: #a0aec0; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Retour
                </a>
            </div>

            {{-- Statut actuel --}}
            <div style="background: #dbeafe; color: #1e40af; padding: 15px; border-radius: 8px; border-left: 4px solid #4299e1;">
                <div style="font-weight: 600; margin-bottom: 5px;">Statut: En Étude</div>
                <div style="font-size: 0.9rem;">
                    Commencée le {{ $projet->date_traitement ? \Carbon\Carbon::parse($projet->date_traitement)->format('d/m/Y') : 'N/A' }}
                    @if($projet->date_traitement)
                    • {{ \Carbon\Carbon::parse($projet->date_traitement)->diffInDays() }} jour(s) d'analyse
                    @endif
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 450px; gap: 30px;">
            {{-- Partie gauche - Résumé du projet --}}
            <div>
                {{-- Résumé financier --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Analyse Financière</h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
                        <div style="text-align: center; padding: 15px; background: #f0fff4; border-radius: 8px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #166534; margin-bottom: 5px;">
                                {{ number_format($projet->montant_total_projet, 0, ',', ' ') }}
                            </div>
                            <div style="font-size: 0.9rem; color: #166534;">Montant Total</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #ebf8ff; border-radius: 8px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #1e40af; margin-bottom: 5px;">
                                {{ number_format($projet->montant_financement_demande, 0, ',', ' ') }}
                            </div>
                            <div style="font-size: 0.9rem; color: #1e40af;">Financement Demandé</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #fef3c7; border-radius: 8px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #92400e; margin-bottom: 5px;">
                                {{ number_format($projet->apport_personnel, 0, ',', ' ') }}
                            </div>
                            <div style="font-size: 0.9rem; color: #92400e;">Apport Personnel</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #faf5ff; border-radius: 8px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #7c3aed; margin-bottom: 5px;">
                                {{ round(($projet->montant_financement_demande / $projet->montant_total_projet) * 100, 1) }}%
                            </div>
                            <div style="font-size: 0.9rem; color: #7c3aed;">Ratio Financement</div>
                        </div>
                    </div>

                    {{-- Indicateurs de viabilité --}}
                    <div style="background: #f7fafc; padding: 20px; border-radius: 8px;">
                        <h4 style="color: #2d3748; margin: 0 0 15px 0;">Indicateurs d'Évaluation</h4>
                        
                        <div style="display: grid; gap: 10px;">
                            <div style="display: flex; justify-content: between; align-items: center;">
                                <span style="color: #718096;">Ratio d'endettement</span>
                                <span style="color: {{ ($projet->montant_financement_demande / $projet->montant_total_projet) > 0.8 ? '#e53e3e' : (($projet->montant_financement_demande / $projet->montant_total_projet) > 0.6 ? '#f59e0b' : '#10b981') }}; font-weight: 600;">
                                    {{ round(($projet->montant_financement_demande / $projet->montant_total_projet) * 100, 1) }}%
                                </span>
                            </div>
                            <div style="display: flex; justify-content: between; align-items: center;">
                                <span style="color: #718096;">Apport personnel minimum (20%)</span>
                                <span style="color: {{ ($projet->apport_personnel / $projet->montant_total_projet) >= 0.2 ? '#10b981' : '#e53e3e' }}; font-weight: 600;">
                                    {{ ($projet->apport_personnel / $projet->montant_total_projet) >= 0.2 ? '✓ Respecté' : '✗ Non respecté' }}
                                </span>
                            </div>
                            <div style="display: flex; justify-content: between; align-items: center;">
                                <span style="color: #718096;">Montant mensuel estimé</span>
                                <span style="color: #4299e1; font-weight: 600;">
                                    {{ number_format(($projet->montant_financement_demande * 1.1) / $projet->duree_remboursement, 0, ',', ' ') }} FCFA/mois
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Évaluation du business plan --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Évaluation Qualitative</h3>
                    
                    <div style="display: grid; gap: 15px;">
                        @php
                        $criteres = [
                            'Innovation du projet' => ['score' => null, 'description' => 'Originalité et différenciation sur le marché'],
                            'Faisabilité technique' => ['score' => null, 'description' => 'Capacité technique de réalisation'],
                            'Potentiel marché' => ['score' => null, 'description' => 'Taille et accessibilité du marché cible'],
                            'Expérience porteur' => ['score' => null, 'description' => 'Compétences et expérience du demandeur'],
                            'Solidité financière' => ['score' => null, 'description' => 'Équilibre et réalisme des projections'],
                        ];
                        @endphp

                        @foreach($criteres as $critere => $details)
                        <div style="padding: 15px; background: #f7fafc; border-radius: 8px;">
                            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 10px;">
                                <h5 style="color: #2d3748; margin: 0; font-weight: 600;">{{ $critere }}</h5>
                                <div style="display: flex; gap: 5px;">
                                    @for($i = 1; $i <= 5; $i++)
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background: #e2e8f0; border: 2px solid #cbd5e0;"></div>
                                    @endfor
                                </div>
                            </div>
                            <div style="color: #718096; font-size: 0.9rem;">{{ $details['description'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Partie droite - Formulaire de décision --}}
            <div>
                {{-- Informations client --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Client</h3>
                    
                    <div style="text-align: center; margin-bottom: 15px;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; color: white; font-size: 1.5rem; font-weight: 700;">
                            {{ substr($projet->compte->nom, 0, 1) }}{{ substr($projet->compte->prenom, 0, 1) }}
                        </div>
                        <div style="font-weight: 600; color: #2d3748;">{{ $projet->compte->nom }} {{ $projet->compte->prenom }}</div>
                        <div style="color: #718096; font-size: 0.9rem;">{{ $projet->compte->telephone }}</div>
                    </div>

                    <div style="background: #f7fafc; padding: 15px; border-radius: 8px; font-size: 0.9rem;">
                        <div style="display: flex; justify-content: between; margin-bottom: 8px;">
                            <span style="color: #718096;">Expérience</span>
                            <span style="color: #2d3748; font-weight: 600; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $projet->experience_domaine ?? 'Non spécifié') }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: between; margin-bottom: 8px;">
                            <span style="color: #718096;">Secteur</span>
                            <span style="color: #2d3748; font-weight: 600; text-transform: capitalize;">{{ ucfirst($projet->secteur_activite) }}</span>
                        </div>
                        <div style="display: flex; justify-content: between;">
                            <span style="color: #718096;">Demande créée</span>
                            <span style="color: #2d3748; font-weight: 600;">{{ $projet->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Formulaire de décision --}}
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 style="color: #2d3748; margin: 0 0 20px 0;">Prise de Décision</h3>
                    
                    <form method="POST" action="{{ route('prendre_decision', $projet->id) }}">
                        @csrf
                        
                        {{-- Choix de la décision --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 15px;">
                                Décision d'évaluation *
                            </label>
                            
                            <div style="display: grid; gap: 15px;">
                                <label style="display: flex; align-items: start; gap: 10px; padding: 15px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" onclick="toggleDecision('approuve')">
                                    <input type="radio" name="decision" value="approuve" required style="margin-top: 5px;">
                                    <div>
                                        <div style="font-weight: 600; color: #166534; margin-bottom: 5px;">✓ Approuver le Projet</div>
                                        <div style="color: #718096; font-size: 0.9rem;">Le projet présente une viabilité suffisante pour bénéficier d'un financement</div>
                                    </div>
                                </label>

                                <label style="display: flex; align-items: start; gap: 10px; padding: 15px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" onclick="toggleDecision('rejete')">
                                    <input type="radio" name="decision" value="rejete" required style="margin-top: 5px;">
                                    <div>
                                        <div style="font-weight: 600; color: #991b1b; margin-bottom: 5px;">✗ Rejeter le Projet</div>
                                        <div style="color: #718096; font-size: 0.9rem;">Le projet ne répond pas aux critères de financement</div>
                                    </div>
                                </label>
                            </div>
                            @error('decision')
                            <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Champs conditionnels pour approbation --}}
                        <div id="approbation-fields" style="display: none; margin-bottom: 25px;">
                            <div style="background: #dcfce7; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <h4 style="color: #166534; margin: 0 0 15px 0;">Conditions de Financement</h4>
                                
                                <div style="display: grid; gap: 15px;">
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                                            Montant à financer (FCFA) *
                                        </label>
                                        <input type="number" name="montant_finance_propose" min="0" max="{{ $projet->montant_financement_demande }}" 
                                            value="{{ $projet->montant_financement_demande }}" step="1000"
                                            style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                                        <div style="color: #718096; font-size: 0.8rem; margin-top: 3px;">
                                            Maximum demandé: {{ number_format($projet->montant_financement_demande, 0, ',', ' ') }} FCFA
                                        </div>
                                    </div>

                                    <div>
                                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                                            Durée de remboursement (mois) *
                                        </label>
                                        <select name="duree_remboursement_accordee" 
                                            style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                                            <option value="12">12 mois</option>
                                            <option value="18">18 mois</option>
                                            <option value="24" {{ $projet->duree_remboursement == 24 ? 'selected' : '' }}>24 mois</option>
                                            <option value="36" {{ $projet->duree_remboursement == 36 ? 'selected' : '' }}>36 mois</option>
                                            <option value="48" {{ $projet->duree_remboursement == 48 ? 'selected' : '' }}>48 mois</option>
                                            <option value="60" {{ $projet->duree_remboursement == 60 ? 'selected' : '' }}>60 mois</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                                            Taux d'intérêt (%) *
                                        </label>
                                        <input type="number" name="ratio_remboursement" min="0" max="30" value="10" step="0.5"
                                            style="width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 14px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Champs conditionnels pour rejet --}}
                        <div id="rejet-fields" style="display: none; margin-bottom: 25px;">
                            <div style="background: #fecaca; padding: 20px; border-radius: 8px;">
                                <h4 style="color: #991b1b; margin: 0 0 15px 0;">Motif du Rejet</h4>
                                <textarea name="motif_rejet" rows="4" placeholder="Expliquez les raisons du rejet du projet..."
                                    style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
                                @error('motif_rejet')
                                <div style="color: #e53e3e; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Observations générales --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px;">
                                Observations de l'évaluation
                            </label>
                            <textarea name="observations_evaluation" rows="4" placeholder="Notes sur l'évaluation, points forts, points d'amélioration..."
                                style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;">{{ old('observations_evaluation') }}</textarea>
                        </div>

                        {{-- Boutons d'action --}}
                        <div style="display: flex; gap: 15px;">
                            <a href="{{ route('projet.dashboard') }}" 
                                style="flex: 1; background: #a0aec0; color: white; padding: 15px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center;">
                                Reporter
                            </a>
                            <button type="submit" 
                                style="flex: 2; background: #4299e1; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                                Valider la Décision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleDecision(type) {
    const approbationFields = document.getElementById('approbation-fields');
    const rejetFields = document.getElementById('rejet-fields');
    
    if (type === 'approuve') {
        approbationFields.style.display = 'block';
        rejetFields.style.display = 'none';
    } else if (type === 'rejete') {
        approbationFields.style.display = 'none';
        rejetFields.style.display = 'block';
    }
}

// Écouter les changements sur les radios
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="decision"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            toggleDecision(this.value);
        });
    });
});
</script>

@endsection