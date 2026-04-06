@extends('frontend/layouts/master')

@section('title', 'Politique de confidentialité')

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Politique de confidentialité'])

    <section class="policy-section mt-3 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="policy-list">
                        <h3 class="policy-title">Introduction</h3>
                        <p>
                            Chez <b style="color: #c29958;">{{ config('app.name') }}</b>, la protection de vos données personnelles est une priorité. La présente politique de confidentialité a pour objectif de vous informer de manière transparente sur la façon dont nous collectons, utilisons, stockons et protégeons vos informations lorsque vous utilisez notre plateforme.
                        </p>
                        <p>
                            En utilisant la plateforme <b style="color: #c29958;">{{ config('app.name') }}</b>, vous acceptez les pratiques décrites dans la présente politique de confidentialité.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Données collectées</h3>
                        <p>
                            Dans le cadre de votre utilisation de la plateforme <b style="color: #c29958;">{{ config('app.name') }}</b>, nous sommes amenés à collecter les informations suivantes :
                        </p>
                        <ul>
                            <li><strong>Informations d'identification</strong> : nom, prénom, adresse e-mail, numéro de téléphone etc...</li>
                            <li><strong>Informations de livraison</strong> : adresse postale complète, ville, quartier etc...</li>
                            <li><strong>Informations de commande</strong> : produits commandés, montants, historique d'achats etc...</li>
                            <li><strong>Données de navigation</strong> : adresse IP, type de navigateur, pages visitées, durée de visite etc..</li>
                        </ul>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Pourquoi collectons-nous ces données ?</h3>
                        <p>Les données que nous collectons sont utilisées exclusivement pour les finalités suivantes :</p>
                        <ul>
                            <li>Traiter et gérer vos commandes de bout en bout.</li>
                            <li>Assurer la livraison de vos produits à l'adresse indiquée.</li>
                            <li>Vous contacter en cas de besoin concernant votre commande.</li>
                            <li>Améliorer votre expérience sur la plateforme.</li>
                            <li>Vous informer de nos promotions, nouveautés et offres spéciales (uniquement si vous y avez consenti).</li>
                            <li>Assurer la sécurité et le bon fonctionnement de la plateforme.</li>
                        </ul>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Conservation des données</h3>
                        <p>
                            Vos données personnelles sont conservées aussi longtemps que nécessaire pour la gestion de votre compte et de vos commandes. Passé ce délai, vos données sont supprimées ou anonymisées, sauf obligation légale contraire.
                        </p>
                        <p>
                            Les données relatives aux transactions commerciales peuvent être conservées plus longtemps afin de répondre à d'éventuelles obligations comptables ou légales.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Partage des données</h3>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> s'engage à ne jamais vendre, louer ou céder vos données personnelles à des tiers à des fins commerciales.
                        </p>
                        <p>
                            Vos données peuvent cependant être partagées dans les cas suivants :
                        </p>
                        <ul>
                            <li><strong>Prestataires de livraison</strong> : uniquement les informations nécessaires à l'acheminement de votre commande (nom, adresse, contact etc...).</li>
                            <li><strong>Obligation légale</strong> : si la loi ou une autorité compétente l'exige.</li>
                        </ul>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Sécurité des données</h3>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> met en œuvre toutes les mesures techniques et organisationnelles appropriées pour protéger vos données personnelles contre tout accès non autorisé, perte, destruction ou divulgation. Cependant, aucune transmission de données sur internet n'est totalement sécurisée, et nous ne pouvons garantir une sécurité absolue.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Cookies</h3>
                        <p>
                            La plateforme <b style="color: #c29958;">{{ config('app.name') }}</b> utilise des cookies afin d'améliorer votre expérience de navigation. Les cookies sont de petits fichiers texte stockés sur votre appareil qui nous permettent de :
                        </p>
                        <ul>
                            <li>Mémoriser vos préférences de navigation.</li>
                            <li>Maintenir votre session active lors de votre connexion.</li>
                            <li>Analyser le trafic et l'utilisation de la plateforme pour l'améliorer continuellement.</li>
                        </ul>
                        <p>
                            Vous pouvez à tout moment configurer votre navigateur pour refuser les cookies. Notez toutefois que certaines fonctionnalités de la plateforme pourraient ne plus fonctionner correctement sans cookies.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Vos droits</h3>
                        <p>
                            Conformément aux lois applicables en matière de protection des données, vous disposez des droits suivants concernant vos données personnelles :
                        </p>
                        <ul>
                            <li><strong>Droit d'accès</strong> : vous pouvez demander à consulter les données que nous détenons sur vous.</li>
                            <li><strong>Droit de rectification</strong> : vous pouvez demander la correction de données inexactes ou incomplètes.</li>
                            <li><strong>Droit à l'effacement</strong> : vous pouvez demander la suppression de vos données personnelles, sous réserve des obligations légales.</li>
                            <li><strong>Droit d'opposition</strong> : vous pouvez vous opposer à l'utilisation de vos données à des fins de prospection commerciale.</li>
                        </ul>
                        <p>
                            Pour exercer l'un de ces droits, contactez-nous directement via notre page de contact ou sur nos réseaux sociaux.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Liens vers des sites tiers</h3>
                        <p>
                            La plateforme <b style="color: #c29958;">{{ config('app.name') }}</b> peut contenir des liens vers des sites externes (réseaux sociaux, partenaires). <b style="color: #c29958;">{{ config('app.name') }}</b> n'est pas responsable des pratiques de confidentialité de ces sites tiers et vous invite à consulter leurs propres politiques de confidentialité.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Modification de la politique de confidentialité</h3>
                        <p>
                            <b style="color: #c29958;">{{ config('app.name') }}</b> se réserve le droit de modifier la présente politique de confidentialité à tout moment. Toute modification sera publiée sur cette page et prendra effet immédiatement. Nous vous encourageons à consulter régulièrement cette page afin de rester informée des éventuelles mises à jour.
                        </p>
                    </div>

                    <div class="policy-list">
                        <h3 class="policy-title">Contact</h3>
                        <p>
                            Pour toute question ou préoccupation concernant la présente politique de confidentialité ou le traitement de vos données personnelles, vous pouvez nous contacter via notre page de contact ou directement sur nos réseaux sociaux. Notre équipe vous répondra dans les meilleurs délais.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection