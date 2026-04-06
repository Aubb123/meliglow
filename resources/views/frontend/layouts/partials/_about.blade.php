<!-- about us area start -->
@if(Route::is('frontend.about'))
    <section class="choosing-area section-padding pt-0">
@else
    <section class="about-us section-padding pb-0">
@endif
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="about-thumb">
                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/about/about.jpg') }}" alt="Méli'Glow">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="about-content">
                    <h2 class="about-title">À propos de Méli'Glow</h2>

                    <h5 class="about-sub-title">
                        Méli'Glow est une boutique en ligne dédiée à la beauté capillaire, proposant une large gamme de produits pour sublimer vos cheveux au quotidien.
                    </h5>

                    <p>
                        Chez <strong>Méli'Glow</strong>, nous croyons que chaque personne mérite de se sentir belle et confiante. 
                        C’est pourquoi nous avons réuni une sélection complète de produits capillaires adaptés à tous les styles et tous les besoins.
                    </p>

                    <p>
                        Notre plateforme propose différentes catégories telles que les perruques naturelles et synthétiques, 
                        les huiles capillaires (huile de ricin, huile de coco), les soins et masques, les extensions, 
                        les shampoings, les accessoires capillaires, les colorations ainsi que les produits coiffants.
                    </p>

                    @if(Route::is('frontend.about'))
                    <p>
                        Nous mettons un point d'honneur à offrir des produits de qualité, à des prix accessibles, 
                        tout en garantissant une expérience d’achat simple, rapide et sécurisée.
                    </p>

                    <p>
                        Avec Méli'Glow, révélez la beauté naturelle de vos cheveux et exprimez votre style en toute confiance.
                    </p>
                    @else
                    <!-- Bouton lire plus -->
                    <a href="{{ route('frontend.about') }}" class="btn btn-hero m-0">Lire plus</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
<!-- about us area end -->