@extends('layouts.home')
@section('content')

<!-- Hero Section avec animation de particules -->
<div style="position: relative; min-height: 100vh; background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); overflow: hidden;">
    <!-- Particules animées -->
    <div style="position: absolute; width: 100%; height: 100%; overflow: hidden; z-index: 1;">
        <div style="position: absolute; width: 4px; height: 4px; background: rgba(255,255,255,0.8); border-radius: 50%; animation: float 6s ease-in-out infinite; top: 20%; left: 10%;"></div>
        <div style="position: absolute; width: 6px; height: 6px; background: rgba(255,255,255,0.6); border-radius: 50%; animation: float 8s ease-in-out infinite; top: 60%; left: 80%;"></div>
        <div style="position: absolute; width: 3px; height: 3px; background: rgba(255,255,255,0.9); border-radius: 50%; animation: float 4s ease-in-out infinite; top: 80%; left: 20%;"></div>
        <div style="position: absolute; width: 5px; height: 5px; background: rgba(255,255,255,0.7); border-radius: 50%; animation: float 7s ease-in-out infinite; top: 30%; left: 70%;"></div>
    </div>

    <!-- Header principal -->
    <div style="position: relative; z-index: 10; padding: 60px 20px; text-align: center;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <!-- Logo et titre principal -->
            <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(20px); border-radius: 30px; padding: 50px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 30px 60px rgba(0,0,0,0.1);">
                <h1 style="font-size: 4rem; font-weight: 900; color: #fff; margin-bottom: 20px; text-shadow: 0 4px 8px rgba(0,0,0,0.3); letter-spacing: 5px; background: linear-gradient(45deg, #fff, #f0f0f0); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    AXE CAPITAL
                </h1>
                <p style="font-size: 1.5rem; color: rgba(255,255,255,0.9); font-weight: 300; font-style: italic; margin-bottom: 30px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    "Les petites tontines pour de grandes ambitions"
                </p>
                <div style="width: 80px; height: 4px; background: linear-gradient(90deg, #fff, transparent); margin: 0 auto 30px; border-radius: 2px;"></div>
                <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto; line-height: 1.8;">
                    🇨🇲 Votre partenaire financier de confiance au Cameroun<br>
                    Épargne • Crédit • Projets • Import/Export
                </p>
            </div>

            <!-- CTA Principal -->
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <button onclick="scrollToServices()" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; border: 2px solid rgba(255,255,255,0.3); padding: 18px 40px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                    🚀 Découvrir nos services
                </button>
                <button onclick="openModal('contact')" style="background: linear-gradient(45deg, #ff6b6b, #ee5a24); color: white; border: none; padding: 18px 40px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(255,107,107,0.4); text-transform: uppercase; letter-spacing: 1px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 40px rgba(255,107,107,0.6)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(255,107,107,0.4)'">
                    💬 Nous contacter
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Section Services avec design moderne -->
<div id="services" style="padding: 100px 20px; background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%); position: relative;">
    <!-- Motif de fond -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 25% 25%, rgba(102,126,234,0.1) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(118,75,162,0.1) 0%, transparent 50%); z-index: 1;"></div>
    
    <div style="max-width: 1400px; margin: 0 auto; position: relative; z-index: 2;">
        <!-- Titre de section -->
        <div style="text-align: center; margin-bottom: 80px;">
            <h2 style="font-size: 3rem; font-weight: 800; color: #2c3e50; margin-bottom: 20px; position: relative;">
                Nos Services
                <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 100px; height: 4px; background: linear-gradient(90deg, #667eea, #764ba2); border-radius: 2px;"></div>
            </h2>
            <p style="font-size: 1.3rem; color: #6c757d; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                Des solutions financières innovantes adaptées à vos besoins
            </p>
        </div>

        <!-- Grille de services -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px;">
            
            <!-- Service 1: Compte -->
            <div style="background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%); border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); transition: all 0.4s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px) rotateX(5deg)'; this.style.boxShadow='0 30px 80px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0) rotateX(0)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.1)'">
                <!-- Icône flottante -->
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; opacity: 0.1; transform: rotate(15deg);"></div>
                
                <div style="display: flex; align-items: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 1.8rem; box-shadow: 0 10px 30px rgba(102,126,234,0.3);">
                        💳
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 0;">Ouverture de Compte</h3>
                </div>
                
                <div style="background: linear-gradient(45deg, #667eea10, #764ba210); border-radius: 15px; padding: 25px; margin-bottom: 25px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.5rem; font-weight: 800; color: #27ae60;">GRATUIT</div>
                            <div style="font-size: 0.9rem; color: #6c757d;">Ouverture</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.5rem; font-weight: 800; color: #667eea;">500 FCFA</div>
                            <div style="font-size: 0.9rem; color: #6c757d;">Solde minimal</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.5rem; font-weight: 800; color: #e74c3c;">1000 FCFA</div>
                            <div style="font-size: 0.9rem; color: #6c757d;">Entretien/trimestre</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.5rem; font-weight: 800; color: #f39c12;">3000 FCFA</div>
                            <div style="font-size: 0.9rem; color: #6c757d;">Activation</div>
                        </div>
                    </div>
                </div>
                
                <button onclick="openModal('compte')" style="width: 100%; background: linear-gradient(45deg, #667eea, #764ba2); color: white; border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(102,126,234,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(102,126,234,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(102,126,234,0.3)'">
                    Ouvrir un compte →
                </button>
            </div>

            <!-- Service 2: Épargne -->
            <div style="background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%); border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); transition: all 0.4s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px) rotateX(5deg)'; this.style.boxShadow='0 30px 80px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0) rotateX(0)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.1)'">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #27ae60, #2ecc71); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; opacity: 0.1; transform: rotate(15deg);"></div>
                
                <div style="display: flex; align-items: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #27ae60, #2ecc71); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 1.8rem; box-shadow: 0 10px 30px rgba(39,174,96,0.3);">
                        💰
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 0;">Épargne Intelligente</h3>
                </div>
                
                <div style="space-y: 15px;">
                    <div style="display: flex; align-items: center; padding: 12px; background: rgba(39,174,96,0.1); border-radius: 10px; margin-bottom: 10px;">
                        <span style="margin-right: 15px; font-size: 1.2rem;">📱</span>
                        <span style="color: #2c3e50; font-weight: 500;">Dépôts via Orange Money</span>
                    </div>
                    <div style="display: flex; align-items: center; padding: 12px; background: rgba(39,174,96,0.1); border-radius: 10px; margin-bottom: 10px;">
                        <span style="margin-right: 15px; font-size: 1.2rem;">⚡</span>
                        <span style="color: #2c3e50; font-weight: 500;">Retraits sous 24h</span>
                    </div>
                    <div style="display: flex; align-items: center; padding: 12px; background: rgba(39,174,96,0.1); border-radius: 10px; margin-bottom: 10px;">
                        <span style="margin-right: 15px; font-size: 1.2rem;">📋</span>
                        <span style="color: #2c3e50; font-weight: 500;">Reçus WhatsApp automatiques</span>
                    </div>
                    <div style="display: flex; align-items: center; padding: 12px; background: rgba(39,174,96,0.1); border-radius: 10px; margin-bottom: 10px;">
                        <span style="margin-right: 15px; font-size: 1.2rem;">🎯</span>
                        <span style="color: #2c3e50; font-weight: 500;">Suivi et motivation 3x/semaine</span>
                    </div>
                </div>
                
                <button onclick="openModal('epargne')" style="width: 100%; background: linear-gradient(45deg, #27ae60, #2ecc71); color: white; border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(39,174,96,0.3); margin-top: 25px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(39,174,96,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(39,174,96,0.3)'">
                    Commencer à épargner →
                </button>
            </div>

            <!-- Service 3: Crédit -->
            <div style="background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%); border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); transition: all 0.4s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px) rotateX(5deg)'; this.style.boxShadow='0 30px 80px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0) rotateX(0)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.1)'">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; opacity: 0.1; transform: rotate(15deg);"></div>
                
                <div style="display: flex; align-items: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #3498db, #2980b9); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 1.8rem; box-shadow: 0 10px 30px rgba(52,152,219,0.3);">
                        🏦
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 0;">Crédit Rapide</h3>
                </div>
                
                <div style="background: linear-gradient(45deg, #3498db10, #2980b910); border-radius: 15px; padding: 25px; margin-bottom: 25px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Taux d'intérêt</span>
                        <span style="color: #3498db; font-weight: 800; font-size: 1.3rem;">10%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Durée</span>
                        <span style="color: #27ae60; font-weight: 800; font-size: 1.3rem;">3 mois</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="color: #2c3e50; font-weight: 600;">Épargne requise</span>
                        <span style="color: #e74c3c; font-weight: 800; font-size: 1.3rem;">30%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #2c3e50; font-weight: 600;">Frais d'étude</span>
                        <span style="color: #f39c12; font-weight: 800; font-size: 1.3rem;">1000 FCFA</span>
                    </div>
                </div>
                
                <div style="background: rgba(52,152,219,0.1); border-radius: 10px; padding: 15px; margin-bottom: 25px; border-left: 4px solid #3498db;">
                    <p style="margin: 0; color: #2c3e50; font-size: 0.95rem; line-height: 1.5;">
                        <strong>Requis:</strong> Membre depuis 1 mois, 2 avalistes, garantie
                    </p>
                </div>
                
                <button onclick="openModal('credit')" style="width: 100%; background: linear-gradient(45deg, #3498db, #2980b9); color: white; border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(52,152,219,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(52,152,219,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(52,152,219,0.3)'">
                    Demander un crédit →
                </button>
            </div>

            <!-- Service 4: Projets -->
            <div style="background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%); border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); transition: all 0.4s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px) rotateX(5deg)'; this.style.boxShadow='0 30px 80px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0) rotateX(0)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.1)'">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #e74c3c, #c0392b); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; opacity: 0.1; transform: rotate(15deg);"></div>
                
                <div style="display: flex; align-items: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #e74c3c, #c0392b); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 1.8rem; box-shadow: 0 10px 30px rgba(231,76,60,0.3);">
                        🚀
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 0;">Financement Projets</h3>
                </div>
                
                <div style="background: linear-gradient(45deg, #e74c3c10, #c0392b10); border-radius: 15px; padding: 25px; margin-bottom: 25px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <div style="font-size: 2rem; font-weight: 800; color: #e74c3c; margin-bottom: 5px;">✨ Réalisez vos rêves</div>
                        <div style="font-size: 1rem; color: #6c757d;">Pour les jeunes entrepreneurs camerounais</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #2c3e50;">📋</div>
                            <div style="font-size: 0.9rem; color: #6c757d; margin-top: 5px;">Business Plan</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #2c3e50;">💰</div>
                            <div style="font-size: 0.9rem; color: #6c757d; margin-top: 5px;">Apport Personnel</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.2rem; font-weight: 700; color: #2c3e50;">🏢</div>
                            <div style="font-size: 0.9rem; color: #6c757d; margin-top: 5px;">NIU</div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                            <div style="font-size: 1.1rem; font-weight: 800; color: #e74c3c;">5000 FCFA</div>
                            <div style="font-size: 0.9rem; color: #6c757d; margin-top: 5px;">Frais d'étude</div>
                        </div>
                    </div>
                </div>
                
                <button onclick="openModal('projet')" style="width: 100%; background: linear-gradient(45deg, #e74c3c, #c0392b); color: white; border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(231,76,60,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(231,76,60,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(231,76,60,0.3)'">
                    Financer mon projet →
                </button>
            </div>

            <!-- Service 5: Import/Export -->
            <div style="background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%); border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); transition: all 0.4s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px) rotateX(5deg)'; this.style.boxShadow='0 30px 80px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0) rotateX(0)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.1)'">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #f39c12, #e67e22); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; opacity: 0.1; transform: rotate(15deg);"></div>
                
                <div style="display: flex; align-items: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #f39c12, #e67e22); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 1.8rem; box-shadow: 0 10px 30px rgba(243,156,18,0.3);">
                        🌍
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 0;">Import/Export Chine</h3>
                </div>
                
                <div style="background: linear-gradient(45deg, #f39c1210, #e67e2210); border-radius: 15px; padding: 25px; margin-bottom: 25px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 12px; background: rgba(255,255,255,0.7); border-radius: 8px;">
                        <span style="color: #2c3e50; font-weight: 600;">🚢 Par bateau</span>
                        <span style="color: #f39c12; font-weight: 800;">2-3 mois</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 12px; background: rgba(255,255,255,0.7); border-radius: 8px;">
                        <span style="color: #2c3e50; font-weight: 600;">✈️ Par avion</span>
                        <span style="color: #27ae60; font-weight: 800;">1-1.5 mois</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 12px; background: rgba(255,255,255,0.7); border-radius: 8px;">
                        <span style="color: #2c3e50; font-weight: 600;">Frais douane</span>
                        <span style="color: #e74c3c; font-weight: 800;">10000 FCFA/kg</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: rgba(255,255,255,0.7); border-radius: 8px;">
                        <span style="color: #2c3e50; font-weight: 600;">Commission</span>
                        <span style="color: #3498db; font-weight: 800;">1000 FCFA/kg</span>
                    </div>
                </div>
                
                <button onclick="openModal('import')" style="width: 100%; background: linear-gradient(45deg, #f39c12, #e67e22); color: white; border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(243,156,18,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(243,156,18,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(243,156,18,0.3)'">
                    Commander de Chine →
                </button>
            </div>

            <!-- Service 6: Intérêts -->
            <div style="background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%); border-radius: 25px; padding: 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); transition: all 0.4s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-10px) rotateX(5deg)'; this.style.boxShadow='0 30px 80px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0) rotateX(0)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.1)'">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #9b59b6, #8e44ad); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; opacity: 0.1; transform: rotate(15deg);"></div>
                
                <div style="display: flex; align-items: center; margin-bottom: 25px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(45deg, #9b59b6, #8e44ad); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 1.8rem; box-shadow: 0 10px 30px rgba(155,89,182,0.3);">
                        📈
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 0;">Intérêts sur Épargne</h3>
                </div>
                
                <div style="background: linear-gradient(45deg, #9b59b610, #8e44ad10); border-radius: 15px; padding: 25px; margin-bottom: 25px; text-align: center;">
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 3rem; font-weight: 900; color: #9b59b6; margin-bottom: 10px;">5%</div>
                        <div style="font-size: 1.1rem; color: #6c757d;">d'intérêts sur les prêts</div>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.8); border-radius: 12px; padding: 20px;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">💡 Comment ça marche ?</div>
                        <p style="color: #6c757d; font-size: 1rem; line-height: 1.6; margin: 0;">
                            Votre épargne est utilisée pour des crédits.<br>
                            Vous recevez <strong style="color: #9b59b6;">5%</strong> du montant prêté.<br>
                            <strong style="color: #27ae60;">2.5%</strong> tous les 6 mois.
                        </p>
                    </div>
                </div>
                
                <button onclick="openModal('interets')" style="width: 100%; background: linear-gradient(45deg, #9b59b6, #8e44ad); color: white; border: none; padding: 15px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(155,89,182,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(155,89,182,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(155,89,182,0.3)'">
                    Découvrir les intérêts →
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Section Contact moderne -->
<div style="padding: 100px 20px; background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); position: relative; overflow: hidden;">
    <!-- Effet de parallaxe -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%); z-index: 1;"></div>
    
    <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 3rem; font-weight: 800; color: white; margin-bottom: 20px;">
                Prêt à commencer ?
            </h2>
            <p style="font-size: 1.3rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto; line-height: 1.6;">
                Rejoignez des milliers de Camerounais qui font confiance à AXE CAPITAL
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 60px;">
            <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border-radius: 20px; padding: 40px; text-align: center; border: 1px solid rgba(255,255,255,0.2);">
                <div style="font-size: 3rem; margin-bottom: 20px;">📱</div>
                <h3 style="font-size: 1.5rem; color: white; margin-bottom: 15px; font-weight: 600;">WhatsApp</h3>
                <p style="color: rgba(255,255,255,0.8); line-height: 1.6; margin-bottom: 20px;">
                    Support disponible 7j/7<br>
                    Notifications automatiques<br>
                    Gestion de compte simplifiée
                </p>
                <button onclick="openModal('contact')" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 12px 25px; border-radius: 25px; cursor: pointer; transition: all 0.3s ease; font-weight: 600;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    Nous contacter
                </button>
            </div>

            <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border-radius: 20px; padding: 40px; text-align: center; border: 1px solid rgba(255,255,255,0.2);">
                <div style="font-size: 3rem; margin-bottom: 20px;">🇨🇲</div>
                <h3 style="font-size: 1.5rem; color: white; margin-bottom: 15px; font-weight: 600;">Local & Fiable</h3>
                <p style="color: rgba(255,255,255,0.8); line-height: 1.6; margin-bottom: 20px;">
                    Entreprise camerounaise<br>
                    Réglementation locale<br>
                    Proximité avec nos clients
                </p>
                <div style="background: rgba(39,174,96,0.3); color: white; padding: 12px 25px; border-radius: 25px; font-weight: 600; display: inline-block;">
                    ✓ Certifié
                </div>
            </div>

            <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border-radius: 20px; padding: 40px; text-align: center; border: 1px solid rgba(255,255,255,0.2);">
                <div style="font-size: 3rem; margin-bottom: 20px;">⚡</div>
                <h3 style="font-size: 1.5rem; color: white; margin-bottom: 15px; font-weight: 600;">Rapidité</h3>
                <p style="color: rgba(255,255,255,0.8); line-height: 1.6; margin-bottom: 20px;">
                    Ouverture de compte immédiate<br>
                    Traitement sous 24h<br>
                    Décisions rapides
                </p>
                <div style="background: rgba(52,152,219,0.3); color: white; padding: 12px 25px; border-radius: 25px; font-weight: 600; display: inline-block;">
                    🚀 Ultra-rapide
                </div>
            </div>
        </div>

        <!-- CTA Final -->
        <div style="text-align: center;">
            <button onclick="openModal('compte')" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; border: none; padding: 20px 50px; border-radius: 50px; font-size: 1.3rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 15px 40px rgba(102,126,234,0.4); text-transform: uppercase; letter-spacing: 2px;" onmouseover="this.style.transform='translateY(-3px) scale(1.05)'; this.style.boxShadow='0 20px 50px rgba(102,126,234,0.6)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 15px 40px rgba(102,126,234,0.4)'">
                🎯 Ouvrir mon compte gratuitement
            </button>
            <p style="color: rgba(255,255,255,0.6); margin-top: 20px; font-size: 1rem;">
                * Ouverture gratuite • Solde minimal 500 FCFA • Activation rapide
            </p>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modal" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); backdrop-filter: blur(5px);">
    <div style="background: linear-gradient(145deg, #ffffff, #f8f9fa); margin: 3% auto; padding: 0; border-radius: 25px; width: 90%; max-width: 700px; max-height: 90vh; overflow: hidden; box-shadow: 0 50px 100px rgba(0,0,0,0.3); position: relative;">
        <div style="background: linear-gradient(45deg, #667eea, #764ba2); padding: 30px; color: white; position: relative;">
            <span onclick="closeModal()" style="position: absolute; top: 20px; right: 25px; color: white; font-size: 35px; font-weight: bold; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='rotate(90deg)'" onmouseout="this.style.transform='rotate(0deg)'">&times;</span>
            <h2 id="modal-title" style="margin: 0; font-size: 2rem; font-weight: 800;"></h2>
        </div>
        <div id="modal-body" style="padding: 40px; max-height: 60vh; overflow-y: auto; line-height: 1.8;"></div>
    </div>
</div>

<!-- Styles et animations -->
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.8; }
        50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
    }
    
    html { scroll-behavior: smooth; }
    
    /* Responsive design */
    @media (max-width: 768px) {
        h1 { font-size: 2.5rem !important; }
        .services-grid { grid-template-columns: 1fr !important; }
        h2 { font-size: 2rem !important; }
        h3 { font-size: 1.5rem !important; }
    }
</style>

@endsection
