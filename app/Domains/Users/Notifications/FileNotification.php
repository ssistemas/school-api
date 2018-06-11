<?php

namespace Emtudo\Domains\Users\Notifications;

use Emtudo\Domains\Files\File;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class FileNotification.
 */
class FileNotification extends Notification
{
    /**
     * The data that should be stored with the notification.
     *
     * @var array
     */
    public $data = [];

    public static $route;

    /**
     * Create a new database message.
     *
     * @param File   $file
     * @param string $label
     * @param array  $params
     */
    public function __construct(File $file, $label = '', $params = [])
    {
        $this->data = [
            'label' => $label,
            'route' => [
                'name' => self::$route,
                'params' => $params,
            ],
            'params' => $params,
            'tenant_id' => $file->tenant_id,
            'file' => $file->toArray(),
        ];
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param User $user
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage())
            ->line('Olá')
            ->line('Para aceitar o convite, clique no link abaixo.')
            ->action('Aceitar Convite')
            ->line('Se você recebeu essa mensagem por engano, fique tranquilo, nenhuma ação é necessária e você pode ignorar esse email.')
            ->subject('[Emtudo] Junte-se a teste!');
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase()
    {
        return new DatabaseMessage($this->data);
    }
}
