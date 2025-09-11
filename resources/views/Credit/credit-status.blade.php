@extends('layouts.home')
@section('content')
<div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header avec timeline du statut -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: white; font-size: 2.5rem; font-weight: bold; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                📊 État de votre Demande de Crédit
            </h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem; margin: 0;">
                Suivez l'évolution de votre demande en temps réel
            </p>
        </div>

        <!-- Timeline du processus -->
        <div style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
            <h2 style="color: #2c3e50; margin-bottom: 30px; text-align: center; font-size: 1.5rem;">Progression de votre demande</h2>
            
            <div style="display: flex; justify-content: space-between; align-items: center; position: relative; margin-bottom: 20px;">
                <!-- Ligne de progression -->
                <div style="position: absolute; top: 20px; left: 0; right: 0; height: 4px; background: #e2e8f0; border-radius: 2px; z-index: 1;">
                    <div id="progressBar" style="height: 100%; background: linear-gradient(90deg, #4299e1, #48bb78); border-radius: 2px; transition: width 0.8s ease;"></div>
                </div>

                <!-- Étapes -->
                <div class="status-step" data-status="en_attente" style="text-align: center; z-index: 2; position: relative;">
                    <div class="step-circle" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.3s;">
                        📝
                    </div>
                    <p style="margin: 0; font-size: 0.9rem; color: #2c3e50; font-weight: 600;">Soumise</p>
                </div>

                <div class="status-step" data-status="en_etude" style="text-align: center; z-index: 2; position: relative;">
                    <div class="step-circle" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.3s;">
                        🔍
                    </div>
                    <p style="margin: 0; font-size: 0.9rem; color: #2c3e50; font-weight: 600;">En étude</p>
                </div>

                <div class="status-step" data-status="approuve" style="text-align: center; z-index: 2; position: relative;">
                    <div class="step-circle" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.3s;">
                        ✅
                    </div>
                    <p style="margin: 0; font-size: 0.9rem; color: #2c3e50; font-weight: 600;">Approuvé</p>
                </div>

                <div class="status-step" data-status="debourse" style="text-align: center; z-index: 2; position: relative;">
                    <div class="step-circle" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.3s;">
                        💰
                    </div>
                    <p style="margin: 0; font-size: 0.9rem; color: #2c3e50; font-weight: 600;">Déboursé</p>
                </div>

                <div class="status-step" data-status="rembourse" style="text-align: center; z-index: 2; position: relative;">
                    <div class="step-circle" style="width: 40px; height: 40px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: all 0.3s;">
                        🏆
                    </div>
                    <p style="margin: 0; font-size: 0.9rem; color: #2c3e50; font-weight: 600;">Remboursé</p>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            
            <!-- Informations du crédit -->
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.3rem; border-bottom: 3px solid #74b9ff; padding-bottom: 10px;">
                    💰 Détails du Crédit
                </h3>

                <div style="space-y: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8f9ff; border-radius: 10px; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Montant demandé</span>
                        <span style="color: #74b9ff; font-weight: bold; font-size: 1.1rem;">{{ number_format($credit->montant, 0, ',', ' ') }} FCFA</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f0fff4; border-radius: 10px; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Durée</span>
                        <span style="color: #00b894; font-weight: bold; font-size: 1.1rem;">{{ $credit->duree }} mois</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #fff5f0; border-radius: 10px; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Taux d'intérêt</span>
                        <span style="color: #fd7e14; font-weight: bold; font-size: 1.1rem;">{{ $credit->taux_interet }}%</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #fef7ff; border-radius: 10px; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Montant total à rembourser</span>
                        <span style="color: #a29bfe; font-weight: bold; font-size: 1.1rem;">{{ number_format($credit->montant_total_rembourser, 0, ',', ' ') }} FCFA</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f0f8ff; border-radius: 10px; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Mensualité</span>
                        <span style="color: #4299e1; font-weight: bold; font-size: 1.1rem;">{{ number_format($credit->montant_mensuel, 0, ',', ' ') }} FCFA</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #fff2f2; border-radius: 10px;">
                        <span style="color: #2c3e50; font-weight: 600;">Épargne requise (30%)</span>
                        <span style="color: #e84393; font-weight: bold; font-size: 1.1rem;">{{ number_format($credit->montant_epargne_requis, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>

                <!-- Objet du crédit -->
                <div style="margin-top: 25px; padding: 20px; background: linear-gradient(135deg, #ffeaa7, #fab1a0); border-radius: 15px;">
                    <h4 style="margin: 0 0 10px 0; color: #2c3e50; font-weight: 600;">📋 Objet du crédit</h4>
                    <p style="margin: 0; color: #2c3e50; line-height: 1.5;">{{ $credit->objet_credit }}</p>
                </div>
            </div>

            <!-- Statut et actions -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                
                <!-- Statut actuel -->
                <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.3rem;">📈 Statut Actuel</h3>
                    
                    <div id="statusCard" style="padding: 25px; border-radius: 15px; text-align: center; margin-bottom: 20px;">
                        <div style="font-size: 3rem; margin-bottom: 15px;" id="statusIcon">⏳</div>
                        <h4 style="margin: 0 0 10px 0; font-size: 1.5rem; font-weight: bold;" id="statusText">{{ $credit->status_label }}</h4>
                        <p style="margin: 0; opacity: 0.9; font-size: 1rem;" id="statusDescription">Votre demande est en cours de traitement</p>
                    </div>

                    @if($credit->date_traitement)
                    <div style="background: #f8f9ff; padding: 15px; border-radius: 10px; border-left: 4px solid #74b9ff;">
                        <p style="margin: 0; color: #2c3e50;">
                            <strong>Traitée le :</strong> {{ \Carbon\Carbon::parse($credit->date_traitement)->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    @endif

                    @if($credit->status == 'rejete' && $credit->motif_rejet)
                    <div style="background: #fee2e2; padding: 20px; border-radius: 10px; border-left: 4px solid #f87171; margin-top: 15px;">
                        <h5 style="margin: 0 0 10px 0; color: #dc2626;">Motif de rejet :</h5>
                        <p style="margin: 0; color: #7f1d1d;">{{ $credit->motif_rejet }}</p>
                    </div>
                    @endif

                    @if($credit->observations)
                    <div style="background: #f0f9ff; padding: 20px; border-radius: 10px; border-left: 4px solid #60a5fa; margin-top: 15px;">
                        <h5 style="margin: 0 0 10px 0; color: #1e40af;">Observations :</h5>
                        <p style="margin: 0; color: #1e3a8a;">{{ $credit->observations }}</p>
                    </div>
                    @endif
                </div>

                <!-- Remboursement (si applicable) -->
                @if(in_array($credit->status, ['debourse', 'en_remboursement', 'rembourse', 'en_retard']))
                <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.3rem;">💳 Suivi des Remboursements</h3>
                    
                    <!-- Barre de progression -->
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #2c3e50; font-weight: 600;">Progression</span>
                            <span style="color: #2c3e50; font-weight: bold;">{{ $credit->pourcentage_remboursement }}%</span>
                        </div>
                        <div style="background: #e2e8f0; height: 12px; border-radius: 6px; overflow: hidden;">
                            <div style="background: linear-gradient(90deg, #48bb78, #00b894); height: 100%; width: {{ $credit->pourcentage_remboursement }}%; transition: width 0.8s ease;"></div>
                        </div>
                    </div>

                    <!-- Détails remboursement -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="background: #f0fff4; padding: 15px; border-radius: 10px; text-align: center;">
                            <div style="color: #00b894; font-weight: bold; font-size: 1.2rem;">
                                {{ number_format($credit->montant_rembourse, 0, ',', ' ') }}
                            </div>
                            <div style="color: #2c3e50; font-size: 0.9rem;">Remboursé</div>
                        </div>
                        
                        <div style="background: #fff5f5; padding: 15px; border-radius: 10px; text-align: center;">
                            <div style="color: #e84393; font-weight: bold; font-size: 1.2rem;">
                                {{ number_format($credit->solde_restant, 0, ',', ' ') }}
                            </div>
                            <div style="color: #2c3e50; font-size: 0.9rem;">Restant</div>
                        </div>
                    </div>

                    <div style="margin-top: 20px; padding: 15px; background: #f8f9ff; border-radius: 10px; display: flex; justify-content: space-between;">
                        <span style="color: #2c3e50;">Échéances payées :</span>
                        <strong style="color: #74b9ff;">{{ $credit->echeances_payees }} / {{ $credit->echeances_totales }}</strong>
                    </div>

                    @if($credit->jours_retard > 0)
                    <div style="margin-top: 15px; padding: 15px; background: #fef2f2; border-radius: 10px; border-left: 4px solid #f87171;">
                        <p style="margin: 0; color: #dc2626; font-weight: 600;">
                            ⚠️ Retard de {{ $credit->jours_retard }} jour(s)
                        </p>
                        @if($credit->penalites > 0)
                        <p style="margin: 5px 0 0 0; color: #7f1d1d;">
                            Pénalités : {{ number_format($credit->penalites, 0, ',', ' ') }} FCFA
                        </p>
                        @endif
                    </div>
                    @endif

                    @if($credit->date_echeance)
                    <div style="margin-top: 15px; padding: 15px; background: #f0f9ff; border-radius: 10px; text-align: center;">
                        <p style="margin: 0; color: #2c3e50;">
                            <strong>Date d'échéance finale :</strong><br>
                            <span style="color: #1d4ed8; font-size: 1.1rem; font-weight: bold;">
                                {{ \Carbon\Carbon::parse($credit->date_echeance)->format('d/m/Y') }}
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Documents -->
                <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.3rem;">📎 Documents Fournis</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        @if($credit->demande_manuscrite)
                        <a href="{{ asset('storage/' . $credit->demande_manuscrite) }}" target="_blank" 
                           style="display: flex; align-items: center; padding: 15px; background: #f0f9ff; border-radius: 10px; text-decoration: none; transition: all 0.3s; border: 2px solid transparent;">
                            <div style="width: 40px; height: 40px; background: #74b9ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: white; font-weight: bold;">📝</div>
                            <div>
                                <div style="color: #2c3e50; font-weight: 600;">Demande manuscrite</div>
                                <div style="color: #718096; font-size: 0.9rem;">Cliquer pour voir</div>
                            </div>
                        </a>
                        @endif

                        @if($credit->photocopie_cni)
                        <a href="{{ asset('storage/' . $credit->photocopie_cni) }}" target="_blank"
                           style="display: flex; align-items: center; padding: 15px; background: #f0fff4; border-radius: 10px; text-decoration: none; transition: all 0.3s; border: 2px solid transparent;">
                            <div style="width: 40px; height: 40px; background: #00b894; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: white; font-weight: bold;">🆔</div>
                            <div>
                                <div style="color: #2c3e50; font-weight: 600;">Photocopie CNI</div>
                                <div style="color: #718096; font-size: 0.9rem;">Cliquer pour voir</div>
                            </div>
                        </a>
                        @endif

                        @if($credit->plan_localisation)
                        <a href="{{ asset('storage/' . $credit->plan_localisation) }}" target="_blank"
                           style="display: flex; align-items: center; padding: 15px; background: #fff5f0; border-radius: 10px; text-decoration: none; transition: all 0.3s; border: 2px solid transparent;">
                            <div style="width: 40px; height: 40px; background: #fd7e14; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: white; font-weight: bold;">🗺️</div>
                            <div>
                                <div style="color: #2c3e50; font-weight: 600;">Plan de localisation</div>
                                <div style="color: #718096; font-size: 0.9rem;">Cliquer pour voir</div>
                            </div>
                        </a>
                        @endif

                        @if($credit->justificatifs_financiers)
                        <a href="{{ asset('storage/' . $credit->justificatifs_financiers) }}" target="_blank"
                           style="display: flex; align-items: center; padding: 15px; background: #fef7ff; border-radius: 10px; text-decoration: none; transition: all 0.3s; border: 2px solid transparent;">
                            <div style="width: 40px; height: 40px; background: #a29bfe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: white; font-weight: bold;">📊</div>
                            <div>
                                <div style="color: #2c3e50; font-weight: 600;">Justificatifs financiers</div>
                                <div style="color: #718096; font-size: 0.9rem;">Cliquer pour voir</div>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Avalistes -->
        <div style="background: white; border-radius: 20px; padding: 30px; margin-top: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
            <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.3rem; border-bottom: 3px solid #fdcb6e; padding-bottom: 10px;">
                👥 Vos Avalistes
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Avaliste 1 -->
                <div style="background: linear-gradient(135deg, #fffbf0, #fff8e1); border: 2px solid #fdcb6e; border-radius: 15px; padding: 25px;">
                    <h4 style="color: #e17055; margin: 0 0 20px 0; font-size: 1.2rem;">Premier Avaliste</h4>
                    <div style="space-y: 15px;">
                        <div>
                            <span style="color: #2c3e50; font-weight: 600;">Nom :</span>
                            <span style="color: #2c3e50; margin-left: 10px;">{{ $credit->avaliste1_nom }}</span>
                        </div>
                        <div>
                            <span style="color: #2c3e50; font-weight: 600;">Téléphone :</span>
                            <span style="color: #2c3e50; margin-left: 10px;">{{ $credit->avaliste1_telephone }}</span>
                        </div>
                        <div>
                            <span style="color: #2c3e50; font-weight: 600;">CNI :</span>
                            <span style="color: #2c3e50; margin-left: 10px;">{{ $credit->avaliste1_cni }}</span>
                        </div>
                    </div>
                </div>

                <!-- Avaliste 2 -->
                <div style="background: linear-gradient(135deg, #fffbf0, #fff8e1); border: 2px solid #fdcb6e; border-radius: 15px; padding: 25px;">
                    <h4 style="color: #e17055; margin: 0 0 20px 0; font-size: 1.2rem;">Deuxième Avaliste</h4>
                    <div style="space-y: 15px;">
                        <div>
                            <span style="color: #2c3e50; font-weight: 600;">Nom :</span>
                            <span style="color: #2c3e50; margin-left: 10px;">{{ $credit->avaliste2_nom }}</span>
                        </div>
                        <div>
                            <span style="color: #2c3e50; font-weight: 600;">Téléphone :</span>
                            <span style="color: #2c3e50; margin-left: 10px;">{{ $credit->avaliste2_telephone }}</span>
                        </div>
                        <div>
                            <span style="color: #2c3e50; font-weight: 600;">CNI :</span>
                            <span style="color: #2c3e50; margin-left: 10px;">{{ $credit->avaliste2_cni }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($credit->garanties)
        <!-- Garanties -->
        <div style="background: white; border-radius: 20px; padding: 30px; margin-top: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
            <h3 style="color: #2c3e50; margin-bottom: 25px; font-size: 1.3rem; border-bottom: 3px solid #00cec9; padding-bottom: 10px;">
                🛡️ Garanties Proposées
            </h3>
            <div style="background: linear-gradient(135deg, #f0fdff, #e6fffa); border: 2px solid #00cec9; border-radius: 15px; padding: 25px;">
                <p style="margin: 0; color: #2c3e50; line-height: 1.6;">{{ $credit->garanties }}</p>
            </div>
        </div>
        @endif

        <!-- Actions selon le statut -->
        @if($credit->status == 'rejete')
        <div style="background: white; border-radius: 20px; padding: 30px; margin-top: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center;">
            <a href="{{ route('credits.create') }}" 
               style="display: inline-block; background: linear-gradient(135deg, #4299e1, #3182ce); color: white; text-decoration: none; padding: 15px 30px; border-radius: 25px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s;">
                🔄 Faire une nouvelle demande
            </a>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentStatus = '{{ $credit->status }}';
    
    // Configuration des statuts
    const statusConfig = {
        'en_attente': {
            icon: '⏳',
            title: 'En Attente',
            description: 'Votre demande est en cours de vérification',
            color: '#fbbf24',
            bgColor: '#fef3c7',
            progress: 20
        },
        'en_etude': {
            icon: '🔍',
            title: 'En Étude',
            description: 'Votre dossier est actuellement analysé par nos experts',
            color: '#f59e0b',
            bgColor: '#fef3c7',
            progress: 40
        },
        'approuve': {
            icon: '✅',
            title: 'Approuvé',
            description: 'Félicitations ! Votre demande a été approuvée',
            color: '#10b981',
            bgColor: '#d1fae5',
            progress: 60
        },
        'rejete': {
            icon: '❌',
            title: 'Rejeté',
            description: 'Votre demande n\'a pas pu être acceptée',
            color: '#ef4444',
            bgColor: '#fee2e2',
            progress: 0
        },
        'debourse': {
            icon: '💰',
            title: 'Déboursé',
            description: 'Le montant a été versé sur votre compte',
            color: '#3b82f6',
            bgColor: '#dbeafe',
            progress: 80
        },
        'en_remboursement': {
            icon: '💳',
            title: 'En Remboursement',
            description: 'Remboursement en cours selon l\'échéancier',
            color: '#8b5cf6',
            bgColor: '#f3e8ff',
            progress: 80
        },
        'rembourse': {
            icon: '🏆',
            title: 'Remboursé',
            description: 'Crédit entièrement remboursé - Bravo !',
            color: '#059669',
            bgColor: '#d1fae5',
            progress: 100
        },
        'en_retard': {
            icon: '⚠️',
            title: 'En Retard',
            description: 'Attention : remboursement en retard',
            color: '#dc2626',
            bgColor: '#fee2e2',
            progress: 80
        }
    };

    // Mettre à jour l'affichage du statut
    const config = statusConfig[currentStatus] || statusConfig['en_attente'];
    
    document.getElementById('statusIcon').textContent = config.icon;
    document.getElementById('statusText').textContent = config.title;
    document.getElementById('statusDescription').textContent = config.description;
    
    const statusCard = document.getElementById('statusCard');
    statusCard.style.background = config.bgColor;
    statusCard.style.color = config.color;

    // Mettre à jour la barre de progression de la timeline
    const progressBar = document.getElementById('progressBar');
    progressBar.style.width = config.progress + '%';

    // Activer les étapes appropriées dans la timeline
    const steps = document.querySelectorAll('.status-step');
    const statusOrder = ['en_attente', 'en_etude', 'approuve', 'debourse', 'rembourse'];
    const currentIndex = statusOrder.indexOf(currentStatus);
    
    // Si le statut est "rejeté", on colore seulement la première étape en rouge
    if (currentStatus === 'rejete') {
        steps[0].querySelector('.step-circle').style.background = '#ef4444';
        steps[0].querySelector('.step-circle').style.color = 'white';
        return;
    }

    // Activer les étapes complétées
    steps.forEach((step, index) => {
        const circle = step.querySelector('.step-circle');
        const stepStatus = step.getAttribute('data-status');
        
        // Si l'étape est complétée ou en cours
        if (index <= currentIndex || stepStatus === currentStatus) {
            circle.style.background = config.color;
            circle.style.color = 'white';
            circle.style.transform = 'scale(1.1)';
        } else {
            // Étapes non atteintes
            circle.style.background = '#e2e8f0';
            circle.style.color = '#64748b';
            circle.style.transform = 'scale(1)';
        }
    });

    // Animation des cartes de documents au survol
    const documentLinks = document.querySelectorAll('a[href*="storage"]');
    documentLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            this.style.borderColor = this.querySelector('div').style.backgroundColor;
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
            this.style.borderColor = 'transparent';
        });
    });

    // Animation au chargement de la page
    const cards = document.querySelectorAll('[style*="background: white"]');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Notification automatique basée sur le statut
    setTimeout(() => {
        showStatusNotification(currentStatus, config);
    }, 1500);
});

