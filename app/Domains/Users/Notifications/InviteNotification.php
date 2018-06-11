<?php

namespace Emtudo\Domains\Users\Notifications;

use Emtudo\Domains\Users\Invite;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

/**
 * Class InviteNotification.
 */
class InviteNotification extends Notification
{
    /**
     * @var string
     */
    public $route;

    /**
     * InviteNotification constructor.
     *
     * @param null|string $route
     */
    public function __construct(string $route = null)
    {
        $this->route = $route ?? 'https://emtudo.com/invite/{token}';
    }

    /**
     * Get the notification's channels.
     *
     * @return array|string
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param Invite $invite
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(Invite $invite)
    {
        return (new MailMessage())
            ->line("Olá {$invite->name}, você foi convidado a se juntar a {$invite->tenant->label}.")
            ->line('Para aceitar o convite, clique no link abaixo.')
            ->action('Aceitar Convite', $this->generateUrl($this->route, $invite->token))
            ->line('Se você recebeu essa mensagem por engano, fique tranquilo, nenhuma ação é necessária e você pode ignorar esse email.')
            ->subject("[Emtudo] Junte-se a {$invite->tenant->label}!");
    }

    /**
     * Generate the url containing the token.
     *
     * @param string $route
     * @param string $token
     *
     * @return string
     */
    protected function generateUrl(string $route, string $token)
    {
        return Str::replaceFirst('{token}', $token, $route);
    }
}
