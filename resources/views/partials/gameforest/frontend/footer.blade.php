<footer class="site-footer bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0 pb-1 pb-md-0">
                <div class="footer-title">{{ config('app.name') }}</div>
                <p>{{ trans('frontend/home.baseline') }}</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0 pb-1 pb-md-0">
                <div class="footer-title">Popular Categories</div>
                <div class="footer-tags">
                    <a href="#">Playstation 4</a>
                    <a href="#">Xbox One</a>
                    <a href="#">God of War</a>
                    <a href="#">Bioshock</a>
                    <a href="#">Uncharted 4</a>
                    <a href="#">Uplay</a>
                    <a href="#">Steam</a>
                    <a href="#">Wordpress</a>
                    <a href="#">Rachet</a>
                    <a href="#">Github</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-title">Devient Premium, chaque jour tu pourra</div>
                <ul>
                    <li>Poster plus de fantasmes</li>
                    <li>Postuler à plus de fantasmes</li>
                </ul>
                <p style="text-align: center;"><a class="btn btn-primary btn-lg btn-rounded" href="register" role="button">S'abonner</a></p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row">
            <div class="order-2 order-md-1">
                <div class="footer-links d-none d-md-inline-block">
                    <a href="#">Terms of Service</a>
                    <a href="https://github.com/obsession-city/www/wiki" target="_blank">Documentation</a>
                    <a href="https://github.com/obsession-city/www/milestones?state=closed">Changelog</a>
                </div>
                <p class="footer-copyright">&copy; {{ date('Y') }} <a href="{{ route('frontend.home') }}" target="_blank">{{ config('app.name') }}</a>. All rights reserved.</p>
            </div>
            <div class="footer-social order-1 order-md-2 ml-md-auto text-center text-md-right">
                <span class="d-none d-sm-block mb-2">Suivez nous sur les réseaux sociaux</span>
                <a href="https://github.com/obsession-city" target="_blank" data-toggle="tooltip" title="github"><i class="ya ya-github"></i></a>
            </div>
        </div>
    </div>
</footer>
<!-- end .site-footer -->
