@extends('anonymous.default')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">{{ trans('global.terms') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">


                            <h2>La socièté</h2>

                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-sm-5 text-right">--}}
                            {{--                                    <p>Socièté</p>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-sm-7 sm-m-t-20">--}}
                            {{--                                    Dénomination Sociale : ObsessionCity<br>--}}
                            {{--                                    Raison Sociale : SARL<br>--}}
                            {{--                                    Identification SIRET : XXX<br>--}}
                            {{--                                    Identification TVA : XXX--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <p>Coordonnées</p>
                                </div>
                                <div class="col-sm-7 sm-m-t-20">
                                    {{--                                    Adresse<br>Adresse<br>France<br>--}}
                                    <a href="{{ route('anonymous.contact.index') }}">Formulaire de contact</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <p>obsession.city</p>
                                </div>
                                <div class="col-sm-7 sm-m-t-20">
                                    <p>
                                        est une platerforme de rencontre.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <p>Hébergement</p>
                                </div>
                                <div class="col-sm-7 sm-m-t-20">
                                    <p>
                                        https://www.fortrabbit.com<br>
                                        Adresse : Görlitzer Str. 52 10997 Berlin<br>
                                        Téléphone : +49 30 609 80 784 0
                                    </p>
                                </div>
                            </div>


                            <h2>Définitions</h2>

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <p>Utilitaires de tracking</p>
                                </div>
                                <div class="col-sm-7 sm-m-t-20">
                                    <p>
                                        <a href="{{ route('anonymous.dashboard') }}">www.obsession.city</a> utilise des services d’analyses de site internet, pour ameliorer la qualité de son service, cela est fait de façon anonyme, ce qui signifie que les données transmisent aux services tiers ne peuvent vous identifier directement.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <p>Les cookies</p>
                                </div>
                                <div class="col-sm-7 sm-m-t-20">
                                    <p>
                                        sont des fichiers texte placés sur votre ordinateur, pour aider le site internet à analyser l’utilisation du site par ses utilisateurs.
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 text-right">
                                    <p>Google Analytics</p>
                                </div>
                                <div class="col-sm-7 sm-m-t-20">
                                    <p>
                                        ce site utilise Google Analytics, un service d’analyse de site internet fourni par Google Inc. (« Google »). Google Analytics utilise des cookies (<a href="https://www.google.com/policies/privacy/partners/" target="_blank" rel="noopener">plus d'information ici</a>).
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