function showStatusNotification(status, config) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${config.bgColor};
        color: ${config.color};
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        z-index: 9999;
        max-width: 350px;
        border: 2px solid ${config.color};
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.5s ease;
        font-family: inherit;
    `;

    let message = '';
    switch(status) {
        case 'en_attente':
            message = 'Votre demande a été reçue et sera traitée dans les plus brefs délais.';
            break;
        case 'en_etude':
            message = 'Nos experts examinent actuellement votre dossier. Merci de votre patience.';
            break;
        case 'approuve':
            message = 'Excellente nouvelle ! Votre crédit a été approuvé. Le débours aura lieu prochainement.';
            break;
        case 'debourse':
            message = 'Le montant de votre crédit a été versé. Vous pouvez maintenant l\'utiliser selon vos besoins.';
            break;
        case 'en_remboursement':
            message = 'N\'oubliez pas vos échéances mensuelles pour maintenir un bon historique de crédit.';
            break;
        case 'rembourse':
            message = 'Félicitations ! Vous avez terminé le remboursement de votre crédit avec succès.';
            break;
        case 'en_retard':
            message = 'Attention : votre remboursement est en retard. Des pénalités peuvent s\'appliquer.';
            break;
        case 'rejete':
            message = 'Votre demande n\'a pas pu être acceptée. Vous pouvez soumettre une nouvelle demande.';
            break;
        default:
            return;
    }

    notification.innerHTML = `
        <div style="display: flex; align-items: flex-start; gap: 15px;">
            <div style="font-size: 1.5rem;">${config.icon}</div>
            <div>
                <div style="font-weight: bold; margin-bottom: 8px; font-size: 1.1rem;">${config.title}</div>
                <div style="line-height: 1.4;">${message}</div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" 
                    style="background: none; border: none; color: ${config.color}; font-size: 1.2rem; cursor: pointer; margin-left: auto;">×</button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animation d'entrée
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Suppression automatique après 8 secondes
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 500);
    }, 8000);
}

