@extends('anonymous.default')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fas fa-file-signature mr-2"></i>{{ trans('global.terms') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('anonymous.dashboard') }}"><i class="fas fa-home mr-2"></i>{{ trans('global.home') }}</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-file-signature mr-2"></i>{{ trans('global.terms') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Introduction</h2>
                            <p>
                                <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a> est une platerforme de partage de code ami du jeu Pokemon Go.
                            </p>
                            <p>
                                Dans le cadre de son activité, la société <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a>, {{-- dont le siège social est situé au <b>1 rue De Malabry 92350 Le Plessis Robinson - France</b>, --}} est amenée à collecter et à traiter des informations dont certaines sont qualifiées de "données personnelles". <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a> attache une grande importance au respect de la vie privée, et n’utilise que des données de manière responsable et confidentielle et dans une finalité précise.
                            </p>
                            <p>
                                La société <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a> n'est pas liée à la sociétè éditrice du jeu (https://www.pokemongo.com/fr-fr & https://nianticlabs.com).
                            </p>
                            <h2>Données personnelles</h2>
                            <p>
                                Sur le site web <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a>, il y a 2 types de données susceptibles d’être recueillies :
                                <ul>
                                    <li>
                                        <b>Les données transmises directement</b><br/>
                                        Ces données sont celles que vous nous transmettez directement, via un formulaire de création de compte utilisateur, de contact ou bien par contact direct par email. Sont obligatoires dans le formulaire de contact le champs « civilité, prénom et nom » et « email ».
                                    </li>
                                    <li>
                                        <b>Les données collectées automatiquement</b><br/>
                                        Lors de vos visites, une fois votre consentement donné, nous pouvons recueillir des informations de type « web analytics » relatives à votre navigation, la durée de votre consultation, votre adresse IP, votre type et version de navigateur. La technologie utilisée est le cookie.
                                    </li>
                                </ul>
                            </p>
                            <h2>Utilisation des données</h2>
                            <p>
                                Les données que vous nous transmettez directement sont utilisées dans le but de :
                                <ul>
                                    <li>vous re-contacter et/ou dans le cadre de la demande que vous nous faites via notre formulaire de contact ou par courriel</li>
                                    <li>de personnaliser l'interface <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a> pour une experience utilisateur optimale</li>
                                </ul>
                                Les données « web analytics » sont collectées sous forme anonyme (en enregistrant des adresses IP anonymes) par Google Analytics, et nous permettent de mesurer l'audience de notre site web, les consultations et les éventuelles erreurs afin d’améliorer constamment l’expérience des utilisateurs. Ces données sont utilisées par <a href="{{ route('anonymous.dashboard') }}">www.pokemon-friends.com</a>, responsable du traitement des données, et ne seront jamais cédées à un tiers ni utilisées à d’autres fins que celles détaillées ci-dessus.
                            </p>
                            <h2>Base légale</h2>
                            <p>
                                Les données personnelles ne sont collectées qu’après consentement obligatoire de l’utilisateur. Ce consentement est valablement recueilli (boutons et cases à cocher), libre, clair et sans équivoque.
                            </p>
                            <h2>Durée de conservation</h2>
                            <p>
                                Les données seront sauvegardées durant une durée maximale de 3 ans.
                            </p>
                            <h2>Cookies</h2>
                            <p>
                                Les cookies sont des fichiers texte placés sur votre ordinateur, pour aider le site internet à analyser l’utilisation du site par ses utilisateurs.<br/>
                                <a href="https://wikis.ec.europa.eu/display/WEBGUIDE/04.+Cookies#section_2">Loi sur les cookies</a>
                            </p>
                            <p>
                                Voici la liste des cookies utilisées et leur objectif :
                                <ul>
                                    <li>Cookies Google Analytics (<a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage">liste exhaustive</a>) : Web analytics, un service d’analyse de site internet fourni par Google Inc. (« Google ») (<a href="https://www.google.com/policies/privacy/partners/" target="_blank" rel="noopener">plus d'information ici</a>).</li>
                                    <li>"laravel_cookie_consent" : Permet de garder en mémoire le fait que vous acceptez les cookies afin de ne plus vous importuner lors de votre prochaine visite.</li>
                                </ul>
                            </p>
                            <h2>Vos droits concernant les données personnelles</h2>
                            <p>
                                Vous avez le droit de consultation, demande de modification ou d’effacement sur l’ensemble de vos données personnelles. Vous pouvez également retirer votre consentement au traitement de vos données.
                            </p>
                            <h2>Contact délégué à la protection des données</h2>
                            <p>
                                Antoine Benevaut - <a href="{{ route('anonymous.contact.index') }}">Formulaire de contact</a>
                            </p>
                            <h2>Hébergement web</h2>
                            <p>
                                https://www.fortrabbit.com<br>
                                Adresse : Görlitzer Str. 52 10997 Berlin<br>
                                Téléphone : +49 30 609 80 784 0
                            </p>
                            <h2>Code open source</h2>
                            <p>
                                L'intégralité du code source de ce site internet est consultable sur <a href="https://github.com/pokemon-friends-com/www">Github.com</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
