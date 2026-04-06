@extends('frontend/layouts/master')

@section('title', 'Conditions générales d\'utilisation')

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Conditions générales d\'utilisation'])

    <section class="policy-section mt-3 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="policy-list">
                        <h3 class="policy-title">Qui sommes-nous ?</h3>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> est une boutique en ligne spécialisée dans la vente de produits capillaires de qualité : perruques naturelles et synthétiques, huiles capillaires, soins, extensions, colorations etc... Notre mission est d'accompagner chaque cliente dans la mise en valeur de sa beauté naturelle.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Acceptation des conditions</h3>
                        <p>
                            En accédant à la plateforme <b style="color: #c29958;">{{ config('app.name') }}</b> et en passant une commande, vous reconnaissez avoir lu, compris et accepté sans réserve les présentes conditions générales d'utilisation. Si vous n'acceptez pas ces conditions, nous vous invitons à ne pas utiliser notre plateforme.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Disponibilité des produits</h3>
                        <p>
                            Les produits proposés sur <b style="color: #c29958;">{{ config('app.name') }}</b> sont disponibles dans la limite des stocks existants. En cas d'indisponibilité d'un produit après validation de votre commande, <b style="color: #c29958;">{{ config('app.name') }}</b> vous en informera dans les plus brefs délais et vous proposera soit un produit de substitution équivalent, soit un avoir, soit un remboursement dans ce cas précis.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Prix</h3>
                        <p>
                            Les prix affichés sur <b style="color: #c29958;">{{ config('app.name') }}</b> sont indiqués en Francs CFA (FCFA) et sont susceptibles d'être modifiés à tout moment sans préavis. Le prix applicable est celui en vigueur au moment de la validation de votre commande.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Données personnelles</h3>
                        <p>
                            Les informations collectées lors de votre commande (nom, prénom, adresse, contact) sont utilisées exclusivement dans le cadre du traitement de votre commande et de la relation commerciale avec <b style="color: #c29958;">{{ config('app.name') }}</b>. Ces données ne sont ni vendues ni transmises à des tiers sans votre consentement.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Propriété intellectuelle</h3>
                        <p>
                            L'ensemble du contenu de la plateforme <b style="color: #c29958;">{{ config('app.name') }}</b> (textes, images, logos, descriptions) est la propriété exclusive de <b style="color: #c29958;">{{ config('app.name') }}</b> et est protégé par les lois en vigueur sur la propriété intellectuelle. Toute reproduction ou utilisation sans autorisation est strictement interdite.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Responsabilités</h3>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> s'engage à proposer des produits de qualité conformes aux descriptions publiées sur la plateforme. Cependant, <b style="color: #c29958;">{{ config('app.name') }}</b> ne pourra être tenue responsable d'une utilisation incorrecte des produits par l'acheteur, notamment en cas de réaction allergique ou d'utilisation non conforme aux recommandations du fabricant.
                        </p>
                        <p>
                            Il appartient à chaque cliente de vérifier la composition des produits avant tout achat, en particulier en cas d'allergie ou de sensibilité connue.
                        </p>
                    </div>
                    
                    <div class="policy-list">
                        <h3 class="policy-title">Commandes et paiement</h3>
                        <p>
                            Toute commande passée sur <b style="color: #c29958;">{{ config('app.name') }}</b> est soumise à un <strong>paiement intégral et préalable</strong> avant toute préparation ou livraison. Aucune commande ne sera traitée, expédiée ou mise de côté sans confirmation du paiement.
                        </p>
                        <p>
                            Le paiement peut être effectué via les moyens mis à disposition sur la plateforme. Dès réception et confirmation de votre paiement, votre commande sera prise en charge et préparée dans les meilleurs délais.
                        </p>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> se réserve le droit d'annuler toute commande pour laquelle le paiement n'aurait pas été reçu dans un délai raisonnable suivant la passation de la commande.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Politique de vente définitive — Aucun retour ni remboursement</h3>
                        <p>
                            Pour des raisons d'hygiène et de sécurité, et conformément à la nature des produits commercialisés (perruques, huiles, soins capillaires, accessoires), <strong>toute vente effectuée sur <b style="color: #c29958;">{{ config('app.name') }}</b> est définitive et irrévocable</strong>.
                        </p>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> n'accepte <strong>aucun retour de produit, aucun échange et aucun remboursement</strong> après qu'une commande ait été livrée ou mise à disposition de l'acheteur. Nous vous invitons à vérifier attentivement vos choix (couleur, taille, type de produit) avant de valider votre commande.
                        </p>
                        <p>
                            En cas de doute sur un produit, notre équipe reste disponible pour vous conseiller avant votre achat via nos canaux de contact.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Livraison</h3>
                        <p>
                            Les délais de livraison sont donnés à titre indicatif et peuvent varier en fonction de votre localisation et des disponibilités. <b style="color: #c29958;">{{ config('app.name') }}</b> ne saurait être tenue responsable des retards causés par des tiers (transporteurs, événements extérieurs).
                        </p>
                        <p>
                            L'acheteur est responsable de fournir une adresse de livraison correcte et complète. Toute commande livrée à une adresse erronée fournie par l'acheteur ne pourra donner lieu à un remboursement ou à un renvoi aux frais de <b style="color: #c29958;">{{ config('app.name') }}</b>.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Modification des conditions</h3>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> se réserve le droit de modifier les présentes conditions générales d'utilisation à tout moment. Les nouvelles conditions seront applicables dès leur mise en ligne sur la plateforme. Il vous appartient de les consulter régulièrement.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Contact</h3>
                        <p>
                            Pour toute question relative à vos commandes ou aux présentes conditions, vous pouvez nous contacter via notre page de contact ou directement sur nos réseaux sociaux. Notre équipe se fera un plaisir de vous répondre dans les meilleurs délais.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
