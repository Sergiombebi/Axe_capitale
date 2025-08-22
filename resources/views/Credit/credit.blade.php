@extends('layouts.home')

@section('content')
<div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header Principal -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h1 style="color: white; font-size: 3rem; font-weight: bold; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                💳 CRÉDIT AXE CAPITAL
            </h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.2rem; margin: 0;">
                Découvrez nos solutions de financement adaptées à vos besoins
            </p>
        </div>

        <!-- Section Conditions d'Éligibilité -->
        <div style="background: white; border-radius: 20px; padding: 40px; margin-bottom: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: white; padding: 15px 25px; border-radius: 50px; margin-bottom: 20px;">
                    <span style="font-size: 2rem;">📋</span>
                </div>
                <h2 style="color: #2c3e50; font-size: 2.5rem; margin: 0; font-weight: bold;">CONDITIONS D'ÉLIGIBILITÉ</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                
                <!-- Condition 1 -->
                <div style="background: linear-gradient(135deg, #74b9ff, #0984e3); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 15px;">⏱️</div>
                    <h3 style="margin: 0 0 15px 0; font-size: 1.3rem;">ANCIENNETÉ</h3>
                    <p style="margin: 0; font-size: 1.1rem; line-height: 1.6;">
                        Être membre à AXE CAPITAL depuis <strong>au moins 1 mois</strong>
                    </p>
                </div>

                <!-- Condition 2 -->
                <div style="background: linear-gradient(135deg, #00b894, #00a085); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 15px;">💰</div>
                    <h3 style="margin: 0 0 15px 0; font-size: 1.3rem;">ÉPARGNE & GARANTIE</h3>
                    <p style="margin: 0; font-size: 1.1rem; line-height: 1.6;">
                        Avoir <strong>30% du montant</strong> sollicité en épargne + une garantie
                    </p>
                </div>

                <!-- Condition 3 -->
                <div style="background: linear-gradient(135deg, #fdcb6e, #e17055); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 15px;">👥</div>
                    <h3 style="margin: 0 0 15px 0; font-size: 1.3rem;">AVALISTES</h3>
                    <p style="margin: 0; font-size: 1.1rem; line-height: 1.6;">
                        Présenter <strong>2 avalistes</strong> membres d'AXE CAPITAL qui épargnent
                    </p>
                </div>
            </div>
        </div>

        <!-- Section Documents Requis -->
        <div style="background: white; border-radius: 20px; padding: 40px; margin-bottom: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; background: linear-gradient(135deg, #a29bfe, #6c5ce7); color: white; padding: 15px 25px; border-radius: 50px; margin-bottom: 20px;">
                    <span style="font-size: 2rem;">📄</span>
                </div>
                <h2 style="color: #2c3e50; font-size: 2.5rem; margin: 0; font-weight: bold;">DOCUMENTS REQUIS</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                
                <div style="background: #f8f9ff; border-left: 5px solid #6c5ce7; padding: 20px; border-radius: 10px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 1.5rem; margin-right: 10px;">✍️</span>
                        <strong style="color: #2c3e50;">Demande manuscrite</strong>
                    </div>
                </div>

                <div style="background: #f8f9ff; border-left: 5px solid #00b894; padding: 20px; border-radius: 10px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 1.5rem; margin-right: 10px;">🆔</span>
                        <strong style="color: #2c3e50;">Photocopie CNI</strong>
                    </div>
                </div>

                <div style="background: #f8f9ff; border-left: 5px solid #fd79a8; padding: 20px; border-radius: 10px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 1.5rem; margin-right: 10px;">📍</span>
                        <strong style="color: #2c3e50;">Plan de localisation</strong>
                    </div>
                </div>

                <div style="background: #f8f9ff; border-left: 5px solid #fdcb6e; padding: 20px; border-radius: 10px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 1.5rem; margin-right: 10px;">📊</span>
                        <strong style="color: #2c3e50;">Fiche du demandeur</strong>
                    </div>
                    <p style="margin: 5px 0 0 0; color: #636e72; font-size: 0.9rem;">
                        (Statut, situation familiale, financière avec justificatifs)
                    </p>
                </div>
            </div>
        </div>

        <!-- Section Tarification -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 30px;">
            
            <!-- Frais et Taux -->
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="background: linear-gradient(135deg, #ff7675, #d63031); color: white; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 2rem;">
                        💸
                    </div>
                    <h3 style="color: #2c3e50; font-size: 1.8rem; margin: 0;">FRAIS & TAUX</h3>
                </div>

                <div style="space-y: 15px;">
                    <div style="background: #fff5f5; border-left: 4px solid #ff7675; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: between; align-items: center;">
                            <span style="font-weight: bold; color: #2c3e50;">Frais d'étude de dossier:</span>
                            <span style="background: #ff7675; color: white; padding: 5px 12px; border-radius: 20px; font-weight: bold; margin-left: 10px;">1 000 FCFA</span>
                        </div>
                    </div>

                    <div style="background: #f0f8ff; border-left: 4px solid #74b9ff; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: #2c3e50;">Taux d'intérêt:</span>
                        </div>
                        <div style="margin-bottom: 8px;">
                            <span style="color: #636e72;">• ≤ 3 mois:</span>
                            <span style="background: #74b9ff; color: white; padding: 3px 10px; border-radius: 15px; font-weight: bold; margin-left: 10px;">10%</span>
                        </div>
                        <div>
                            <span style="color: #636e72;">• > 3 mois:</span>
                            <span style="background: #e17055; color: white; padding: 3px 10px; border-radius: 15px; font-weight: bold; margin-left: 10px;">20%</span>
                        </div>
                    </div>

                    <div style="background: #fff0f0; border-left: 4px solid #d63031; padding: 15px; border-radius: 8px;">
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: #d63031;">Pénalités de retard:</span>
                        </div>
                        <div style="color: #636e72;">
                            <span style="background: #d63031; color: white; padding: 3px 10px; border-radius: 15px; font-weight: bold;">1 000 FCFA/jour</span>
                            <span style="margin-left: 10px;">pendant 30 jours maximum</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Intérêts sur Épargne -->
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="background: linear-gradient(135deg, #00b894, #00a085); color: white; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 2rem;">
                        📈
                    </div>
                    <h3 style="color: #2c3e50; font-size: 1.8rem; margin: 0;">INTÉRÊTS SUR ÉPARGNE</h3>
                </div>

                <div style="background: #f0fff4; border: 2px solid #00b894; border-radius: 15px; padding: 25px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h4 style="color: #00a085; margin: 0 0 10px 0; font-size: 1.3rem;">Épargne sollicitée pour crédit</h4>
                        <p style="color: #636e72; margin: 0; font-size: 0.95rem; line-height: 1.5;">
                            Lorsque votre épargne est utilisée pour un crédit, vous recevez des intérêts après remboursement
                        </p>
                    </div>

                    <div style="display: flex; justify-content: space-around; align-items: center; margin-top: 20px;">
                        <div style="text-align: center;">
                            <div style="background: #00b894; color: white; padding: 15px; border-radius: 50%; font-size: 1.5rem; margin-bottom: 10px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-left: auto; margin-right: auto;">
                                5%
                            </div>
                            <span style="color: #2c3e50; font-weight: bold; font-size: 0.9rem;">Intérêt total</span>
                        </div>
                        
                        <div style="text-align: center;">
                            <div style="background: #74b9ff; color: white; padding: 15px; border-radius: 50%; font-size: 1.3rem; margin-bottom: 10px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-left: auto; margin-right: auto;">
                                2.5%
                            </div>
                            <span style="color: #2c3e50; font-weight: bold; font-size: 0.9rem;">Chaque 6 mois</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Note Importante -->
        <div style="background: linear-gradient(135deg, #ff9ff3, #f368e0); color: white; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            <div style="font-size: 3rem; margin-bottom: 15px;">⚠️</div>
            <h3 style="margin: 0 0 15px 0; font-size: 1.8rem;">IMPORTANT À RETENIR</h3>
            <p style="margin: 0; font-size: 1.1rem; line-height: 1.6; opacity: 0.95;">
                L'emprunteur doit être une personne <strong>fiable et honnête</strong>. 
                Tous les documents requis doivent être fournis pour l'étude du dossier. 
                Le respect des délais de remboursement est essentiel pour éviter les pénalités.
            </p>
        </div>

        <!-- Call to Action -->
        <div style="text-align: center; margin-top: 40px;">
            <div style="background: white; border-radius: 15px; padding: 25px; display: inline-block; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <p style="color: #2c3e50; margin: 0 0 15px 0; font-size: 1.1rem;">
                    Prêt à faire votre demande de crédit ?
                </p>
                <a href="#" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; text-decoration: none; padding: 15px 35px; border-radius: 50px; font-weight: bold; font-size: 1.1rem; display: inline-block; transition: all 0.3s;">
                    📝 Faire une demande
                </a>
            </div>
        </div>
    </div>
</div>
@endsection