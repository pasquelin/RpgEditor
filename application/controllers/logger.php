<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * Controller public auth. Pour la gestion d'identification.
 *
 * @package Auth
 * @author Pasquelin Alban
 * @copyright     (c) 2011
 * @license http://www.openrpg.fr/license.html
 */
class Logger_Controller extends Template_Controller
{

    /**
     * Homepage en cas de non identification.
     *
     * @return  void
     */
    public function index()
    {
        $this->css = 'css/login';
        $cache = Cache::instance();

        if (!$this->template->content = $cache->get('view_auth')) {
            $this->template->content = self::auth();
            $cache->set('table', $this->template->content, array('page'), 600);
        }
    }

    /**
     * Formulaire d'authentification.
     *
     * @return  void
     */
    public function auth()
    {
        if (Auth::instance()->logged_in())
            return url::redirect(NULL);

        $view = new View('auth/index');
        $view->alert = $this->input->get('msg');
        $view->users = Statistiques_Model::instance()->top_user();

        if (($ajax = url::current() == 'logger/auth') ? TRUE : FALSE)
            $this->auto_render = FALSE;

        return $view->render($ajax);
    }


    /**
     * Logout un utilisateur.
     *
     * @return  void
     */
    public function logout()
    {
        $this->auto_render = FALSE;

        $authentic = Auth::instance();

        if ($authentic->logged_in())
            $authentic->logout(TRUE);

        cookie::delete('urlAdminUrl');

        return self::redirection(Kohana::lang('logger.disconnect'));
    }

    /**
     * Envoyer mot de passe perdu.
     *
     * @return  void
     */
    public function send()
    {
        if (Auth::instance()->logged_in())
            return url::redirect('/');

        elseif ($_POST) {
            if (($email = $this->input->post('username')) !== FALSE) {
                if (!valid::email($email) || !valid::email_domain($email) || !valid::email_rfc($email))
                    $txt = Kohana::lang('logger.error_mail_valid');

                elseif (($mdp = User_Model::modifier_mot_de_passe($email)) !== FALSE) {
                    $from = Kohana::config('game.name') . ' <' . Kohana::config('email.from') . '>';
                    $subject = Kohana::lang('logger.title_mail_send_password', Kohana::config('game.name'));
                    $message = Kohana::lang('logger.content_mail_send_password', $mdp);

                    if (email::send($email, $from, $subject, $message, TRUE))
                        $txt = Kohana::lang('logger.new_password_send');
                    else
                        $txt = Kohana::lang('logger.error_password_send');
                } else
                    $txt = Kohana::lang('logger.error_generate_password');
            } else
                $txt = Kohana::lang('logger.error_mail_valid');
        } else
            $txt = Kohana::lang('logger.no_acces');

        return self::redirection($txt);
    }

    /**
     * Login un utilisateur après vérification des données POST.
     *
     * @return  void
     */
    public function login()
    {
        if ($_POST) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($username && $password) {
                $user = ORM::factory('user', $username);

                if ($user->loaded) {
                    if (Auth::instance()->login($username, $password))
                        return url::redirect();
                    else
                        $txt = Kohana::lang('logger.error_password');
                } else
                    $this->register();
            } else
                $txt = Kohana::lang('logger.no_username_password');
        } else
            $txt = Kohana::lang('logger.no_acces');

        return self::redirection($txt);
    }

    /**
     * Enregistrement d'un utilisateur.
     *
     * @return  void
     */
    public function register()
    {
        if (Auth::instance()->logged_in())
            return url::redirect(cookie::get('urlAdminUrl') . '?msg=' . urlencode(Kohana::lang('logger.identify')));

        elseif ($_POST) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $tmpUsername = explode('@', $username);
            $tmpUsername = $tmpUsername[0];

            $user = ORM::factory('user', $username);

            if (!$username || !$password)
                $txt = Kohana::lang('logger.error_all_form');

            elseif (!valid::email($username) || !valid::email_domain($username) || !valid::email_rfc($username))
                $txt = Kohana::lang('logger.error_mail_valid'); elseif (User_Model::verification_mail($username))
                $txt = Kohana::lang('logger.exist_email'); elseif ($user->loaded)
                $txt = Kohana::lang('logger.exist_username'); elseif ($user->insert(array('username' => $tmpUsername,
                'x' => Kohana::config('game.initialPosition.x'),
                'y' => Kohana::config('game.initialPosition.y'),
                'z' => Kohana::config('game.initialPosition.z'),
                'region_id' => Kohana::config('game.initialPosition.region'),
                'speed' => Kohana::config('game.initialSpeed'),
                'gravity' => Kohana::config('game.initialGravity'),
                'password' => Auth::instance()->hash_password($password),
                'last_login' => date::Now(),
                'argent' => 0,
                'hp' => Kohana::config('game.initialHP'),
                'hp_max' => Kohana::config('game.initialHP'),
                'email' => $username,
                'ip' => $_SERVER['REMOTE_ADDR']))
            ) {
                Auth::instance()->login($username, $password);

                $from = Kohana::config('game.name') . ' <' . Kohana::config('email.from') . '>';
                $subject = Kohana::lang('logger.title_mail_register', Kohana::config('game.name'));
                $message = Kohana::lang('logger.content_mail_register', $username, $username, $password);
                email::send($username, $from, $subject, $message, TRUE);

                return url::redirect('?msg=' . urlencode(Kohana::lang('logger.identify')));
            } else
                $txt = Kohana::lang('logger.error_register');
        } else
            $txt = Kohana::lang('logger.no_acces');

        return self::redirection($txt);
    }

    /**
     * Redirection avec un message d'alerte.
     *
     * @return  void
     */
    public function redirection($msg = FALSE)
    {
        return url::redirect('?msg=' . urlencode($msg));
    }

}

?>