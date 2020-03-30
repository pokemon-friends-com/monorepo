<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Users;

use Tests\OAuthTestCaseTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testToVisitDashboard()
    {
        $this
            ->get('/')
            ->assertSuccessful()
            ->assertSeeText('Sign up to share your friend code and join your trainer community!')
            ->assertSeeText(e('Now go share \'em all!'))
            ->assertSeeText('Home')
            ->assertSeeText('Contact')
            ->assertSeeText('Terms of Service')
            ->assertSeeText('Login')
            ->assertSeeText('Register');
    }

    public function testToVisitDashboardInFrench()
    {
        $this
            ->get('/?locale=fr')
            ->assertSuccessful()
            ->assertSeeText('Inscrivez-vous pour partager votre code ami et rejoindre vote communauté de dresseurs!')
            ->assertSeeText('Maintenant, allez tous les partager !')
            ->assertSeeText('Accueil')
            ->assertSeeText('Contact')
            ->assertSeeText(e('Conditions générales d\'utilisation'))
            ->assertSeeText('Se connecter')
            ->assertSeeText(e('S\'inscrire'));
    }

    public function testToVisitDashboardInGerman()
    {
        $this
            ->get('/?locale=de')
            ->assertSuccessful()
            ->assertSeeText('Sign up to share your friend code and join your trainer community!')
            ->assertSeeText(e('Now go share \'em all!'))
            ->assertSeeText('Home')
            ->assertSeeText('Contact')
            ->assertSeeText('Terms of Service')
            ->assertSeeText('Einloggen')
            ->assertSeeText('Registrieren');
    }

    public function testToVisitDashboardInSpanish()
    {
        $this
            ->get('/?locale=es')
            ->assertSuccessful()
            ->assertSeeText('Sign up to share your friend code and join your trainer community!')
            ->assertSeeText(e('Now go share \'em all!'))
            ->assertSeeText('Home')
            ->assertSeeText('Contact')
            ->assertSeeText('Terms of Service')
            ->assertSeeText('Iniciar sesión')
            ->assertSeeText('Registrarse');
    }

    public function testToVisitDashboardInRussian()
    {
        $this
            ->get('/?locale=ru')
            ->assertSuccessful()
            ->assertSeeText('Sign up to share your friend code and join your trainer community!')
            ->assertSeeText(e('Now go share \'em all!'))
            ->assertSeeText('Home')
            ->assertSeeText('Contact')
            ->assertSeeText('Terms of Service')
            ->assertSeeText('Авторизоваться')
            ->assertSeeText('регистр');
    }

    public function testToVisitDashboardInChinese()
    {
        $this
            ->get('/?locale=zh-CN')
            ->assertSuccessful()
            ->assertSeeText('Sign up to share your friend code and join your trainer community!')
            ->assertSeeText(e('Now go share \'em all!'))
            ->assertSeeText('Home')
            ->assertSeeText('Contact')
            ->assertSeeText('Terms of Service')
            ->assertSeeText('登录')
            ->assertSeeText('寄存器');
    }

    public function testToVisitTerms()
    {
        $this
            ->get('/terms-of-services')
            ->assertSuccessful()
            ->assertSeeText('www.pokemon-friends.com is a friend sharing code platform from the Pokemon Go game.');
    }

    public function testToVisitTermsInFrench()
    {
        $this
            ->get('/terms-of-services?locale=fr')
            ->assertSuccessful()
            ->assertSeeText('www.pokemon-friends.com est une plateforme de partage de code ami du jeu Pokemon Go.');
    }
}