// Fonction pour actualiser les données (si nécessaire)
function refreshCreditStatus() {
    // Cette fonction pourrait être utilisée pour actualiser les données via AJAX
    console.log('Actualisation des données...');
    // Implementation AJAX si nécessaire
}

// Raccourci clavier pour actualiser (Ctrl/Cmd + R)
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshCreditStatus();
    }
});
</script>

<style>
/* Animations CSS pour améliorer l'expérience utilisateur */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Styles responsives */
@media (max-width: 768px) {
    [style*="display: grid; grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
    
    [style*="display: flex; justify-content: space-between; align-items: center"] {
        flex-direction: column !important;
        gap: 10px !important;
        align-items: flex-start !important;
    }
    
    .status-step {
        font-size: 0.8rem;
    }
    
    .step-circle {
        width: 30px !important;
        height: 30px !important;
        font-size: 0.9rem !important;
    }
}

/* Amélioration de l'accessibilité */
.status-step:focus-within {
    outline: 2px solid #4299e1;
    outline-offset: 2px;
    border-radius: 8px;
}

/* Effet de survol pour les éléments interactifs */
[onclick]:hover {
    cursor: pointer;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Style pour les liens de documents */
a[href*="storage"]:focus {
    outline: 2px solid #4299e1;
    outline-offset: 2px;
}
</style>

@endsection